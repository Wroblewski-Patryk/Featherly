# Coolify Staging Rollout Evidence: test.luckusparrow.ch

Date: 2026-05-02
Environment: staging
Public URL: `https://test.luckusparrow.ch`
Status: BLOCKED

## Purpose

This file records the first external Coolify target evidence for Featherly v1.
The target environment now exists, but the public URL is not reachable from this
workspace, so the deployment gate cannot be marked passed yet.

## Evidence Captured

Timestamp: `2026-05-02T01:45:15+02:00`

Commands:

```powershell
Resolve-DnsName test.luckusparrow.ch
```

Result:

```text
DNS_ERROR_RCODE_NAME_ERROR
test.luckusparrow.ch : DNS name does not exist
```

Commands:

```powershell
Invoke-WebRequest -Uri https://test.luckusparrow.ch -MaximumRedirection 5 -TimeoutSec 20
Invoke-WebRequest -Uri http://test.luckusparrow.ch -MaximumRedirection 5 -TimeoutSec 20
curl.exe -I -L --max-time 20 https://test.luckusparrow.ch
```

Result:

```text
Could not resolve host: test.luckusparrow.ch
```

## Evidence Captured After Reported Deploy

Timestamp: `2026-05-02T02:03:16+02:00`

Operator note: deploy was reported as completed.

Commands:

```powershell
Resolve-DnsName test.luckusparrow.ch
nslookup test.luckusparrow.ch 1.1.1.1
nslookup test.luckusparrow.ch 8.8.8.8
Invoke-WebRequest -Uri https://test.luckusparrow.ch -MaximumRedirection 5 -TimeoutSec 30
curl.exe -I -L --max-time 30 https://test.luckusparrow.ch
```

Result:

```text
Resolve-DnsName: DNS_ERROR_RCODE_NAME_ERROR
1.1.1.1: Non-existent domain
8.8.8.8: Non-existent domain
Invoke-WebRequest: could not resolve remote name 'test.luckusparrow.ch'
curl: Could not resolve host: test.luckusparrow.ch
```

## Gate Result

The staging target is identified and deploy was reported complete, but public
smoke checks still cannot proceed until DNS resolves and the application
responds over HTTPS.

Current deployment gate blockers:

- DNS for `test.luckusparrow.ch` does not resolve from this workspace.
- Main app public URL cannot be reached.
- Health/readiness endpoint cannot be checked.
- `updates:confirm` evidence is not captured from the target environment.
- Coolify deployment history entry is not attached.

## Required Next Evidence

After DNS and routing are fixed, capture:

- Coolify project/environment name
- deployment history entry or deployment ID
- running commit or build artifact
- `APP_VERSION`
- `php artisan updates:confirm` output from the target environment
- `php artisan ops:health-check --json` output from the target environment
- standard post-deploy smoke result from `docs/operations/post-deploy-smoke.md`

## Decision

FEA-015 remains blocked, but the blocker is now narrower: the external staging
target is known, and the next required action is to make
`test.luckusparrow.ch` publicly resolvable and reachable before rollout evidence
can be completed.
