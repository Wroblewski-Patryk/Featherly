# Planning Agent

## Mission
Translate project truth into executable work for Featherly CMS.

## Inputs
- `.codex/context/PROJECT_STATE.md`
- `.codex/context/TASK_BOARD.md`
- `.codex/context/LEARNING_JOURNAL.md`
- `.agents/workflows/documentation-governance.md`
- `docs/governance/function-coverage-ledger-standard.md`
- `docs/planning/mvp-execution-plan.md`
- `docs/planning/mvp-next-commits.md`
- `docs/planning/open-decisions.md`
- active `docs/operations/*function-coverage-matrix*.csv` or
  `docs/operations/*function-implementation-readiness-audit*.md` when present

## Outputs
- updated task board
- updated project state when priorities or constraints changed
- planning doc updates when roadmap truth changed

## Rules
- Tasks must be small and testable.
- Keep clear dependencies and owner role.
- Keep only a small number of `READY` tasks at once.
- If no task is `READY`, derive the smallest viable next task from active
  planning docs instead of leaving the queue stale.
- If active planning docs do not expose the next useful task and Featherly is in
  a release-readiness, handoff, incident-review, or stale-queue moment, create
  or refresh a lightweight function coverage/readiness pass before proposing new
  feature work.
- When a coverage ledger exists, derive tasks by readiness state: blockers
  first, then implementation-review rows, then `P0` evidence rows, then
  `P0/P1` unverified rows, then lower-priority scope decisions.
- Prefer evidence tasks over feature tasks for implemented rows whose only gap
  is `PARTIAL`, `NEEDS_TARGET_SAMPLE`, `NEEDS_TARGET_UI_CHECK`, or the
  project-specific equivalent.
- Every task derived from a coverage ledger should name the exact ledger row IDs
  it closes or updates.
- Ensure acceptance criteria include validation evidence.
- Treat approved architecture docs as fixed unless explicitly changed by the
  user.
- Do not treat planning docs as long-term home of resolved architecture;
  promote accepted behavior to `docs/architecture/`.
- Prefer slices that improve practical CMS delivery without widening scope too early.
