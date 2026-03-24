---
description: Workspace rules for Featherly
---

# General Workspace Rules

## Stack Snapshot
- Backend: Laravel 12, PHP 8.2+
- Frontend: Vue 3 (Composition API), Inertia.js, Pinia, Ziggy
- Styling/UI: Tailwind CSS, DaisyUI, custom admin components
- Runtime constraints: localized routing under `/{locale}` and `/{locale}/admin`

## Architecture Rules
- Keep route split explicit: `auth`, `admin`, `public`.
- Preserve block-based content model (`content` JSON + `settings` JSON).
- Prefer existing feature-first frontend modules under `resources/js/features/admin/`.
- Keep shared admin UI components centralized in `features/admin/shared`.

## UI/UX Rules
- Preserve visual consistency across admin modules.
- Use the block builder and shared controls before introducing new patterns.
- For animation-related changes, keep progressive enhancement and accessibility defaults.

## Delivery Rules
- Keep changes scoped and reversible.
- Require acceptance evidence before completion.
- Use subagents only according to `.agents/workflows/subagent-orchestration.md`.
- Update relevant docs when behavior or scope changes.
