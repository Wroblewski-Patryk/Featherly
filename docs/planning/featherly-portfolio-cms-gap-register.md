# Featherly Portfolio CMS Gap Register

Date: 2026-08-08

Source task: FEA-022

Reference: owner-provided portfolio source archive, SHA-256
`15DD863BCF142A5FC6DB83C3C921CAEA1F31E41F66AE4FDE88629C56F69F111C`

## Purpose

This register separates portfolio content work from reusable Featherly product
gaps. A row is recorded only when code inspection, a reproducible CMS action,
or browser evidence confirms the behavior.

This file is the single handoff for agents who develop Featherly itself.
FEA-022 must not implement the open rows below: portfolio work may only use the
capabilities already exposed by the production CMS. Do not copy these gaps into
parallel implementation notes; link to this register instead.

## Resolved In The Current Slice

| Priority | Contract | Confirmed symptom | Root cause | Resolution and evidence |
| --- | --- | --- | --- | --- |
| P0 | Theme persistence | Colors and fonts appeared changed in the configurator but reverted after reload and the public page continued to receive legacy defaults. | An empty `block_defaults` array failed the `required` validator, while shared public props rebuilt `theme_config` exclusively from the older `theme_colors`, `theme_radius`, and `theme_typography` keys. | Empty block defaults are now accepted as a present array; public props consume the canonical `theme_config` and retain legacy values only as a backward-compatible fallback. Covered by `ThemeManagementTest`. |
| P0 | Image block runtime | A media selection and URL persisted in page JSON but produced no public image. | `DynamicBlock.vue` had no `image` renderer branch. | Added accessible figure/image/caption rendering with normalized storage URLs and an editor-only placeholder. Covered by the portfolio CMS contract test. |
| P0 | Navbar destinations | Navbar labels rendered, but neither links nor the action button had editable destinations. | Navbar content stored strings only and the runtime rendered anchors without `href`. | Navbar content now stores `{ label, href }`, includes brand/action destinations, migrates legacy strings in the editor, and renders real anchors. Covered by the portfolio CMS contract test. |
| P1 | Repeated page saves | A successful save could be followed by a false optimistic-lock conflict. | The page editor replaced the server revision timestamp with the browser clock. | The editor now takes `page.updated_at` from the successful Inertia response. Covered by the portfolio CMS contract test; production repetition smoke remains required after deploy. |
| P1 | Responsive navbar interaction | The renderer hid navigation below `lg` without an equivalent mobile control. | Desktop links were the only navigation branch. | Added an accessible mobile toggle, destination list, action link, Escape handling, and close-on-navigation behavior. Covered by the portfolio CMS contract test; production touch/keyboard smoke remains required. |

## Confirmed Open Product Gaps

