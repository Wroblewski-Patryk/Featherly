# AGENTS.md - Featherly Execution Standard

## Purpose

This repository uses a multi-agent workflow to keep delivery parallel, traceable, and aligned with documentation.

## Canonical Files

- `docs/overview.md`
- `docs/product/product.md`
- `docs/product/mvp_scope.md`
- `docs/architecture/system-architecture.md`
- `docs/architecture/modules.md`
- `docs/planning/mvp-execution-plan.md`
- `docs/planning/mvp-next-commits.md`
- `docs/planning/open-decisions.md`
- `docs/governance/working-agreements.md`
- `.codex/context/PROJECT_STATE.md`
- `.codex/context/TASK_BOARD.md`
- `.agents/workflows/general.md`
- `.agents/workflows/subagent-orchestration.md`

## Core Rules

- Keep repository artifacts in English.
- Keep communication with users in their preferred language.
- Treat docs as source of truth; update docs and code together when behavior changes.
- Keep tasks tiny and reversible.
- Do not mark work done without validation evidence.
- Do not reference sibling repositories or `!template` in project docs.

## Agent Catalog

- Planner: `.agents/prompts/planner.md` or `.claude/agents/planner.agent.md`
- Product Docs: `.agents/prompts/product-docs.md` or `.claude/agents/product-docs.agent.md`
- Backend Builder: `.agents/prompts/backend-builder.md` or `.claude/agents/backend-builder.agent.md`
- Frontend Builder: `.agents/prompts/frontend-builder.md` or `.claude/agents/frontend-builder.agent.md`
- QA/Test: `.agents/prompts/qa-test.md` or `.claude/agents/qa-test.agent.md`
- Security: `.agents/prompts/security-auditor.md` or `.claude/agents/security-auditor.agent.md`
- DB/Migrations: `.agents/prompts/db-migrations.md` or `.claude/agents/db-migrations.agent.md`
- Ops/Release: `.agents/prompts/ops-release.md` or `.claude/agents/ops-release.agent.md`
- Code Review: `.agents/prompts/code-reviewer.md`

## Trigger Intent

If the user sends a short execution nudge (`start`, `go`, `next`, `run`, `dzialaj`, `lecimy`):

1. Read `docs/planning/mvp-next-commits.md`.
2. Take the first unchecked task from `NOW`.
3. If `NOW` is empty, refill it from `docs/planning/mvp-execution-plan.md`.
4. Execute exactly one tiny task.
5. Run relevant checks.
6. Update planning and context docs.
7. Return files changed, checks run, and next tiny task.

## Project-Specific Focus

- Featherly is a custom CMS with block-based content editing.
- Preserve locale-aware routing conventions.
- Prefer feature-first frontend structure under `resources/js/features/admin/`.
- Keep i18n integrity (`i18n:scan` + translation integrity test) in the delivery flow.
