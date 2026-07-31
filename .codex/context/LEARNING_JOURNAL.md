# Learning Journal

Use this file to capture verified recurring pitfalls and execution guardrails.

## Entry Template

- Date:
- Context:
- Symptom:
- Root cause:
- Guardrail:
- Preferred pattern:
- Avoid:

## Entries

- Date: 2026-07-31
- Context: Featherly theme configurator and public rendering.
- Symptom: saved theme colors and fonts were replaced by legacy defaults on the
  public page.
- Root cause: an empty `block_defaults` array failed the `required` validator;
  after valid writes, shared runtime props still read three older setting keys.
- Guardrail: every settings editor and consumer must use the same canonical key
  and share a persistence/reload integration test.
- Preferred pattern: accept empty optional maps with `present|array`, expose
  field-local validation errors, and use canonical `theme_config` with an
  explicit legacy fallback at the read boundary.
- Avoid: rebuilding a parallel runtime configuration from deprecated keys.

- Date: 2026-07-31
- Context: optimistic locking in CMS editors.
- Symptom: a second save after a successful first save could report a false
  conflict.
- Root cause: the client generated the next lock with its own clock rather than
  using the persisted model timestamp.
- Guardrail: synchronize locks exclusively from the successful server response.
- Preferred pattern: `response.props.<resource>.updated_at` becomes the next
  optimistic lock.
- Avoid: `new Date().toISOString()` as a revision identifier.

- Date: 2026-07-31
- Context: block-builder media and navigation contracts.
- Symptom: fields persisted image and navigation data that the public renderer
  could not use.
- Root cause: editor capabilities were added without matching runtime branches
  and end-to-end contract assertions.
- Guardrail: every authorable field must have a persisted schema, public render
  path, accessible output, and regression test in the same vertical slice.
- Preferred pattern: test editor schema and runtime output together.
- Avoid: shipping an editor-only capability as a completed CMS feature.
