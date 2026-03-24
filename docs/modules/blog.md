# Module: Blog

## Goal
Manage localized posts and render blog content through block-based structures.

## Current Scope
- Admin CRUD for posts.
- Translatable fields: title, slug, excerpt, featured image, SEO fields.
- Content stored as block JSON.
- Revisions available through morph relation.

## Runtime Notes
- Controller logic for post rendering exists.
- Final public route exposure for blog detail/list requires completion in `routes/public.php`.

## Risks
- Route wiring and slug resolution must stay aligned with locale conventions.
- Category/taxonomy support requires consistency checks with current implementation state.
