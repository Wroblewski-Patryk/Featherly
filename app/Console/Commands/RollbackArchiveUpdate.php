<?php

namespace App\Console\Commands;

use App\Services\SystemUpdates\UpdateManager;
use Illuminate\Console\Command;

class RollbackArchiveUpdate extends Command
{
    protected $signature = 'updates:rollback-archive {--force : Confirm the operator intends to restore the recorded archive backup}';

    protected $description = 'Restore the archive update release path from the recorded backup';

    public function handle(UpdateManager $updateManager): int
    {
        if (!$this->option('force')) {
            $this->error('Archive rollback requires --force.');

            return self::FAILURE;
        }

        $status = $updateManager->rollbackArchiveUpdate();
        $message = $status['operator_message']
            ?? $status['failure_message']
            ?? $status['status_label']
            ?? 'Archive rollback attempt completed.';

        $this->line($message);

        foreach (($status['operator_instructions'] ?? []) as $instruction) {
            $this->line('- ' . $instruction);
        }

        return ($status['apply_status'] ?? null) === 'archive_rolled_back'
            ? self::SUCCESS
            : self::FAILURE;
    }
}
