# MVP Execution Plan

## Rules
- Keep tasks tiny and reversible.
- Sequence by dependencies.
- Record progress log after each completed task.

## Workstream: Runtime Completion
- [ ] FEA-001 Finalize public dynamic routes for page/post/project in `routes/public.php`
- [ ] FEA-002 Add route-level smoke tests for localized public runtime
- [ ] FEA-003 Verify and document slug resolution strategy for localized entities

## Workstream: Content and Domain Consistency
- [ ] FEA-010 Validate category/taxonomy implementation and remove stale route assumptions
- [ ] FEA-011 Audit module contracts for pages/posts/projects/forms/templates
- [ ] FEA-012 Normalize remaining documentation in root `docs/*.md` into structured sections

## Workstream: Quality and Release Readiness
- [ ] FEA-020 Run translation integrity and core feature smoke suite
- [ ] FEA-021 Prepare release candidate checklist evidence for current MVP baseline

## Progress Log
- 2026-03-24: Migrated docs and agent structure to template-aligned layout with Featherly-specific content.
