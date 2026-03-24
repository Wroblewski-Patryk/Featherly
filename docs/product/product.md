# Product

## Problem
Teams need a CMS that is fast for editors, supports multilingual content, and does not require coupling to a heavy external admin framework.

## Users and Segments
- Admin users (content editors, marketers)
- Technical operators (developers, maintainers)
- End users consuming localized content pages

## Core Jobs To Be Done
- Create and publish pages/posts/projects with structured blocks.
- Manage reusable templates and global settings.
- Keep admin UI translated and locale-aware.
- Maintain SEO basics and route consistency.

## Current Product Baseline
- Localized route model with locale middleware and language switching.
- Block Builder as central editing UX.
- Admin CRUD across core content and configuration modules.
- Translation scan + integrity checks to reduce missing UI keys.

## MVP Features
- Localized routing and language management.
- Block-based content authoring for primary modules.
- Admin operations for media, settings, templates, and users.
- SEO baseline (`sitemap.xml`, `robots.txt`, core meta fields).

## Post-MVP Focus
- Full public dynamic route exposure for page/blog/project.
- Expanded animation tooling and scene/timeline authoring.
- Additional hardening for release and runtime observability.

## Acceptance Criteria Strategy
Each feature is considered complete when:
- behavior is documented,
- route and permission impact is explicit,
- relevant tests or smoke checks were executed,
- follow-up items are captured in planning docs.
