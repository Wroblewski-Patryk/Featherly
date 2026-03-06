---
name: add_theme_property
description: Dodaje nową właściwość (np. kolor, font, border-radius) do panelu konfiguracyjnego motywu widocznego w całej aplikacji.
---

# Procedura: Tworzenie nowego ustawienia motywu

Skill służy do wpinania nowych ustawień CSS/Theme dla użytkownika końcowego. Pozwala to na spójne kolorowanie/stylowanie witryny we Vue + Tailwind CSS za pomocą panelu admina.

## Krok 1: Określenie miejsca zmiennej UI
1. Upewnij się, dotyczy jakiej kategorii to ustawienie (np. Kolory, Typografia, Układ).
2. Edytuj odpowiedni plik wewnątrz `resources/js/Components/ThemeConfigurator/` (np. dodaj nowy `ColorInput.vue` lub `UnitInput.vue`).

## Krok 2: Powiązanie ze Store / Stanem
1. Odnajdź logikę Pinii lub obiekty reaktywne trzymające `global_settings` (najprawdopodobniej w bazie globalnych ustawień witryny przesyłanych poprzez `Inertia::share` z backendu, albo lokalnie w Vue).
2. Dopisz nowe pole do struktury JSON, która ostatecznie poleci do API/Backendu i zostanie zapisana.

## Krok 3: Wygenerowanie CSS
1. Otwórz plik generujący zmienne CSS dla całej witryny, na przykład `ThemeStyleProvider.vue`.
2. Dodaj regułę mapującą dodaną wcześniej wartość stanu na globalną zmienną CSS zgodną z Tailwind v4 lub standardowym `var(--nazwa-zmiennej)`. Przykład: `document.documentElement.style.setProperty('--my-new-color', newColor.value)`.

## Krok 4: Weryfikacja i zapis
1. Upewnij się, że ustawione wartości działają w podglądzie "na żywo".
2. Poproś użytkownika o akceptację i opcjonalnie zrób commit "Add [nazwa funkcji] to Theme Configurator".
