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
  - `GET /{locale}/{path}` for the named public content resolver
  - `GET /{locale}/forms/{id}/preview`
  - `GET /sitemap.xml`
  - `GET /robots.txt`
  - `GET /lang/{lang}`
- Planned routes:
  - module-qualified public taxonomy routes, if approved after V1
  - fuller `/api/v1/headless/*` route set, if productized after MVP

## In Progress
- Module contract audit for pages/posts/projects/forms/templates.
- Coolify staging/live evidence capture for production update enablement.

## Explicitly Out of Scope (Current MVP)
- Plugin marketplace.
- Headless public API productization.
- Multi-tenant SaaS billing stack.
