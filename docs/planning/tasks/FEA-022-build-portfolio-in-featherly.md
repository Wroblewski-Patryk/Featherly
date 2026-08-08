# Task

## Header
- ID: FEA-022
- Title: Build the owner portfolio through the Featherly CMS
- Task Type: feature
- Current Stage: implementation
- Status: IN_PROGRESS
- Owner: Frontend Builder
- Depends on: FEA-021 runtime availability
- Priority: P0
- Coverage Ledger Rows: not applicable
- Iteration: 2
- Operation Mode: BUILDER

## Process Self-Audit
- [x] All seven autonomous loop steps are planned.
- [x] No loop step is being skipped.
- [x] Exactly one priority task is selected.
- [x] Operation mode matches the iteration number.
- [x] The task is aligned with repository source-of-truth documents.

## Context
The production Featherly instance is reachable at `wroblewskipatryk.pl`. The
owner wants the existing portfolio reference recreated through the CMS itself,
without source-code shortcuts, parallel frontend systems, or changes to
unrelated Coolify resources.

## Goal
Create an editable, responsive portfolio homepage in the production Featherly
instance that faithfully represents the owner-provided reference URL.

## Scope
- Production public homepage and its Polish localized content.
- Existing Featherly pages, templates, block builder, media library, theme
  settings, and navigation surfaces exposed through the admin UI.
- Desktop, tablet, and mobile browser verification.
- Task, context, and visual evidence documentation.
- Portfolio content remains CMS-authored; reusable Featherly defects confirmed
  to block this task may be fixed in PHP/Vue with tests and normal deployment.
- No database-console, direct SQL, parallel frontend, or unrelated Coolify
  mutation.

## Implementation Plan
1. Capture the owner-provided reference on desktop and mobile, including
   structure, content, assets, styles, and interactions.
2. Audit the current production homepage and available Featherly CMS controls.
3. Recreate the page using only native CMS pages, blocks, media, templates,
   navigation, and theme controls.
4. Verify persistence after refresh and compare production screenshots against
   the reference at desktop, tablet, and mobile breakpoints.
5. Record evidence, residual mismatches, and rollback notes.

## Autonomous Loop Evidence

### 1. Analyze Current State
- Issues: production contains the complete portfolio copy and source media, but
  its composition still differs materially from the reference.
- Gaps: equal-viewport comparison confirms P1 hero, theme-token, section-layout,
  and navigation-destination mismatches.
- Inconsistencies: none in the deployment record; FEA-021 and the Coolify
  contract now reflect the healthy trusted-TLS production runtime.
- Architecture constraints: preserve localized public/admin routes, block
  content contracts, media references, and shared theme controls.

### 2. Select One Priority Task
- Selected task: FEA-022 portfolio CMS implementation.
- Priority rationale: it is the direct owner request and the production runtime
  is now reachable.
- Why other candidates were deferred: framework feature expansion and unrelated
  release hardening do not block a native CMS content implementation.

### 3. Plan Implementation
- Files or surfaces to modify: production CMS content/theme/media and this task
  evidence; project context only when verified truth changes.
- Logic: use the existing block builder, media picker, template, and theme
  contracts without adding a parallel frontend.
- Edge cases: authenticated reference access, missing reference assets, CMS
  block capability gaps, responsive behavior, localization, and rollback.

### 4. Execute Implementation
- Implementation notes: the owner archive was rendered locally and captured at
  desktop and mobile sizes. Production page `#7` (`Patryk Wróblewski`, slug
  `portfolio`) was created and published through the normal Featherly editor.
  Thirty native content blocks reproduce the Polish hero, introduction, notes,
  project ecosystem, principles, contact, and footer copy. The canonical hero
  composite and supporting assets were uploaded through the media library.
  Native templates `#10 Portfolio Header` and `#11 Portfolio Footer` were
  created and assigned to the page. General settings now select page `#7` as
  the homepage, so both `/pl/` and `/pl/portfolio` render the portfolio. No
  unrelated page, template, media, or Coolify resource was deleted.
  On 2026-07-31 the reusable Featherly blockers were fixed and deployed as
  commit `ae80eaea`: canonical theme persistence, empty theme-map validation,
  public image rendering, structured navbar destinations, accessible mobile
  navigation, and server-derived optimistic locks.

