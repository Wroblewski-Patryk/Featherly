# Modul bloga (stan kodu)

## Dane i admin

- Model: `Post`.
- Pola translatable: `title`, `slug`, `excerpt`, `featured_image`, pola SEO.
- Tresc wpisu: `content` (JSON, blokowo).
- Rewizje tresci: morph relation `revisions`.

Admin ma CRUD dla `posts`.

## Routing publiczny

Aktualnie publiczne trasy bloga nie sa finalnie wystawione w `routes/public.php`.

Kod `PageController` zawiera logike `showPost(...)`, ale aktualne route wiring jest jeszcze porzadkowane po refaktorze locale.

## Kategorie/tagi

W `routes/admin.php` jest zarejestrowany resource `categories`, ale brak implementacji kontrolera/modelu.