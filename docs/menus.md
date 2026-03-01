# System menu

System menu umożliwia tworzenie struktur nawigacyjnych dla witryny.  Każde menu ma nazwę oraz tablicę elementów przechowywaną jako JSON, co zapewnia elastyczność i brak konieczności modyfikacji schematu bazy danych przy zmianie struktury.

## Model danych

Tabela `menus` zawiera pola:

- `name` – nazwa menu, widoczna w panelu administracyjnym【650687144038052†L29-L52】.
- `items` – tablica elementów menu.  Każdy element może zawierać co najmniej: `label` (tekst w różnych językach), `href` (link do strony, wpisu lub adres zewnętrzny), `target` (np. `_blank`), `children` (zagnieżdżone elementy).  Struktura jest rekursywna i zapisywana jako JSON【650687144038052†L29-L52】.
- `created_at`, `updated_at`.

## Operacje w panelu admina

- **Lista menu:** wyświetla wszystkie zdefiniowane menu【650687144038052†L11-L15】.
- **Tworzenie menu:** administrator wprowadza nazwę menu i dodaje elementy poprzez interfejs drag‑and‑drop; do elementów można przypisać strony, linki zewnętrzne lub definicje niestandardowe【650687144038052†L18-L33】.
- **Edycja menu:** umożliwia zmianę nazwy oraz struktury elementów; treść pola `items` jest zapisywana w bazie w formie JSON【650687144038052†L47-L55】.
- **Usuwanie menu:** usuwa definicję menu wraz z elementami【650687144038052†L60-L64】.

## Wyświetlanie menu na stronie

Na froncie menu renderuje się jako lista nawigacyjna.  Domyślnie system generuje menu na podstawie domyślnych szablonów nagłówka i stopki, ale w blokach treści można również umieścić własne menu (np. jako blok `navigation`).  Elementy mogą posiadać zagnieżdżenia dowolnej głębokości, co pozwala tworzyć rozwijalne sub‑menu.  Linki do stron wykorzystują slug w aktualnym języku.