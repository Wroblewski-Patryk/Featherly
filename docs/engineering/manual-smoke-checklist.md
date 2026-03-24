# Manual Smoke Checklist

Run this checklist before merge for UI/API-affecting changes.

## Setup
- Branch/PR:
- Environment URL:
- Seed dataset/version:
- Test account(s):
- Browser/device:

## Core Flows
- [ ] Home page loads without blocking errors.
- [ ] Navigation from home to login works.
- [ ] Login succeeds with valid credentials.
- [ ] Login validation appears for invalid email format.
- [ ] Dashboard loads after successful login.
- [ ] Profile page loads and existing address is visible.
- [ ] Address can be updated and saved.
- [ ] Success message appears after saving address.
- [ ] Persisted address is visible after refresh.
- [ ] Logout returns user to public state.

## Evidence
- [ ] Screenshot at each milestone step.
- [ ] DOM snapshot for at least one success and one validation case.
- [ ] Console/network logs attached for any failure.

## Result
- Status: Pass / Fail / Partial
- Notes:
- Blockers:
- Follow-up issue(s):