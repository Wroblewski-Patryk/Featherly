# Modules

## Module List
- Block Builder
  - Owner: admin frontend
  - Responsibilities: visual authoring, block state, history, block configuration
  - Inputs/Outputs: content JSON + settings JSON
- Renderer
  - Owner: frontend runtime
  - Responsibilities: resolve block types and render runtime UI
  - Inputs/Outputs: block JSON -> rendered components
- Content Architecture
  - Owner: backend content domain
  - Responsibilities: shared behavior for page/post/project CRUD and contracts
  - Inputs/Outputs: normalized model behavior and admin responses
- Forms
  - Owner: content/runtime backend + frontend
  - Responsibilities: form definitions and runtime submissions
  - Inputs/Outputs: form JSON definitions, submission records
- Projects
  - Owner: content domain
  - Responsibilities: project portfolio entities with client relation and SEO fields
  - Inputs/Outputs: project records + locale-aware slug resolution
- Templates
  - Owner: layout domain
  - Responsibilities: reusable page/header/footer/sidebar structures
  - Inputs/Outputs: template JSON blocks + global associations
- Settings
  - Owner: configuration domain
  - Responsibilities: global key-value configuration for routing/SEO/theme
  - Inputs/Outputs: key-value settings consumed by runtime/admin
- Media
  - Owner: media domain
  - Responsibilities: upload, listing, and asset references for content modules
  - Inputs/Outputs: media records + storage files
- RBAC
  - Owner: authz/security domain
  - Responsibilities: roles/permissions and access enforcement
  - Inputs/Outputs: permission map to backend middleware and frontend props

## Cross-Module Contracts
- Locale-aware routes and translatable fields are required across content modules.
- Block content contracts must stay compatible between builder and renderer.
- Settings and templates must remain compatible with public runtime rendering.
- Role/permission decisions must be mirrored in admin UI visibility.
