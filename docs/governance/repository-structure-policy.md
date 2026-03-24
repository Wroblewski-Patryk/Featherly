# Repository Structure Policy

## Goal
- Keep the repository predictable, searchable, and automation-friendly.

## Root Directory Rules
- Keep root minimal and intentional.
- Allowed in root: runtime/config/build files and top-level project files, for example:
  - `README.md`, `AGENTS.md`, `LICENSE`, `CHANGELOG.md`
  - workspace/package manager files (`package.json`, `pnpm-workspace.yaml`, lockfiles)
  - infrastructure entry files (`docker-compose.yml`, CI configs, formatter/linter configs)
  - agent/context folders (`.agents/`, `.claude/`, `.codex/`)
  - source directories (`apps/`, `packages/`, `scripts/`, `docs/`)
- Do not add ad-hoc documentation files directly in root.

## Documentation Placement
- Product, architecture, engineering, operations, security, and UX docs must live in `docs/` subfolders.
- Use existing category folders first; create a new folder only when scope is clearly distinct.
- File names should use kebab-case and domain-specific names.

## Migration Rule For Existing Root Docs
- When a root markdown file is project documentation (not top-level repo metadata), move it under `docs/` in the correct category.
- After moving, update inbound links in:
  - `docs/README.md`
  - `AGENTS.md` canonical list if relevant
  - any planning/context files that referenced the old path

## Cross-Project Isolation
- Do not reference files from sibling repositories.
- Use only paths that exist inside the current repository.
- Avoid hardcoded absolute paths in docs and prompts.

## Enforcement
- Any PR that adds new root docs must justify why the file cannot live in `docs/`.
- If no strong reason exists, move it to `docs/` before merge.
