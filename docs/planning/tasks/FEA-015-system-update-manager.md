# Task

## Header
- ID: FEA-015
- Title: Design and implement environment-adaptive System Update Manager
- Task Type: feature
- Current Stage: planning
- Status: READY
- Owner: Backend Builder
- Depends on: `docs/architecture/system-update-manager-contract.md`
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
Featherly needs WordPress-like update behavior for both maintainer-controlled
deployments, such as Coolify on a VPS, and third-party self-hosted
installations where the maintainer has no server access.

The architecture decision is recorded in
`docs/architecture/system-update-manager-contract.md`: the app owns update
discovery, settings, status, and safety checks; update application is delegated
to a safe environment-specific driver.

## Goal
Implement a System Update Manager that checks for trusted Featherly releases,
shows update state in the admin panel, allows automatic updates to be enabled
or disabled, and applies updates only through a supported driver that passes
preflight checks.

## Scope
- Update settings and status persistence.
- Admin settings/status surface under the existing admin boundary.
- Laravel scheduler command for daily update checks.
- Release manifest client and version comparison.
- Update driver interface and first driver implementations:
  - `coolify`
  - `archive`
  - `manual`
- Fake or test driver for automated tests.
- Audit logging for checks and attempts.
- Deployment, rollback, smoke, and security documentation updates.

Out of scope for the first implementation slice:

- marketplace/plugin updates
- self-modifying code without staging/verification
- automatic application of high-risk/manual-review releases
- bypassing hosting-level deployment controls

## Implementation Plan
1. Inspect current settings storage, scheduler commands, audit logging, admin
   settings UI, deployment docs, and security docs.
2. Add update configuration and status storage using the existing settings or a
   narrowly scoped update status model if audit/history requirements require it.
3. Add a release manifest client that reads a stable trusted manifest and
   validates version, channel, checksum metadata, migration risk, and manual
   review flags.
4. Add `updates:check` command and schedule it daily without blocking normal
   runtime when the manifest source is unavailable.
5. Add admin UI controls for update checks, auto-apply, release channel,
   preferred driver, current version, latest version, last check, last attempt,
   and failure details.
6. Add update driver contract with `manual`, fake/test, `coolify`, and
   `archive` drivers.
7. Add `updates:apply` guarded by permissions, settings, environment kill
   switch, driver support, release integrity, preflight checks, and release
   risk classification.
8. Add tests for settings authorization, manifest handling, scheduler command,
   driver selection, fail-closed behavior, and fake driver application.
9. Update operations docs with driver setup, smoke, rollback, and recovery
   evidence.

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: Featherly has Coolify deployment notes but no approved runtime update
  contract.
- Gaps: no update settings, scheduler checks, release manifest, driver
  interface, shared-hosting strategy, or rollback model for automatic updates.
- Inconsistencies: the desired WordPress-like update behavior spans runtime,
  deployment, security, and shared-hosting constraints that are not yet modeled.
- Architecture constraints: preserve admin/public split, existing settings and
  permission patterns, Laravel scheduler usage, deployment gate, rollback docs,
  and secure secret handling.

### 2. Select One Priority Task
- Selected task: FEA-015 System Update Manager.
- Priority rationale: deployment and third-party installation strategy affects
  how releases are packaged, shipped, and operated.
- Why other candidates were deferred: feature-specific CMS tasks do not answer
  the installation/update lifecycle requirement.

### 3. Plan Implementation
- Files or surfaces to modify: settings/admin UI, scheduler command files,
  update services, tests, translations, deployment docs, rollback docs,
  architecture references.
- Logic: check release manifest daily, store update status, expose admin
  controls, select a driver, apply only when safe, and degrade to manual mode
  when unsupported.
- Edge cases: no shell access, missing write permissions, manifest unavailable,
  checksum mismatch, high-risk migrations, disabled auto-update, missing
  Coolify secret, failed archive staging, post-update smoke failure.

### 4. Execute Implementation
- Implementation notes: not started.

### 5. Verify and Test
- Validation performed: not started.
- Result: not started.

### 6. Self-Review
- Simpler option considered: Coolify-only auto-deploy.
- Technical debt introduced: no, task not implemented yet.
- Scalability assessment: driver-based design supports Coolify, VPS, Docker,
  archive/shared-hosting, and manual fallback without duplicating update logic.
- Refinements made: automatic update application is fail-closed and separated
  from update checks.

