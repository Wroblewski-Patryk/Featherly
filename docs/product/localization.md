# Localization

## Supported Languages
Languages are managed in the `languages` table with active/default flags.  
Locale middleware validates locale against active languages.

## Routing Strategy
- Admin/auth/public routes are locale-prefixed.
- Locale resolution order:
  1. route parameter
  2. first URL segment
  3. session
  4. `config('app.locale')`
- Middleware sets `URL::defaults(['locale' => ...])`.

## Translation Source of Truth
- Runtime UI strings are stored in `translations`.
- Seeder source of truth is file-based under `database/seeders/data/translations/`.
- Admin keys follow `admin.*` naming in code and are normalized during scan/import.

## Automation
- Scan command: `php artisan i18n:scan --scope=admin`
- Integrity test: `php artisan test tests/Feature/Admin/TranslationIntegrityTest.php`

## Fallback Rules
- Only active languages are accepted in switch flow.
- Missing key behavior must be handled through translation review before release.

## QA Checklist
- Verify language switch on admin and public routes.
- Verify translated menu labels and common actions.
- Verify newly added keys are present in seeder data and DB.
