# Wielojęzyczność i tłumaczenia

Aplikacja obsługuje wiele języków zarówno dla treści stron/wpisów, jak i interfejsu użytkownika.  W implementacji wykorzystano pakiet **Spatie Translatable**, który pozwala definiować pola typu `json` i automatycznie zwracać wartość w aktualnym języku.

## Języki

Informacje o dostępnych językach są przechowywane w tabeli `languages`.  Każdy rekord zawiera kod języka (np. `pl`, `en`), nazwę, oraz flagi `is_default` i `is_active`【384882840001921†L20-L47】.  W panelu admina można dodawać nowe języki i oznaczać jeden z nich jako domyślny.  Usunięcie języka domyślnego jest blokowane – przed usunięciem trzeba wybrać inny język jako domyślny【384882840001921†L20-L47】.

Użytkownik może przełączać języki na froncie dzięki kontrolerowi `LocaleController`, który zapisuje wybrany kod języka w sesji i aplikacji【574101382453779†L10-L18】.  Domyślny język jest używany, gdy w sesji nie ustawiono innego.

## Pola tłumaczone w modelach

Modele `Page`, `Post`, `Project` oraz `Translation` posiadają tablicę `$translatable`, która określa, które pola powinny być tłumaczone.  Spatie Translatable zapisuje wartości tych pól jako obiekt JSON z kluczami językowymi.  Podczas pobierania atrybutu np. `$page->title` automatycznie zwracana jest wartość w aktualnym języku.  Przykładowa struktura:

```json
{
  "pl": "Moja strona",
  "en": "My page"
}
```

W panelu edycji administrator wprowadza wartości w wybranych językach.  Wymagane jest podanie co najmniej pola w języku domyślnym (np. `pl`).  Jeżeli slug w danym języku jest pusty, można go automatycznie wygenerować na podstawie tytułu w języku domyślnym【124322144455570†L40-L43】.

## Tłumaczenia interfejsu

Interfejs użytkownika (etykiety przycisków, komunikaty itp.) korzysta z tabeli `translations`.  Rekord `Translation` zawiera `group`, `key` i pole `text` z tłumaczeniami【78226462258872†L20-L39】.  W kodzie można pobierać tłumaczenia poprzez helpery (np. `trans('auth.login')`), a aplikacja automatycznie zwróci odpowiednią wersję językową.  Panel `Translations` umożliwia tworzenie i edycję wpisów oraz import/eksport do plików JSON.

## Wersjonowanie treści

Wersjonowanie jest niezależne od tłumaczeń; każda zmiana zawartości strony lub wpisu zapisuje kopię w tabeli `revisions` z aktualnym stanem wszystkich języków.  Dzięki temu można odzyskać starsze wersje treści niezależnie od języka【820323160797495†L65-L83】.