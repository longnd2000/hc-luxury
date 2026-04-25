---
description: How to create a new custom Elementor widget.
---

# Create Elementor Widget

// turbo-all

## Steps

1. **Duplicate the master template**:
   ```
   Copy widgets/template/duplicate_widget.php → widgets/template/{widget_name}.php
   ```

2. **Update widget class**:
   - Rename class to `{Widget_Name}` (snake_case).
   - Update `get_name()` → unique slug.
   - Update `get_title()` → display name.
   - Update `get_icon()` → Elementor icon class.
   - Set `get_categories()` → Pick ONE from: `['lx_typography']`, `['lx_media']`, `['lx_cards']`, `['lx_sections']`, `['lx_loops']`, `['lx_forms']`, `['lx_misc']`.

3. **Add controls** in `_register_controls()`:
   - Use Elementor's control types (TEXT, TEXTAREA, MEDIA, REPEATER, etc.) for **CONTENT ONLY**.
   - **DO NOT** add Style Controls (Color, Typography, Margin, Padding). This theme uses a Strict UI Kit Strategy. All styling is handled via `lx_` prefixed SCSS classes.

4. **Build render output** in `render()`:
   - Get settings: `$settings = $this->get_settings_for_display();`
   - Output HTML with `lx_` prefixed classes.
   - Follow data validation rules (check existence before rendering).
   - If using a reusable component, use `include()`.

5. **Register the widget** in `widgets/index.php`:
   ```php
   require_once WIDGETS_PATH . '/{widget_name}.php';
   $widgets_manager->register(new \{Widget_Class}());
   ```

6. **Add CSS**: Style in `_style.scss` with `lx_` prefixed classes.

7. **Update registry**: Add to `.agent/context/widgets.md`.

8. **Test**: Add widget in Elementor editor, verify frontend rendering.
