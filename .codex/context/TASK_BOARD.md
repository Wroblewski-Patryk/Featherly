# TASK_BOARD

Last updated: 2026-07-31

## READY

- [ ] (none)

## BACKLOG

- [ ] (none)

## IN_PROGRESS

- [ ] FEA-022 Build the owner portfolio through the Featherly CMS
  - Status: IN_PROGRESS
  - Owner: Frontend Builder
  - Priority: P0
  - Target: production homepage at `wroblewskipatryk.pl`
  - Reference: owner-provided source archive with SHA-256
    `15DD863BCF142A5FC6DB83C3C921CAEA1F31E41F66AE4FDE88629C56F69F111C`
  - Constraint: use native Featherly CMS pages, blocks, media, templates, and
    theme controls only; do not modify unrelated Coolify resources
  - Current state: production page `#7` is published and selected as the `/pl/`
    homepage; native templates `#10` and `#11`, Polish portfolio copy, and the
    canonical hero media are live and persist across refresh
  - Current implementation slice: fixes for canonical theme persistence,
    image-block public rendering, responsive navbar destinations, and
    server-derived page locks are deployed on production commit `ae80eaea`
  - Verification: Coolify reports `Running`; `/pl/` renders the canonical image
    and portfolio copy with no public console errors
  - Current state: the owner has restored the authenticated production admin
    session; page `#7` now has the canonical four-line hero rhythm, corrected
    background crop/repeat behavior, and dark/light chapter surfaces authored
    and published through Featherly only
  - Remaining product gaps: tracked exclusively in
    `docs/planning/featherly-portfolio-cms-gap-register.md` for separate CMS
    agents; FEA-022 must not patch Featherly
  - Next slice: use the existing container and working native controls to close
    as much desktop/tablet/mobile parity as the production CMS supports, then
    attach equal-viewport evidence and hand off any confirmed CMS limitation
  - Done when: the owner-provided reference is recreated with desktop, tablet,
    mobile, interaction, persistence, and visual-parity evidence

## BLOCKED

- [ ] FEA-015 Implement archive/Docker/Git update drivers and Coolify rollout hardening
  - Status: BLOCKED
  - Owner: Backend Builder
  - Depends on: FEA-015P
  - Priority: P1
  - Blocker: Coolify staging target is identified as
    `https://test.luckysparrow.ch`; public smoke reaches the application, but
    target-environment confirmation still needs the media serving fix deployed
    with `composer deploy:coolify` and verified with `/storage/media/...`
    evidence.
  - Done when:
    - Coolify staging/live rollout evidence is captured from the runbook
    - deployment gate evidence is attached for the target environment

## DONE

- [x] FEA-021 Deploy the first Featherly-backed portfolio production instance
  - Status: DONE
  - Owner: Ops/Release
  - Priority: P0
  - Target: Coolify project `a14a7zgzt6r13wtqxe5c916y`, environment
    `gz5uke25v3tpqcc0o47gyw2e`, domain `wroblewskipatryk.pl`
  - Constraint: do not delete or modify unrelated Coolify resources
  - Current state: application, PostgreSQL, migrations, seed data, secure admin,
    persistent media, healthcheck, scheduler, workers, restart, and rollback
    history are verified
  - Evidence: trusted `https://wroblewskipatryk.pl/pl/`, runtime and public
    media smoke pass; Coolify reports `Running` on `ae80eaea`.

- [x] FEA-020 Add Coolify post-deploy cache and migration maintenance
- [x] FEA-019 Project category fallback backfill and removal plan
- [x] FEA-012 Residual legacy docs normalization
- [x] FEA-018 Decide project category compatibility retirement path
- [x] FEA-017 Decide and harden forms/templates admin ownership contract
- [x] FEA-011 Module contract audit for pages/posts/projects/forms/templates
- [x] FEA-016 Remove legacy project category authoring from admin project surfaces
- [x] FEA-014 Use taxonomy-backed project presentation in public runtime
- [x] FEA-013 Restrict V1 public taxonomy archives to posts
- [x] FEA-010 Category/taxonomy alignment decision
- [x] FEA-001 Finalize public dynamic routes for page/post/project
- [x] FEA-015P Record Coolify rollout evidence blocker for v1 gate
- [x] FEA-015O Add archive rollback command from recorded backup
- [x] FEA-015N Add gated archive live switch with backup and preserve paths
- [x] FEA-015M Add archive switch and rollback plan evidence
- [x] FEA-015L Add no-switch archive extraction staging validation
- [x] FEA-015K Defer Docker/Git runtime drivers from System Update Manager v1
- [x] FEA-015J Add archive extraction runtime capability gate
- [x] FEA-015I Add no-switch archive download and SHA-256 verifier
- [x] FEA-015H Add archive release integrity metadata preflight gate
- [x] FEA-015G Add Coolify update rollout evidence runbook
- [x] FEA-015F Gate post-deploy confirmation on operational health checks
- [x] FEA-015E Add post-deploy version confirmation for Coolify-triggered updates
- [x] FEA-015D Add gated Coolify apply trigger test path
- [x] FEA-015C Implement production driver preflight status
- [x] FEA-015B Implement manual/fake System Update Manager apply contract
- [x] FEA-015A Implement verified System Update Manager update-check baseline
- [x] DOC-ARCH-001 Synchronize architecture folder with current implementation map
- [x] DOC-001 Migrate Featherly docs and agent files to template-aligned structure with project-specific content
- [x] FEX-001..FEX-080 Prior feature execution waves completed and recorded in docs/project state
