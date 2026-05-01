# Task

## Header
- ID: FEA-015N
- Title: Add gated archive live switch with backup and preserve paths
- Task Type: feature
- Current Stage: verification
- Status: DONE
- Owner: Backend Builder
- Depends on: FEA-015M
- Priority: P1
- Coverage Ledger Rows:
- Iteration:
- Operation Mode: BUILDER

## Process Self-Audit
- [x] All seven autonomous loop steps are planned.
- [x] No loop step is being skipped.
- [x] Exactly one priority task is selected.
- [x] Operation mode matches the iteration number once execution starts.
- [x] The task is aligned with repository source-of-truth documents.

## Context
Archive staging now verifies integrity, extracts the artifact, validates
required release files, and writes a switch/rollback plan. The next safe
segment is an explicitly gated live switch that only runs when the operator
enables it through environment configuration.

## Goal
Switch a validated staged archive into the configured release path only when
`FEATHERLY_UPDATE_ARCHIVE_SWITCH_ENABLED=true`, while preserving local runtime
state and recording backup evidence for operator rollback.

## Scope
- Archive switch feature flag configuration.
- Current release backup under archive staging.
- Preserve `.env`, `storage`, and `public/storage` during file replacement.
- Persist switch timestamp and backup path in update status.
- Regression coverage for successful gated switch behavior.
- Architecture, operations, planning, and context docs.

## Implementation Plan
1. Add an archive switch-enabled configuration flag.
2. After archive staging validation and switch-plan generation, run live switch
   only when the flag is enabled.
3. Back up the existing release path before deleting or copying files.
4. Preserve local runtime paths during removal and copy operations.
5. Validate required Laravel release files after switch and restore backup on
   validation failure.
6. Persist switch evidence and update docs.

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: archive staging stopped before live file replacement.
- Gaps: no tested path proved local runtime state could survive archive switch.
- Inconsistencies: architecture allowed archive switch only after explicit gate
  and rollback evidence.
- Architecture constraints: no unattended archive auto-apply by default.

### 2. Select One Priority Task
- Selected task: FEA-015N gated archive live switch.
- Priority rationale: it closes the next implementation gap while preserving
  the fail-closed default.
- Why other candidates were deferred: rollback command and Coolify evidence are
  separate tasks with different risk surfaces.

### 3. Plan Implementation
- Files or surfaces to modify: archive driver, update manager status fields,
  update config, update command tests, and docs.
- Logic: switch only from a validated extracted directory, copy existing
  release into backup, preserve local paths, copy staged release files, then
  validate required files.
- Edge cases: missing release path, missing extracted directory, repeated test
  runs, invalid switched release, and path-constrained deletion.

### 4. Execute Implementation
- Implementation notes: added `switchRelease()` and path-preserving copy/remove
  helpers behind `FEATHERLY_UPDATE_ARCHIVE_SWITCH_ENABLED`.

### 5. Verify and Test
- Validation performed: ZIP-enabled archive switch test and full
  `SystemUpdateCheckCommandTest` suite.
- Result: the switch test verifies backup creation, old release removal,
  staged release copy, `.env`/`storage`/`public/storage` preservation, and
  persisted `archive_backup_path`.

### 6. Self-Review
- Simpler option considered: copy staged files over release without backup.
- Technical debt introduced: archive rollback remains an operator procedure.
- Scalability assessment: the recorded backup path can become the rollback
  command input.
- Refinements made: deletion is constrained to the configured allowed root.

### 7. Update Documentation and Knowledge
- Docs updated: architecture map, update manager contract, rollback and
  reliability docs, MVP plan, next commits, task board, project state, and
  FEA-015 evidence.
- Context updated: yes.
- Learning journal updated: not applicable.

## Acceptance Criteria
- [x] Archive live switch is disabled by default.
- [x] Switch runs only when `FEATHERLY_UPDATE_ARCHIVE_SWITCH_ENABLED=true`.
- [x] Current release path is backed up before replacement.
- [x] `.env`, `storage`, and `public/storage` are preserved.
- [x] Update status records `archive_switched_at` and `archive_backup_path`.
- [x] Required release files are validated after switch.

## Success Signal
- User or operator problem: shared-host archive updates need a safe path to
  replace code without losing installation-specific files.
- Expected product or reliability outcome: archive switching is explicit,
  reversible by operator backup, and regression-tested.
- How success will be observed: successful apply records
  `apply_status=archive_switched` and `archive_switch_status=switched`.
