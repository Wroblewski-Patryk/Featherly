# Task

## Header
- ID: FEA-015O
- Title: Add archive rollback command from recorded backup
- Task Type: feature
- Current Stage: verification
- Status: DONE
- Owner: Backend Builder
- Depends on: FEA-015N
- Priority: P1
- Coverage Ledger Rows:
- Iteration:
- Operation Mode: TESTER

## Process Self-Audit
- [x] All seven autonomous loop steps are planned.
- [x] No loop step is being skipped.
- [x] Exactly one priority task is selected.
- [x] Operation mode matches the iteration number once execution starts.
- [x] The task is aligned with repository source-of-truth documents.

## Context
Archive switch execution records `archive_backup_path`, but rollback still
needed a reproducible command path before archive v1 could be considered
recoverable.

## Goal
Provide an explicit operator command that restores the configured archive
release path from the recorded backup while preserving local runtime paths.

## Scope
- `updates:rollback-archive --force` command.
- Archive rollback logic using `system_update_status.archive_backup_path`.
- Status evidence for rolled-back archive switch attempts.
- Regression coverage for restored release files and preserved local state.
- Architecture, operations, planning, and context docs.

## Implementation Plan
1. Add archive rollback behavior to the archive driver.
2. Add `UpdateManager::rollbackArchiveUpdate()` to persist rollback evidence and
   audit events.
3. Add an operator command that requires `--force`.
4. Cover rollback with a feature test that restores backup files, removes
   switched-only files, and preserves `.env` and `storage`.
5. Synchronize docs and task context.

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: archive switch had backup evidence but no command to restore it.
- Gaps: rollback was documented as an operator procedure only.
- Inconsistencies: FEA-015 done criteria still required rollback command or
  explicit deferral.
- Architecture constraints: rollback must preserve local runtime state.

### 2. Select One Priority Task
- Selected task: FEA-015O archive rollback command.
- Priority rationale: it closes the archive recovery gap left by the gated
  switch slice.
- Why other candidates were deferred: Coolify rollout evidence requires a live
  environment and should be recorded separately.

### 3. Plan Implementation
- Files or surfaces to modify: archive driver, update manager, console command,
  update command tests, architecture and operations docs.
- Logic: validate backup, remove release files except preserve paths, copy
  backup files while skipping preserve paths, validate required Laravel files.
- Edge cases: missing backup, invalid backup, missing release files after
  restore, accidental rollback without force.

### 4. Execute Implementation
- Implementation notes: added `updates:rollback-archive --force` and rollback
  status fields.

### 5. Verify and Test
- Validation performed: targeted rollback test plus update command suite.
- Result: rollback restores old release files, removes new-only files, preserves
  current `.env` and `storage`, and records `archive_switch_status=rolled_back`.

### 6. Self-Review
- Simpler option considered: keep rollback as documentation only.
- Technical debt introduced: no new runtime driver; Coolify evidence remains.
- Scalability assessment: command uses the same backup evidence created during
  switch and can be extended with richer audit UI later.
- Refinements made: command requires `--force`.

### 7. Update Documentation and Knowledge
- Docs updated: architecture map, update manager contract, rollback and
  reliability docs, MVP plan, next commits, task board, project state, and
  FEA-015 evidence.
- Context updated: yes.
- Learning journal updated: not applicable.

## Acceptance Criteria
- [x] Archive rollback command exists and requires `--force`.
- [x] Rollback validates the recorded backup path.
- [x] Rollback restores release files from backup.
- [x] Rollback preserves `.env`, `storage`, and `public/storage`.
- [x] Rollback records status evidence.
- [x] Regression coverage proves restore and preservation behavior.

## Success Signal
- User or operator problem: a failed archive switch needs a deterministic
  recovery command rather than handwritten file operations.
- Expected product or reliability outcome: archive v1 has tested switch and
  rollback paths.
- How success will be observed: `apply_status=archive_rolled_back` and
  `archive_switch_status=rolled_back`.
- Post-launch learning needed: yes.

## Deliverable For This Stage
Verified archive rollback command from recorded backup.

## Constraints
- Do not run migrations automatically.
- Do not roll back without explicit `--force`.
- Preserve local runtime state.
- Keep behavior server-side only.

## Definition of Done
- [x] Code builds without errors.
- [x] Feature works through the existing CLI/operator path.
- [x] No mock, placeholder, fake, or temporary path remains in production
  behavior.
- [x] Full data flow works across backup path, release restore, status
  persistence, and tests.
