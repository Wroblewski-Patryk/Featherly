# Design QA — FEA-022 portfolio in Featherly

## Comparison target

- Source visual truth: `docs/ux/evidence/fea-022/reference-hero.png`
- Implementation: `docs/ux/evidence/fea-022/production-after-deploy-hero.png`
- Combined evidence: `docs/ux/evidence/fea-022/comparison-after-deploy-hero.jpg`
- Viewport: 1440 × 900 CSS px, device scale factor 1
- Source and implementation pixels: 1425 × 891 each after browser chrome
  normalization
- State: Polish homepage, top of page, production commit `ae80eaea`

## Findings

- [P1] Hero composition is not source-faithful.
  - Evidence: the source uses a left-aligned, narrow editorial headline with
    amber emphasis, body copy and two CTAs; production centers one dark
    oversized line over a brighter, differently cropped image and moves body
    copy below it.
  - Impact: the primary identity and hierarchy are materially different.
  - Fix: rebuild the hero as a semantic section container, apply the canonical
    composite crop, Titillium hierarchy, amber emphasis, body column and CTA
    row through Featherly controls.
- [P1] Global palette and typography are still default Featherly.
  - Evidence: production header/content uses white surfaces, black heavy type
    and a purple CTA; the source uses ink, paper, amber and restrained light
    display typography.
  - Impact: every section reads as an unstyled CMS document.
  - Fix: save the reference tokens and Titillium Web/Roboto through the repaired
    theme configurator, then verify persistence after reload.
- [P1] Page structure is a flat document flow.
  - Evidence: production places the next chapter directly under the hero with
    no section surface, grid, measured spacing or visual rhythm.
  - Impact: the source's chapter-based portfolio composition is absent.
  - Fix: group the 30 content blocks into semantic containers with responsive
    spacing, surfaces and stable IDs.
- [P2] Navigation destinations remain legacy placeholders.
  - Evidence: Start, Notatki, Projekty and O mnie currently resolve to `#`.
  - Impact: the primary journey is not functional.
  - Fix: edit template `#10` using the deployed structured destination fields
    and connect it to section IDs.

## Open questions and blocker

- The production CMS session expired after deployment and `/pl/admin/pages/7/edit`
  redirects to `/pl/login`. The owner must authenticate in the in-app browser;
  credentials for Coolify are not assumed to be Featherly credentials and no
  terminal or database bypass will be used.

## Required fidelity surfaces

- Fonts and typography: blocked by CMS authentication; current production is a
  P1 mismatch.
- Spacing and layout rhythm: blocked by CMS authentication; current production
  is a P1 mismatch.
- Colors and visual tokens: repaired runtime is deployed, authoring remains
  blocked by CMS authentication.
- Image quality and asset fidelity: canonical source asset renders; crop and
  composition remain P1 mismatches.
- Copy and content: Polish copy is present and readable; section composition
  remains incomplete.

## Comparison history

- Pass 1: confirmed the deployed renderer now exposes the source image and all
  portfolio copy without console errors. P1 hero, token and section-layout
  differences remain. No visual fix can be applied until the CMS session is
  restored.

## Implementation checklist

- Authenticate in Featherly admin.
- Save and reload the canonical theme.
- Rebuild page `#7` as semantic section containers.
- Configure template `#10` destinations and mobile navigation.
- Run desktop/mobile interaction and persistence smoke.
- Repeat equal-viewport comparison until no P0-P2 findings remain.

final result: blocked
