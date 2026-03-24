# MVP Next Commits

## NOW (max 3)
- [ ] SCL-027 Add query profiling and remove N+1 in public render paths
- [ ] SCL-014 Standardize API response envelopes for admin endpoints
- [ ] SCL-030 Add search strategy for JSON-translated content

## NEXT
- [ ] SCL-031 Add pagination strategy for very large media collections
- [ ] SCL-032 Introduce cursor pagination where offset scaling hurts
- [ ] SCL-034 Add route-level response time budget checks

## LATER
- [ ] SCL-039 Remove locale hardcodes and use active language source everywhere
- [ ] SCL-049 Add revision diff view (content comparison)
- [ ] SCL-062 Integrate backend+frontend error tracking platform

## Program Backlog
- Full backlog source: `docs/planning/scaling-backlog-65.md`
- Program roadmap: `docs/planning/scaling-roadmap.md`

## Refill Rules
- Pull from `docs/planning/scaling-backlog-65.md` when `NOW` is empty.
- Keep priority order (P0 -> P1 -> P2 -> P3) and dependencies intact.
- Keep tasks small and reversible (`<=10 files` per task).
