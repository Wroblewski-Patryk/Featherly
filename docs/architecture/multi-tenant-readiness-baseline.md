# Multi-Tenant Readiness Baseline

## Purpose
Define a safe, phased architecture baseline for enabling multi-tenant capabilities without changing current single-tenant behavior.

## Current State (2026-03-25)
- Application runs in single-tenant mode.
- Content, settings, media, and identity data are globally scoped.
- No tenant discriminator is present in core domain tables.

## Target Principles
- Tenant isolation by default for reads and writes.
- Explicit tenant context resolution for every request path.
- Backward-compatible rollout with feature flags and migration rehearsals.
- No hidden cross-tenant data paths.

## Tenant Domain Baseline
- New canonical tenant entity:
  - `tenants` (`id`, `slug`, `name`, `status`, timestamps)
- Optional membership pivot:
  - `tenant_user` (`tenant_id`, `user_id`, `role`, timestamps)
- Core entities become tenant-aware using `tenant_id`:
  - pages, posts, projects, forms, templates, media, taxonomies, settings, translations.

## Request Context Contract
Tenant context must resolve in deterministic order:
1. Signed token claim (API/headless flows)
2. Tenant-bound subdomain or route segment
3. Authenticated user default tenant
4. Explicit fallback only for single-tenant compatibility mode

If context cannot be resolved, request fails fast (`404` or `403`, depending on path class).

## Data Isolation Contract
- Every tenant-aware table must include `tenant_id` index.
- Composite uniqueness moves to tenant scope (example: `tenant_id + slug + locale`).
- Cross-tenant joins are disallowed unless explicitly whitelisted for system operations.
- Caches, queues, and logs include tenant identifiers in keys and context metadata.

## Runtime Guardrails
- Introduce `TenantContext` value object for request lifecycle.
- Add global query scope for tenant-aware models.
- Add explicit bypass paths only for system/admin operations.
- Add integration tests for scope leakage protection.

## Rollout Plan
1. Add tenant schema (no behavior change).
2. Backfill `tenant_id` with default tenant for all existing records.
3. Introduce tenant-aware key strategy (cache/session/queues).
4. Gate tenant scopes behind feature flag.
5. Migrate selected modules incrementally (content -> media -> settings -> auth).
6. Remove compatibility fallback once all modules are tenant-aware.

## Risk Controls
- Migration rehearsals on fresh copies of production-like data.
- Dual-read assertions during transition windows.
- Rollback plan for each module migration step.
- Observability: tenant-tagged error rate, query anomalies, cache miss spikes.

## Out of Scope (Follow-up Tasks)
- Tenant-aware cache/session key strategy (`SCL-059`).
- Tenant lifecycle and retention policy.
- Tenant billing/plan enforcement.
