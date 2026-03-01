# Data model hints (do not overengineer)

## Pages
- id
- title
- slug (unique)
- status: draft/published
- seo fields (optional)
- published_at
- created_at/updated_at

## Page versions / revisions
- page_id
- version_number
- blocks_json (snapshot)
- created_by
- created_at

## Blocks storage approach (preferred for MVP)
Store page content as JSON:
- blocks_json: array of block instances
Block instance fields:
- id (uuid)
- type (string)
- settings (json)
- animation (json)
- timeline (json)
- children (optional for nested layout blocks)

## Media
- id
- path/url
- mime
- size
- alt_text
- created_at

## Form submissions
- id
- form_type
- payload json
- ip (optional)
- created_at