### 5. Verify and Test
- Validation performed: public `/pl/` and `/pl/portfolio` refresh checks,
  desktop screenshots, native 375px editor preview, content persistence after
  reload, header/footer assignment, and root-routing verification.
- Result: the localized portfolio, custom PW navigation, contact copy, footer,
  and hero asset are live. The previously confirmed persistence, image-render,
  navigation-schema, mobile-menu, and optimistic-lock defects are fixed and
  deployed. Pixel-close parity is not yet achieved: equal-viewport evidence
  confirms P1 hero, token, and section-layout gaps. CMS re-authoring is paused
  only because the production admin session expired and redirects to
  `/pl/login`.

### 6. Self-Review
- Simpler option considered: use the seeded page and replace its content rather
  than creating a second public runtime.
- Technical debt introduced: no.
- Scalability assessment: native CMS blocks keep the page editable and reusable.
- Refinements made: replaced the seeded Alpine header/footer on the portfolio
  with dedicated native templates, removed one generated placeholder paragraph,
  applied the canonical hero through the media-backed fill control, and kept the
  seeded page available for rollback.

### 7. Update Documentation and Knowledge
- Docs updated: task contract and task board.
- Context updated: production implementation, deployment evidence, current
  authentication blocker, and remaining native-CMS gaps are synchronized in
  the task board, project state, deployment contract, and gap register.
- Learning journal updated: reusable theme, image, navbar, and optimistic-lock
  findings are recorded.

## Acceptance Criteria
- [ ] The production homepage matches the owner-provided reference structure,
  content, assets, and visual direction using only native Featherly CMS paths.
- [ ] Navigation and primary interactions work on desktop, tablet, and mobile.
- [ ] Content persists after refresh and no unrelated Coolify resources or CMS
  content are deleted.

## Success Signal
- User or operator problem: the production CMS does not yet present the owner's
  portfolio.
- Expected product or reliability outcome: visitors see the requested portfolio
  and the owner can edit it later through Featherly.
- How success will be observed: browser parity evidence plus successful public
  navigation and refresh checks.
- Post-launch learning needed: yes.

## Deliverable For This Stage
A tested Featherly runtime slice that closes the confirmed theme, image,
navigation-destination, and page-save defects, followed by deployment and CMS
re-authoring of the production portfolio.

## Constraints
- Use only existing Featherly CMS mechanisms for portfolio content.
- Do not introduce workaround-only code, custom parallel runtimes, or direct DB
  edits.
- Preserve locale-aware routes and admin/public boundaries.
- Do not delete or modify unrelated Coolify resources.
- Do not guess missing visual evidence.

## Validation Evidence
- Tests: 13/13 focused JavaScript contracts pass; focused theme and optimistic-
  lock PHP tests pass; ESLint, Prettier, Vite production build, direct PHPStan,
  and `git diff --check` pass. The full PHP suite remains non-green because the
  existing translation-integrity scan reports one generated key; the local
  environment also lacks its normal `.env`/SQLite setup.
- Manual checks: Coolify deployment `ln9f8lap3d81yf9wbf0jugjo` is `Running` on
  `ae80eaea`; `/pl/` renders the canonical image and portfolio copy without
  browser console errors; admin currently redirects to `/pl/login`.
- Screenshots/logs: equal-viewport reference, deployed implementation, and
  combined comparison evidence are stored under `docs/ux/evidence/fea-022`.
- High-risk checks: preserve unrelated production resources and content.
- Coverage ledger updated: not applicable.

## Integration Evidence
- `INTEGRATION_CHECKLIST.md` reviewed: yes.
- Real API/service path used: yes, production Featherly admin UI.
- DB schema and migrations verified: yes, inherited from FEA-021 production
  evidence.
- Loading state verified: public navigation and refresh complete normally.
- Error state verified: save-conflict behavior was observed and recovered by
  reloading the saved revision before the next normal editor save.
- Refresh/restart behavior verified: content, templates, media, and homepage
  selection persisted across browser reloads.
