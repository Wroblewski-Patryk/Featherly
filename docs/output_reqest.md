# AI Output Request

Read all /docs/*.md as source of truth.

Deliver:
1) Work Breakdown Structure (Epics → Features → Tasks) for MVP
2) Recommended architecture:
   - Laravel modules/layers
   - Vue admin structure
   - blocks renderer strategy
   - GSAP runtime strategy (public + admin preview)
3) Data model proposal (tables + key columns + relationships)
4) API design for builder (endpoints + payloads)
5) Rendering strategy options (SSR vs cached HTML vs hybrid) with pros/cons
6) Risks + mitigations:
   - performance (GSAP, preview re-renders)
   - SEO
   - security (richtext sanitization, uploads)
   - accessibility (reduced motion)
7) MVP timeline estimate in dev-days for solo developer

If anything important is unknown, ask a short question list first instead of assuming.