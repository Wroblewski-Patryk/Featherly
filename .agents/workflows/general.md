---
description: 🛠️ Instrukcje Specyficzne dla Projektu (Workspace Rules)
---

1. **Zarys Technologiczny (Stack)**: 
   - Backend zasilany jest przez **Laravel 12** z **PHP 8.2+**. 
   - Frontend obsługiwany jest przez **Vue.js 3** (wyłącznie Composition API `<script setup>`), **Inertia.js** oraz **Ziggy** (routing bez API).
2. **Customowy Panel Administracyjny**: 
   - Aplikacja posiada w 100% autorski panel administracyjny przypominający strukturą WordPressa. Brak zewnętrznych pakietów z ustrukturyzowanymi panelami (np. Filament).
3. **Kluczowy system - Custom Block Builder**: 
   - Aplikacja skupia się wokół zaawansowanego, wizualnego edytora bloków dla jednostek "Pages" i "Posts". 
   - Złożony stan narzędzia deweloperskiego (Block Builder) np. zaznaczone bloki, ustawienia, struktury z-indexów, jest rygorystycznie zarządzany przez store w **Pinii** (`useBlockBuilderStore`), aby uniknąć anti-patternu props-drilling'u. 
   - Zbudowane struktury lądują w bazie danych w wielowarstwowym polu z formatem JSON.
4. **Stylowanie i Motywy (Themes)**:
   - System opiera się o klasy narzędziowe (utility-first) frameworka **Tailwind CSS v4** oraz gotowe klasy i komponenty biblioteki **DaisyUI** (np. `.btn`, `.collapse`, `.input-bordered`).
   - Panel admina obsługuje oraz udostępnia do dynamicznej zmiany różne motywy wbudowane w DaisyUI (np. `cyberpunk`, `light`, `dark` i inne).
   - Użytkownik i administrator mogą skonfigurować swoje spersonalizowane ustawienia "theme + daisyui theme", co owocuje w generowanie jednorodnego motywu wizualnego zaaplikowanego i używanego od razu na docelowej witrynie renderowanej z bloków dla końcowych klientów.
5. **UI/UX, Projektowanie interfejsów i Interakcje**: 
   - Do pomocy przy projektowaniu i zarządzaniu ekranami/widokami używaj **Stitch przez złącze MCP** (`StitchMCP`).
   - Projekt jest bogaty i nastawiony na świetne doznania wizualne (UI/UX). Przy nowych funkcjonalnościach zawsze dbamy o precyzyjne interakcje.
   - Do przeciągania elementów (drag&drop) zaimplementowana jest biblioteka **`vuedraggable`**, a za potężne efekty i animacje odpowiada środowisko **GSAP**. Dodatkowo aplikacja zaciąga paczkę ikon z `@phosphor-icons/vue` oraz klasycznych FontAwesome.
6. **Styl architektoniczny**: 
   - Architektura SSR z Inertia.js – zapytania AJAX/API ogranicz do absolutnego minimum. Dane powinny być wstrzykiwane bezpośrednio przez propsy kontrolerów z backendu Laravel.
   - Czysty podział: komponenty Vue trzymamy logicznie oddzielone od układów kontrolerów Laravel. Specyficzne komponenty grupujemy w odpowiednich podfolderach (np. `Admin`, `ThemeConfigurator`).
