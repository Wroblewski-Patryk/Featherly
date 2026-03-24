# Module: Data Model

## Goal
Document core tables and contracts for content and configuration modules.

## Core Tables
- `pages`
- `posts`
- `projects`
- `forms`
- `templates`
- `translations`
- `languages`
- `settings`
- `revisions`
- `media`, `media_folders`
- RBAC tables (`roles`, `permissions`, role/user bridges)

## Common Patterns
- JSON fields for translatable and block-based content.
- Publish/archive lifecycle fields on content entities.
- Shared SEO field model across major content tables.

## Integrity Notes
- Keep schema, route assumptions, and module docs synchronized.
- Validate translated slug behavior whenever schema or queries are changed.
