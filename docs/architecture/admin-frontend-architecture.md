# Admin Frontend Architecture

## Information Architecture
The admin frontend uses feature-first modules under `resources/js/features/admin/`.

Core areas:
- `block-builder/`
- `media/`
- `settings/`
- `shared/`
- `theme/`

## State Management
- Complex editor state is managed in Pinia (`useBlockBuilderStore`).
- Shared Inertia props provide locale, languages, translations, and selected global config.

## Shared Components
- Reusable admin UI building blocks live in `features/admin/shared/components`.
- `ResourceTable` pattern is used across list-based modules.

## Routing Strategy
- Admin routes are locale-prefixed under `/{locale}/admin`.
- Frontend route generation uses Ziggy route names.

## Performance Notes
- Prefer modular component loading and avoid unnecessary global state.
- Keep data shaping in backend controllers to reduce frontend over-fetching.
- Preserve consistent translation key usage for stable render paths.
