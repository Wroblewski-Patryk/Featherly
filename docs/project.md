# Projekt: Featherly CMS

## Stan na 2026-03-12

Projekt jest po serii commitow i18n oraz refaktorze routingu na podejscie modularne z prefiksem locale.

## Fundament, ktory jest dowieziony

- Laravel 12 + Inertia + Vue 3 + Pinia + Tailwind/DaisyUI.
- Block Builder jako glowny mechanizm edycji tresci.
- Moduly admina dla glownego contentu i konfiguracji systemu.
- SEO service + meta head + sitemap/robots.
- Warstwa lokalizacji oparta o `languages` + `translations` + middleware locale.

## Najwazniejsze zmiany architektoniczne

1. Routing zostal podzielony na `auth`, `admin`, `public`.
2. Locale jest obslugiwane przez middleware i domyslne parametry URL.
3. Shared props Inertia zawieraja m.in. `languages`, `translations`, `theme_config`, `seo_settings`.

## Obecne luki techniczne (stan kodu)

- Trasy `categories` i `clients` istnieja, ale brakuje implementacji backendowej.
- Publiczne dynamiczne routy tresci (catch-all/blog/projects) sa przygotowane po stronie kontrolera, ale nie sa jeszcze finalnie wystawione w `routes/public.php`.
- Modul formularzy ma edycje i preview, ale runtime submit jest nadal etapem nastepnym.