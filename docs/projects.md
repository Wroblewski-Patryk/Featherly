# Modul projektow (stan kodu)

## Dane i admin

- Model: `Project`.
- Tresc projektu jest blokowa (`content` JSON), analogicznie do pages/posts.
- Dodatkowe pola: `desktop_image`, `mobile_image`, `url`, `category`, `client`, `order`.
- Pola SEO i status publikacji sa wspierane.

Admin ma CRUD dla `projects`.

## Routing publiczny

Kod `PageController` zawiera `showProject(...)`, ale aktualne publiczne route wiring po refaktorze locale jest jeszcze dopinane w `routes/public.php`.

## Uwaga o slug

Model zaklada translatable pola `title/description/SEO`, ale `slug` w tabeli nadal jest stringiem.
Jednoczesnie logika wyszukiwania projektu po slug jest juz przygotowywana pod locale (`slug->{locale}`).