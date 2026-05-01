# Module Contract Audit

Date: 2026-05-02
Status: VERIFIED FROM CODE READS AND TARGETED TESTS

## Purpose

This audit compares the current implementation contract for pages, posts,
projects, forms, and templates against the architecture map. It is intended to
turn module drift into explicit follow-up tasks instead of broad refactors.

## Shared Content Contract

Pages, posts, and projects currently follow the strongest shared content
contract:

- localized admin routes under `/{locale}/admin`
- admin resource routes protected by `permission:manage-content`
- `BaseAdminContentController` for listing, shared props, taxonomy sync,
  revision restore, optimistic-lock checks, and bulk actions
- dedicated create/update FormRequest classes
- `AdminContentPersistenceService` transactions for create/update and relation
  sync
- `ContentPolicy` authorization checks inside controllers
- localized slug normalization, reserved-route validation, canonical URL
  normalization, SEO fields, publish status handling, revisions, and block
  builder module categories

Forms and templates reuse meaningful parts of this contract but are not fully
aligned with the pages/posts/projects implementation style.

## Module Matrix

| Module | Admin Route Owner | Validation | Authz | Taxonomy | Revision | Public Runtime |
| --- | --- | --- | --- | --- | --- | --- |
| Pages | `manage-content` | Dedicated FormRequests | `ContentPolicy` gates | No | Yes | Home and dynamic page resolver |
| Posts | `manage-content` | Dedicated FormRequests | `ContentPolicy` gates | Posts categories/tags | Yes | Blog archive/detail via configured archive page |
| Projects | `manage-content` | Dedicated FormRequests | `ContentPolicy` gates | Projects categories/tags | Yes | Project archive/detail via configured archive page |
| Forms | `manage-settings` | Inline controller validation | Route middleware only | No | No explicit revision route | Preview + throttled public submit |
| Templates | `manage-settings` | Inline controller validation | Route middleware + system delete guard | No | Yes | Header/footer/sidebar/page layout resolution |

## Findings

### Pages

- Contract fit: strong.
- Uses `Page`, admin `PageController`, page FormRequests, `ContentPolicy`,
  shared persistence, revisions, bulk actions, template overrides, and public
  dynamic resolution.
- No follow-up required from this audit.

### Posts

- Contract fit: strong.
- Uses post FormRequests, taxonomies, shared persistence, revisions, bulk
  actions, post detail resolution through the configured blog archive page, and
  posts-only public taxonomy archives.
- No follow-up required from this audit.

### Projects

- Contract fit: mostly strong.
- Uses project FormRequests, client relation, taxonomies, shared persistence,
  bulk actions, and taxonomy-backed public presentation.
- Remaining debt: `projects.category` still exists as compatibility fallback in
  persistence/runtime surfaces. Admin authoring is removed, but the field still
  needs a deliberate retirement/backfill decision.

### Forms

- Contract fit: partial.
- Forms have admin CRUD, block-builder module categories, public preview, and
  throttled public submission with idempotency support.
- Drift: forms are routed under `manage-settings`, use inline controller
  validation, and do not use explicit policy checks in the controller.
- Follow-up: decide whether forms are configuration-owned or content-owned. If
  content-owned, add FormRequest classes and policy checks aligned with shared
  admin content modules.

### Templates

- Contract fit: partial.
- Templates have admin CRUD, block-builder template slots, revision restore,
  system-template delete protection, and public layout resolution.
- Drift: templates are routed under `manage-settings`, use inline controller
  validation, and do not use explicit policy checks in the controller.
- Follow-up: keep templates settings-owned by explicit decision, or add
  template-specific FormRequests and policy checks to match the shared content
  quality bar.

## Follow-Up Queue

1. FEA-017: Decide and harden forms/templates admin ownership contract.
2. FEA-018: Audit remaining `projects.category` persistence/runtime fallback
   surfaces and decide retirement or explicit long-term compatibility.
3. FEA-012: Normalize residual legacy docs after module ownership decisions are
   recorded.

## Verification

- `php artisan test --filter=PublicRouteContractTest`
- Code reads:
  - `routes/admin.php`
  - `routes/public.php`
  - `app/Http/Controllers/Admin/*Controller.php`
  - `app/Models/Page.php`
  - `app/Models/Post.php`
  - `app/Models/Project.php`
  - `app/Models/Form.php`
  - `app/Models/Template.php`
  - `app/Http/Requests/Admin/*`
  - `config/block_builder.php`
