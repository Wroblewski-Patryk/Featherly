# Moduł formularzy

Moduł formularzy umożliwia administratorowi definiowanie własnych formularzy kontaktowych czy zapisu na newsletter.  Dzięki elastycznej strukturze JSON można tworzyć pola różnego typu (tekst, e‑mail, textarea, checkbox itp.) oraz konfigurować walidację i zachowanie pól.

## Model danych

Tabela `forms` zawiera następujące kolumny:

- `name` – nazwa formularza (string)【197084225736030†L26-L33】.
- `content` – tablica bloków reprezentujących pola formularza oraz ich właściwości (label, typ, nazwa, wymagane, opcje itp.)【197084225736030†L26-L33】.
- `settings` – ogólne ustawienia formularza (np. wiadomość sukcesu, adres e‑mail powiadomień, reCAPTCHA) przechowywane jako JSON【197084225736030†L26-L33】.
- `is_published` – flaga aktywacji formularza【197084225736030†L32-L33】.
- Znaczniki `created_at` i `updated_at`.

Moduł formularzy jest przeznaczony do definiowania formularzy, natomiast zgłoszenia są zapisywane w osobnych tabelach w zależności od typu formularza.  Formularz kontaktowy korzysta z `contact_messages`【780838231871505†L8-L20】.

## Operacje administracyjne

W panelu admina dostępne są następujące akcje:

1. **Lista formularzy:** wyświetla wszystkie zdefiniowane formularze wraz z ich statusem i datami utworzenia【197084225736030†L11-L15】.
2. **Dodawanie formularza:** administrator wybiera nazwę, definiuje pola i ustawienia.  Pola są zapisywane w tablicy JSON w polu `content`【197084225736030†L26-L33】.
3. **Edycja formularza:** umożliwia modyfikowanie pól i ustawień oraz zmianę statusu publikacji【197084225736030†L49-L56】.
4. **Usuwanie formularza:** trwałe usunięcie rekordu wraz z przypisaną konfiguracją【197084225736030†L64-L68】.

## Integracja na froncie

Każdy formularz może być umieszczony w treści strony za pomocą dedykowanego bloku `form`.  Blok wczytuje konfigurację formularza z bazy i renderuje odpowiednie pola.  Po wysłaniu danych następuje walidacja po stronie serwera, zapis w odpowiedniej tabeli i wyświetlenie wiadomości sukcesu.  Formularze mogą implementować proste zabezpieczenia antyspamowe (honeypot) i ratelimit, a dodatkowa wtyczka reCAPTCHA może zostać dodana w przyszłości【931571771783566†L12-L21】.

## Przykład pola w JSON

Pola formularza mogą wyglądać następująco (przykład w polu `content`):

```json
[
  {
    "type": "text",
    "name": "fullname",
    "label": { "pl": "Imię i nazwisko", "en": "Full name" },
    "required": true,
    "placeholder": { "pl": "Wpisz swoje imię", "en": "Enter your name" }
  },
  {
    "type": "email",
    "name": "email",
    "label": { "pl": "Adres e-mail", "en": "Email address" },
    "required": true
  },
  {
    "type": "textarea",
    "name": "message",
    "label": { "pl": "Wiadomość", "en": "Message" },
    "required": true,
    "rows": 5
  }
]
```

Struktura ta może być rozszerzana o pola typu select, radio, checkbox czy zgodę RODO.  Dzięki wykorzystaniu JSON nie ma konieczności modyfikacji schematu bazy przy dodawaniu nowych typów pól.