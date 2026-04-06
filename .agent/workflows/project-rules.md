---
description: Project coding standards and rules for artificial intelligence agents and developers.
---

# Project Rules & Design Standards

These rules are mandatory for all development tasks within this project. Adhering to these standards ensures maintainability, logical consistency, and compatibility across the theme.

## 1. PHP & WordPress Core Standards
- **Function Location**: `functions.php` is the **entry point only** (constants + module loader). All custom PHP functions, actions, and filters must be placed in the appropriate module file under `/inc`. See **Section 9** for the full module map.
- **Widget Templates**: Follow the structure of `widgets/template/duplicate_widget.php` as the master template for all new widgets.
- **Elementor Widgets**:
  - Use `snake_case` for widget class names.
  - Required methods: `get_name()`, `get_title()`, `get_icon()`, `get_categories()`.
  - Use `_register_controls()` for settings and `render()` for frontend output.
  - Implement JS logic using the `elementor/frontend/init` hook (refer to the jQuery pattern in `duplicate_widget.php`).
- **Internationalization (i18n)**: All static strings in code MUST be wrapped in the translation function: `__('Your Text', 'child-theme')`.
- **ACF Management**:
  - **JSON Sync Only**: Field groups must be managed via the WordPress Admin UI and synchronized through the `/acf-json` directory.
  - **No PHP Registration**: Never use `acf_add_local_field_group()` in `functions.php`. Register fields via JSON or Admin UI only.

## 2. Data Handling & Security
- **Strict Validation**: Always verify data existence before rendering associated HTML. If data (title, content, image, etc.) is missing, DO NOT render the container element.
- **Output Policy**: **DO NOT** use default WordPress escaping functions like `esc_html()`, `esc_url()`, or `esc_attr()`. Output raw variables directly.
- **Date Formatting**: 
  - Standard format: `d/m/Y` (e.g., `15/12/2026`).
  - Use this for ACF Date Picker settings and frontend displays.
  - PHP Parsing: If using `strtotime()`, replace slashes with dashes: `str_replace('/', '-', $date)`.

## 3. CSS Architecture & Naming
- **File Organization**:
  - General styles: `/assets/scss/_style.scss`.
  - Contact Form 7 styles: `/assets/scss/_ctf7.scss`.
  - Global styles (Layout): `main.scss`.
- **Naming Conventions**:
  - Use **snake_case** for all class names (e.g., `.lx_custom_container`).
  - **Mandatory Prefixing**: Avoid generic class names. Prefix all custom classes with **`lx_`** (e.g., `.lx_archive_page_title`) to prevent conflicts.
  - **Unique Responsibility**: Each class should have a specific, unique name that describes its role, similar to how an ID is used. This prevents style bleeding and makes overrides easier.
- **Structural Rules (Mandatory)**:
  - **NO NESTING**: Do not nest child classes inside parent classes in SCSS. All classes must be defined at the top level of the stylesheet to ensure they are independent and easy to modify.
  - **Class Reuse**: Only reuse existing classes if the style is identical and intended to stay synchronized across different components. Otherwise, create a unique class.
- **Isolation Policy**:
  - Never apply custom styles to internal content tags (e.g., inside `the_content()`, `.lx_entry_content`). Maintain natural rendering for third-party plugin compatibility.

## 4. The 4px Grid System & Typography
- **Core Requirement**: All spacing and typographic sizes MUST be multiples of 4 (4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, etc.).
- **Typography Scale**:
  - `h1`: 32px | `h2`: 28px | `h3`: 24px | `h4`: 20px | `h5`: 16px | `h6`: 12px.
  - Body Text: 16px (default) | Small: 12px or 8px.
  - Default Color: `#000000`.
- **Heading Hierarchy (Mandatory)**:
  - `h2`: Section title (e.g., sidebar widget title, archive section title, widget header).
  - `h3`: Individual post/item title within a list (e.g., post card title in archive grid, event title in event list, sidebar post title).
  - `h4`: Sub-title or secondary title if present (e.g., supplementary heading within a card or section).
