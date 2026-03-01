# Bloki treści – wersja zaktualizowana

System bloków umożliwia elastyczne budowanie stron i wpisów poprzez łączenie gotowych komponentów.  Każdy blok jest reprezentowany jako obiekt w tablicy JSON w polu `content`.  Poniżej zestawiono główne kategorie oraz przykładowe typy bloków obsługiwane w projekcie.

## Kategorie bloków i przykłady

| Kategoria | Przykładowe typy bloków | Opis |
|---|---|---|
| **Treść (Content)** | `paragraph`, `heading`, `list`, `quote` | Podstawowe bloki tekstowe i typograficzne; mogą zawierać ustawienia stylu (rozmiar, kolor). |
| **Media** | `image`, `gallery`, `video`, `audio` | Bloki wczytujące obrazy lub multimedia z biblioteki mediów; pola konfiguracji obejmują źródło, opis alternatywny, tryb wyświetlania. |
| **Układ/sekcje** | `section`, `twoColumns`, `grid`, `accordion`, `tabs` | Bloki kontenerowe umożliwiające organizację treści w sekcje z kolumnami, zakładkami itp.; zawierają tablicę dzieci (`children`). |
| **Hero i marketing** | `hero`, `ctaBox`, `features`, `pricingTable` | Duże sekcje wprowadzające z nagłówkiem, opisem, przyciskiem i obrazem; wykorzystywane na stronach startowych i landing pages. |
| **Nawigacja i motyw** | `navigation`, `languageSwitcher`, `breadcrumb` | Bloki do wstawiania menu oraz elementów interfejsu, takich jak przełącznik języka. |
| **Wpisy i projekty** | `postList`, `postItem`, `projectList`, `projectItem` | Bloki pobierające dane z modułów bloga i portfolio.  `postList` i `projectList` oferują parametry filtrowania (kategoria, liczba elementów) oraz obsługę stronicowania; elementy indywidualne (`postItem`/`projectItem`) są używane wewnętrznie w listach. |
| **Formularze i interakcje** | `contactForm`, `form`, `newsletterSignup`, `button` | Bloki do umieszczania formularza kontaktowego, formularzy niestandardowych oraz wezwań do działania; konfiguracja obejmuje m.in. wybór formularza z bazy, tekst przycisku, pola zgody itp. |
| **Integracje/Embed** | `iframe`, `map`, `youtubeEmbed`, `tweet` | Osadzanie treści z zewnętrznych źródeł (mapy, wideo, wpisy z mediów społecznościowych). |
| **Dane dynamiczne** | `menu`, `languageSwitcher`, `breadcrumbs`, `footerLinks` | Bloki pobierające dane z innych tabel, np. definicje menu lub listę obsługiwanych języków. |
| **Specjalne** | `html`, `script`, `divider`, `spacer` | Dodatkowe narzędzia do wstawiania niestandardowego HTML/JS, linii oddzielających czy odstępów. |

## Ustawienia bloku

Każdy blok posiada zestaw właściwości:

- **`type`** – nazwa typu bloku.
- **`settings`** – obiekt z parametrami konfiguracyjnymi (np. wyrównanie, kolor tła, liczbę kolumn).  Struktura ustawień jest definiowana dla każdego typu bloku oddzielnie.
- **`animation`** – informacje o animacji GSAP (preset, duration, delay, ease, trigger)【653274490132042†L0-L58】.
- **`timeline`** – identyfikator sekwencji, jeżeli blok jest częścią złożonej animacji.
- **`children`** – tablica elementów podrzędnych dla bloków kontenerowych.

Dzięki takiemu podejściu możliwe jest dodawanie nowych typów bloków bez zmian w schemacie bazy – wystarczy utworzyć renderer publiczny i komponent edycyjny w panelu admina zgodnie z zasadami określonymi w dokumentacji architektury【923699511808356†L2-L11】.

---

## Rozszerzenie: Scene Mode + warstwy

Aby obsłużyć strony „bez scrolla” (przełączanie sekcji jak slajdy), wprowadzamy dodatkowe byty/typy bloków i pola:

### Nowe typy (propozycja)

- `scene` – pełnoekranowa sekcja (viewport section). Zawiera `children`.
- `layerGroup` – grupa warstw (folder) do organizacji.
- `globalLayer` – warstwa renderowana niezależnie od scen (np. tło/ramka/dekor).

### Pola warstw / layout (propozycja minimalna)

W `settings` (lub w wydzielonym polu `layout`) bloki mogą mieć:

- `position`: `relative | absolute | fixed | sticky`
- `z_index`: number
- `z_depth`: number (np. -500..500) – do **podglądu głębi** i opcjonalnego `translateZ`
- `transform`: `translateX/translateY/scale/rotate` (dla absolutnych layoutów)
- `anchor`: np. `top-left`, `center`, `bottom-right` (ułatwia UI)

### Tryby strony

W `Page.settings` proponujemy:

- `page_mode`: `document` (domyślnie) / `scenes`
- `scene_settings`: opcje nawigacji (wheel/keys/url sync), parametry przejść itp.
