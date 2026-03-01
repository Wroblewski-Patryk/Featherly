# Timeline format (JSON) – propozycja

Celem jest zapis timeline w JSON, który da się w runtime skompilować do GSAP.

## Minimalny format

```json
{
  "id": "tl-enter-welcome",
  "duration": 1.2,
  "steps": [
    {
      "at": 0.0,
      "target": "block:heading-1",
      "preset": "fadeInUp",
      "params": { "duration": 0.6, "ease": "power2.out" }
    },
    {
      "at": 0.2,
      "target": "block:cta-1",
      "preset": "fadeIn",
      "params": { "duration": 0.5 }
    }
  ]
}
```

### Pola
- `at` – czas startu kroku (sekundy).
- `target` – selektor logiczny, np. `block:<id>` albo `layer:<id>`.
- `preset` – nazwa presetu, mapowana na funkcję (GSAP).
- `params` – parametry presetu.

## Exit timeline
- `exitMode = "reverseEnter"`: runtime odpala `enter` w trybie reverse.
- `exitMode = "separate"`: osobny JSON dla `exitTimeline`.

## Kompilacja w runtime
1. Tworzysz `gsap.timeline({ paused: true })`.
2. Dla każdego `step` wyliczasz element DOM po `target`.
3. Aplikujesz preset i dodajesz do timeline na czasie `at`.
