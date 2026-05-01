# TASK_BOARD

Last updated: 2026-05-01

## READY

- [ ] FEA-015 Design and implement environment-adaptive System Update Manager
  - Status: READY
  - Owner: Backend Builder
  - Depends on: architecture approval in
    `docs/architecture/system-update-manager-contract.md`
  - Priority: P1
  - Done when:
    - update settings, scheduler checks, release manifest parsing, and admin
      status are implemented
    - Coolify and archive/manual driver paths are covered by tests or fakes
    - deployment, rollback, security, and smoke docs are synchronized

- [ ] FEA-001 Finalize public dynamic routes for page/post/project
  - Status: READY
  - Owner: Backend Builder
  - Depends on: none
  - Priority: P1
  - Done when:
    - routes are explicit in `routes/public.php`
    - localized behavior is covered by smoke or feature tests
    - docs and project state reflect the chosen route contract

## BACKLOG

- [ ] FEA-010 Category/taxonomy alignment decision
  - Status: BACKLOG
  - Owner: Product Docs Agent
  - Depends on: FEA-001
  - Priority: P1
  - Done when:
    - taxonomy direction is explicit in docs
    - implementation implications are queued as follow-up tasks

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

## IN_PROGRESS

- [ ] (none)

## BLOCKED

- [ ] (none)

## DONE

- [x] DOC-ARCH-001 Synchronize architecture folder with current implementation map
- [x] DOC-001 Migrate Featherly docs and agent files to template-aligned structure with project-specific content
- [x] FEX-001..FEX-080 Prior feature execution waves completed and recorded in docs/project state
