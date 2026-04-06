---
description: How to create a new reusable component in /components.
---

# Create Component

// turbo-all

## Steps

1. **Identify the repeated pattern**: Confirm the markup is used in 2+ templates or widgets.

2. **Create the component file**:
   - Path: `components/{component_name}.php` (snake_case)
   - Add data contract at the top:
     ```php
     <?php
     /**
      * Component: {Component Name} ({css_class})
      *
      * {Brief description}
      *
      * Expected variables:
      * @var string $var1 — Description
      * @var string $var2 — Description
      */
     ?>
     ```

3. **Extract the markup**: Move the HTML block from the template into the component file. Keep only markup and conditionals — no `WP_Query` or loops.

4. **Replace in parent templates**: In each template where the markup was duplicated, replace with:
   ```php
   // For components needing parent variables (MOST cases):
   include(get_stylesheet_directory() . '/components/{component_name}.php');

   // For self-contained components ONLY:
   get_template_part('components/{component_name}');
   ```

5. **Add CSS**: Ensure all component classes use `lx_` prefix and are defined in `_style.scss`.

6. **Update registry**: Add the new component to `.agent/context/components.md`.

7. **Test**: Visit all pages that use the component to verify output matches.
