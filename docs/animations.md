# GSAP Animations System (MVP)

## Cel
System musi obsługiwać animacje GSAP w sposób konfigurowalny:
- per blok (wejście do widoku / start na load)
- per strona i per szablon (master timeline)
- z użyciem presetów (żeby było szybkie i spójne)
- z możliwością spięcia bloków w timeline przez label/position

## Zasada główna (bardzo ważne)
Publiczne strony muszą być czytelne bez JS.
GSAP to progressive enhancement: treść widoczna, animacja tylko “upiększa”.

## Koncepcje
### 1) Presets (biblioteka animacji)
Presety to nazwy + mapowanie na GSAP vars.
Przykłady presetów:
- fadeUp
- fadeIn
- slideLeft
- slideRight
- scaleIn
- staggerChildrenFadeUp

Presety muszą być:
- wersjonowane (zmiana presetu nie psuje starych stron)
- rozszerzalne (łatwo dodać nowy preset)

### 2) Per-block entrance animation
Każdy block instance może mieć:
- enabled: boolean
- trigger: onLoad | onEnterViewport
- preset: string
- duration, delay, ease
- once: true/false (dla viewport)
- stagger (opcjonalnie)

### 3) Timelines: page + template
- Template timeline: dla layoutów typu Header/Hero “zawsze podobny”
- Page timeline: master timeline dla danej strony
Block może się “wpiąć” do timeline:
- timeline.parent: page | template
- timeline.label: string
- timeline.position: string (GSAP position: '+=0.2', '<', '>-0.1', 'label', itp.)

### 4) Triggery (MVP)
- onLoad: po renderze strony i gotowości runtime
- onEnterViewport: IntersectionObserver (MVP) lub ScrollTrigger (later)

### 5) Reduced motion
Respektuj prefers-reduced-motion:
- wyłącz lub mocno skróć animacje
- nie psuj layoutu

## Minimal schema per block instance (JSON)
animation:
- enabled: boolean
- trigger: 'onLoad'|'onEnterViewport'
- preset: string
- duration: number
- delay: number
- ease: string
- once: boolean
- stagger:
  - enabled: boolean
  - each: number
  - from: 'start'|'center'|'end'|'random'

timeline:
- enabled: boolean
- parent: 'page'|'template'
- label: string
- position: string

## Runtime: odpowiedzialności
- “GSAP Runtime” inicjalizuje animacje po renderze publicznej strony.
- Runtime skanuje DOM i czyta config bloków przez:
  - data-attributes, lub
  - JSON w embed script, lub
  - mapę configu przekazaną z backendu
- Runtime musi wspierać:
  - public render SSR (preferowane)
  - admin preview (builder preview)

## Admin preview
- Preview powinien uruchamiać runtime w “sandbox mode”
- Musi czyścić animacje przy re-renderze (kill tweens/timelines)
- Nie może powodować memory leaków przy częstych zmianach w builderze