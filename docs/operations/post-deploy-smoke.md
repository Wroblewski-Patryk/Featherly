# Post-Deploy Smoke

Use this file to record the minimum checks after each deploy.

## Global Checks

- [ ] Health endpoint returns success
- [ ] Main app is reachable through the public URL
- [ ] Logs show no startup crash loop
- [ ] Background workers are connected and healthy

## User Journey Checks

- [ ] Primary entry flow works
- [ ] One critical happy-path action works
- [ ] One negative or validation path behaves correctly

## Ops Checks

- [ ] Migrations completed successfully
- [ ] Required env values are present
- [ ] If a Featherly update deployment was triggered, `php artisan
      updates:confirm` reports the expected `APP_VERSION` and passing
      DB/cache/queue health checks
- [ ] Metrics or error tracking show no new critical issue

## Evidence

- Timestamp: 2026-05-02T01:45:15+02:00
- Environment: staging, `https://test.luckusparrow.ch`
- Commands run:
  - `Resolve-DnsName test.luckusparrow.ch`
  - `Invoke-WebRequest -Uri https://test.luckusparrow.ch -MaximumRedirection 5 -TimeoutSec 20`
  - `curl.exe -I -L --max-time 20 https://test.luckusparrow.ch`
- Screenshots or logs: DNS lookup and HTTP smoke are blocked by unresolved
  domain from this workspace
- Coolify update rollout evidence, when applicable:
  - deployment history entry: pending operator evidence
  - target version: pending target environment evidence
  - `updates:confirm` result: pending target environment evidence
