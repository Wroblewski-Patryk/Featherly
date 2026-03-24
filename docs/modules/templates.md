# Module: Templates

## Goal
Provide reusable layout structures for pages and shared site sections.

## Supported Types
- `header`
- `footer`
- `sidebar`
- `page`

## Data Contracts
- `name`, `type`, `content`, `is_active`, `is_default`
- SEO metadata fields for template-level usage where relevant

## Integration
- Pages can assign template and header/footer/sidebar overrides.
- Templates participate in the same builder/renderer ecosystem as other content modules.
