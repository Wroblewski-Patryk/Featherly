# MVP Scope

## Admin Scope
- Active sections:
  - Auth
  - Dashboard
  - Pages
  - Posts
  - Media
  - Projects
  - Forms
  - Templates
  - Translations
  - Languages
  - Users
  - Settings
  - Theme
  - Blocks
  - Clients
- Planned/partially aligned sections:
  - Categories/Taxonomies alignment and completion
  - Mediatheque extension (if reintroduced as separate area)

## Public Runtime Scope
- Exposed routes:
  - `GET /{locale}`
  - `GET /{locale}/forms/{id}/preview`
  - `GET /sitemap.xml`
  - `GET /robots.txt`
  - `GET /lang/{lang}`
- Planned routes:
  - public dynamic page resolution
  - public post/blog detail routes
  - public project detail/list routes

## In Progress
- Final public route wiring for dynamic content.
- Validation of taxonomy/category implementation consistency.

## Explicitly Out of Scope (Current MVP)
- Plugin marketplace.
- Headless public API productization.
- Multi-tenant SaaS billing stack.
