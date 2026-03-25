# MVP Next Commits

## NOW (max 3)
- [ ] SCL-039 Remove locale hardcodes and use active language source everywhere
- [ ] SCL-046 Add route-level locale edge-case tests
- [ ] SCL-049 Add revision diff view (content comparison)

## NEXT
- [ ] SCL-040 Standardize localized slug conflict policy
- [ ] SCL-041 Add slug normalization and reserved-path safeguards
- [ ] SCL-043 Improve hreflang generation for nested and archive routes

## LATER
- [ ] SCL-062 Integrate backend+frontend error tracking platform
- [ ] SCL-063 Add core operational metrics (queue lag, slow queries, cache hit)
- [ ] SCL-064 Expand health checks for DB/cache/queue readiness

## Program Backlog
- Full backlog source: `docs/planning/scaling-backlog-65.md`
- Program roadmap: `docs/planning/scaling-roadmap.md`

## Refill Rules
- Pull from `docs/planning/scaling-backlog-65.md` when `NOW` is empty.
- Keep priority order (P0 -> P1 -> P2 -> P3) and dependencies intact.
- Keep tasks small and reversible (`<=10 files` per task).
