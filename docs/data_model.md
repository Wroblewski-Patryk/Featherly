# Model danych – wersja zaktualizowana

Poniższy dokument opisuje strukturę danych używaną w projekcie.  Modele wykorzystują Eloquent ORM z Laravel i w wielu miejscach stosują bibliotekę **Spatie Translatable** do przechowywania pól w różnych językach.  Wartości JSON są przechowywane jako kolumny typu `json` w bazie danych i automatycznie konwertowane na tablice w modelach.

## Tabele podstawowe

| Model (tabela) | Kluczowe pola | Uwagi |
|---|---|---|
| **pages** | `id`, `title` (json), `slug` (json), `content` (json), `settings` (json), `meta_title` (json), `meta_description` (json), `og_image` (json), `header_override_id`, `footer_override_id`, `created_at`, `updated_at` | Strony przechowują blokową treść i ustawienia. Pola są tłumaczone za pomocą Spatie Translatable, a zawartość i ustawienia przechowywane są jako JSON【2643092693358†L19-L27】. Nadpisania nagłówka i stopki są opcjonalnymi kluczami obcymi do tabeli `templates`【2643092693358†L28-L37】. |
| **revisions** | `id`, `revisionable_id`, `revisionable_type`, `content` (json), `user_id`, `created_at` | Przechowuje historyczne kopie treści stron i wpisów. Polimorficzna relacja `revisionable` wskazuje na `pages` lub `posts`, a treść jest zapisana w postaci JSON【199580663495322†L10-L19】. |
| **posts** | `id`, `title` (json), `slug` (json), `excerpt` (json), `content` (json), `featured_image` (json), `meta_title` (json), `meta_description` (json), `og_image` (json), `is_published` (bool), `published_at` (datetime), `created_at`, `updated_at` | Wpisy blogowe są tłumaczone i wersjonowane.  Publikacja sterowana przez pola `is_published` i `published_at`【302681491428206†L19-L27】. |
| **projects** | `id`, `title` (json), `slug` (string), `description` (json), `desktop_image` (string), `mobile_image` (string), `url` (string), `category` (string), `order` (integer), `created_at`, `updated_at` | Projekty/portfolio posiadają tłumaczone tytuły i opisy, ścieżki do obrazów, opcjonalny URL i kategorię.  Pole `order` określa kolejność wyświetlania【532262206668602†L12-L23】. |
| **media** | `id`, `path`, `mime`, `size`, `alt_text`, `created_at` | Pliki przesyłane do systemu.  Ścieżka w storage, typ MIME, rozmiar w bajtach i tekst alternatywny【310440221567370†L20-L36】. |
| **forms** | `id`, `name`, `content` (json), `settings` (json), `is_published` (bool), `created_at`, `updated_at` | Definicje formularzy tworzone przez administratora.  Zawartość pól i ustawienia formularza są zapisane jako JSON【197084225736030†L26-L56】. |
| **contact_messages** | `id`, `name`, `email`, `message`, `subject`, `ip_address`, `user_agent`, `is_read` (bool), `created_at` | Zgłoszenia z formularza kontaktowego.  Zawiera proste pola tekstowe oraz dane techniczne (IP, UA) i status odczytu【780838231871505†L8-L20】. |
| **languages** | `id`, `code`, `name`, `is_default` (bool), `is_active` (bool), `created_at`, `updated_at` | Lista dostępnych języków.  Tylko jeden język może być domyślny w danym momencie【384882840001921†L20-L47】. |
| **translations** | `id`, `group`, `key`, `text` (json), `created_at`, `updated_at` | Tabela dla tłumaczeń interfejsu.  Pole `text` przechowuje tłumaczenia w różnych językach【78226462258872†L20-L39】. |
| **menus** | `id`, `name`, `items` (json), `created_at`, `updated_at` | Definicje struktur nawigacyjnych.  Pole `items` jest tablicą obiektów zawierających etykietę, link i parametry【650687144038052†L29-L52】. |
| **templates** | `id`, `name`, `type` (`header` lub `footer`), `content` (json), `is_active` (bool), `is_default` (bool), `created_at`, `updated_at` | Szablony nagłówków i stopek.  Mogą być oznaczone jako aktywne lub domyślne【554272131220493†L27-L58】. |
| **settings** | `id`, `key`, `value` (json), `created_at`, `updated_at` | Klucz‑wartość dla ustawień globalnych (np. identyfikator strony domowej, klucze integracji).  Wartość jest zapisana jako JSON【931956191704161†L6-L12】. |
| **users** | `id`, `name`, `email`, `password`, `created_at`, `updated_at` | Prosta tabela użytkowników do uwierzytelniania w panelu administracyjnym【86099599642477†L19-L33】.  Hasła są przechowywane w postaci haszowanej【86099599642477†L40-L46】. |

