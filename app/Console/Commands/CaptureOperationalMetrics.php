<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CaptureOperationalMetrics extends Command
{
    protected $signature = 'ops:metrics {--json : Output metrics as JSON}';

    protected $description = 'Capture core operational metrics snapshot (queue lag, slow queries, cache hit probe)';

    public function handle(): int
    {
        $metrics = [
            'captured_at' => Carbon::now()->toIso8601String(),
            'queue_pending_jobs' => $this->pendingJobsCount(),
            'queue_lag_seconds' => $this->queueLagSeconds(),
            'slow_query_events_last_hour' => $this->countRecentSlowQueryLogs(1),
            'cache_probe_hit' => $this->cacheProbeHit(),
        ];

        Log::info('ops:metrics snapshot', $metrics);

        if ($this->option('json')) {
            $this->line((string) json_encode($metrics, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } else {
            $this->info('Operational metrics snapshot captured.');
        }

        return self::SUCCESS;
    }

    private function pendingJobsCount(): int
    {
        if (!Schema::hasTable('jobs')) {
            return 0;
        }

        return (int) DB::table('jobs')->count();
    }

    private function queueLagSeconds(): int
    {
        if (!Schema::hasTable('jobs')) {
            return 0;
        }

        $oldestAvailableAt = DB::table('jobs')->min('available_at');
        if ($oldestAvailableAt === null) {
            return 0;
        }

        return max(0, Carbon::now()->timestamp - (int) $oldestAvailableAt);
    }

    private function countRecentSlowQueryLogs(int $hours): int
    {
        $logPath = storage_path('logs/laravel.log');
        if (!is_file($logPath)) {
            return 0;
        }

        $content = (string) @file_get_contents($logPath);
        if ($content === '') {
            return 0;
        }

        $cutoff = Carbon::now()->subHours($hours);
        $count = 0;

        foreach (preg_split('/\R/', $content) as $line) {
            if (!str_contains($line, 'Slow query detected')) {
                continue;
            }

            if (!preg_match('/^\[([^\]]+)\]/', $line, $matches)) {
                continue;
            }

            try {
                $logTime = Carbon::parse($matches[1]);
            } catch (\Throwable) {
                continue;
            }

            if ($logTime->greaterThanOrEqualTo($cutoff)) {
                $count++;
            }
        }

        return $count;
    }

    private function cacheProbeHit(): bool
    {
        $key = 'ops:metrics:cache-probe';
        $value = (string) Carbon::now()->timestamp;

        Cache::put($key, $value, now()->addMinutes(5));
        return Cache::get($key) === $value;
    }
}