- Post-launch learning needed: yes.

## Deliverable For This Stage
Verified gated archive switch execution with backup and local-state
preservation.

## Constraints
- Do not enable switch by default.
- Do not run migrations automatically.
- Do not implement unattended rollback in this slice.
- Preserve the admin/public and server-side update boundaries.

## Definition of Done
- [x] Code builds without errors.
- [x] Feature works through the existing CLI/operator path.
- [x] No mock, placeholder, fake, or temporary path remains in production
  behavior.
- [x] Full data flow works across archive staging, release backup, switch,
  status persistence, and tests.
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
- Tests: `php -d extension=zip vendor/bin/phpunit --filter
  test_archive_apply_switches_release_when_explicitly_enabled_and_preserves_local_state`;
  `php -d extension=zip vendor/bin/phpunit --filter
  SystemUpdateCheckCommandTest`; `php artisan test
  --filter=SystemUpdateCheckCommandTest`.
- Manual checks: reviewed switch status and backup assertions.
- Screenshots/logs: PHPUnit command output.
- High-risk checks: switch path stays env-gated and preserves local runtime
  paths.
- Coverage ledger updated: not applicable.
- Coverage rows closed or changed:

## Integration Evidence
- `INTEGRATION_CHECKLIST.md` reviewed: yes.
- Real API/service path used: HTTP archive download covered with fake.
- Endpoint and client contract match: not applicable.
- DB schema and migrations verified: not applicable.
- Loading state verified: not applicable.
- Error state verified: yes.
- Refresh/restart behavior verified: status persists in settings.
- Regression check performed: targeted command tests.

## Reliability / Observability Evidence
- `docs/operations/service-reliability-and-observability.md` reviewed: yes.
- Critical user journey: operator can explicitly switch a verified archive into
  a release path and retain backup evidence.
- SLI: `archive_switch_status=switched` plus `archive_backup_path`.
- SLO: bounded local filesystem operation after archive validation.
- Error budget posture: healthy.
- Health/readiness check: post-switch smoke and `updates:confirm` remain
  required.
- Logs, dashboard, or alert route: admin update status and audit events.
- Smoke command or manual smoke: archive `updates:apply --force` switch path.
- Rollback or disable path: disable switch flag or restore the recorded backup
  path manually.

## Security / Privacy Evidence
- `docs/security/secure-development-lifecycle.md` reviewed: yes.
- Data classification: local filesystem paths and update status.
- Trust boundaries: staged release artifact to configured release filesystem.
- Permission or ownership checks: server-side CLI/admin apply path.
- Abuse cases: path traversal, accidental deletion, local state loss, unsafe
  auto-apply.
- Secret handling: `.env` is preserved and not exposed in status.
- Security tests or scans: path-constrained deletion and regression coverage.
- Fail-closed behavior: switch does not run unless env flag is enabled.
- Residual risk: automated rollback command still pending.

## Architecture Evidence
- Architecture source reviewed:
  `docs/architecture/system-update-manager-contract.md`.
- Fits approved architecture: yes.
- Mismatch discovered: no.
- Decision required from user: no.
- Approval reference if architecture changed: user requested continuing this
  task segment on 2026-05-01.
- Follow-up architecture doc updates: none.

## Deployment / Ops Evidence
- Deploy impact: high when switch flag is enabled.
- Env or secret changes: optional
  `FEATHERLY_UPDATE_ARCHIVE_SWITCH_ENABLED=true`.
- Health-check impact: post-switch confirmation and smoke remain required.
- Smoke steps updated: rollback and reliability notes updated.
- Rollback note: use recorded `archive_backup_path`; automated rollback command
  is still pending.
- Observability or alerting impact: switch and backup status are persisted.
- Staged rollout or feature flag: env-gated switch.
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
- Task summary: added explicitly gated archive live switch execution with
  backup and local-state preservation.
- Files changed: `config/updates.php`,
  `app/Services/SystemUpdates/Drivers/ArchiveUpdateDriver.php`,
  `app/Services/SystemUpdates/UpdateManager.php`,
  `tests/Feature/SystemUpdateCheckCommandTest.php`, architecture docs,
  operations docs, planning docs, task board, and project state.
- How tested: ZIP-enabled targeted archive switch test, full update command
  suite with ZIP, standard update command suite without ZIP, and diff checks.
- What is incomplete: archive rollback command and captured Coolify staging/live
  evidence.
- Next steps: add archive rollback command coverage or capture Coolify rollout
  evidence from the runbook.
