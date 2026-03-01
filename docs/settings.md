# Ustawienia globalne

Moduł ustawień umożliwia przechowywanie dowolnych wartości konfiguracyjnych w bazie danych bez konieczności tworzenia nowych kolumn.  Ustawienia są przechowywane w tabeli `settings`, gdzie każda pozycja składa się z klucza (`key`) i wartości (`value`) zapisanej jako JSON【931956191704161†L6-L12】.

## Przykładowe klucze

Kilka przykładowych ustawień globalnych, które mogą być definiowane w aplikacji:

- `homepage_id` – identyfikator strony, która powinna być wyświetlana jako strona główna.
- `default_header_template_id` – ID szablonu nagłówka używanego w całym serwisie, jeśli strona nie nadpisuje nagłówka.
- `default_footer_template_id` – ID szablonu stopki【2643092693358†L28-L38】.
- `contact_recipient_email` – adres e‑mail, na który wysyłane są wiadomości z formularza kontaktowego.
- `analytics_code` – kod śledzenia Google Analytics lub innego narzędzia analitycznego.
- `social_links` – tablica linków do profili społecznościowych (Facebook, LinkedIn itp.).

Ograniczeń co do nazw kluczy nie ma – można dodawać własne ustawienia według potrzeb projektu.  Panel admina umożliwia edycję wielu wartości naraz; podczas zapisu klucze, które nie istnieją, są tworzone, a istniejące są aktualizowane【632105239854753†L26-L33】.

## Dostęp do ustawień

W aplikacji Laravel można uzyskać dostęp do ustawień poprzez prosty helper (np. `setting('homepage_id')`), który odczyta wartość z bazy i opcjonalnie ją zcache’uje.  Przy aktualizacji ustawień warto wyczyścić cache, aby zmiany były od razu widoczne.

## Ustawienia a szablony

Szablony nagłówka i stopki są przechowywane w osobnej tabeli `templates`.  Ustawienia globalne definiują ID domyślnych szablonów, a jednocześnie każda strona i wpis mogą nadpisać te wartości poprzez pola `header_override_id` i `footer_override_id`【2643092693358†L28-L38】.  Logika aplikacji najpierw sprawdza, czy rekord posiada nadpisanie, potem sięga po wartości w ustawieniach, a na końcu wybiera pierwszy aktywny szablon oznaczony jako domyślny【2643092693358†L28-L38】.