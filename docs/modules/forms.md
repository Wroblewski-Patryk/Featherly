# Module: Forms

## Goal
Manage form definitions in admin and collect runtime submissions from public pages.

## Current Scope
- Admin CRUD for forms under localized admin routes.
- Form definitions stored as block JSON in `forms.content`.
- Additional config stored in `forms.settings`.
- Public preview route: `/{locale}/forms/{id}/preview`.
- Runtime submission path stores records in `form_submissions`.

## Data Contracts
- `forms`: status, title, content, settings, publish/archive lifecycle fields.
- `form_submissions`: `form_id`, submission `data` JSON, client metadata (`ip_address`, `user_agent`), read flag.

## Runtime Contract
- Form block provides runtime form state.
- Input blocks inject shared form state and submit to runtime endpoint.

## Risks
- Keep submission schema stable when adding new field types.
- Ensure validation and spam/abuse protections remain explicit.