- Regression check performed: seeded pages remain present; no unrelated Coolify
  or CMS resources were removed.

## Product / Discovery Evidence
- Problem validated: yes.
- User or operator affected: portfolio owner and public visitors.
- Existing workaround or pain: the reference portfolio is hosted separately
  and not editable in Featherly.
- Smallest useful slice: one complete production homepage.
- Success metric or signal: faithful public page and native CMS editability.
- Feature flag, staged rollout, or disable path: not applicable.
- Post-launch feedback or metric check: owner visual review.

## Reliability / Observability Evidence
- Critical user journey: visitor opens the localized portfolio homepage.
- SLI: successful HTTPS response and complete visual render.
- Health/readiness check: production `/up` plus public page browser smoke.
- Logs, dashboard, or alert route: Coolify runtime logs.
- Smoke command or manual smoke: desktop/tablet/mobile public route and refresh.
- Rollback or disable path: restore the previous page revision or seeded page
  content through Featherly revisions.

## Security / Privacy Evidence
- Data classification: public portfolio content and administrator credentials.
- Trust boundaries: browser to Featherly admin; Featherly to production DB and
  media storage.
- Permission or ownership checks: authenticated administrator CMS path only.
- Secret handling: credentials are entered only into the owner production CMS.
- Fail-closed behavior: stop if reference or CMS authentication is unavailable.

## Architecture Evidence
- Architecture source reviewed: architecture source of truth, module block
  registry, builder design controls, and media picker contracts.
- Fits approved architecture: yes.
- Mismatch discovered: yes; the confirmed reusable runtime defects were fixed,
  while the CMS still needs stronger reusable semantic section/layout controls
  for efficient source-faithful composition.
- Decision required from user: none for the current slice; owner authentication
  is required before CMS-only visual authoring can resume.

## UX/UI Evidence
- Design source type: approved_snapshot
- Design source reference:
  `https://patryk-wroblewski-portfolio.wroblewskipatryk.chatgpt.site/`
- Canonical visual target: owner-provided live portfolio.
- Fidelity target: pixel_close
- Evidence-driven UX review used: yes.
- Experience-quality bar reviewed: yes.
- Visual-direction brief reviewed: yes.
- Existing shared pattern reused: Featherly block builder and theme controls.
- New shared pattern introduced: no.
- Visual gap audit completed: yes; layout, color, navigation, hero composition,
  responsive behavior, and section hierarchy were compared.
- Screenshot comparison pass completed: first pass complete; pixel-close pass
  remains blocked by the recorded native CMS defects.
- Anti-patterns checked: yes; no parallel frontend, injected HTML/CSS, direct DB
  writes, hotlinked source runtime, or placeholder asset was introduced.
- Screen-quality checklist reviewed: yes.
- Responsive checks: desktop | tablet | mobile.
- Accessibility checks: headings, links, keyboard focus, contrast, and readable
  text.
- Parity evidence: pending.

## Deployment / Ops Evidence
- Deploy impact: low; content-only production CMS change.
- Env or secret changes: none.
- Health-check impact: none.
- Smoke steps updated: no; existing public-route smoke applies.
- Rollback note: Featherly page revision or previous seeded content.
- Observability or alerting impact: none.
- Staged rollout or feature flag: not applicable.
- `DEPLOYMENT_GATE.md` reviewed: yes.

## Result Report
- Task summary: the portfolio is live as the Featherly homepage and remains
  editable through page `#7`; FEA-022 stays in progress until visual parity and
  interaction requirements pass.
- Files changed: task contract and task board. Production CMS changed page `#7`,
  templates `#10` and `#11`, the homepage setting, and owner-provided media.
- How tested: public route/refresh smoke, CMS persistence checks, desktop visual
  inspection, and native mobile preview.
- What is incomplete: pixel-close color/layout polish, functional navbar
  destinations, reliable mobile parity, and the CMS defects listed above.
- Next steps: implement and verify the smallest native Featherly fixes for theme
  persistence, image rendering, navbar destinations, and optimistic locking;
  then complete the desktop/tablet/mobile parity pass.
- Decisions made: build through Featherly only; no code or direct DB content
  manipulation.
