# Task

## Header
- ID: FEA-021
- Title: Deploy the first Featherly-backed portfolio production instance
- Task Type: release
- Current Stage: implementation
- Status: IN_PROGRESS
- Owner: Ops/Release
- Depends on: FEA-020
- Priority: P0
- Coverage Ledger Rows: not applicable
- Iteration: 1
- Operation Mode: BUILDER

## Process Self-Audit
- [x] All seven autonomous loop steps are planned.
- [x] No loop step is being skipped.
- [x] Exactly one priority task is selected.
- [x] Operation mode matches the iteration number.
- [x] The task is aligned with repository source-of-truth documents.

## Context
The owner selected the existing Coolify project/environment as the production
home for the first real Featherly-backed website. The public production domain
is `wroblewskipatryk.pl`. Existing Coolify resources outside the explicitly
selected project/environment must remain untouched.

## Goal
Run Featherly as the application behind `wroblewskipatryk.pl` in the selected
Coolify project/environment, with persistent application data and a verified
rollback path.

## Scope
- The Coolify project `a14a7zgzt6r13wtqxe5c916y` and environment
  `gz5uke25v3tpqcc0o47gyw2e` only.
- The `wroblewskipatryk.pl` and `www.wroblewskipatryk.pl` production domains.
- Featherly production build, runtime environment, database, persistent media,
  queue/scheduler expectations, health check, migration, smoke, and rollback
  evidence.
- Deployment documentation and project context required by the repository.
- No deletion or modification of unrelated Coolify resources.

## Implementation Plan
1. Inspect the selected Coolify environment without deleting or changing
   unrelated resources.
2. Verify the Featherly production build and deploy contract locally.
3. Configure the existing selected project with the Featherly repository,
   required runtime services, secrets, persistent storage, and domain.
4. Deploy through Coolify and run migration, health, public-route, media,
   admin-route, queue/scheduler, and reload smoke checks.
5. Record deployment and rollback evidence in the canonical operations docs.

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: Coolify access is restored and the selected environment is now
  configured; the first production deployment and smoke evidence remain.
- Gaps: successful deployment history, restart persistence, and production
  route/media smoke evidence are not yet captured.
- Inconsistencies: operations docs currently name only the existing staging
  target, while the owner has now confirmed a separate production target.
- Architecture constraints: preserve the Laravel/Inertia runtime, localized
  public/admin routes, database-backed queue/cache contract, and public media
  storage contract.

### 2. Select One Priority Task
- Selected task: FEA-021 production deployment.
- Priority rationale: it is the direct user request and the highest-impact
  current delivery blocker.
- Why other candidates were deferred: visual portfolio implementation and CMS
  feature expansion follow after the runtime is safely deployable.

### 3. Plan Implementation
- Files or surfaces to modify: deployment/context documentation and only the
  selected Coolify project/environment.
- Logic: reuse the existing Coolify post-deploy maintenance contract and
  Laravel `/up` health endpoint.
- Edge cases: existing target resources, missing env values, persistent media,
  failed migrations, failed health checks, DNS/SSL propagation, and rollback.

### 4. Execute Implementation
- Implementation notes: the selected environment now contains the Featherly
  application, a dedicated PostgreSQL database, production-only secrets,
  persistent public media storage, `/up` healthcheck, and Laravel scheduler.
  The repository also contains the documented Coolify/Nixpacks all-in-one
  runtime with Nginx, PHP-FPM, and two queue workers.

### 5. Verify and Test
- Validation performed: `npm run build`, `npm run lint`,
  `npm run format:check`, `composer deptrac`, a focused backend feature test,
  and PHPStan under both PHP 8.5 and the declared PHP 8.3-compatible runtime.
- Result: frontend checks and dependency architecture pass; the focused
  backend test passes with an explicit test `APP_KEY`; the 20 PHPStan findings
  were resolved and PHPStan now passes on PHP 8.3.

### 6. Self-Review
- Simpler option considered: deploy the existing Featherly repository directly
  instead of duplicating the CMS into a second application codebase.
- Technical debt introduced: no.
- Scalability assessment: one production instance is within the approved
  current deployment model.
- Refinements made: production and existing staging targets remain distinct.

### 7. Update Documentation and Knowledge
- Docs updated: task contract, task board, project state, Coolify deployment
  contract.
- Context updated: yes.
- Learning journal updated: not applicable.

## Acceptance Criteria
- [ ] The selected Coolify project deploys the Featherly repository without
  deleting or modifying unrelated Coolify resources.
- [ ] `https://wroblewskipatryk.pl/up` and the localized public route return
  successful responses over HTTPS.
- [ ] Database migrations, persistent public media, admin login route, queue,
  scheduler, refresh behavior, and rollback path are verified with evidence.

## Success Signal
- User or operator problem: no production Featherly instance currently serves
  the owner's portfolio domain.
- Expected product or reliability outcome: the domain runs the owner's CMS as
  the base for subsequent portfolio implementation.
