---
name: create_builder_block
description: Tworzy nowy blok do wizualnego edytora Block Builder, w tym komponent Vue, rejestrację i ikonę.
---

# Procedura: Tworzenie nowego bloku do Block Buildera

Ten skill służy do ustandaryzowanego dodawania nowych "klocków" do wizualnego edytora stron. Zawsze wykonuj poniższe kroki w podanej kolejności.

## Krok 1: Wybór ikony
1. Znajdź odpowiednią ikonę reprezentującą nowy blok. 
2. Używaj biblioteki `@phosphor-icons/vue` lub FontAwesome (klasy `.fas`).

## Krok 2: Rejestracja bloku w `useBlockBuilderStore.js`
1. Otwórz plik z logiką Pinii zarządzającą schematami bloków: `resources/js/Stores/useBlockBuilderStore.js` (użyj `grep_search` aby upewnić się gdzie jest trzymany słownik bloków).
2. Dodaj nową definicję bloku do tablicy/słownika. Wymagane właściwości zazwyczaj obejmują:
   - `id`: Unikalny identyfikator (np. `uuid` lub generowany dynamicznie).
   - `type`: Nazwa systemowa bloku (np. `testimonial`, `gallery`).
   - `label`: Czytelna nazwa dla użytkownika.
   - `icon`: Klasa ikony (np. `fas fa-star`).
   - `content`: Domyślny JSON zawartości.
   - `settings`: Domyślny JSON z marginesami, paddingiem itp.

## Krok 3: Stworzenie komponentu Vue
1. Utwórz plik `resources/js/Components/Blocks/[BlockName].vue` (np. `TestimonialBlock.vue`).
2. Struktura komponentu musi wykorzystywać `<script setup>`.
3. Komponent musi przyjmować właściwość `block` (Object) jako prop, który będzie zawierał dane JSON przekazane z BlockBuildera.
4. Używaj Tailwind CSS v4 i klas DaisyUI do ostylowania domyślnego wyglądu bloku.

## Krok 4: Zarejestrowanie komponentu w `DynamicBlock.vue`
1. Otwórz `resources/js/Components/DynamicBlock.vue`.
2. Dodaj import nowo utworzonego komponentu.
3. Wykorzystaj `<component :is="...">` lub mapowanie w `<script setup>`, aby edytor wiedział, w jaki sposób zrenderować nowy `type` bloku.

## Krok 5: Weryfikacja
1. Odśwież środowisko Vue (`npm run dev` powinno to wychwycić).
2. Poinformuj użytkownika o możliwości przetestowania dodanego bloku w przeglądarce.
