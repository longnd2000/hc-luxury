---
description: Project coding standards and rules for artificial intelligence agents and developers.
---

# Project Rules & Design Standards

These rules are mandatory for all development tasks within this project. Adhering to these standards ensures maintainability, logical consistency, and compatibility across the theme.

## 1. PHP & WordPress Core Standards
- **Function Location**: All custom PHP functions, actions, and filters must be placed in `functions.php`.
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
- **Heading Consistency**: When changing heading tags (`h1`-`h6`) in PHP, immediately update the corresponding CSS `font-size` in `_style.scss` to match the scale above.

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