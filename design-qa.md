# Design QA — FEA-022 portfolio in Featherly

## Comparison target

- Source visual truth: `docs/ux/evidence/fea-022/reference-hero.png`
- Production route: `https://wroblewskipatryk.pl/pl/`
- State: Polish homepage, top of page, page `#7`, CMS-only authoring
- Current evidence: public cold reload plus DOM/computed-style inspection on
  2026-08-08; a new equal-viewport comparison remains required.

## Current result

- The source asset, Titillium Web, Polish headline, deliberate four-line title
  rhythm, 760px hero surface, `cover`, centered crop, and `no-repeat` background
  are now saved through Featherly and visible publicly.
- Introduction, notes/projects, principles, and contact copy now use the
  source's dark/dark/paper/dark chapter rhythm through native block classes.
- Navigation destinations resolve to `#start`, `#notes`, `#projects`, `#about`,
  and `#contact`.
- The result is not yet source-faithful.

## Findings

- [P1] Hero composition still differs materially.
  - Source: restrained left editorial column, paper and amber emphasis, body
    copy, two CTAs, and the subject on the right.
  - Production: the image and four-line heading occupy the hero, but body copy
    and CTAs are outside the surface and amber emphasis is unavailable.
- [P1] Public palette does not use the values saved in Theme.
  - Production still computes DaisyUI `light` defaults, leaving a white header
    and purple CTA instead of ink, paper, amber, and cyan.
- [P1] The remaining page is still a flat sequence of blocks.
  - Featherly has a nestable Container, but the existing page content has not
    yet been regrouped and its layout controls lack breakpoint variants.
- [P2] Responsive and interaction parity has not been re-verified after the
  current CMS changes.
- [P0] The sticky header is visually present but loses pointer hit-testing to
  content after the first anchor jump, so subsequent navigation clicks fail.

## Blocker and handoff

The exact reusable Featherly limitations, evidence, impact, and completion
contracts are maintained only in
`docs/planning/featherly-portfolio-cms-gap-register.md`. FEA-022 must not patch
Featherly; it continues with working production CMS controls only.

## Required next QA

- Capture source and production at the same desktop viewport and state.
- Repeat at tablet and mobile widths.
- Verify theme values after cold reload, headline fill persistence, navigation,
  overflow, focus order, and public console errors.
- Current public console error check: no errors observed after cold reload and
  section navigation tests.
- Resolve every P0–P2 finding before changing this result to passed.

final result: blocked
