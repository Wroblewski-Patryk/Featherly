# Cache TTL Matrix

## Scope
This matrix defines default TTL rules for shared application caches to keep behavior predictable and invalidation intentional.

## TTL Policy
| Dataset / Key Family | Current Key Pattern | TTL Policy | Invalidation Trigger |
|---|---|---|---|
| Global settings | `shared:v1:global_settings` | `forever` | Settings update (`SharedInertiaCache::forgetSettings`) |
| Global header/footer | `shared:v1:global_header_*`, `shared:v1:global_footer_*` | `forever` | Template activation/update/delete (`forgetHeaderFooter*`) |
| Active languages | `shared:v1:active_languages` | `forever` | Language update (`forgetLanguages`) |
| Project listing | `shared:v1:all_projects` | `forever` | Project/content updates (`forgetProjects`) |
| Per-locale translations | `shared:v1:translations.{locale}` | `3600s` (1h) | Translation updates (`forgetTranslationsForActiveLocales`) |

## Rules
- `forever` is allowed only for datasets with explicit invalidation hooks in application code.
- Time-based TTL is preferred for localized dictionaries to avoid long stale windows when invalidation misses.
- New shared cache keys must be namespaced (`shared:v{n}:*`) and added to this matrix before rollout.
- Any new `remember()` TTL value should be declared explicitly in planning updates with rationale.
