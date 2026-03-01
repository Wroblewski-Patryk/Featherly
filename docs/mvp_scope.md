# MVP Scope

## Admin (CMS)
- Logowanie
- Pages CRUD:
  - title
  - slug
  - status (draft/published)
  - SEO: meta_title, meta_description, og_image (opcjonalnie)
- Builder:
  - dodaj/usuń/przenieś blok (reorder)
  - edycja ustawień bloku (Content, Media, Layout, Marketing, Theme)
  - **Magic Sauce**: Panel animacji GSAP dla każdego bloku (triggers, presets, duration, delay)
  - podgląd (desktop/tablet/mobile)
  - zapis wersji roboczej / publikacja
- Rewizje:
  - przechowywać historię zmian (min. 10)
  - możliwość przywrócenia

## Media
- Upload obrazów
- Lista mediów
- Alt text

## Public
- Render strony po slug
- 404
- Szybkość i SEO (treść widoczna bez JS)

## Formularze
- Blok ContactForm:
  - name/email/message
  - wysyłka maila + zapis w DB
  - antyspam: honeypot + rate-limit + prosta walidacja