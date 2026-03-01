# Blocks (MVP)

## Layout
1) Section
- background: none | color | image
- padding: top/bottom
- width: full | boxed
- anchor_id (opcjonalnie)

2) Columns
- columns_count: 2|3|4
- responsive_stack: true/false
- gap

## Content
3) Heading
- level: h1-h4
- text
- align

4) RichText
- html (sanitized)
- align

5) Image
- media_id
- alt_override (opcjonalnie)
- caption (opcjonalnie)
- align
- width

6) Button
- label
- url
- style: primary|secondary
- new_tab: true/false

## Marketing
7) Hero
- heading
- subheading
- background_image (media_id)
- primary_cta (label/url)
- secondary_cta (optional)

## Forms
8) ContactForm
- success_message
- recipient (global config, nie per blok)

---

## Universal: Animation settings (applies to all blocks)
Each block instance supports:
- entrance animation config (trigger + preset + params)
- timeline binding (page/template timeline)
- future: advanced override (raw GSAP vars) but NOT required for MVP