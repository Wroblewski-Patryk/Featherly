# Featherly CMS

Custom CMS oparty o Laravel 12 + Vue 3 + Inertia.

## Uruchamianie lokalnie

Masz dwie poprawne opcje:

1. Dwa terminale:
- `php artisan serve`
- `npm run dev`

2. Jeden terminal:
- `composer run dev`

`composer run dev` uruchamia server + queue + pail + vite.

## Aktualna architektura routingu

Routing jest modularny i lokalizowany:

- `routes/auth.php` pod prefiksem `/{locale}`
- `routes/admin.php` pod prefiksem `/{locale}/admin`
- `routes/public.php` pod prefiksem `/{locale}`
- techniczne trasy bez prefiksu: `sitemap.xml`, `robots.txt`, `lang/{lang}`

Konfiguracja jest spinana w `bootstrap/app.php` (middleware `locale`, alias i redirecti auth).

## Co aktualnie dziala

- Panel admin: pages, posts, media, projects, forms, templates, translations, languages, users, settings, theme, blocks.
- i18n backend: tabela `languages`, tabela `translations`, share tlumaczen przez Inertia.
- SEO techniczne: `sitemap.xml`, `robots.txt`.

## Co jest jeszcze do dopiecia

- W `routes/admin.php` sa zarejestrowane `categories` i `clients`, ale brak odpowiadajacych kontrolerow/modeli.
- W `routes/public.php` obecnie aktywne sa tylko: `/{locale}` i `/{locale}/forms/{id}/preview`.
  Logika dynamicznych podstron/blog/projekty jest w `PageController`, ale ekspozycja tras publicznych jest jeszcze w trakcie porzadkowania.
- Dynamiczny submit dla formularzy z modulu `forms` nie jest jeszcze domkniety.