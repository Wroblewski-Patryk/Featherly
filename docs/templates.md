# Szablony (Templates)

Szablony w tym projekcie służą do zarządzania nagłówkami i stopkami witryny.  Mogą być przypisane globalnie dla wszystkich stron/wpisów lub nadpisane na poziomie konkretnej strony czy wpisu.  Treść szablonu jest przechowywana jako tablica bloków w kolumnie `content`, dzięki czemu można użyć tych samych bloków co w edytorze stron.

## Struktura danych

Tabela `templates` zawiera pola:

- `name` – nazwa szablonu【554272131220493†L27-L58】.
- `type` – rodzaj szablonu: `header` lub `footer`【554272131220493†L31-L35】.
- `content` – tablica bloków tworzących układ nagłówka/stopy【554272131220493†L27-L58】.
- `is_active` – flaga określająca, czy szablon jest aktywny i może być wybrany w ustawieniach【554272131220493†L31-L34】.
- `is_default` – flaga oznaczająca, że szablon jest domyślny dla danego typu (header/footer)【554272131220493†L31-L35】.
- `created_at`, `updated_at`.

## Operacje w panelu admina

1. **Lista szablonów:** stronicowana lista wszystkich szablonów z możliwością filtrowania według typu【554272131220493†L11-L16】.
2. **Dodawanie szablonu:** administrator definiuje nazwę, typ, zawartość (w postaci bloków), status aktywacji oraz informację, czy ma to być szablon domyślny【554272131220493†L27-L39】.  Warto zaznaczyć, że tylko jeden szablon może być domyślny dla danego typu; ustawienie nowego domyślnego automatycznie resetuje poprzedni.
3. **Edycja szablonu:** umożliwia zmianę nazwy, typu, treści oraz flag aktywacji i domyślności【554272131220493†L50-L60】.
4. **Usuwanie szablonu:** usuwa rekord z bazy danych【554272131220493†L65-L68】.

## Użycie szablonów

Domyślne szablony są określane przez pola `default_header_template_id` i `default_footer_template_id` w ustawieniach globalnych【2643092693358†L28-L38】.  Każda strona lub wpis może jednak nadpisać te wartości, ustawiając atrybuty `header_override_id` i `footer_override_id` na identyfikatory niestandardowych szablonów【2643092693358†L28-L38】.  Podczas renderowania system stosuje następującą kolejność:

1. Jeżeli rekord ma nadpisany nagłówek/stopkę, użyć wskazanego szablonu.
2. W przeciwnym razie, jeżeli w ustawieniach globalnych zdefiniowano domyślny szablon, użyć go.
3. W ostateczności wybrać pierwszy aktywny szablon danego typu oznaczony jako domyślny【2643092693358†L28-L38】.

Dzięki wykorzystaniu bloków do budowy szablonów administrator może tworzyć złożone układy nagłówków i stopek (np. logo, menu, CTA, sekcje społecznościowe) bez ingerencji w kod.