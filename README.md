# Featherly CMS

Featherly is a custom CMS built with Laravel 12, Inertia, and Vue 3.  
It focuses on block-based content editing, multilingual content, and a custom admin panel.

## Local Development

Use one of these options:

1. Two terminals:
- `php artisan serve`
- `npm run dev`

2. One terminal:
- `composer run dev`

`composer run dev` starts server, queue, pail, and Vite together.

## Current Routing Architecture

Routing is modular and localized:

- `routes/auth.php` under `/{locale}`
- `routes/admin.php` under `/{locale}/admin`
- `routes/public.php` under `/{locale}`
- technical routes without locale prefix: `sitemap.xml`, `robots.txt`, `lang/{lang}`

Locale behavior is wired in `bootstrap/app.php` and locale middleware.

## Current Status (2026-03-24)

Implemented:

- Admin modules: pages, posts, media, projects, forms, templates, translations, languages, users, settings, theme, blocks, clients.
- i18n backend: `languages` + `translations`, shared to frontend via Inertia props.
- SEO base: `sitemap.xml`, `robots.txt`, default meta handling.
- Translation scanning workflow: `php artisan i18n:scan --scope=admin` + integrity test.

Known gaps:

- Public dynamic routes for page/blog/project are partially prepared in controllers but not fully exposed in `routes/public.php`.
- Category taxonomy routes were introduced before full implementation and still require validation against the current model set.

## Documentation

Primary docs are in `docs/`.
Start from:

- `docs/overview.md`
- `docs/product/product.md`
- `docs/architecture/system-architecture.md`
- `docs/planning/mvp-next-commits.md`