## Relacje między modelami

- **Pages/Post ↔ Revisions:** relacja polimorficzna `morphMany` – każda strona i każdy wpis może mieć wiele rewizji.  Tworzenie nowej rewizji następuje przy aktualizacji i zapisuje kopię starej treści wraz z identyfikatorem użytkownika【820323160797495†L65-L83】.
- **Pages/Post ↔ Templates:** pola `header_override_id` i `footer_override_id` w modelu `Page` oraz podobne w `Post` (widoczne w kontrolerze) pozwalają na przypisanie niestandardowych nagłówków/stopek; w przeciwnym razie używana jest szablon domyślny【2643092693358†L28-L38】.
- **Menus ↔ Pages:** podczas tworzenia lub edytowania menu możliwe jest wybieranie stron jako elementów menu; definicja jest przechowywana w polu JSON【650687144038052†L22-L44】.
- **Forms ↔ Menus:** formularz w panelu edycji może być powiązany z menu (np. dodać link w nawigacji) – kontroler przekazuje listę dostępnych menu do widoku edycji formularza【197084225736030†L18-L23】.
- **Translations, Languages:** tłumaczenia interfejsu (model `Translation`) są niezależne, ale `Language` określa, które kody językowe są dostępne.  Aplikacja ładuje właściwe wartości z pola `text` w zależności od aktualnego języka sesji【384882840001921†L20-L47】.

## Przechowywanie bloków treści

Zawartość stron, wpisów i szablonów jest przechowywana jako tablica bloków w polu `content`.  Każdy element zawiera co najmniej:

- `id` – unikalny identyfikator blokowy (np. UUID).
- `type` – nazwa typu bloku (np. `paragraph`, `image`, `section`, `postList`).
- `settings` – szczegółowe ustawienia bloku (np. wariant kolorystyczny, wyrównanie).
- `animation` – definicja animacji GSAP (preset, parametry, trigger).
- `timeline` – identyfikator sekwencji animacji, jeśli blok bierze udział w timeline.
- `children` – tablica z blokami potomnymi w przypadku bloków sekcji lub kontenerów.

Taka struktura umożliwia dodawanie nowych typów bloków bez modyfikacji schematu bazy danych i jest zgodna z wytycznymi dotyczącymi progresywnego ulepszania【923699511808356†L2-L11】.

---

## Rozszerzenie modelu: Scene Mode (propozycja)

Obecny model przechowuje stronę jako `pages.content` (tablica bloków). Aby wspierać sceny bez scrolla, są dwie ścieżki:

### Opcja A (najprostsza): wszystko w JSON w `pages.content`

- `pages.settings.page_mode = "scenes"`
- `pages.content` przechowuje tablicę scen:

```json
[
  {
    "id": "scene-1",
    "type": "scene",
    "settings": { "name": "Welcome" },
    "enter_timeline": { "id": "tl-enter-welcome", "steps": [] },
    "exit_timeline": { "id": "tl-exit-welcome", "steps": [] },
    "children": [ /* zwykłe bloki */ ]
  }
]
```

Plus osobna sekcja w `pages.settings` dla nawigacji:

```json
{
  "page_mode": "scenes",
  "scene_navigation": { "wheel": true, "keys": true, "url_sync": "path" }
}
```

Zalety: brak migracji i tabel. Wady: trudniej raportować, walidować i wersjonować granularnie.

### Opcja B (bardziej „CMS-owa”): tabele dla scen i timeline

Proponowane tabele:

- `page_scenes`:
  - `id`, `page_id`, `name`, `order`, `settings` (json), `enter_timeline` (json), `exit_timeline` (json)
- `scene_blocks` (opcjonalnie):
  - `id`, `scene_id`, `content` (json) – albo normalizacja bloków, albo przechowywanie JSON
- `global_layers`:
  - `id`, `page_id`, `content` (json), `order`

Zalety: lepsze zarządzanie, możliwość przyszłego UI „scene library”. Wady: więcej pracy.

> Rekomendacja: zacząć od opcji A (MVP), a dopiero potem rozważyć opcję B.
