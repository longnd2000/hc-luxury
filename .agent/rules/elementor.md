---
description: Elementor widget development standards and specificity rules.
---

# Elementor Rules

## Widget Templates
Follow the structure of `widgets/template/duplicate_widget.php` as the master template for all new widgets.

## Widget Class Conventions
- Use `snake_case` for widget class names.
- Required methods: `get_name()`, `get_title()`, `get_icon()`, `get_categories()`.
- Use `_register_controls()` for settings and `render()` for frontend output.
- Implement JS logic using the `elementor/frontend/init` hook (refer to the jQuery pattern in `duplicate_widget.php`).

## Widget Registration
- Widget files live in `widgets/template/`.
- Register in `widgets/index.php` using `$widgets_manager->register(new \Widget_Class())`.
- Assign to one of the **LX UI Kit categories**: `lx_typography`, `lx_media`, `lx_cards`, `lx_sections`, `lx_loops`, `lx_forms`, `lx_misc`.

## Strict CSS Isolation (UI Kit Strategy)
- This theme is built as a highly reusable **UI Kit**.
- **NO ELEMENTOR STYLING CONTROLS**: Do **NOT** add controls for Typography, Color, Margin, or Padding in the widget's PHP file.
- All styles must be defined using strict SCSS classes starting with the `lx_` prefix (e.g., `lx_card`, `lx_title_primary`).
- Elementor's sole purpose is to provide the content input (Text, Images, Toggles) and act as a structural drag-and-drop wrapper.

## Specificity Override
Elementor injects global heading styles via `.elementor-kit-{id} h1-h6` selectors (specificity `0,1,1`), which override single-class selectors (specificity `0,1,0`). When custom `font-size` or `font-weight` on heading elements is being overridden by Elementor, use `!important` to enforce. This applies to all custom heading classes inside Elementor widget templates and theme templates.

## Layout Restriction
Do **NOT** use global layout classes (`.section_box`, `.py_section`, `.container`) inside Elementor Widgets or Shortcodes.
