# Architecture Guardrails

- Monolit Laravel + Vue admin.
- Public pages render server-side (SEO, szybkość).
- Vue/JS wymagane tylko dla panelu i builder preview.
- Bloki i ich settings trzymamy w strukturze, która pozwala dodawać nowe bloki bez migracji DB dla każdej drobnej zmiany.
- Każdy blok musi mieć:
  - schema walidacji settings
  - renderer publiczny
  - komponent edytora (Vue)
- Animacje to progressive enhancement: treść widoczna bez JS.
- Jeżeli jakaś decyzja (SSR/SSG/cache) jest niejasna → najpierw zaproponować opcje + trade-offy, dopiero potem wybór.