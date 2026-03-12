# Lokalizacja i tlumaczenia (stan kodu)

## Routing i middleware locale

- Trasy auth/admin/public dzialaja pod prefiksem `/{locale}`.
- `LocaleMiddleware` ustala jezyk w kolejnosci:
  1. parametr trasy `locale`
  2. pierwszy segment URL
  3. sesja
  4. `config('app.locale')`
- Middleware waliduje locale na podstawie aktywnych jezykow z tabeli `languages`.
- Middleware ustawia `URL::defaults(['locale' => ...])`.

## Przelaczanie jezyka

- Trasa switchera: `GET /lang/{lang}` (nazwa: `lang.switch`).
- `LocaleController` akceptuje tylko jezyki aktywne z tabeli `languages`.

## Shared i18n przez Inertia

`HandleInertiaRequests` udostepnia:

- `locale`
- `languages` (aktywne jezyki)
- `translations` (flat mapa `group.key -> text`)

## Aktualne ograniczenia

- Frontendowy `LanguageSwitcher.vue` ma obecnie hardcoded opcje `pl` i `en`.
- `LanguageSwitcher.vue` odwoluje sie do `route('locale.switch', ...)`, podczas gdy backend rejestruje `lang.switch`.
- W dokumentacji i kodzie trwaja dalsze porzadki i18n po refaktorze.