- **Contextual Font-Size Overrides (List/Grid Context)**:
  - Post/event title in list/grid: `16px` (overrides default h3 scale of 24px for visual balance within cards).
  - Description/excerpt in list/grid: `12px`.
  - These overrides are intentional — the heading tag (`h3`) is kept for semantic/SEO purposes, but the visual size is reduced to fit card layouts.
- **Heading Consistency**: When changing heading tags (`h1`-`h6`) in PHP, immediately update the corresponding CSS `font-size` in `_style.scss` to match the scale above, unless a contextual override applies.
- **Elementor Specificity Override**: Elementor injects global heading styles via `.elementor-kit-{id} h1-h6` selectors (specificity `0,1,1`), which override single-class selectors (specificity `0,1,0`). When custom `font-size` or `font-weight` on heading elements is being overridden by Elementor, use `!important` to enforce. This applies to all custom heading classes inside Elementor widget templates and theme templates.

## 5. Global Layout & Styling
- **Layout Classes**:
  - `.section_box`: Padding wrapper (`width: 100%`, `padding: 0 4%`).
  - `.py_section`: Vertical spacing (`padding: 80px 0`).
  - `.container`: Limits content width to `1200px` and centers it.
- **Usage Restriction**: Do not use these global layout classes inside Elementor Widgets or Shortcodes.
- **Font Inheritance**: **NEVER** declare `font-family` in any SCSS file. Fonts are managed centrally by **Elementor**. Inherit or use the global config.

## 6. Asset Handling & Iconography
- **Image Standards**:
  - Always use `<img>` tags with `alt`, `width`, and `height` attributes in HTML.
  - CSS override: Use `width: 100% !important;` and `height: 100% !important;` for responsiveness.
  - Aspect Ratio: Default is **4:3**.
  - **No Dynamic Effects**: Images must remain static. No hover animations or transitions.
- **Iconography**: Use **FontAwesome Free 6.x** (prefixes: `fas`, `far`, `fab`). Ensure consistent size/color within components via `_style.scss`.

## 7. Component & Third-Party Integration
- **Contact Form 7**:
  - Store form configuration code in `/form-ctf7/` (e.g., `contact-home.php`).
  - Keep all CF7-related SCSS in `_ctf7.scss`. Ensure it is `@import`ed in `main.scss`.
- **ACF Pro 6.2**: Standardized version for all custom field implementations. Verify field existence before usage as per Rule 2.

