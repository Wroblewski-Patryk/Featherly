# Private Media Storage and Signed Access Evaluation

## Goal
Evaluate moving media assets from public storage to private storage with time-limited signed access URLs, without introducing regressions in existing content delivery.

## Current Baseline
- Media files are stored on `public` disk (`storage/app/public/media`).
- Public URL resolution uses `/storage/...` paths.
- This is simple and fast, but direct URLs are long-lived and effectively public.

## Evaluation Summary
- Recommendation: keep current public storage as default for existing runtime, and introduce private signed access as an opt-in rollout for selected media classes.
- Rationale:
  - avoids breaking existing page/post/project content references,
  - enables gradual migration per use case (e.g. client-only assets, gated downloads),
  - supports future multi-tenant and audit requirements.

## Proposed Target Model (Phased)
1. Storage classification:
   - `public` media (current behavior, unchanged),
   - `private` media (stored outside public path).
2. Access model for private media:
   - signed route returning stream/download,
   - short TTL signature (example: 5-15 minutes),
   - optional permission check before stream.
3. Compatibility rules:
   - keep existing `Media::url` semantics for public media,
   - resolve private media URLs via a signed-access resolver only when flagged as private.

## Rollout Plan (No Regression)
- Phase A: add private disk + signed route in disabled/opt-in mode.
- Phase B: add per-media visibility flag and admin-safe defaults (`public`).
- Phase C: migrate selected media records and verify reference rendering.
- Phase D: enforce policy for sensitive uploads only (not global cutover).

## Risks and Mitigations
- Broken references after migration:
  - mitigate with dual-resolution fallback during transition.
- Cache/CDN behavior differences:
  - mitigate with explicit cache headers and signed URL TTL policy.
- Operational complexity:
  - mitigate with clear ownership in ops runbook and monitoring for signed URL failures.

## Decision
SCL-022 is accepted as `evaluated`: proceed with incremental opt-in private media architecture rather than immediate global migration.
