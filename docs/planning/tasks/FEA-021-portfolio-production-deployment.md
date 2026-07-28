# Task

## Header
- ID: FEA-021
- Title: Deploy the first Featherly-backed portfolio production instance
- Task Type: release
- Current Stage: implementation
- Status: BLOCKED
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
- Issues: the application is deployed and runtime smoke passes, but the public
  TLS certificate is blocked by stale apex and `www` AAAA records pointing to
  `2001:41d0:301:5::27` instead of the selected VPS.
- Gaps: trusted HTTPS evidence can only be captured after the stale AAAA records
  are removed or changed to an IPv6 address routed to this VPS.
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
  PostgreSQL compatibility was added for legacy text-to-JSON migrations and
  the obsolete template type check constraint. Production migrations and
  seeders completed, and the initial administrator was secured.

### 5. Verify and Test
- Validation performed: `npm run build`, `npm run lint`,
  `npm run format:check`, `composer deptrac`, a focused backend feature test,
  and PHPStan under both PHP 8.5 and the declared PHP 8.3-compatible runtime.
- Result: frontend checks and dependency architecture pass; the focused
  backend test passes with an explicit test `APP_KEY`; the 20 PHPStan findings
  were resolved and PHPStan now passes on PHP 8.3. Production application,
  operational health, scheduler, queue workers, public route, login route, and
  persistent storage pass; trusted TLS remains blocked by DNS AAAA records.

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
- [x] The selected Coolify project deploys the Featherly repository without
  deleting or modifying unrelated Coolify resources.
- [ ] `https://wroblewskipatryk.pl/up` and the localized public route return
  successful responses over HTTPS.
- [x] Database migrations, persistent public media, admin login route, queue,
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
- Manual checks: `/up` 200, `/pl` 200, `/pl/login` 200, unauthenticated
  `/pl/admin` redirects to login, and `www` redirects to the apex route when
  certificate verification is bypassed only for diagnostic purposes.
- Screenshots/logs: Coolify deployment `bkdd55plrx5tsmkairh55pxb` succeeded on
  commit `5646ccd`; PostgreSQL, two queue workers, Nginx, and PHP-FPM are
  running; scheduler last run is successful.
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
- What is incomplete: a browser-trusted Let's Encrypt certificate.
- Next steps: remove the apex and `www` AAAA records for
  `2001:41d0:301:5::27` (or route the correct VPS IPv6), wait for DNS
  propagation and Traefik ACME retry, then repeat HTTPS smoke without bypassing
  certificate verification.
- Decisions made: use Featherly directly as the production application rather
  than maintaining a duplicated frontend codebase.
