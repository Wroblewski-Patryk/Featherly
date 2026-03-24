# TASK_BOARD

Last updated: 2026-03-24

## Backlog

- [ ] FEA-011 Module contract audit for pages/posts/projects/forms/templates
  - Status: BACKLOG
  - Owner: Planning Agent
  - Depends on: FEA-001
  - Priority: P2
  - Done when:
    - contracts are checked against routes/controllers/models
    - mismatches are documented and queued

- [ ] FEA-012 Residual legacy docs normalization
  - Status: BACKLOG
  - Owner: Product Docs Agent
  - Depends on: FEA-011
  - Priority: P3
  - Done when:
    - legacy root docs are either migrated or explicitly deprecated

## In Progress

- [ ] FEA-001 Finalize public dynamic routes for page/post/project
  - Status: IN_PROGRESS
  - Owner: Backend Builder
  - Depends on: none
  - Priority: P1
  - Done when:
    - routes are explicit in `routes/public.php`
    - localized behavior is covered by smoke tests

## Blocked

- [ ] FEA-010 Category/taxonomy alignment decision
  - Status: BLOCKED
  - Owner: Backend Builder
  - Depends on: DEC-002
  - Priority: P1
  - Blocker: implementation direction pending audit outcome

## Done

- [x] DOC-001 Migrate Featherly docs and agent files to template-aligned structure with project-specific content.
