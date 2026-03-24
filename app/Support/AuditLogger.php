<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AuditLogger
{
    /**
     * Persist an audit entry. Logging failures should not break user flows.
     */
    public static function log(string $event, array $context = [], ?Model $auditable = null): void
    {
        try {
            AuditLog::create([
                'user_id' => auth()->id(),
                'event' => $event,
                'module' => self::extractModule($event),
                'action' => self::extractAction($event),
                'auditable_type' => $auditable?->getMorphClass(),
                'auditable_id' => $auditable?->getKey(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'context' => $context ?: null,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Failed to persist audit log entry', [
                'event' => $event,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private static function extractModule(string $event): string
    {
        $parts = explode('.', $event);
        return $parts[0];
    }

    private static function extractAction(string $event): ?string
    {
        $parts = explode('.', $event);
        return $parts[count($parts) - 1] ?? null;
    }
}
