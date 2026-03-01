# Zakres MVP – wersja zaktualizowana

Ten dokument podsumowuje minimalny zakres funkcjonalny (MVP) dla systemu CMS opartego na Laravel + Vue.  Uwzględnia on moduły, które zostały zrealizowane w repozytorium i opisane w tym projekcie.

## Panel administracyjny

Administracja jest aplikacją SPA opartą na Inertia.js.  Użytkownik posiadający uprawnienia administratora ma dostęp do następujących sekcji:

1. **Uwierzytelnianie:** logowanie/wylogowywanie użytkowników (AuthController)【128056137757408†L11-L41】.
2. **Strony:** lista i edycja stron z edytorem blokowym, obsługa rewizji (tworzenie wersji przy każdej aktualizacji)【272824724932212†L13-L88】.  Pola tytuł, slug i metadane są tłumaczone, a zawartość i ustawienia stron są przechowywane jako JSON【2643092693358†L19-L27】.
3. **Wpisy (Blog):** tworzenie, edycja, publikacja i usuwanie wpisów.  Wpisy posiadają tytuł, slug, treść, zajawkę, obraz wyróżniający, pola SEO oraz flagi publikacji/termin publikacji【302681491428206†L19-L27】, a historia zmian jest przechowywana w tabeli rewizji【820323160797495†L33-L83】.
4. **Projekty (Portfolio):** moduł do zarządzania projektami/realizacjami.  Projekt posiada tłumaczony tytuł i opis, slug, obrazy desktop/mobile, link oraz kategorię【532262206668602†L12-L21】.  Obsługiwane jest sortowanie według pola `order`【124322144455570†L28-L38】.
5. **Media:** lista plików, przesyłanie nowych (z walidacją rozszerzeń i rozmiaru do 10 MB) oraz usuwanie plików【310440221567370†L20-L48】.
6. **Formularze:** tworzenie formularzy z polami definiowanymi przez użytkownika, przechowywanie zawartości i ustawień jako JSON oraz możliwość publikacji/depublikacji【197084225736030†L26-L56】.
7. **Menu:** zarządzanie strukturą nawigacji – dodawanie, edycja i usuwanie menu z listą elementów przechowywaną jako JSON【650687144038052†L29-L52】.
8. **Szablony:** edycja szablonów nagłówka i stopki z możliwością ustawienia jako domyślnych, definiowanie nazw, typu (`header`/`footer`) oraz zawartości JSON【554272131220493†L27-L58】.  Szablony mogą być przypisane globalnie lub nadpisywane na poziomie konkretnej strony lub wpisu【2643092693358†L28-L38】.
9. **Ustawienia globalne:** klucz‑wartość przechowywane w tabeli `settings`, w której każde ustawienie posiada klucz i wartość JSON【931956191704161†L6-L12】.  Panel umożliwia aktualizację wielu ustawień na raz【632105239854753†L12-L33】.
10. **Języki:** dodawanie, edycja i usuwanie języków z polami `code`, `name`, `is_default`, `is_active`.  Przy oznaczeniu języka jako domyślny pozostałe są automatycznie odznaczane【384882840001921†L20-L47】.
11. **Tłumaczenia:** zarządzanie wpisami klucz‑wartość dla interfejsu użytkownika.  Każdy rekord posiada grupę, klucz oraz tłumaczenia w wielu językach zapisane w polu JSON【78226462258872†L20-L39】.
12. **Wiadomości z formularzy:** sekcja dla zgłoszeń z formularza kontaktowego.  Każda wiadomość zawiera imię, e‑mail, temat, treść oraz znaczniki IP/UA i status odczytu【780838231871505†L8-L20】.

## Edytor blokowy i animacje

Zarządzanie treścią opiera się na systemie bloków.  Administrator może dodawać, usuwać i sortować bloki w ramach strony lub wpisu.  Każdy blok przechowuje swój typ, ustawienia, animację (opisane w osobnym dokumencie) oraz ewentualne bloki potomne w polu `children`.  Dodatkowa zakładka w edytorze pozwala definiować sekwencje animacji GSAP z wyzwalaczami (onLoad, onEnter, onHover) i parametrami (preset, duration, delay, ease)【653274490132042†L0-L58】.

## Publiczny rendering stron

Publiczne strony renderowane są po stronie serwera.  Widoki wykorzystują Blade i Inertia (SSR), aby dostarczać pełny HTML z meta‑danymi, a następnie włączać JS jedynie do interaktywnych elementów.  Bloki są renderowane przez dedykowane komponenty, a szablony nagłówka i stopki są dołączane automatycznie.  Nawigacja jest generowana na podstawie menu zapisanych w bazie.  Formularze obsługują walidację zarówno po stronie klienta, jak i serwera, a wiadomości są zapisywane w tabeli `contact_messages`【931571771783566†L17-L29】.

## Spoza zakresem MVP

* Rozbudowany sklep internetowy czy system płatności.
* Wsparcie dla wielu klientów (multi‑tenant).
* Zaawansowana analityka i integracje marketing automation.
* Obsługa motywów zewnętrznych / marketplace bloków.

Zakres MVP skupia się na stworzeniu stabilnego fundamentu CMS z elastycznym systemem bloków, wielojęzycznością, modułem bloga i portfolio oraz panelem admina umożliwiającym łatwe zarządzanie treścią.

---

## Dodatek: „Scene Mode” (vNext / rozszerzenie fundamentu)

Obecny MVP opisuje klasyczny układ „strona = lista bloków”. Dla odtworzenia strony legacy i wsparcia bardziej „interaktywnych” stron, planujemy tryb dodatkowy:

### MVP-Scene (etap 1: działający runtime)

1. **Page Settings: `page_mode`** = `document` (domyślnie) lub `scenes`.
2. **Scene list** w edytorze: dodawanie/usuwanie/zmiana kolejności scen.
3. **Runtime navigation controller**:
   - obsługa wheel/arrow/hash(path),
   - lock przejść podczas aktywnego timeline,
   - enter/exit timeline per scena.
4. **Global layers (opcjonalnie w etapie 1)**: podstawowy support dla warstw niezależnych od scen.

### MVP-Scene (etap 2: warstwy + pseudo-3D podgląd)

5. Panel „Layers”: hierarchy, group, lock/hide, drag&drop.
6. Podstawowy `z-index` + `z-depth` (do podglądu głębi w edytorze).
7. Toggle „Depth View” (pseudo-3D) w kanwie edytora.

### MVP-Scene (etap 3: timeline editor)

8. Timeline scrubber per scena (play/pause, czas).
9. Presety animacji + możliwość mapowania kroków timeline do bloków.
10. Zapis timeline w JSON i kompilacja do GSAP w runtime.

> Zasada: najpierw dowozimy **Scene runtime** (przejścia), potem warstwy, na końcu timeline editor.
