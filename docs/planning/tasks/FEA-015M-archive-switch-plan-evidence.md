# Task

## Header
- ID: FEA-015M
- Title: Add archive switch and rollback plan evidence
- Task Type: feature
- Current Stage: verification
- Status: DONE
- Owner: Backend Builder
- Depends on: FEA-015L
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
Archive staging validation proves the artifact can be extracted and contains
the required Laravel release files. Before any live switch can be implemented,
operators need deterministic switch and rollback evidence.

## Goal
Generate a no-switch archive switch plan after staging validation, recording
the release path, preserve paths, required pre-switch approvals, and rollback
strategy.

## Scope
- Archive driver switch-plan JSON generation.
- Update status evidence for switch-plan path and generated timestamp.
- Regression coverage in ZIP-enabled archive staging test.
- Architecture, reliability, planning, and context docs.

## Implementation Plan
1. Generate a switch-plan JSON file inside archive staging after extraction
   validation succeeds.
2. Record target version, archive filename, extracted directory, release path,
   preserve paths, required pre-switch approvals, and rollback strategy.
3. Persist switch-plan evidence in update status.
4. Keep live files untouched and do not mark the update applied.
5. Update tests and documentation.

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: staging validation had no explicit switch/rollback handoff evidence.
- Gaps: preserve paths and pre-switch requirements were documented but not
  recorded with the staged artifact.
- Inconsistencies: FEA-015 still needed switch/rollback gate evidence.
- Architecture constraints: no live switch without explicit approval and
  rollback implementation.

### 2. Select One Priority Task
- Selected task: FEA-015M archive switch/rollback plan evidence.
- Priority rationale: plan evidence is the smallest safe step before live
  switch execution.
- Why other candidates were deferred: actual switch and rollback are higher
  risk and should not be implemented implicitly.

### 3. Plan Implementation
- Files or surfaces to modify: archive driver, update manager status fields,
  update command tests, architecture and operations docs.
- Logic: write JSON plan after successful staging validation and store its path
  in `system_update_status`.
- Edge cases: failed plan write, repeated staging validation, no live mutation.

### 4. Execute Implementation
- Implementation notes: added `writeSwitchPlan()` and persisted plan evidence
  fields.

### 5. Verify and Test
- Validation performed: normal update tests, ZIP-enabled PHPUnit tests,
  settings tests.
- Result: ZIP-enabled staging test asserts the plan exists and contains target
  version, release path, preserve paths, and no-live-change rollback marker.

### 6. Self-Review
- Simpler option considered: keep switch plan only in docs.
- Technical debt introduced: no.
- Scalability assessment: the generated plan can become the input contract for
  a later guarded switch command.
- Refinements made: switch plan records that this step changed no live files.

### 7. Update Documentation and Knowledge
- Docs updated: architecture map, update manager contract, service reliability,
  MVP plan, next commits, task board, project state, and FEA-015 evidence.
- Context updated: yes.
- Learning journal updated: not applicable.

## Acceptance Criteria
- [x] Switch plan is generated after successful archive staging validation.
- [x] Plan records preserve paths and rollback strategy.
- [x] Update status records plan path and generated timestamp.
- [x] Live files are not switched or marked applied.

## Success Signal
- User or operator problem: switching live files without a recorded plan risks
  losing local runtime state or rollback clarity.
- Expected product or reliability outcome: archive switch work has a concrete
  evidence artifact before implementation.
- How success will be observed: `archive_switch_status=planned` and switch
  plan JSON exists in staging.
- Post-launch learning needed: yes.

## Deliverable For This Stage
Verified no-switch switch/rollback plan evidence.

## Constraints
- Do not switch live files.
- Do not run migrations.
- Do not mark update applied.
- Keep switch execution behind a future explicit approval.

## Definition of Done
- [x] Code builds without errors.
- [x] Feature works through the existing CLI/operator path.
- [x] No mock, placeholder, fake, or temporary path remains in production
  behavior.
- [x] Full data flow works across archive staging, switch-plan write, status
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
- Tests: `php artisan test --filter=SystemUpdateCheckCommandTest`;
  `php -d extension=zip vendor/bin/phpunit --filter
  SystemUpdateCheckCommandTest`; `php artisan test
  --filter=SettingsManagementTest`.
- Manual checks: reviewed generated switch-plan assertions.
- Screenshots/logs: PHPUnit command output.
- High-risk checks: switch plan records `live_files_changed_by_this_step=false`.
- Coverage ledger updated: not applicable.
- Coverage rows closed or changed:

## Integration Evidence
- `INTEGRATION_CHECKLIST.md` reviewed: yes.
- Real API/service path used: HTTP archive download covered with fake.
- Endpoint and client contract match: not applicable.
- DB schema and migrations verified: not applicable.
- Loading state verified: not applicable.
- Error state verified: yes.
- Refresh/restart behavior verified: plan evidence persists in settings.
- Regression check performed: targeted command tests.

## Reliability / Observability Evidence
- `docs/operations/service-reliability-and-observability.md` reviewed: yes.
- Critical user journey: operator reviews a deterministic switch/rollback plan
  before file replacement.
- SLI: staged archive records `archive_switch_status=planned`.
- SLO: local JSON write after staging validation.
- Error budget posture: healthy.
- Health/readiness check: not applicable before live switch.
- Logs, dashboard, or alert route: admin update status and switch-plan file.
- Smoke command or manual smoke: archive `updates:apply --force` staging path.
- Rollback or disable path: no live files changed.

## Security / Privacy Evidence
- `docs/security/secure-development-lifecycle.md` reviewed: yes.
- Data classification: local filesystem paths and update status.
- Trust boundaries: staged release artifact to operator-reviewed switch plan.
- Permission or ownership checks: server-side CLI/admin apply path.
- Abuse cases: switching without backup, losing `.env` or `storage`, unclear
  rollback.
- Secret handling: no secrets added.
- Security tests or scans: regression test asserts no-live-change rollback
  marker.
- Fail-closed behavior: no switch execution exists in this slice.
- Residual risk: live switch and rollback implementation still pending.

## Architecture Evidence
- Architecture source reviewed:
  `docs/architecture/system-update-manager-contract.md`.
- Fits approved architecture: yes.
- Mismatch discovered: no.
- Decision required from user: no.
- Approval reference if architecture changed: not applicable.
- Follow-up architecture doc updates: none.

## Deployment / Ops Evidence
- Deploy impact: medium.
- Env or secret changes: none.
- Health-check impact: none.
- Smoke steps updated: service reliability notes updated.
- Rollback note: plan records rollback strategy, but rollback execution is not
  implemented.
- Observability or alerting impact: switch-plan status is persisted.
- Staged rollout or feature flag: archive still does not switch files.
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
- [x] Docs or context were updated if repository truth changed.
- [x] Learning journal was updated if a recurring pitfall was confirmed.

## Result Report
- Task summary: archive staging now writes switch/rollback plan evidence
  without switching live files.
- Files changed: `app/Services/SystemUpdates/Drivers/ArchiveUpdateDriver.php`,
  `app/Services/SystemUpdates/UpdateManager.php`,
  `tests/Feature/SystemUpdateCheckCommandTest.php`, and synchronized docs.
- How tested: targeted PHPUnit feature tests with and without ZIP enabled.
- What is incomplete: archive live switch execution, migration handling,
  rollback execution, and captured staging/live Coolify rollout evidence.
- Next steps: implement guarded live switch only with explicit approval or
  capture Coolify evidence.
- Decisions made: switch planning is evidence-only and not execution.

## Notes
This slice intentionally prepares the handoff for future switch execution
without changing live application files.
