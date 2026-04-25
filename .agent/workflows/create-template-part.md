---
description: Cách tạo một template part (đoạn mã tái sử dụng) trong /templates/parts.
---

# Create Template Part

// turbo-all

## Steps

1. **Identify the repeated pattern**: Confirm the markup is used in 2+ templates or widgets.

2. **Create the template part file**:
   - Path: `templates/parts/{name}.php` (snake_case)
   - Add data contract at the top:
     ```php
     <?php
     /**
      * Template Part: {Name} ({css_class})
      *
      * {Brief description}
      *
      * Expected variables:
      * @var string $var1 — Description
      * @var string $var2 — Description
      */
     ?>
     ```

3. **Extract the markup**: Move the HTML block from the template into the part file. Keep only markup and conditionals — no `WP_Query` or loops.

4. **Replace in parent templates**: In each template where the markup was duplicated, replace with:
   ```php
   // For parts needing parent variables (MOST cases):
   include(get_stylesheet_directory() . '/templates/parts/{name}.php');

   // For self-contained parts ONLY:
   get_template_part('templates/parts/{name}');
   ```


5. **Add CSS**: Ensure all component classes use `lx_` prefix and are defined in `_style.scss`.

6. **Update registry**: Add the new component to `.agent/context/components.md`.

7. **Test**: Visit all pages that use the component to verify output matches.
