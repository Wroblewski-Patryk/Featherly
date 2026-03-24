# Module: Projects

## Goal
Manage portfolio projects with localized content and client associations.

## Current Scope
- Admin CRUD for projects.
- Block-based project content JSON.
- Client association support (`client_id`).
- Additional fields include desktop/mobile image, URL, completion date, and SEO metadata.

## Slug and Localization
- Project slug is expected in localized form.
- Runtime lookup should resolve by locale-aware slug value.

## Risks
- Keep DB schema and routing assumptions synchronized when slug behavior changes.
- Keep client relation constraints validated in admin forms and queries.
