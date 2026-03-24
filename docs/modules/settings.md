# Module: Settings

## Goal
Centralize global runtime and admin configuration via key-value storage.

## Key Areas
- Routing/page mapping keys (`home_page_id`, `blog_page_id`, `projects_page_id`, etc.)
- SEO defaults (`site_name`, default descriptions/images, sitemap and robots switches)
- Theme/layout defaults (`theme_config`, default header/footer)

## Notes
- Values may be stored as scalar or JSON depending on key.
- Admin settings UI is the canonical operational path for updates.
