# User Journeys

Use this file as the canonical list of end-user flows that must stay valid.

## Journey Catalog

| ID | Journey | Entry Point | Persona | Priority | Automated E2E | Manual Smoke |
| --- | --- | --- | --- | --- | --- | --- |
| J-001 | Sign in from home page | Home page CTA | Returning user | P0 | Yes | Yes |
| J-002 | Registration with validation | Register page | New user | P0 | Yes | Yes |
| J-003 | Update profile address | Profile settings | Authenticated user | P1 | Yes | Yes |
| J-004 | Dashboard access after login | Login form | Authenticated user | P0 | Yes | Yes |

## Journey Template

Copy this block when adding a new journey.

### ID: J-XXX
- Name:
- Persona:
- Preconditions:
- Seed data:
- Steps:
  1. Open:
  2. Click:
  3. Enter:
  4. Submit:
  5. Observe:
- Expected result:
- Negative case(s):
- Evidence points (screenshot/DOM/log):
- Related tests:
- Last validated date:
- Last validated by:

## Change Policy
- Any feature affecting navigation, forms, auth, profile, or checkout updates this file in the same PR.
- New critical features require at least one new P0 or P1 journey.
- Deprecated journeys should be marked as archived with reason and date.