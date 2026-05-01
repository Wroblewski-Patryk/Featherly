<?php

namespace App\Services\SystemUpdates\Drivers;

use App\Services\SystemUpdates\UpdateDriver;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use ZipArchive;

class ArchiveUpdateDriver implements UpdateDriver
{
    public function key(): string
    {
        return 'archive';
    }

    public function label(): string
    {
        return 'Archive';
    }

    public function isConfigured(): bool
    {
        return $this->stagingPath() !== '' && $this->releasePath() !== '';
    }

    public function isSupported(): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        $stagingParent = dirname($this->stagingPath());
        $releaseParent = dirname($this->releasePath());

        return is_dir($stagingParent)
            && is_writable($stagingParent)
            && is_dir($releaseParent)
            && is_writable($releaseParent);
    }

    public function preflight(array $status, array $settings): array
    {
        if (!$this->isConfigured()) {
            return [
                'ok' => false,
                'supports_apply' => false,
                'message' => 'Archive driver requires FEATHERLY_UPDATE_ARCHIVE_STAGING_PATH and FEATHERLY_UPDATE_ARCHIVE_RELEASE_PATH.',
            ];
        }

        if (!$this->isSupported()) {
            return [
                'ok' => false,
                'supports_apply' => false,
                'message' => 'Archive driver paths must exist and be writable before apply can be considered.',
            ];
        }

        if (!$this->hasArchiveIntegrityMetadata($status)) {
            return [
                'ok' => false,
                'supports_apply' => false,
                'message' => 'Archive driver requires release_archive_url and release_archive_sha256 metadata before apply can be considered.',
            ];
        }

        return [
            'ok' => true,
            'supports_apply' => false,
            'message' => 'Archive staging and release paths are writable and release integrity metadata is present. Apply execution is pending archive download, verification, and switch implementation.',
        ];
    }

    public function apply(array $status, array $settings): array
    {
        $archiveUrl = $this->stringValue($status['release_archive_url'] ?? null);
        $expectedSha256 = strtolower($this->stringValue($status['release_archive_sha256'] ?? null));
        $targetVersion = $this->stringValue($status['latest_version'] ?? 'release');

        if (!$this->hasArchiveIntegrityMetadata($status)) {
            return [
                'ok' => false,
                'applied' => false,
                'apply_status' => 'preflight_failed',
                'message' => 'Archive verification requires release archive URL and SHA-256 metadata.',
                'operator_instructions' => [
                    'Run the update check again after the trusted manifest includes archive integrity metadata.',
                ],
                'rollback_note' => 'No archive was downloaded or staged.',
            ];
        }

        $stagingDirectory = $this->ensureStagingDirectory();
        $filename = $this->archiveFilename($targetVersion);
        $targetPath = $stagingDirectory . DIRECTORY_SEPARATOR . $filename;

        $response = Http::timeout(30)->get($archiveUrl);

        if (!$response->successful()) {
            throw new RuntimeException('Release archive download failed.');
        }

        $bytes = file_put_contents($targetPath, $response->body(), LOCK_EX);
        if ($bytes === false) {
            throw new RuntimeException('Release archive could not be written to the staging path.');
        }

        $actualSha256 = hash_file('sha256', $targetPath);
        if (!is_string($actualSha256) || strtolower($actualSha256) !== $expectedSha256) {
            @unlink($targetPath);

            return [
                'ok' => false,
                'applied' => false,
                'apply_status' => 'archive_verification_failed',
                'message' => 'Release archive SHA-256 verification failed.',
                'operator_instructions' => [
                    'Do not use the downloaded archive.',
                    'Re-check the release manifest and release artifact source before retrying.',
                ],
                'rollback_note' => 'No live files were changed. The failed staged archive was removed.',
            ];
        }

        if (!class_exists(ZipArchive::class)) {
            return [
                'ok' => true,
                'applied' => false,
                'apply_status' => 'archive_verified',
                'message' => 'Release archive downloaded and verified. ZIP extraction is unavailable in this PHP runtime, so no live files were changed.',
                'operator_instructions' => [
                    'Enable the PHP zip extension before archive extraction or file switching can be implemented.',
                    'Review the staged archive before enabling extraction or file switching.',
                    'Back up .env, storage, uploaded media, and the database before replacing files.',
                ],
                'rollback_note' => 'No live files were changed. Remove the staged archive if it should not be used.',
                'archive_verified_at' => Carbon::now()->toIso8601String(),
                'archive_verified_sha256' => $actualSha256,
                'archive_verified_bytes' => $bytes,
                'archive_verified_filename' => $filename,
                'archive_extraction_status' => 'unavailable',
                'archive_extraction_message' => 'PHP ZipArchive extension is not available.',
            ];
        }

        $extraction = $this->extractAndValidate($targetPath, $targetVersion);
        if (!($extraction['ok'] ?? false)) {
            return [
                'ok' => false,
                'applied' => false,
                'apply_status' => 'archive_staging_failed',
                'message' => $this->stringValue($extraction['message'] ?? 'Archive staging validation failed.'),
                'operator_instructions' => [
                    'Do not switch live files.',
                    'Inspect the release archive structure and rebuild the artifact before retrying.',
                ],
                'rollback_note' => 'No live files were changed. Failed extraction output was removed.',
                'archive_verified_at' => Carbon::now()->toIso8601String(),
                'archive_verified_sha256' => $actualSha256,
                'archive_verified_bytes' => $bytes,
                'archive_verified_filename' => $filename,
                'archive_extraction_status' => 'failed',
                'archive_extraction_message' => $this->stringValue($extraction['message'] ?? 'Archive staging validation failed.'),
            ];
        }

        $switchPlan = $this->writeSwitchPlan($targetVersion, $filename, $extraction);

        if ($this->switchEnabled()) {
            $switch = $this->switchRelease($targetVersion, $extraction);

            return [
                'ok' => true,
                'applied' => true,
                'apply_status' => 'archive_switched',
                'message' => 'Release archive downloaded, verified, staged, and switched into the configured release path.',
                'operator_instructions' => [
                    'Run post-deploy smoke checks immediately.',
                    'Run php artisan updates:confirm after the runtime reports the new APP_VERSION.',
                    'Use the recorded archive backup path if rollback is required.',
                ],
                'rollback_note' => 'Restore the recorded archive backup path if smoke checks fail.',
                'archive_verified_at' => Carbon::now()->toIso8601String(),
                'archive_verified_sha256' => $actualSha256,
                'archive_verified_bytes' => $bytes,
                'archive_verified_filename' => $filename,
                'archive_extraction_status' => 'validated',
                'archive_extraction_message' => 'Archive extracted to staging and required files were found.',
                'archive_extracted_directory' => $extraction['directory'] ?? null,
                'archive_extracted_file_count' => $extraction['file_count'] ?? null,
                'archive_switch_status' => 'switched',
                'archive_switch_plan_path' => $switchPlan['path'],
                'archive_switch_plan_generated_at' => $switchPlan['generated_at'],
                'archive_switched_at' => $switch['switched_at'],
                'archive_backup_path' => $switch['backup_path'],
            ];
        }

        return [
            'ok' => true,
            'applied' => false,
            'apply_status' => 'archive_staged',
            'message' => 'Release archive downloaded, verified, extracted to staging, and switch plan recorded. No live files were changed.',
            'operator_instructions' => [
                'Review the validated staging directory before enabling file switching.',
                'Review the generated switch plan before any live file replacement.',
                'Back up .env, storage, uploaded media, and the database before replacing files.',
                'Run the later archive switch task before any live file replacement.',
            ],
            'rollback_note' => 'No live files were changed. Remove the staged archive if it should not be used.',
            'archive_verified_at' => Carbon::now()->toIso8601String(),
            'archive_verified_sha256' => $actualSha256,
            'archive_verified_bytes' => $bytes,
            'archive_verified_filename' => $filename,
            'archive_extraction_status' => 'validated',
            'archive_extraction_message' => 'Archive extracted to staging and required files were found.',
            'archive_extracted_directory' => $extraction['directory'] ?? null,
            'archive_extracted_file_count' => $extraction['file_count'] ?? null,
            'archive_switch_status' => 'planned',
            'archive_switch_plan_path' => $switchPlan['path'],
            'archive_switch_plan_generated_at' => $switchPlan['generated_at'],
        ];
    }

    private function stagingPath(): string
    {
        $value = config('updates.drivers.archive.staging_path');

        return is_string($value) ? trim($value) : '';
    }

    private function releasePath(): string
    {
        $value = config('updates.drivers.archive.release_path');

        return is_string($value) ? trim($value) : '';
    }

    private function switchEnabled(): bool
    {
        return filter_var(config('updates.drivers.archive.switch_enabled', false), FILTER_VALIDATE_BOOL);
    }

    private function hasArchiveIntegrityMetadata(array $status): bool
    {
        $archiveUrl = $status['release_archive_url'] ?? null;
        $archiveSha256 = $status['release_archive_sha256'] ?? null;

        return is_string($archiveUrl)
            && trim($archiveUrl) !== ''
            && is_string($archiveSha256)
            && preg_match('/^[a-f0-9]{64}$/i', trim($archiveSha256)) === 1;
    }

    private function ensureStagingDirectory(): string
    {
        $stagingDirectory = $this->stagingPath();

        if ($stagingDirectory === '') {
            throw new RuntimeException('Archive staging path is not configured.');
        }

        if (!is_dir($stagingDirectory) && !mkdir($stagingDirectory, 0775, true) && !is_dir($stagingDirectory)) {
            throw new RuntimeException('Archive staging directory could not be created.');
        }

        if (!is_writable($stagingDirectory)) {
            throw new RuntimeException('Archive staging directory is not writable.');
        }

        return $stagingDirectory;
    }

    private function archiveFilename(string $targetVersion): string
    {
        $safeVersion = preg_replace('/[^A-Za-z0-9._-]/', '-', $targetVersion);

        return 'featherly-' . ($safeVersion ?: 'release') . '.zip';
    }

    /**
     * @return array<string, mixed>
     */
    private function extractAndValidate(string $archivePath, string $targetVersion): array
    {
        $zip = new ZipArchive();
        if ($zip->open($archivePath) !== true) {
            return ['ok' => false, 'message' => 'Release archive could not be opened for extraction.'];
        }

        try {
            $unsafeEntry = $this->unsafeArchiveEntry($zip);
            if ($unsafeEntry !== null) {
                return ['ok' => false, 'message' => "Release archive contains an unsafe path: {$unsafeEntry}."];
            }

            $directory = $this->extractionDirectory($targetVersion);
            $this->resetDirectory($directory);

            if (!$zip->extractTo($directory)) {
                $this->removeDirectory($directory);

                return ['ok' => false, 'message' => 'Release archive could not be extracted to staging.'];
            }
        } finally {
            $zip->close();
        }

        $missing = $this->missingRequiredFiles($directory);
        if ($missing !== []) {
            $this->removeDirectory($directory);

            return [
                'ok' => false,
                'message' => 'Release archive staging validation failed. Missing: ' . implode(', ', $missing) . '.',
            ];
        }

        return [
            'ok' => true,
            'directory' => $directory,
            'file_count' => $this->countFiles($directory),
        ];
    }

    private function unsafeArchiveEntry(ZipArchive $zip): ?string
    {
        for ($index = 0; $index < $zip->numFiles; $index++) {
            $name = $zip->getNameIndex($index);

            if (!is_string($name)) {
                return 'unknown';
            }

            $normalized = str_replace('\\', '/', $name);
            if (
                str_starts_with($normalized, '/')
                || preg_match('/^[A-Za-z]:\//', $normalized) === 1
                || str_contains($normalized, '../')
                || $normalized === '..'
            ) {
                return $name;
            }
        }

        return null;
    }

    private function extractionDirectory(string $targetVersion): string
    {
        $safeVersion = preg_replace('/[^A-Za-z0-9._-]/', '-', $targetVersion) ?: 'release';

        return $this->ensureStagingDirectory() . DIRECTORY_SEPARATOR . 'extracted' . DIRECTORY_SEPARATOR . $safeVersion;
    }

    /**
     * @return array<int, string>
     */
    private function missingRequiredFiles(string $directory): array
    {
        $required = [
            'artisan',
            'composer.json',
            'bootstrap/app.php',
            'public/index.php',
        ];

        return array_values(array_filter($required, fn (string $path): bool => !is_file($directory . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path))));
    }

    private function resetDirectory(string $directory): void
    {
        if (is_dir($directory)) {
            $this->removeDirectory($directory);
        }

        if (!mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Archive extraction directory could not be created.');
        }
    }

    private function removeDirectory(string $directory, ?string $allowedRoot = null): void
    {
        $stagingRoot = realpath($allowedRoot ?? $this->ensureStagingDirectory());
        $target = realpath($directory);

        if (
            $stagingRoot === false
            || $target === false
            || !($target === $stagingRoot || str_starts_with($target, $stagingRoot . DIRECTORY_SEPARATOR))
        ) {
            throw new RuntimeException('Refusing to remove a directory outside the allowed archive path.');
        }

        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($target, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }

        rmdir($target);
    }

    private function countFiles(string $directory): int
    {
        $count = 0;
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($items as $item) {
            if ($item->isFile()) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param  array<string, mixed>  $extraction
     * @return array{path: string, generated_at: string}
     */
    private function writeSwitchPlan(string $targetVersion, string $archiveFilename, array $extraction): array
    {
        $generatedAt = Carbon::now()->toIso8601String();
        $planPath = $this->ensureStagingDirectory()
            . DIRECTORY_SEPARATOR
            . 'switch-plan-' . (preg_replace('/[^A-Za-z0-9._-]/', '-', $targetVersion) ?: 'release') . '.json';

        $plan = [
            'generated_at' => $generatedAt,
            'target_version' => $targetVersion,
            'archive_filename' => $archiveFilename,
            'extracted_directory' => $extraction['directory'] ?? null,
            'release_path' => $this->releasePath(),
            'preserve_paths' => $this->preservePaths(),
            'required_before_switch' => [
                'database backup captured',
                'current release backup captured',
                'maintenance mode decision recorded',
                'operator approval recorded',
            ],
            'rollback' => [
                'strategy' => 'restore previous release path and database backup',
                'live_files_changed_by_this_step' => false,
            ],
        ];

        $encoded = json_encode($plan, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if (!is_string($encoded) || file_put_contents($planPath, $encoded, LOCK_EX) === false) {
            throw new RuntimeException('Archive switch plan could not be written.');
        }

        return [
            'path' => $planPath,
            'generated_at' => $generatedAt,
        ];
    }

    /**
     * @param  array<string, mixed>  $extraction
     * @return array{switched_at: string, backup_path: string}
     */
    private function switchRelease(string $targetVersion, array $extraction): array
    {
        $releasePath = $this->releasePath();
        $extractedDirectory = $this->stringValue($extraction['directory'] ?? null);

        if ($releasePath === '' || $extractedDirectory === '' || !is_dir($extractedDirectory)) {
            throw new RuntimeException('Archive switch requires a validated extracted directory and release path.');
        }

        $this->ensureReleaseDirectory();
        $backupPath = $this->backupDirectory($targetVersion);
        $this->resetDirectory($backupPath);
        $this->copyDirectoryContents($releasePath, $backupPath);
        $this->removeReleaseContentsExceptPreserved($releasePath);
        $this->copyDirectoryContents($extractedDirectory, $releasePath, $this->preservePaths());

        $missing = $this->missingRequiredFiles($releasePath);
        if ($missing !== []) {
            $this->removeReleaseContentsExceptPreserved($releasePath);
            $this->copyDirectoryContents($backupPath, $releasePath);

            throw new RuntimeException('Archive switch validation failed. Release path was restored from backup.');
        }

        return [
            'switched_at' => Carbon::now()->toIso8601String(),
            'backup_path' => $backupPath,
        ];
    }

    private function ensureReleaseDirectory(): string
    {
        $releasePath = $this->releasePath();

        if ($releasePath === '') {
            throw new RuntimeException('Archive release path is not configured.');
        }

        if (!is_dir($releasePath) && !mkdir($releasePath, 0775, true) && !is_dir($releasePath)) {
            throw new RuntimeException('Archive release directory could not be created.');
        }

        if (!is_writable($releasePath)) {
            throw new RuntimeException('Archive release directory is not writable.');
        }

        return $releasePath;
    }

    private function backupDirectory(string $targetVersion): string
    {
        $safeVersion = preg_replace('/[^A-Za-z0-9._-]/', '-', $targetVersion) ?: 'release';
        $stamp = Carbon::now()->format('YmdHis');

        return $this->ensureStagingDirectory() . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $safeVersion . '-' . $stamp;
    }

    /**
     * @return array<int, string>
     */
    private function preservePaths(): array
    {
        return [
            '.env',
            'storage',
            'public/storage',
        ];
    }

    private function removeReleaseContentsExceptPreserved(string $releasePath): void
    {
        $preserve = $this->preservePaths();
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($releasePath, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) {
            $relative = str_replace('\\', '/', substr($item->getPathname(), strlen($releasePath) + 1));

            if ($this->isPreservedPath($relative, $preserve) || $this->hasPreservedDescendant($relative, $preserve)) {
                continue;
            }

            if ($item->isDir()) {
                $this->removeDirectory($item->getPathname(), $releasePath);
            } else {
                unlink($item->getPathname());
            }
        }
    }

    /**
     * @param  array<int, string>  $skipPaths
     */
    private function copyDirectoryContents(string $source, string $destination, array $skipPaths = []): void
    {
        if (!is_dir($source)) {
            return;
        }

        if (!is_dir($destination) && !mkdir($destination, 0775, true) && !is_dir($destination)) {
            throw new RuntimeException('Archive destination directory could not be created.');
        }

        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($items as $item) {
            $relative = str_replace('\\', '/', substr($item->getPathname(), strlen($source) + 1));

            if ($this->isPreservedPath($relative, $skipPaths)) {
                continue;
            }

            $target = $destination . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);

            if ($item->isDir()) {
                if (!is_dir($target) && !mkdir($target, 0775, true) && !is_dir($target)) {
                    throw new RuntimeException('Archive destination subdirectory could not be created.');
                }
            } else {
                $parent = dirname($target);
                if (!is_dir($parent) && !mkdir($parent, 0775, true) && !is_dir($parent)) {
                    throw new RuntimeException('Archive destination parent directory could not be created.');
                }

                copy($item->getPathname(), $target);
            }
        }
    }

    /**
     * @param  array<int, string>  $paths
     */
    private function isPreservedPath(string $relativePath, array $paths): bool
    {
        $normalized = str_replace('\\', '/', trim($relativePath, '/'));

        foreach ($paths as $path) {
            $preserved = trim($path, '/');

            if ($normalized === $preserved || str_starts_with($normalized, $preserved . '/')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<int, string>  $paths
     */
    private function hasPreservedDescendant(string $relativePath, array $paths): bool
    {
        $normalized = str_replace('\\', '/', trim($relativePath, '/'));

        foreach ($paths as $path) {
            $preserved = trim($path, '/');

            if (str_starts_with($preserved, $normalized . '/')) {
                return true;
            }
        }

        return false;
    }

    private function stringValue(mixed $value): string
    {
        return is_string($value) ? trim($value) : '';
    }
}
