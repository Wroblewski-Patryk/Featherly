# Warstwy i podgląd głębi (pseudo-3D) – spec

## Cel
Ułatwić budowę stron z nakładającymi się elementami (z-index) i globalnymi warstwami, z możliwością „zobaczenia” układu w głąb.

## Funkcje panelu Layers
- drzewo elementów (scene → groups → blocks),
- drag&drop kolejności (wpływa na z-index / render order),
- hide/lock,
- grupowanie (foldery),
- szybkie filtry (tylko absolute/fixed, tylko global layers).

## Z-depth
- `z_depth` jest liczbą (np. -500..500).
- W trybie Depth View kanwa dostaje `perspective`, a każdy blok `translateZ(z_depth)`.

## Tryb Depth View (toggle)
- działa tylko w edytorze,
- nie musi renderować „realnego” 3D na froncie,
- ma pomagać w debugowaniu i ustawianiu warstw.
