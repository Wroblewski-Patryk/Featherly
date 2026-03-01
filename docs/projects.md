# Moduł portfolio/projektów

Moduł **Projects** pozwala prezentować portfolio realizacji.  Projekty są prostszą strukturą niż wpisy blogowe: nie przechowują bloków treści, lecz zawierają zestaw pól opisowych oraz obrazy.  Wszystkie pola oprócz slug są tłumaczone za pomocą Spatie Translatable.

## Struktura danych

W tabeli `projects` znajdują się następujące kolumny:

- `title` – tablica tłumaczeń nazwy projektu【532262206668602†L12-L23】.
- `slug` – unikalny identyfikator w adresie URL; generowany automatycznie z tytułu w domyślnym języku, jeżeli nie podano【124322144455570†L28-L42】.
- `description` – tablica tłumaczeń opisu projektu【532262206668602†L12-L23】.
- `desktop_image` – ścieżka do grafiki w wysokiej rozdzielczości【532262206668602†L16-L17】.
- `mobile_image` – ścieżka do grafiki zoptymalizowanej dla urządzeń mobilnych【532262206668602†L17-L18】.
- `url` – zewnętrzny link do projektu (np. strona klienta)【532262206668602†L18-L19】.
- `category` – krótka etykieta kategorii projektu (np. „web”, „print”)【532262206668602†L19-L20】.
- `order` – liczba określająca kolejność wyświetlania; im mniejsza wartość, tym projekt pojawia się wcześniej【532262206668602†L20-L21】.
- `created_at`, `updated_at` – daty utworzenia i aktualizacji rekordu.

## Operacje w panelu admina

Panel administracyjny modułu projektów obsługuje następujące czynności:

1. **Wyświetlanie listy projektów** w kolejności określonej przez pole `order`【124322144455570†L14-L16】.
2. **Dodawanie projektu:** formularz pozwala na wprowadzenie tłumaczeń tytułu i opisu, obrazów, linku, kategorii i kolejności.  Jeśli nie podano slugu, generowany jest automatycznie ze stringa tytułu w języku polskim【124322144455570†L28-L43】.
3. **Edycja projektu:** umożliwia aktualizację pól; slug musi pozostać unikalny【124322144455570†L56-L67】.
4. **Usuwanie projektu:** usuwa rekord z bazy danych【124322144455570†L75-L78】.

## Widoki publiczne

Na stronie publicznej projekty mogą być wyświetlane w sekcji portfolio.  Najczęstszy układ to siatka miniatur; po kliknięciu na projekt użytkownik może zostać przekierowany na stronę szczegółową (jeżeli zostanie zaimplementowana) lub bezpośrednio na zewnętrzny URL.

## Rozszerzenia

W przyszłości można dodać możliwość:

- Definiowania wielu kategorii i filtrowania projektów na froncie.
- Przypisywania bloków treści do projektu w podobny sposób jak do strony/wpisu.
- Dodawania galerii obrazów (tablica ścieżek) zamiast pojedynczych pól `desktop_image` i `mobile_image`.