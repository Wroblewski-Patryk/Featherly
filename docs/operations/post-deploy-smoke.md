# Post-Deploy Smoke

Use this file to record the minimum checks after each deploy.

## Global Checks

- [ ] Health endpoint returns success
- [ ] Main app is reachable through the public URL
- [ ] Public media URL under `/storage/media/...` returns the uploaded asset
- [ ] Logs show no startup crash loop
- [ ] Background workers are connected and healthy

## User Journey Checks

- [ ] Primary entry flow works
- [ ] One critical happy-path action works
- [ ] One negative or validation path behaves correctly

## Ops Checks

- [ ] Migrations completed successfully
- [ ] Coolify post-deploy maintenance completed successfully
      (`composer deploy:coolify` or `sh scripts/coolify-post-deploy.sh`)
- [ ] Required env values are present
- [ ] If a Featherly update deployment was triggered, `php artisan
      updates:confirm` reports the expected `APP_VERSION` and passing
      DB/cache/queue health checks
- [ ] Metrics or error tracking show no new critical issue

## Evidence

- Timestamp: 2026-05-02T01:45:15+02:00
- Environment: staging, `https://test.luckysparrow.ch`
- Commands run:
  - `Resolve-DnsName test.luckysparrow.ch`
  - `curl.exe -I -L --max-time 20 https://test.luckysparrow.ch`
  - `curl.exe -I --max-time 20 https://test.luckysparrow.ch/storage/media/<uploaded-file>`
- Screenshots or logs: application reachability now resolves against
  `test.luckysparrow.ch`; uploaded media URL reachability remains the required
  post-deploy confirmation.
- Coolify update rollout evidence, when applicable:
  - deployment history entry: pending operator evidence
  - target version: pending target environment evidence
  - `updates:confirm` result: pending target environment evidence
