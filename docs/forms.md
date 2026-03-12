# Modul formularzy (stan kodu)

## Co dziala

- CRUD formularzy w panelu admin (`/{locale}/admin/forms`).
- Edycja formularza przez Block Builder (JSON w `content`).
- Ustawienia formularza w `settings`.
- Preview publiczne: `/{locale}/forms/{id}/preview`.

## Schema

Tabela `forms`:

- `status`
- `title`
- `content` (json)
- `settings` (json)
- `published_at`, `archived_at`

## Co jest w toku

- Brak uniwersalnego endpointu submit runtime dla formularzy tworzonych w module `forms`.
- `ContactController` i `contact_messages` istnieja, ale to osobny tor, nie finalny runtime calego buildera formularzy.