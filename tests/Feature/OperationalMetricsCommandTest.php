<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class OperationalMetricsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_ops_metrics_command_outputs_core_metrics_snapshot(): void
    {
        DB::table('jobs')->insert([
            'queue' => 'default',
            'payload' => json_encode(['displayName' => 'TestJob']),
            'attempts' => 0,
            'reserved_at' => null,
            'available_at' => Carbon::now()->subSeconds(30)->timestamp,
            'created_at' => Carbon::now()->subSeconds(30)->timestamp,
        ]);

        $logPath = storage_path('logs/laravel.log');
        File::ensureDirectoryExists(dirname($logPath));
        File::put($logPath, sprintf(
            "[%s] local.WARNING: Slow query detected {\"sql\":\"select 1\"}\n",
            Carbon::now()->subMinutes(10)->format('Y-m-d H:i:s')
        ));

        $exitCode = Artisan::call('ops:metrics', ['--json' => true]);
        $output = Artisan::output();

        $this->assertSame(0, $exitCode);
        $this->assertStringContainsString('"queue_pending_jobs": 1', $output);
        $this->assertStringContainsString('"queue_lag_seconds":', $output);
        $this->assertStringContainsString('"slow_query_events_last_hour": 1', $output);
        $this->assertStringContainsString('"cache_probe_hit": true', $output);
    }
}
