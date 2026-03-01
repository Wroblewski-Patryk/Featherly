# Legacy migration – mapowanie starej strony na Fetherly

Ten dokument opisuje jak przenieść wzorce ze starego projektu (statyczny HTML+JS) do nowego CMS.

## Co w legacy jest kluczowe

1. **Sekcje jako sceny**  
   Sekcje są identyfikowane po ID (`#welcome`, `#about` itd.) i zajmują pełny viewport.

2. **Nawigacja bez scrolla**  
   Wejście/wyjście ze scen odbywa się poprzez:
   - wheel (next/prev),
   - arrow keys,
   - URL (hash/path) jako źródło prawdy.

3. **Timeline per scena**  
   Każda sekcja ma animację wejścia i wyjścia. Wyjście jest osobnym timeline albo reverse.

4. **Transition lock**  
   W trakcie animacji nie wolno przyjąć kolejnego przejścia. W legacy zwykle rozwiązuje to:
   - `timeline.isActive()` albo globalna flaga.

5. **Warstwy globalne**  
   Tło/ramka/tytuły często żyją ponad sekcjami i mają własne animacje.

## Mapowanie na nowy runtime (Vue + GSAP)

### A) SceneRegistry
- Weź `Page.content` i zbuduj listę scen.
- Mapuj `scene.id` ↔ route (hash/path).
- Utrzymuj `activeSceneIndex`.

### B) TransitionController
Minimalny interfejs:

- `goTo(index | id)`
- `next()`, `prev()`
- `isTransitioning`
- `source` (wheel/keys/url/menu)

Kroki:
1. Jeśli `isTransitioning` → ignore.
2. Odtwórz `exitTimeline` sceny A.
3. Przełącz scenę (mount/unmount lub show/hide).
4. Odtwórz `enterTimeline` sceny B.
5. Zdejmij lock.

### C) URL sync
- `url_sync: "hash"` lub `"path"`.
- Zmiana URL ma wywoływać `goTo(scene)`, ale bez pętli (guard źródła).

## Checklist implementacyjny
- [ ] `page_mode=scenes` w settings strony
- [ ] Scene list w editorze
- [ ] Wheel/keys handler w runtime
- [ ] Transition lock + enter/exit
- [ ] URL sync + deep-linking
