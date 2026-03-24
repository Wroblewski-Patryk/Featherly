# System Architecture

## Context Diagram (Textual)
- Clients:
  - Admin users in browser (Inertia + Vue admin panel)
  - Public users in browser (localized public runtime)
- Core service:
  - Laravel application (routing, auth, content/domain logic)
- Data stores:
  - relational database (content, users, translations, settings, roles)
  - filesystem storage (`storage/app/public/media`) for media assets

## Domain Boundaries
- Auth and access control (including RBAC via Spatie).
- Content domains: pages, posts, projects, templates, forms.
- Configuration domains: settings, theme, languages, translations.
- Delivery domains: renderer/public runtime and SEO endpoints.

## Data Flows
- Admin writes content through Block Builder -> JSON persisted in content models.
- Public runtime reads localized content -> renderer composes block tree.
- Translation scan detects UI keys -> translation records synchronized -> shared through Inertia props.

## Scalability Notes
- Feature-first frontend organization supports modular growth.
- Shared base admin patterns reduce duplication across modules.
- Block JSON schema allows incremental extension without schema churn for every UI variant.

## Reliability Notes
- Keep route exposure explicit and documented.
- Keep translation integrity check in routine validation.
- Keep release and smoke checklist evidence in ops/engineering docs.
