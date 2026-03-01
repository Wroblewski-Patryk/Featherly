# GSAP Animations System (The Magic Sauce) 🎬

Our CMS stands out by treating animations not as individual block features, but as a universal "Magic Sauce" (Meta-Block property) available to every element in the system.

## Core Philosophy: Progressive Enhancement
- **Content First**: Public pages must be fully readable without JavaScript.
- **GSAP as Polish**: Animations only "beautify" the experience and should not break the layout if they fail to load.
- **Performance**: Use efficient triggers and clean up timelines during re-renders.

## 1. The Unified Animation Settings Panel
Each block instance in the CMS (whether it's a Heading, Image, or Column) inherits these core settings:

### Triggers & Events
- **onEnter (Entrance)**: The initial animation when a block enters the screen.
- **onScroll**: Scroll-based interactions (ScrollTrigger).
- **onLoad**: Immediate execution on page ready.
- **onHover**: Interactive states for user engagement.

### Core Parameters
- **Preset**: Select from a curated library of professional GSAP transitions.
- **Duration**: Speed of the animation (e.g., 0.6s).
- **Delay**: Staggering or timing offsets (e.g., 0.2s).
- **Ease**: Natural movement curves (e.g., `power2.out`, `expo.inOut`).
- **Scope**: Choose whether the animation applies to the `Element` itself, its `Inner Group`, or the entire `Section`.

### Sequential Storytelling (Timeline ID)
- Blocks can be assigned a **Timeline ID**.
- Elements with the same ID can be sequenced into a single, complex GSAP Timeline, allowing for cinematic page reveals.

## 2. Animation Preset Library
Curated, high-end presets that ensure visual consistency:
- **fadeUp / fadeIn**: Subtle entrance from bottom or zero opacity.
- **slideLeft / slideRight**: Directional movement.
- **scaleIn**: Pop-in effect with natural elastic easing.
- **clipReveal**: Sophisticated clip-path reveals (Horizontal, Vertical, Diagonal).
- **staggerChildren**: Automatically applies a delay sequence to child elements (e.g., list items or gallery images).

## 3. Runtime Responsibilities
The "GSAP Runtime" is the engine that executes these plans on the frontend:
- **Scan & Initialize**: Scans the DOM for block configurations (passed via data-attributes or JSON).
- **Intersection Observer**: Handles `onEnter` triggers efficiently.
- **Admin Sandbox**: In the Page Builder, the runtime must:
  - Provide real-time previews.
  - Safely "kill" and restart tweens during editing to prevent memory leaks and ghost animations.

## 4. Accessibility (Reduced Motion)
- Always respect the `prefers-reduced-motion` media query.
- When enabled, animations should be simplified to basic fades or disabled entirely to ensure user comfort.