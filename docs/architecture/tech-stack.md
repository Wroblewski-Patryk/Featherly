# Tech Stack

## Languages and Frameworks
- PHP 8.2+
- Laravel 12
- Vue 3 (Composition API)
- Inertia.js
- Pinia
- Spatie Laravel Permission for RBAC.
- Spatie Laravel Translatable for localized JSON fields.
- Tightenco Ziggy for frontend route generation.
- Sentry Laravel and Sentry Vue are optional error tracking integrations.

## Runtime and Hosting
- Web runtime served by Laravel.
- Admin SPA behavior delivered through Inertia/Vite.
- Local development commonly uses `composer run dev`.
- Laravel scheduler owns recurring publish, metrics, and health-check commands.
- Laravel health endpoint is exposed at `/up`.
- Production update application may be delegated to Coolify, Docker, Git,
  archive-based release replacement, or manual operator workflows according to
  `docs/architecture/system-update-manager-contract.md`.

## Data and Messaging
- Relational DB for application data.
- JSON fields for translatable and block-based content.
- Filesystem storage for media under `storage/app/public/media`.

## Tooling
- Vite for frontend build/dev.
- Tailwind CSS + DaisyUI for UI system.
- GSAP for animation runtime where enabled.
- `vuedraggable` for builder/editor interactions.
- Phosphor Icons and Font Awesome Free are available for admin/builder icon
  surfaces.
- Vue color picker supports theme configuration UI.
- PHPStan/Larastan, Deptrac, PHPUnit, ESLint, Prettier, and Laravel Pint are
  the main verification and guardrail tools.

## Verification Commands
- Backend tests: `php artisan test`
- Static analysis: `composer analyse`
- Architecture dependency checks: `composer deptrac`
- Frontend lint: `npm run lint`
- Frontend format check: `npm run format:check`
- Production frontend build: `npm run build`
- Admin i18n scan: `php artisan i18n:scan --scope=admin`

## Version Policy
- Follow locked dependency versions from `composer.lock` and `package-lock.json`.
- Update dependencies intentionally with changelog notes and smoke validation evidence.
- Runtime application updates must target trusted releases or release
  manifests, not arbitrary moving branches.
