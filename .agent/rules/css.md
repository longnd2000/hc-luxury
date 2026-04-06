---
description: CSS architecture, naming conventions, 4px grid system, typography, and global layout rules.
---

# CSS Rules

## File Organization
- General styles: `/assets/scss/_style.scss`.
- Contact Form 7 styles: `/assets/scss/_ctf7.scss`.
- Global styles (Layout): `main.scss`.

## Naming Conventions
- Use **snake_case** for all class names (e.g., `.lx_custom_container`).
- **Mandatory Prefixing**: Avoid generic class names. Prefix all custom classes with **`lx_`** (e.g., `.lx_archive_page_title`) to prevent conflicts.
- **Unique Responsibility**: Each class should have a specific, unique name that describes its role, similar to how an ID is used. This prevents style bleeding and makes overrides easier.

## Structural Rules (Mandatory)
- **NO NESTING**: Do not nest child classes inside parent classes in SCSS. All classes must be defined at the top level of the stylesheet to ensure they are independent and easy to modify.
- **Class Reuse**: Only reuse existing classes if the style is identical and intended to stay synchronized across different components. Otherwise, create a unique class.

## Isolation Policy
- Never apply custom styles to internal content tags (e.g., inside `the_content()`, `.lx_entry_content`). Maintain natural rendering for third-party plugin compatibility.

## The 4px Grid System
- **Core Requirement**: All spacing and typographic sizes MUST be multiples of 4 (4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, etc.).

## Typography Scale
- `h1`: 32px | `h2`: 28px | `h3`: 24px | `h4`: 20px | `h5`: 16px | `h6`: 12px.
- Body Text: 16px (default) | Small: 12px or 8px.
- Default Color: `#000000`.

## Heading Hierarchy (Mandatory)
- `h2`: Section title (e.g., sidebar widget title, archive section title, widget header).
- `h3`: Individual post/item title within a list (e.g., post card title in archive grid, event title in event list, sidebar post title).
- `h4`: Sub-title or secondary title if present (e.g., supplementary heading within a card or section).

## Contextual Font-Size Overrides (List/Grid Context)
- Post/event title in list/grid: `16px` (overrides default h3 scale of 24px for visual balance within cards).
- Description/excerpt in list/grid: `12px`.
- These overrides are intentional — the heading tag (`h3`) is kept for semantic/SEO purposes, but the visual size is reduced to fit card layouts.

## Heading Consistency
When changing heading tags (`h1`-`h6`) in PHP, immediately update the corresponding CSS `font-size` in `_style.scss` to match the scale above, unless a contextual override applies.

## Global Layout Classes
- `.section_box`: Padding wrapper (`width: 100%`, `padding: 0 4%`).
- `.py_section`: Vertical spacing (`padding: 80px 0`).
- `.container`: Limits content width to `1200px` and centers it.
- **Usage Restriction**: Do not use these global layout classes inside Elementor Widgets or Shortcodes.

## Font Inheritance
**NEVER** declare `font-family` in any SCSS file. Fonts are managed centrally by **Elementor**. Inherit or use the global config.