- [x] Backend error handling exists.
- [x] No existing functionality is broken.
- [x] Changes are documented in the relevant source of truth.
- [x] Behavior is reproducible from validation evidence.
- [x] Reliability, security, deployment, and rollback evidence are recorded.
- [x] `DEFINITION_OF_DONE.md` was checked before status changed to `DONE`.

## Stage Exit Criteria
- [x] The output matches the declared `Current Stage`.
- [x] Work from later stages was not mixed in without explicit approval.
- [x] Risks and assumptions for this stage are stated clearly.

## Validation Evidence
- Tests: `php artisan test --filter=test_archive_rollback_restores_backup_and_preserves_local_state`;
  `php artisan test --filter=SystemUpdateCheckCommandTest`.
- Manual checks: `php artisan list updates` shows `updates:rollback-archive`.
- Screenshots/logs: Artisan/PHPUnit command output.
- High-risk checks: command requires `--force` and preserves local runtime
  paths.
- Coverage ledger updated: not applicable.
- Coverage rows closed or changed:

## Integration Evidence
- `INTEGRATION_CHECKLIST.md` reviewed: yes.
- Real API/service path used: local filesystem recovery path.
- Endpoint and client contract match: not applicable.
- DB schema and migrations verified: not applicable.
- Loading state verified: not applicable.
- Error state verified: yes.
- Refresh/restart behavior verified: status persists in settings.
- Regression check performed: targeted command tests.

## Reliability / Observability Evidence
- `docs/operations/service-reliability-and-observability.md` reviewed: yes.
- Critical user journey: operator restores archive release files from a known
  backup after switch failure.
- SLI: `archive_switch_status=rolled_back`.
- SLO: bounded local filesystem operation from recorded backup path.
- Error budget posture: healthy.
- Health/readiness check: post-rollback smoke and `updates:confirm` remain
  required.
- Logs, dashboard, or alert route: audit event and admin update status.
- Smoke command or manual smoke: `php artisan updates:rollback-archive --force`.
- Rollback or disable path: this task is the rollback path.

## Security / Privacy Evidence
- `docs/security/secure-development-lifecycle.md` reviewed: yes.
- Data classification: local filesystem paths and update status.
- Trust boundaries: recorded backup path to configured release filesystem.
- Permission or ownership checks: server-side CLI/operator path.
- Abuse cases: accidental rollback, invalid backup, local state loss.
- Secret handling: `.env` is preserved and not exposed.
- Security tests or scans: regression test covers preservation.
- Fail-closed behavior: missing or invalid backup fails before restore.
- Residual risk: host-level filesystem permissions can still block rollback.

## Architecture Evidence
- Architecture source reviewed:
  `docs/architecture/system-update-manager-contract.md`.
- Fits approved architecture: yes.
- Mismatch discovered: no.
- Decision required from user: no.
- Approval reference if architecture changed: user requested continuing to v1 on
  2026-05-01.
- Follow-up architecture doc updates: none.

## Deployment / Ops Evidence
- Deploy impact: medium; adds operator recovery command.
- Env or secret changes: none.
- Health-check impact: post-rollback confirmation and smoke remain required.
- Smoke steps updated: rollback and reliability notes updated.
- Rollback note: rollback command restores from `archive_backup_path`.
- Observability or alerting impact: rollback status is persisted and audited.
- Staged rollout or feature flag: command requires `--force`.
- `DEPLOYMENT_GATE.md` reviewed: yes.

## Review Checklist (mandatory)
- [x] Process self-audit completed before implementation.
- [x] Autonomous loop evidence covers all seven steps.
- [x] Exactly one priority task was completed in this iteration.
- [x] Operation mode was selected according to iteration rotation.
- [x] Current stage is declared and respected.
- [x] Deliverable for the current stage is complete.
- [x] Architecture alignment confirmed.
- [x] Existing systems were reused where applicable.
- [x] No workaround paths were introduced.
- [x] No temporary solution was introduced.
- [x] No logic duplication was introduced.
- [x] Integration checklist evidence is attached where applicable.
- [x] AI testing evidence is attached where applicable.
- [x] Deployment gate evidence is attached.
- [x] Definition of Done evidence is attached.
- [x] Relevant validations were run.
- [x] Docs or context were updated.
- [x] Learning journal was updated if a recurring pitfall was confirmed.

## Result Report
- Task summary: added archive rollback command from recorded backup.
- Files changed: archive driver, update manager, rollback command, update
  command tests, architecture docs, operations docs, planning docs, task board,
  and project state.
- How tested: targeted rollback test, update command suite, command discovery,
  and diff checks.
- What is incomplete: captured Coolify staging/live rollout evidence.
- Next steps: capture Coolify rollout evidence or record the environment
  blocker before closing FEA-015 v1.
