# Coolify VPS Deployment Contract

Featherly uses this file to make the deployment target explicit. Coolify on a
VPS is the default contract shape until the project records a different
production target in `.codex/context/PROJECT_STATE.md`.

## Deployment Target

- VPS provider:
- Coolify project or environment: staging target identified, exact Coolify
  project name pending operator evidence
- Public domains: `https://test.luckysparrow.ch`
- Private services:

## Runtime Inventory

- Main app services: Laravel application runtime, Vite-built public/admin
  assets
- Worker or cron services:
- Databases:
- Cache or queue:
- Persistent volumes: Laravel `storage` path, including
  `storage/app/public/media`; public media must be reachable through
  `/storage/...` after deploy.

## Required Artifacts

- Dockerfile paths:
- Compose or service-definition paths:
- Env example files: `.env.example`
- Health or readiness endpoints:
- Migration/cache entrypoint: configure Coolify to run
  `composer deploy:coolify` after each successful redeploy, or run
  `sh scripts/coolify-post-deploy.sh` directly when Composer scripts are not
  available.

## Env And Secrets Contract

- Which env files exist:
- Which values must come from Coolify secrets:
- Which values are safe to keep in examples:
- Who owns secret rotation:
- Optional deploy toggles:
  - `FEATHERLY_DEPLOY_RUN_MIGRATIONS=false` disables automatic
    `php artisan migrate --force` for an emergency/manual migration window.
  - `FEATHERLY_DEPLOY_REFRESH_CACHE=false` disables automatic production cache
    rebuild for an emergency/manual cache window.

## Release Requirements

- Required checks before deploy:
- Required smoke checks after deploy: `docs/operations/post-deploy-smoke.md`;
  current staging evidence must include public `/storage/media/...` asset
  reachability after deployment.
- Rollback trigger:
- Rollback method:

## Coolify Post-Deploy Maintenance

The post-deploy maintenance script is idempotent and should run after every
successful Coolify redeploy:

1. `php artisan optimize:clear --no-interaction`
2. `php artisan storage:link --force --no-interaction`
3. `php artisan migrate --force --no-interaction`
4. `php artisan optimize --no-interaction`

This keeps route/config/view/event cache aligned with the currently deployed
release and prevents stale cached configuration from serving old filesystem or
routing behavior.

## Automatic Updates

- Coolify is the first supported automatic update driver for VPS deployments.
- Featherly owns update discovery, admin settings, status, and audit evidence.
- Coolify owns deployment execution through a configured webhook or API path.
- The webhook secret must live in the hosting environment and must never be
  exposed to the browser.
- Operator rollout, evidence, confirmation, and failure handling must follow
  `docs/operations/coolify-update-rollout-runbook.md` before the driver is
  treated as production-ready.
- Installations outside Coolify must use the driver contract in
  `docs/architecture/system-update-manager-contract.md`.

## Data Safety

- Backup strategy:
- Restore verification expectation:
- Risky migration policy:
