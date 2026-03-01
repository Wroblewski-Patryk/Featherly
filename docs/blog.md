# Moduł bloga

Moduł bloga umożliwia tworzenie, edycję i publikowanie artykułów.  Wykorzystuje on te same założenia projektowe co strony – wpisy są składane z bloków treści, posiadają tłumaczenia i obsługują rewizje.

## Struktura danych

Wpisy są reprezentowane przez model **Post**.  Kluczowe pola obejmują:

- `title` – tablica tłumaczona, nagłówek wpisu【302681491428206†L19-L27】.
- `slug` – tablica tłumaczona; generowane automatycznie z tytułu w języku domyślnym, jeżeli nie podano podczas tworzenia【124322144455570†L28-L42】.
- `excerpt` – krótkie streszczenie artykułu (tablica tłumaczona)【302681491428206†L19-L20】.
- `content` – tablica bloków budujących pełny artykuł【302681491428206†L19-L20】.
- `featured_image` – tablica tłumaczona z linkiem do obrazu wyróżniającego【302681491428206†L19-L20】.
- `meta_title`, `meta_description`, `og_image` – pola SEO tłumaczone【302681491428206†L19-L20】.
- `is_published` – flaga wskazująca na publikację wpisu【302681491428206†L24-L27】.
- `published_at` – data i czas publikacji; umożliwia planowanie publikacji na przyszłość【302681491428206†L24-L27】.

Model `Post` korzysta z traitu `HasTranslations`, co umożliwia łatwe pobieranie i aktualizowanie treści w aktualnym języku.  Dodatkowo każdy wpis ma relację polimorficzną z modelem `Revision` i może przechowywać historię zmian【820323160797495†L65-L83】.

## Operacje w panelu admina

Panel administracyjny udostępnia standardowy zestaw operacji:

1. **Lista wpisów:** stronicowana lista wszystkich artykułów, sortowana malejąco po dacie publikacji【820323160797495†L11-L17】.  Widok wyświetla podstawowe informacje (tytuł, status publikacji, data utworzenia).
2. **Tworzenie wpisu:** formularz zawiera pola tytułu, slug, zajawki, treści, obrazu oraz ustawienia publikacji.  Przy pierwszym zapisie tworzony jest nowy rekord w tabeli `posts`【820323160797495†L19-L50】.
3. **Edycja wpisu:** dostępne są wszystkie pola z formularza oraz panel rewizji pokazujący poprzednie wersje treści【820323160797495†L51-L63】.  Przed aktualizacją bieżąca wersja treści jest zapisywana do tabeli `revisions`【820323160797495†L65-L83】.
4. **Usuwanie wpisu:** możliwość trwałego usunięcia wpisu z bazy danych【820323160797495†L91-L97】.

## Widoki publiczne

System generuje dwie główne widoki publiczne:

- **Lista wpisów (blog index):** korzysta z bloku `postList`, który pobiera i renderuje listę opublikowanych wpisów, z obsługą stronicowania i filtrowania (np. po kategorii).  W MVP wystarczy wyświetlenie tytułu, daty publikacji, zajawki i linku „czytaj więcej”.
- **Strona artykułu:** wyświetla pojedynczy wpis, renderując poszczególne bloki treści w odpowiednim układzie.  Szablon strony może korzystać z globalnego nagłówka i stopki albo z nadpisanych szablonów przypisanych do wpisu przez administratora.

## Kategorie i tagi

W wersji bieżącej repozytorium nie zaimplementowano osobnej tabeli kategorii ani tagów.  W polu `category` można zapisać pojedynczą kategorię wpisu; w przyszłości można rozbudować system o wiele kategorii lub tagów.

## Wersjonowanie

Przed każdą aktualizacją wpisu bieżąca treść jest zapisywana w tabeli `revisions` razem z identyfikatorem użytkownika.  Pozwala to na przywrócenie poprzednich wersji artykułu i śledzenie historii edycji【820323160797495†L65-L83】.