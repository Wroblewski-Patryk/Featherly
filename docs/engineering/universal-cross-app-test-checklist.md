# Universal Cross-App Test Checklist

Use this checklist as a baseline for any web application. Mark items as N/A when out of scope.

## A. App Availability
- [ ] Application loads without blank screen or fatal error.
- [ ] Main route responds within acceptable time.
- [ ] Static assets (CSS/JS/images/fonts) load successfully.
- [ ] Friendly fallback is shown when backend is unavailable.

## B. Navigation and Routing
- [ ] Top-level navigation links work.
- [ ] Browser back/forward keeps app state consistent.
- [ ] Deep-link route opens correctly when pasted directly.
- [ ] Unknown route shows 404/not-found page.

## C. Authentication and Session
- [ ] Login succeeds with valid credentials.
- [ ] Login fails with invalid credentials and shows clear message.
- [ ] Input validation blocks malformed email (for example missing `@`).
- [ ] Logout clears session and protects private routes.
- [ ] Session expiration is handled gracefully.

## D. Forms and Validation
- [ ] Required fields show validation messages.
- [ ] Invalid format rules are enforced (email, phone, date, etc.).
- [ ] Save/submit button is disabled during processing.
- [ ] Success message is shown after valid submit.
- [ ] Persisted data remains after refresh.

## E. CRUD and Data Integrity
- [ ] Create action stores new record correctly.
- [ ] Read/list view displays expected data.
- [ ] Update action changes data and shows confirmation.
- [ ] Delete action requires explicit confirmation.
- [ ] Empty-state UI appears when no records exist.

## F. Error Handling and Resilience
- [ ] Network/API error shows user-safe message.
- [ ] Retry path is available for recoverable errors.
- [ ] Form state is preserved when recoverable error happens.
- [ ] No raw stack traces or sensitive internals are exposed.

## G. Permissions and Access Control
- [ ] Non-authenticated user cannot access private pages.
- [ ] Role restrictions are enforced in UI and API behavior.
- [ ] Forbidden actions show appropriate message/state.

## H. UX and Accessibility Baseline
- [ ] Core flow is usable on desktop and mobile viewport.
- [ ] Keyboard navigation works for key actions.
- [ ] Focus order and focus visibility are correct.
- [ ] Labels/aria names exist for actionable controls.
- [ ] Color contrast is acceptable for key text/actions.

## I. Browser and Device Baseline
- [ ] Latest Chrome passes smoke.
- [ ] One secondary browser passes smoke (for example Firefox or Edge).
- [ ] Mobile viewport smoke (for example 390x844) passes.

## J. Security Baseline (Functional)
- [ ] CSRF/session protection behavior works as expected.
- [ ] Unsafe HTML/script input is sanitized or rejected.
- [ ] Sensitive data is not visible in URL/query string.

## K. Observability and Diagnostics
- [ ] No critical console errors during happy path.
- [ ] Failed API calls are traceable in logs/monitoring.
- [ ] Correlation/request ID is visible where applicable.

## L. Evidence to Capture
- [ ] Screenshot at key milestones.
- [ ] DOM snapshot for one success case.
- [ ] DOM snapshot for one validation/error case.
- [ ] Console/network logs for failed checks.
- [ ] Short note: expected vs actual result.

## Recommended Execution Modes
- Automated E2E (Playwright): sections A, B, C, D, E, F.
- Browser-driven manual (agent + Playwright/MCP): sections C, D, F, H, I.
- Human sign-off before merge/release: sections H, I and high-risk business flows.