- How success will be observed: successful Coolify deployment plus production
  smoke evidence.
- Post-launch learning needed: yes.

## Deliverable For This Stage
A production-ready and verified Featherly deployment in the explicitly selected
Coolify project/environment, or a truthful blocked report naming the exact
missing access or deployment evidence.

## Constraints
- Reuse existing Featherly and Coolify contracts.
- Preserve localized routing and admin/public authorization boundaries.
- Do not delete or modify unrelated Coolify resources.
- Do not commit secrets or expose them in browser-visible configuration.
- Do not bypass failed deployment gates.

## Definition of Done
- [ ] Code builds without errors.
- [ ] The real production operator and browser paths work.
- [ ] Migrations and persistent media work after restart/redeploy.
- [ ] Health, logs, queue/scheduler, smoke, and rollback evidence are recorded.
- [ ] Relevant project and operations documentation is synchronized.
- [ ] `DEFINITION_OF_DONE.md` was checked before status changed to `DONE`.

## Validation Evidence
- Tests:
  - `npm run build`: pass, with a non-blocking large-chunk warning.
  - `npm run lint`: pass.
  - `npm run format:check`: pass.
  - `composer deptrac`: pass with 0 violations and 0 errors; the abandoned
    shim emits PHP 8.5 deprecation warnings.
  - `php artisan test --filter=AdminForgotPasswordFlowTest` with an explicit
    local test `APP_KEY`: pass, 2 tests and 6 assertions; missing `.env`
    warnings remain in the container-only local check.
  - `vendor/bin/phpstan analyse` on PHP 8.3 after deployment-readiness fixes:
    pass with no errors.
  - A first broader test attempt without `APP_KEY` was invalid and stopped
    after confirming `MissingAppKeyException`; it is not acceptance evidence.
- Manual checks: pending.
- Screenshots/logs: Coolify shows the dedicated PostgreSQL resource running;
  the application resource is configured and awaits its first deployment.
- High-risk checks: no target resource was modified or deleted.
- Coverage ledger updated: not applicable.

## Integration Evidence
- `INTEGRATION_CHECKLIST.md` reviewed: yes.
- Real API/service path used: pending Coolify access.
- DB schema and migrations verified: pending.
- Refresh/restart behavior verified: pending.
- Regression check performed: pending.

## Reliability / Observability Evidence
- `docs/operations/service-reliability-and-observability.md` reviewed: yes.
- Critical user journey: public visitor opens the localized portfolio and an
  administrator opens the localized admin login.
- SLI: HTTPS availability and correct application response.
- Health/readiness check: `/up` plus `php artisan ops:health-check --json`.
- Logs, dashboard, or alert route: Coolify deployment/runtime logs; optional
  Sentry when configured.
- Smoke command or manual smoke: production URL, `/up`, localized public/admin
  routes, and one uploaded `/storage/media/...` asset.
- Rollback or disable path: previous successful Coolify deployment.

## Security / Privacy Evidence
- `docs/security/secure-development-lifecycle.md` reviewed: yes.
- Data classification: account credentials, application secret, database
  credentials, and administrator data are confidential.
- Trust boundaries: browser to Coolify, Coolify to GitHub, proxy to Laravel,
  Laravel to database/storage/queue.
- Secret handling: secrets remain only in Coolify secret environment values.
- Fail-closed behavior: deployment stays blocked while required access or
  secrets are unavailable.

## Architecture Evidence
- Architecture source reviewed: `docs/architecture/README.md`,
  `architecture-source-of-truth.md`, `system-architecture.md`, `tech-stack.md`,
  and `current-implementation-map.md`.
- Fits approved architecture: yes.
- Mismatch discovered: no.
- Decision required from user: only if valid Coolify access cannot be restored.

## Deployment / Ops Evidence
- Deploy impact: high.
- Env or secret changes: production-only values in the selected Coolify
  environment; exact values pending target inspection.
- Health-check impact: production `/up` must be configured and pass.
- Smoke steps updated: production evidence pending.
- Rollback note: use the prior successful Coolify deployment and preserve the
  production database and media volume.
- Observability or alerting impact: deployment/runtime logs are required.
- Staged rollout or feature flag: initial deployment in the selected project.
- `DEPLOYMENT_GATE.md` reviewed: yes.

## Result Report
- Task summary: production infrastructure and runtime configuration prepared;
  first deployment and smoke verification are in progress.
- Files changed: deployment runtime, narrow PHPStan readiness fixes, and
  task/context/operations documentation.
- How tested: frontend build/lint/format, dependency architecture, focused
  backend feature test, PHPStan on PHP 8.3, authoritative DNS queries, and
  direct HTTP/HTTPS probes against the VPS.
- What is incomplete: first deployment and all production smoke evidence.
- Next steps: push the verified revision, deploy it in the selected resource,
  and capture health, route, migration, worker, scheduler, media, and rollback
  evidence without deleting any existing resource.
- Decisions made: use Featherly directly as the production application rather
  than maintaining a duplicated frontend codebase.
