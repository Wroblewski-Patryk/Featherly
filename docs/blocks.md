# Blocks System Documentation

Our CMS uses a block-based architecture inspired by the best features of WordPress Gutenberg and Elementor, with a unique "magic sauce" for GSAP-driven animations.

## 1. Fundament: Treść (Content Blocks)
Essential text-based blocks for daily content creation.
- **Akapit / Tekst (Paragraph)**: Core text block.
- **Nagłówek (Heading)**: H1–H6 with alignment controls.
- **Lista (List)**: Bullets and numbered lists.
- **Cytat (Quote)**: Standard and pullquote variations.
- **Przycisk CTA (Button / Buttons)**: Individual and groups of call-to-action buttons.
- **Separator & Odstęp (Divider & Spacer)**: For visual rhythm and layout.
- **Tabela (Table)**: Structured data representation.
- **Kod / HTML (Code / Custom HTML)**: For integrations and custom embeds.

## 2. Media: Zdjęcia i Wideo
Visual storytelling assets.
- **Obraz (Image)**: Responsive settings, alt text, captions, and links.
- **Galeria (Gallery)**: Multi-image layouts.
- **Wideo (Video)**: Self-hosted and high-quality embeds.
- **Audio**: Podcasting and audio clips.
- **Plik do pobrania (File / Download)**: Document sharing.
- **Obraz + Tekst (Media & Text)**: Split-screen layouts.
- **Karuzela / Slider (Carousel)**: Dynamic image cycling.

## 3. Layout / Sekcje: Konstrukcja Strony
The structural heart of the system.
- **Sekcja / Kontener (Section / Container)**: Top-level wrappers with background controls.
- **Kolumny / Siatka (Columns / Grid)**: Responsive multi-column layouts.
- **Grupa (Group)**: Logical grouping of multiple blocks.
- **Stack / Flex**: Low-level flexbox-based row/column controls.
- **Alignment & Widths**: Full-width, Wide, Boxed, and Z-index controls.

## 4. Hero & Sekcje Marketingowe
High-conversion marketing components.
- **Cover / Hero**: Background (video/image) + Overlay + Content.
- **CTA Box**: Title + Description + Button combined.
- **Card / Box**: Universal containers with shadows, borders, and padding.
- **Ikona (Icon)**: Individual icons with styling.
- **Icon Box / Image Box**: Icon/Image with title and description.
- **Testimonials (Opinie)**: Customer social proof.
- **FAQ / Accordion**: Collapsible content sections.
- **Pricing Tables / Plans**: Comparison grids.
- **Counter / Statystyki**: Animated number counters.
- **Timeline / Steps**: Process visualization.

## 5. Nawigacja i Theme Blocks (Full Site Editing)
Blocks for building the entire site structure.
- **Menu / Nawigacja**: Site navigation builder.
- **Logo / Site Title**: Global brand identity.
- **Breadcrumbs**: SEO-friendly path navigation.
- **Template Part**: Reusable Header/Footer logic.
- **Query / Lista wpisów**: Latest posts grid/list with filtering.
- **Pagination**: Loading and page controls.

## 6. Embed / Integracje
Connecting with external services.
- **Universal Embed**: YouTube, Vimeo, Instagram, X, TikTok, Spotify.
- **Mapy (Google Maps)**: Interactive location previews.
- **Shortcode / HTML Embed**: Legacy and custom connector support.
- **Form Connector**: Connection to external or internal form builders.

## 7. Magic Sauce: GSAP Animation Layer 🎬
The unique advantage of our CMS. Animation is treated as a "Meta-Block" property.
- **Panel Wspólny**: Shared animation settings for all blocks.
- **Triggers**: `onEnter` (fade/slide/scale/clip), `onScroll`, `onLoad`, `onHover`.
- **Parameters**: Delay, Duration, Ease.
- **Scope**: Element, Group, or entire Section.
- **Timeline ID**: Assign blocks to specific sequences for complex storytelling.