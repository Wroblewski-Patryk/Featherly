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
- Install and bootstrap flow for first-run database and language setup.
- Content domains: pages, posts, projects, clients, taxonomies, templates,
  forms, composed blocks, animation presets, revisions, and publication
  scheduling.
- Configuration domains: settings, theme, languages, translations.
- Media domains: folders, uploads, deduplication, safe replacement, lifecycle
  metadata, and public URL resolution.
- Delivery domains: renderer/public runtime, SEO endpoints, public form
  submission, and token-scoped JSON content export.
- Reliability domains: request correlation IDs, response budget warnings,
  slow-query profiling, scheduled publish execution, operational metrics, and
  health checks.
- System update domain: update discovery, admin preferences, status/audit
  visibility, and environment-specific update drivers. See
  `docs/architecture/system-update-manager-contract.md`.

## Data Flows
- Admin writes content through Block Builder -> JSON persisted in content models.
- Public runtime reads localized content -> renderer composes block tree.
- Translation scan detects UI keys -> translation records synchronized -> shared through Inertia props.
- Admin content writes use dedicated request validation, policy checks,
  optimistic-lock checks, transactional persistence, taxonomy sync, and revision
  snapshots where supported.
- Shared Inertia data is cached through versioned keys for settings, languages,
  header/footer templates, translations, and public project payloads.
- Public forms accept throttled submissions with idempotency-key handling.
- Headless export requests use hashed bearer tokens with explicit scopes before
  returning paginated public content.

## Scalability Notes
- Feature-first frontend organization supports modular growth.
- Shared base admin patterns reduce duplication across modules.
- Block JSON schema allows incremental extension without schema churn for every UI variant.
- Module-scoped block registry and composed blocks let editor capability grow
  without hard-coding each module page.
- Admin list surfaces share pagination, selection, bulk action, and optimistic
  rollback behavior through reusable table primitives.
- See `docs/architecture/current-implementation-map.md` for the current
  verified runtime surface inventory.

## Reliability Notes
- Keep route exposure explicit and documented.
- Keep translation integrity check in routine validation.
- Keep release and smoke checklist evidence in ops/engineering docs.
- For media access hardening strategy, see `docs/architecture/private-media-signed-access-evaluation.md`.
- Keep scheduler-owned behavior observable through command tests, structured
  logs, health checks, and post-deploy smoke evidence.
- Automatic update application must use a safe configured update driver and
  fail closed when environment support or release integrity cannot be verified.
