# Project: Laravel + Vue CMS + Block Builder + GSAP

## Stan obecny
- Strona działa jako HTML + JS + formularz w PHP.
- Treści są w kodzie, brak CMS, brak edytora.
- Strona jest niestandardowa i opiera się o animacje (GSAP), więc “zwykły CMS” odpada.

## Cel
Zbudować system w Laravel + Vue, który pozwoli:
- zarządzać stronami bez edycji kodu
- budować strony z bloków (jak Gutenberg/Elementor w podstawowym zakresie)
- konfigurować animacje GSAP per blok/element oraz poprzez timeliny na poziomie strony i szablonu
- publikować treści (draft → published)
- mieć szybkie i SEO-friendly publiczne strony

## Kryteria sukcesu (MVP)
- Da się odtworzyć kluczowe strony obecnej witryny za pomocą bloków i ustawień.
- Edycja treści i animacji jest szybka i stabilna.
- Publiczne strony są renderowane SEO-friendly (bez wymogu JS do samej treści).
- Formularz kontaktowy działa + jest zabezpieczony.
- Media (obrazy) + alt text.

## Non-goals (MVP)
- Pełny klon Elementora (zaawansowane animacje, builder-canvas jak Figma, mega efekty).
- Multi-tenant SaaS.
- Marketplace bloków.

## Tech
- Backend: Laravel (monolit)
- Admin UI: Vue (panel + builder)
- Public: render server-side (preferowane) + GSAP jako progressive enhancement

## Twarde ograniczenia
- Projekt jest dla 1 osoby → prostota > perfekcja.
- Animacje muszą być częścią systemu (preset + timeline), a nie “dodatek”.