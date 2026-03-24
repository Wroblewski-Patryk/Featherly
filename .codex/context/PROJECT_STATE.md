# PROJECT_STATE

Last updated: 2026-03-24

## Product Snapshot
- Name: Featherly CMS
- Goal: deliver a multilingual, block-based CMS with a custom admin panel
- Commercial model: internal/custom deployment model (SaaS assumptions from template are not active constraints)
- Current phase: MVP stabilization and runtime completion

## Confirmed Decisions
- 2026-03-17: translation scanning and integrity checks are part of the baseline workflow.
- 2026-03-24: documentation and agent setup aligned to template structure with Featherly-specific content.

## Technical Baseline
- Backend: Laravel 12 + PHP 8.2+
- Frontend: Vue 3 + Inertia + Pinia + Ziggy
- Mobile: none in repository scope
- Database: relational DB with JSON fields for localized/block content
- Infra: Laravel app runtime + Vite for frontend build/dev

## Current Focus
- Main active objective: finalize public dynamic routing and consistency checks.
- Top blockers: route exposure gaps and category/taxonomy alignment uncertainty.
- Success criteria for this phase: stable route coverage, updated docs, and validated smoke paths.

## Working Agreements
- Keep docs, task board, and planning files synchronized.
- Keep changes small and reversible.
- Validate touched areas before marking work done.
- Keep repository artifacts in English.
- Communicate with users in their language.

## Canonical Docs
- `docs/overview.md`
- `docs/product/product.md`
- `docs/architecture/system-architecture.md`
- `docs/planning/mvp-execution-plan.md`
