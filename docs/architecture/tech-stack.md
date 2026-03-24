# Tech Stack

## Languages and Frameworks
- PHP 8.2+
- Laravel 12
- Vue 3 (Composition API)
- Inertia.js
- Pinia

## Runtime and Hosting
- Web runtime served by Laravel.
- Admin SPA behavior delivered through Inertia/Vite.
- Local development commonly uses `composer run dev`.

## Data and Messaging
- Relational DB for application data.
- JSON fields for translatable and block-based content.
- Filesystem storage for media under `storage/app/public/media`.

## Tooling
- Vite for frontend build/dev.
- Tailwind CSS + DaisyUI for UI system.
- GSAP for animation runtime where enabled.
- `vuedraggable` for builder/editor interactions.

## Version Policy
- Follow locked dependency versions from `composer.lock` and `package-lock.json`.
- Update dependencies intentionally with changelog notes and smoke validation evidence.