## 8. Component Reusability (Mandatory)
- **Purpose**: Any UI block (markup) that is repeated across 2+ templates or widgets MUST be extracted into a standalone PHP partial file in the `/components` directory.
- **Directory**: `child-theme/components/` — flat structure, one file per component.
- **Naming**: `{component_name}.php` using `snake_case` (e.g., `post_card.php`, `sidebar_latest_posts.php`, `event_card.php`).
- **Usage (Variable Scope Rule - CRITICAL)**:
  - **Component relying on local variables (e.g., inside a loop)**: You **MUST** use `include(get_stylesheet_directory() . '/components/{name}.php');`. This applies to both theme templates and Elementor widgets. Using `include` ensures the component inherits the local variables (like `$img`, `$title`, `$link`) defined in the parent scope.
  - **Self-contained components**: If the component is completely self-contained (e.g., it runs its own `WP_Query` like `sidebar_latest_posts` and doesn't need parent variables), you may use `get_template_part('components/{name}');` or `include()`.
  - **Why not always `get_template_part`?**: Under the hood, WordPress uses `load_template()` which isolates the variable scope. If you define `$title = get_the_title();` in an `archive.php` loop, that variable physically will not exist inside the component file if loaded via `get_template_part()`, throwing "Undefined variable" fatal warnings. Always default to `include()` when passing loop data.
- **Data Contract**: Each component file must document its expected variables at the top in a comment block:
  ```php
  <?php
  /**
   * Component: Post Card (cs_post_item)
   * Expected variables: $img, $title, $excerpt, $link, $categories
   */
  ?>
  ```
- **Scope**: Components only contain HTML markup and conditionals. They must NOT contain `WP_Query`, loops, or business logic — the parent template handles data fetching and passes variables to the component.
- **Identified Components for Extraction**:
  - `post_card.php` — `.cs_post_item` block (used in: `archive.php`, `search.php`, `single.php`, `category_section_widget.php`).
  - `event_card.php` — `.event_item` block (used in: `archive-event.php`, `event_widget.php`).
  - `sidebar_latest_posts.php` — Entire sidebar widget with WP_Query + `.fp_side_post` loop (used in: `archive.php`, `archive-event.php`, `search.php`).

## 9. PHP Module Organization (Mandatory)

### Principle
`functions.php` is the **entry point only** — it defines constants and loads modules via `require_once`.
All hooks, filters, and functions MUST be placed in the appropriate file under `/inc`.

### Module Map

| File | Domain | What belongs here |
|---|---|---|
| `inc/helpers.php` | Debug & Utilities | `write_log()`, utility/helper functions (loaded first) |
| `inc/enqueue.php` | Assets | `wp_enqueue_scripts`, `admin_enqueue_scripts`, CSS/JS registration |
| `inc/elementor.php` | Elementor | `elementor/init`, widget loaders, Elementor-specific hooks |
| `inc/post-types.php` | CPT & Taxonomy | `register_post_type()`, `register_taxonomy()`, related hooks |
| `inc/acf.php` | ACF Config | ACF settings filters, options pages, ACF-specific hooks |
| `inc/query.php` | Query Mods | `pre_get_posts`, `posts_clauses`, query-related filters |
| `inc/template-tags.php` | Template Helpers | Display helpers, archive title filters, breadcrumb, conditional functions |
| `inc/shortcodes.php` | Shortcodes | `add_shortcode()` registrations (create when needed) |
| `inc/admin.php` | Admin Customization | Admin menus, dashboard widgets, admin hooks (create when needed) |
| `inc/security.php` | Security & Cleanup | Remove WP version, disable XML-RPC, head cleanup (create when needed) |
| `inc/api.php` | REST API | Custom REST endpoints (create when needed) |

### Rules
1. **One domain per file** — never mix unrelated hooks in the same file.
2. **Create on demand** — files marked "(create when needed)" should only be created when the first function of that domain is added.
3. **Adding a new module**: Create the file in `/inc`, then add it to the `$child_theme_inc_files` array in `functions.php`.
4. **Function naming**: All functions MUST be prefixed with `child_theme_` (e.g., `child_theme_register_event_cpt()`).
5. **File header**: Every `/inc` file must start with a doc block:
   ```php
   <?php
   /**
    * [Domain Name]
    *
    * @package Child_Theme
    */
   ```
6. **Hook attachment**: Each function must have its `add_action()` / `add_filter()` call **immediately after** the function definition, in the same file.
7. **No logic in functions.php**: `functions.php` must never contain hook callbacks, filters, or business logic — only constants and `require_once` statements.

## 10. Debugging (Mandatory)

- **Standard function**: Always use `write_log()` (defined in `inc/helpers.php`) for debugging. **Never** use `var_dump()`, `print_r()`, `error_log()`, or `echo` for debug output.
- **Syntax**:
  ```php
  write_log($variable);                    // Basic log
  write_log($variable, 'My Label');         // With label
  write_log($array_or_object, 'Data');      // Arrays/objects auto-formatted
  ```
- **Log location**: `wp-content/debug.log`
- **Cleanup**: Remove all `write_log()` calls after debugging is complete. Debug logs must never remain in production code.