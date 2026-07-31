# Featherly Portfolio CMS Gap Register

Date: 2026-07-31

Source task: FEA-022

Reference: owner-provided portfolio source archive, SHA-256
`15DD863BCF142A5FC6DB83C3C921CAEA1F31E41F66AE4FDE88629C56F69F111C`

## Purpose

This register separates portfolio content work from reusable Featherly product
gaps. A row is recorded only when code inspection, a reproducible CMS action,
or browser evidence confirms the behavior.

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
| P1 | Theme source ownership | Default theme structures still exist in both `ThemeController` and shared Inertia composition. | Future token additions can drift between admin and public runtime. | Extract one canonical theme-default/normalization service and cover old-setting migration plus public/admin parity. |
| P2 | Localized structured navigation editing | The new destination model supports runtime localized labels, but `NavigationSettings` currently edits one plain label value rather than using the shared locale-aware text control. | A multilingual site cannot author each navbar label with the same explicit locale workflow as headings and paragraphs. | Reuse the shared localized input primitive for `links[].label`, brand title, and action label without changing the `{ label, href }` runtime schema. |
| P2 | Design-token validation | Theme globals accept broad arrays without validating individual colors, fonts, radii, or advanced CSS token values. | Invalid values can be stored and silently ignored by the browser. | Add nested validation, normalized defaults, field-local errors, and persistence tests for each theme tab. |

## Portfolio-Specific Work Remaining After CMS Deployment

- Re-author page `#7` into semantic section containers rather than a flat stack
  of headings and paragraphs.
- Apply the canonical ink/paper/amber/cyan palette and Titillium Web/Roboto
  typography through the repaired theme configurator.
- Attach stable HTML IDs to the notes, projects, about, and contact sections,
  then set the new navbar destinations.
- Complete equal-viewport desktop and mobile visual comparisons against the
  source implementation and fix all P0-P2 differences.
- Verify repeated save, reload persistence, image rendering, keyboard
  navigation, responsive overflow, and public console errors in production.

## Rollback

- Code: redeploy the previous successful Coolify revision.
- Content: restore the previous Featherly page/template revision and theme
  setting through the admin UI.
- No unrelated Coolify resource, CMS page, template, or media item is in scope.
