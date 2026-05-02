# FEA-020 Coolify Post-Deploy Maintenance

## Header
- ID: FEA-020
- Title: Add Coolify post-deploy cache and migration maintenance
- Task Type: fix
- Current Stage: verification
- Status: DONE
- Owner: Ops/Release
- Depends on: FEA-015
- Priority: P0
- Iteration: 20
- Operation Mode: TESTER

## Process Self-Audit
- [x] All seven autonomous loop steps are represented.
- [x] No loop step was skipped.
- [x] Exactly one priority task was selected.
- [x] Operation mode matches iteration 20.
- [x] The task is aligned with deployment and media architecture docs.

## Goal
Make Coolify redeploys automatically clear stale Laravel cache, ensure public
storage linkage, run migrations, and rebuild production cache.

## Scope
- `scripts/coolify-post-deploy.sh`
- `composer.json`
- `.env.example`
- Coolify/post-deploy operations docs and project context

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: production media upload wrote records and files, but public
  `/storage/media/...` URLs returned `404` until storage routing/config was
  refreshed and deployed.
- Gaps: no explicit post-deploy entrypoint existed for cache refresh,
  `storage:link`, and migrations.
- Inconsistencies: Coolify docs mentioned migrations but not a concrete
  maintenance command.
- Architecture constraints: keep Coolify as the deployment executor and keep
  Featherly-owned deploy maintenance deterministic and idempotent.

### 2. Select One Priority Task
- Selected task: add one reusable Coolify post-deploy maintenance entrypoint.
- Priority rationale: stale route/config cache can keep production on old
  storage behavior after redeploy.
- Why other candidates were deferred: full Coolify rollout evidence still needs
  the target environment after deployment.

### 3. Plan Implementation
- Files or surfaces to modify: deploy script, Composer script alias, env
  example flags, and ops/planning/context docs.
- Logic: clear old cache, recreate public storage link, run forced migrations,
  rebuild production cache.
- Edge cases: emergency windows can disable migrations or cache rebuild through
  environment flags.

### 4. Execute Implementation
- Implementation notes: added `scripts/coolify-post-deploy.sh` and
  `composer deploy:coolify`.

### 5. Verify and Test
- Validation performed:
  - `composer validate --no-check-publish`
  - `php artisan optimize --no-interaction`
  - `php artisan route:list --name=storage`
  - `php artisan optimize:clear --no-interaction`
  - `php artisan route:list --name=storage`
  - `php artisan test tests\Feature\Admin\MediaManagementTest.php`
  - `git diff --check`
- Result: Composer JSON is valid; storage route remains `storage.public` before
  and after cache clear; media tests pass.

### 6. Self-Review
- Simpler option considered: only document a Coolify UI command.
- Technical debt introduced: no.
- Scalability assessment: script is safe as a single deploy hook and can absorb
  future deploy maintenance commands.
- Refinements made: added env toggles for emergency migration/cache windows.

### 7. Update Documentation and Knowledge
- Docs updated: Coolify deployment contract, rollout runbook, post-deploy
  smoke, MVP planning docs.
- Context updated: project state and task board.
- Learning journal updated: not applicable.

## Acceptance Criteria
- [x] Coolify has one command for post-deploy maintenance.
- [x] The command clears/rebuilds Laravel cache and runs migrations.
- [x] Ops docs name the command and smoke evidence required.

## Result Report
- Task summary: added `composer deploy:coolify` and
  `scripts/coolify-post-deploy.sh` for automatic post-redeploy maintenance.
- Files changed: deploy script, Composer script, env example, ops/planning
  docs, project context.
- How tested: validation commands listed above.
- What is incomplete: target Coolify must run the command during the next
  redeploy and attach evidence.
- Next steps: deploy and confirm `/storage/media/...` returns the uploaded
  asset.
