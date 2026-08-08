# Design Memory

Purpose: keep a compact memory of approved visual directions, reusable UI
patterns, and verified UX learnings so future tasks can build on them instead
of rediscovering them.

## Update Rules

- Add or update an entry when a visual pattern, layout approach, or interaction
  rule has been approved in implementation or review.
- Prefer updating an existing entry over creating duplicates.
- Keep entries specific enough to reuse in future tasks.
- If a pattern is project-specific, say so explicitly.

## Entry Template

```markdown
### YYYY-MM-DD - Short Title
- Type: visual_direction | reusable_pattern | responsive_rule | ux_learning
- Context:
- Decision:
- Reuse when:
- Avoid when:
- Evidence:

### YYYY-MM-DD - Background Asset Fidelity Rule
- Type: ux_learning
- Context:
- Decision:
- Reuse when:
- Avoid when:
- Evidence:
```

## Entries

### 2026-07-31 - CMS parity requires semantic sections
- Type: reusable_pattern
- Context: Recreating the owner portfolio in Featherly from an approved visual
  source.
- Decision: Build each visual chapter as a semantic container with shared
  tokens, responsive spacing, a stable anchor ID, and source assets; do not
  approximate the page with a flat sequence of oversized text blocks.
- Reuse when: translating a designed landing page or portfolio into the block
  builder.
- Avoid when: the source is intentionally a simple document flow.
- Evidence: FEA-022 desktop comparison in `docs/ux/evidence/fea-022` and the
  portfolio CMS gap register.

### 2026-08-08 - Editor tool buttons must not submit content forms
- Type: ux_learning
- Context: Interactive fill and spacing controls in the Featherly block-builder
  inspector.
- Decision: Give every tool, toggle, mode, alignment, and link button explicit
  `type="button"`; reserve submit behavior for the named save action only.
- Reuse when: adding any reusable control inside page, template, theme, form, or
  content editor forms.
- Avoid when: the control is intentionally the form's primary submit action.
- Evidence: reproducible FEA-022 production behavior plus the
  `portfolioCmsContracts` regression test.
