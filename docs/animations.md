# System animacji (GSAP) – wersja zaktualizowana

Animacje są traktowane jako **progresywne ulepszenie** treści – strona musi pozostać w pełni funkcjonalna bez JS.  System wykorzystuje bibliotekę **GSAP** do definiowania wejść/wyjść bloków i sekwencji animacji.  Definicje animacji są przechowywane w polu `animation` każdego bloku oraz opcjonalnie w tablicy timeline na poziomie strony lub wpisu.

## Panel animacji w edytorze

W edytorze bloków dostępny jest osobny panel „Animations”, gdzie można:

- Ustawić **trigger** animacji: `onLoad` (zaraz po załadowaniu strony), `onEnter` (gdy blok pojawi się w widoku), `onHover`, `onScroll`【653274490132042†L0-L58】.
- Wybrać **preset animacji** z biblioteki (`fadeIn`, `slideLeft`, `zoomIn`, `flipX` itp.)【653274490132042†L0-L58】.
- Skonfigurować parametry: `duration`, `delay`, `ease`, a także opcjonalnie `stagger` dla kolekcji elementów【653274490132042†L0-L58】.
- Przypisać blok do **timeline**, czyli sekwencji, w której animacje są odtwarzane jedna po drugiej; timeline identyfikowany jest stringiem.

Panel umożliwia podgląd wybranej animacji oraz zapisywanie ustawień w strukturze JSON bloku.

## Preset library

Biblioteka presetów powinna zawierać najczęściej używane animacje: `fadeIn`, `fadeInUp`, `slideLeft`, `slideRight`, `zoomIn`, `zoomOut`, `scaleIn`, `flipX`, `rotateY`.  Dodatkowe presety można definiować w pliku konfiguracyjnym i udostępniać w panelu.

## Timeline i sekwencje

Jeżeli w panelu zdefiniujemy timeline, każde powiązane z nim `animation` zostanie dodane do sekwencji z zachowaniem określonego `order`.  Sekwencje można wykorzystywać do tworzenia złożonych animacji, np. animowanego wejścia wszystkich sekcji strony w zdefiniowanej kolejności.  Sekwencje są wykonywane dopiero po załadowaniu biblioteki GSAP.

## Warstwa runtime

Runtime odpowiada za odczyt konfiguracji animacji z JSON‑a i wygenerowanie kodu GSAP.  Powinien on być zgodny z założeniami progressive enhancement:

1. Jeżeli przeglądarka nie obsługuje JS lub użytkownik ustawił `prefers-reduced-motion`, animacje nie powinny się wykonywać【653274490132042†L0-L58】.
2. Animacje powinny startować dopiero, gdy elementy są w widoku (lazy loading) i po załadowaniu biblioteki.
3. Dla sekwencji timeline należy stosować globalny kontroler, który synchronizuje odtwarzanie poszczególnych animacji.

## Dostępność

Ważne jest, aby animacje nie utrudniały dostępu do treści.  Należy zadbać o:

- Dodanie atrybutów ARIA w przypadku ruchomych elementów (np. informowanie screenreaderów o wprowadzeniu nowych treści).
- Umożliwienie zatrzymania animacji poprzez ustawienie `prefers-reduced-motion` i unikanie nadmiernych efektów paralaksy czy ruchu.

System animacji jest modułowy: każdy blok definiuje własne ustawienia, a przed rozpoczęciem animacji sprawdzane są globalne preferencje użytkownika.  Dzięki temu interaktywne efekty pozostają dodatkiem, a treść pozostaje czytelna w każdych warunkach【923699511808356†L2-L11】.

---

## Scene transitions: enter/exit timeline + kontroler przejść

Dla stron „scene-based” animacje nie są tylko dodatkiem do bloków, ale sterują samą nawigacją.

### Model

- **Scene** ma:
  - `enterTimeline` – uruchamiany po wejściu w scenę,
  - `exitTimeline` – uruchamiany przed opuszczeniem sceny,
  - opcja `exitMode: reverseEnter | separate`.

- **Transition Controller**:
  - posiada stan `isTransitioning`,
  - ignoruje kolejne zdarzenia wejścia (wheel/keys/url), gdy `isTransitioning=true`,
  - odpala `exitTimeline` sceny A → przełącza scenę → odpala `enterTimeline` sceny B.

### Źródła nawigacji

- wheel (delta -> next/prev),
- arrow keys,
- URL hash/path (deep-link do sceny),
- (opcjonalnie) kliknięcia w menu.

### Preferencje dostępności

- `prefers-reduced-motion` powinno przełączać tryb na:
  - brak animacji, natychmiastowe przejście,
  - lub minimalne crossfade.

---

## Timeline editor (panel)

Docelowo edytor powinien umożliwiać:

- Play/Pause/Restart dla sceny,
- scrubber czasu,
- „tracks” przypisane do bloków (lub do grup),
- presety (fade, slide, stagger),
- zapis timeline jako JSON i kompilację do GSAP.

Szczegółowy format JSON opisuje plik `docs/timeline-format.md`.
