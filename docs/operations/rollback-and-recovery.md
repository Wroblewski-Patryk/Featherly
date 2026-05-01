# Rollback And Recovery

Document the first safe rollback path before the first production deploy.

## Rollback Triggers

- What symptoms justify rollback:
- Who can trigger rollback:
- What evidence should be captured first:

## Rollback Method

- App rollback:
  - Coolify update driver rollbacks use the previous successful deployment in
    Coolify deployment history, then re-run `php artisan updates:confirm`.
  - Archive update driver rollbacks use the recorded
    `system_update_status.archive_backup_path` from the failed switch attempt.
    Restore that backup over the configured
    `FEATHERLY_UPDATE_ARCHIVE_RELEASE_PATH`, preserve the live `.env`,
    `storage`, and `public/storage` paths unless the incident requires a full
    release-path restore, then run post-deploy smoke and
    `php artisan updates:confirm`.
  - Archive rollback command: run
    `php artisan updates:rollback-archive --force` after confirming the
    recorded backup path is the intended recovery point. The command restores
    release files from `archive_backup_path` and preserves local `.env`,
    `storage`, and `public/storage`.
- Migration rollback or forward-fix rule:
- Worker rollback:
- Cache or queue considerations:

## Recovery Verification

- Health checks:
  - `php artisan ops:health-check --json`
  - for Coolify-triggered updates, `php artisan updates:confirm`
- User journey smoke:
- Log review:
- Data integrity review:

## Notes

- Prefer deterministic rollback or forward-fix rules over improvisation.
- If rollback is unsafe for a given change type, record the required mitigation
  before deployment.
- Docker and Git runtime update drivers are deferred from System Update Manager
  v1. Rollback for those deployments remains platform/operator-owned until
  dedicated driver contracts exist.
