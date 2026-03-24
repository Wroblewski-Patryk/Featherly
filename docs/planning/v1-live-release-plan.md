# V1 Live Release Plan

## Pre-Release Gates
- Product acceptance for localized admin and public baseline.
- Route and runtime smoke checks passed.
- Translation integrity test passed.
- Security and risk checklist reviewed.
- Monitoring and rollback plan confirmed.

## Launch Checklist
- [ ] Public dynamic route behavior validated in target locales
- [ ] Key admin CRUD paths smoke-tested
- [ ] Translation scan + integrity checks passed
- [ ] SEO baseline endpoints (`sitemap.xml`, `robots.txt`) verified
- [ ] Rollback path documented

## Post-Launch
- Day 0: monitor route errors, translation gaps, and form submissions.
- Day 1: review logs, user feedback, and unresolved known limits.
- Incident path: follow `docs/operations/operator-handbook.md` and release runbook.