| Priority | Contract | Evidence | Product impact | Required completion contract |
| --- | --- | --- | --- | --- |
| P0 | Editor style-control persistence | On production page `#7`, selecting solid/gradient/image fill or changing linked-spacing mode immediately submits the surrounding page form; the selected mode does not remain active. Direct edits to both gradient color fields followed by save/reload also return to `#000000ff` and `#ffffffff`. Browser console shows no application error. Code inspection confirms the mode/link buttons in `FillControl.vue` and `LinkedUnitInput.vue` omit explicit non-submit semantics. | Editors cannot reliably use native background/text fill controls or independently tune spacing, blocking the paper/amber headline and asymmetric hero geometry required by the reference. | Make every editor-only action inside a form explicitly non-submit, verify that color-field events update the same model contract, add interaction tests for mode/color/link changes without form submission, then verify save/reload persistence on a real page. |
| P0 | Heading typography control ownership | On production page `#7`, heading size and line-height persist and reach the public page, but authored `font-weight: 300` and letter spacing are written to the outer block wrapper. The rendered heading primitive still computes `font-weight: 900` and its own `-0.05em` tracking, overriding the editor values. This was reproduced on `#notes` after an explicit save and cold public reload. | Editors can change heading scale but cannot reproduce the reference's light Titillium display weight or exact tracking through the native appearance controls. | Apply authored typography to the rendered text element, or make the heading primitive inherit every typography property from its block contract. Add editor-to-public integration coverage for family, size, line-height, weight, tracking, transform, alignment, and responsive variants. |
| P0 | Public theme color application | The production theme editor saves the requested palette and retains it after admin reload, but `/pl/` still computes DaisyUI `light` defaults: `--color-primary: oklch(45% .24 277.023)` and `--color-base-100: oklch(100% 0 0)`. The saved font does reach public runtime (`--font-sans: 'Titillium Web'`). | The header remains white, the CTA remains purple, and global ink/paper/amber/cyan styling cannot be authored through the theme UI even though the administrator receives a successful save state. | Map the canonical saved color configuration to public CSS variables/theme selection, cover admin-save to public-render integration for every palette token, and verify values after a cold public reload. |
| P0 | Sticky template stacking and navigation | Template `#10` renders correct `#start`, `#notes`, `#projects`, `#about`, and `#contact` hrefs. The first jump works at the top of the page, but after scrolling `document.elementFromPoint()` over the visibly sticky header resolves to the content block underneath. The outer header wrapper carries `sticky top-0 z-[60]`, yet computed `z-index` is `0` because the shared block wrapper writes an inline default. Subsequent header clicks do not change the hash or scroll position. | The primary navigation becomes non-interactive after the visitor enters the page, despite looking present and exposing correct link destinations. | Do not serialize an inline zero z-index when no explicit value is authored; define and test a template/header stacking contract that remains above content at every scroll position, including pointer hit-testing and repeated anchor navigation. |
| P1 | Responsive container layout | Featherly already has a nestable `container` block, drag-and-drop children, HTML tag, stable ID, boxed mode, flex/grid layout, spacing, and fill controls. However, `layoutType`, `flexConfig.direction`, and `gridConfig.cols` are single values with no breakpoint variants; public rendering applies the same row/column count at every viewport. | A two-column desktop hero or project row cannot natively collapse to one column on mobile while preserving the same CMS-authored structure. | Add mobile/tablet/desktop variants for container direction, column count, gap, alignment, and width; editor preview and public runtime must resolve the same breakpoint contract and preserve legacy single-value content. |
| P1 | Theme source ownership | Default theme structures still exist in both `ThemeController` and shared Inertia composition. | Future token additions can drift between admin and public runtime. | Extract one canonical theme-default/normalization service and cover old-setting migration plus public/admin parity. |
| P2 | Localized structured navigation editing | The new destination model supports runtime localized labels, but `NavigationSettings` currently edits one plain label value rather than using the shared locale-aware text control. | A multilingual site cannot author each navbar label with the same explicit locale workflow as headings and paragraphs. | Reuse the shared localized input primitive for `links[].label`, brand title, and action label without changing the `{ label, href }` runtime schema. |
| P2 | Design-token validation | Theme globals accept broad arrays without validating individual colors, fonts, radii, or advanced CSS token values. | Invalid values can be stored and silently ignored by the browser. | Add nested validation, normalized defaults, field-local errors, and persistence tests for each theme tab. |

## Portfolio Work That Remains In FEA-022

- Continue authoring page `#7` only through the production Featherly UI, using
  the existing container and working style controls where they are sufficient.
- Keep the canonical ink/paper/amber/cyan palette, Titillium Web typography,
  stable section IDs, and navbar destinations already saved through the CMS.
- Preserve the 2026-08-08 production polish: duplicate in-content image and
  footer line hidden, section heading scale/line-height refined, and the source
  hero asset retained as the native media-backed heading fill.
- Do not patch Featherly while executing this portfolio task. New confirmed CMS
  limitations belong in the open-gap table above for a separate agent.
- Complete equal-viewport desktop and mobile visual comparisons against the
  source implementation and fix all P0-P2 differences.
- Verify repeated save, reload persistence, image rendering, keyboard
  navigation, responsive overflow, and public console errors in production.

## Rollback

- Code: redeploy the previous successful Coolify revision.
- Content: restore the previous Featherly page/template revision and theme
  setting through the admin UI.
- No unrelated Coolify resource, CMS page, template, or media item is in scope.