### 7. Update Documentation and Knowledge
- Docs updated: architecture and planning docs for this task.
- Context updated: project state and task board.
- Learning journal updated: not applicable.

## Acceptance Criteria
- [ ] Update checks are enabled by default and run daily through Laravel
  scheduler.
- [ ] Admin users with the existing settings permission can view update status
  and change update preferences.
- [ ] Automatic update application can be disabled in admin settings and by an
  environment-level override.
- [ ] Unsupported environments degrade to manual update notification instead of
  attempting unsafe file or service changes.
- [ ] The Coolify driver triggers deployment only through server-side secrets.
- [ ] The archive driver verifies release integrity and preserves local runtime
  state before switching files.
- [ ] High-risk or manual-review releases do not auto-apply.
- [ ] Update attempts are audit logged without leaking secrets.
- [ ] Tests cover manifest parsing, fail-closed behavior, driver selection,
  authorization, and at least one successful fake-driver update.

## Success Signal
- User or operator problem: Featherly installations can drift from the latest
  code and currently have no safe app-level update experience across hosting
  models.
- Expected product or reliability outcome: self-hosted installations can detect
  and, where supported, apply stable updates automatically.
- How success will be observed: admin update screen shows accurate status,
  scheduler records daily checks, and supported drivers can apply a test update
  path with rollback/recovery evidence.
- Post-launch learning needed: yes

## Deliverable For This Stage
Approved architecture and implementation task plan for a safe,
environment-adaptive update system.

## Constraints
- use existing settings, scheduler, admin permission, and audit patterns first
- preserve locale-aware route boundaries and the admin/public split
- keep translation and i18n scanning implications explicit for admin copy
- do not expose deploy secrets to the browser
- do not implement direct unsafe self-mutation of the live app
- fail closed to notification/manual mode when support or integrity is uncertain
- document rollback and recovery before enabling production auto-apply

## Definition of Done
- [ ] Code builds without errors.
- [ ] Feature works manually through the real UI, CLI, and driver path.
- [ ] No mock, placeholder, fake, or temporary path remains in production
  behavior.
- [ ] Full data flow works across admin UI, backend, scheduler, storage,
  drivers, validation, and audit logging.
- [ ] Backend and UI/client error handling exists.
- [ ] No existing functionality is broken.
- [ ] Feature works after restart, reload, and scheduler rerun.
- [ ] Changes are documented in architecture, operations, and planning docs.
- [ ] Behavior is reproducible from validation evidence.
- [ ] Security, reliability, deployment, and rollback evidence are recorded.
- [ ] `DEFINITION_OF_DONE.md` was checked before status changed to `DONE`.

## Stage Exit Criteria
- [x] The output matches the declared `Current Stage`.
- [x] Work from later stages was not mixed in without explicit approval.
- [x] Risks and assumptions for this stage are stated clearly.

## Validation Evidence
- Tests: not run; planning/documentation-only stage.
- Manual checks: architecture, settings, scheduler, operations, and security
  docs inspected before planning.
- Screenshots/logs: not applicable.
- High-risk checks: update application is explicitly fail-closed and driver
  gated.
- Coverage ledger updated: not applicable.
- Coverage rows closed or changed:

## Integration Evidence
- `INTEGRATION_CHECKLIST.md` reviewed: not applicable for planning stage.
- Real API/service path used: not applicable.
- Endpoint and client contract match: not applicable.
- DB schema and migrations verified: not applicable.
- Loading state verified: not applicable.
- Error state verified: not applicable.
- Refresh/restart behavior verified: not applicable.
- Regression check performed: documentation-only review.

## Product / Discovery Evidence
- Problem validated: yes.
- User or operator affected: maintainers, self-hosting site owners, and
  third-party installers.
- Existing workaround or pain: manual deploys or platform-specific setup only.
- Smallest useful slice: update checks, admin status, settings, manifest
  parsing, and fake/manual driver before destructive apply paths.
- Success metric or signal: daily update status is visible and supported
  drivers can safely apply a trusted release.
- Feature flag, staged rollout, or disable path: yes.
- Post-launch feedback or metric check: monitor failed preflights and manual
  fallback frequency.

## Reliability / Observability Evidence
- `docs/operations/service-reliability-and-observability.md` reviewed: yes.
- Critical user journey: site remains available and recoverable across update
  check/apply attempts.
- SLI: update attempts either complete with healthy post-update status or fail
  closed without corrupting the installation.
- SLO: define before production auto-apply rollout.
- Error budget posture: healthy.
- Health/readiness check: required before production auto-apply.
- Logs, dashboard, or alert route: audit log and operator-visible admin status.
- Smoke command or manual smoke: required per driver before release.
- Rollback or disable path: admin setting, environment kill switch, driver
  rollback/recovery instructions.

## Security / Privacy Evidence
- `docs/security/secure-development-lifecycle.md` reviewed: yes.
- Data classification: deployment secrets, release metadata, installation
  status, admin settings.
- Trust boundaries: browser to admin backend, backend to release manifest,
  backend to deployment platform or filesystem.
- Permission or ownership checks: existing `manage-settings` permission or a
  stricter update-specific permission if introduced.
- Abuse cases: malicious manifest, checksum mismatch, secret leakage, forced
  downgrade, unauthorized update trigger, partial file replacement.
- Secret handling: env-only secrets, never included in Inertia props or logs.
- Security tests or scans: required during implementation.
- Fail-closed behavior: missing integrity proof, unsupported driver, or
  high-risk release prevents automatic application.
- Residual risk: archive and Git drivers need careful staging and rollback
  implementation before production enablement.

## Architecture Evidence
- Architecture source reviewed: `docs/architecture/README.md`,
  `docs/architecture/system-architecture.md`,
  `docs/architecture/tech-stack.md`,
  `docs/architecture/system-update-manager-contract.md`
- Fits approved architecture: yes
- Mismatch discovered: yes, automatic updates were not previously documented
- Decision required from user: no, user requested this behavior be planned and
  recorded
- Approval reference if architecture changed: conversation on 2026-05-01
- Follow-up architecture doc updates: none pending for planning stage

## Deployment / Ops Evidence
- Deploy impact: high once implemented.
- Env or secret changes: update manifest URL, channel, auto-apply kill switch,
  Coolify webhook/API secret, optional driver configuration.
- Health-check impact: update apply requires health/readiness and post-deploy
  smoke evidence.
- Smoke steps updated: required during implementation.
- Rollback note: driver-specific rollback must be documented before production
  auto-apply.
- Observability or alerting impact: update status and audit logging required.
- Staged rollout or feature flag: auto-apply setting and environment kill
  switch.
- `DEPLOYMENT_GATE.md` reviewed: required during implementation.

## Review Checklist (mandatory)
- [x] Process self-audit completed before implementation.
- [x] Autonomous loop evidence covers all seven steps.
- [x] Exactly one priority task was completed in this planning iteration.
- [x] Operation mode was selected according to iteration rotation once
  execution starts.
- [x] Current stage is declared and respected.
- [x] Deliverable for the current stage is complete.
- [x] Architecture alignment confirmed.
- [x] Existing systems were reused where applicable.
- [x] No workaround paths were introduced.
- [x] No temporary solution was introduced.
- [x] No logic duplication was introduced.
- [x] Integration checklist evidence is attached where applicable.
- [x] AI testing evidence is attached where applicable.
- [x] Deployment gate evidence is attached where applicable.
- [x] Definition of Done evidence is attached.
- [x] Relevant validations were run or explicitly scoped out.
- [x] Docs or context were updated if repository truth changed.
- [x] Learning journal was updated if a recurring pitfall was confirmed.

## Result Report
- Task summary: planning and architecture source-of-truth for the System Update
  Manager are recorded.
- Files changed: `docs/architecture/system-update-manager-contract.md`,
  `docs/architecture/README.md`,
  `docs/architecture/system-architecture.md`,
  `docs/architecture/tech-stack.md`,
  `docs/operations/coolify-vps-deployment-contract.md`,
  `.codex/context/PROJECT_STATE.md`,
  `.codex/context/TASK_BOARD.md`,
  `docs/planning/tasks/FEA-015-system-update-manager.md`
- How tested: documentation-only stage; no runtime tests run.
- What is incomplete: runtime implementation, release manifest publication,
  update drivers, admin UI, tests, and driver-specific rollback docs.
- Next steps: implement the smallest safe slice: update settings, release
  manifest checker, daily `updates:check`, admin status, and manual/fake driver.
- Decisions made: Featherly updates are environment-adaptive and driver-based;
  unsupported hosts degrade to manual mode.

## Notes
The first production-ready auto-apply target should be Coolify because rollback
and deployment execution can be delegated to the platform. The archive driver is
required for shared hosting support but must be treated as higher risk until
staging, checksum verification, local-state preservation, and rollback are
proven.
