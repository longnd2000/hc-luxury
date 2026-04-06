---
description: How to add a new PHP module in /inc.
---

# Add Inc Module

// turbo-all

## Steps

1. **Identify the domain**: Check the Module Map in `rules/php.md` to see if an existing module fits. Only create a new file if no existing module covers the domain.

2. **Create the module file**:
   - Path: `inc/{module_name}.php`
   - Add file header:
     ```php
     <?php
     /**
      * {Domain Name}
      *
      * @package Child_Theme
      */
     ```

3. **Write functions**: 
   - Prefix all functions with `child_theme_`.
   - Place `add_action()` / `add_filter()` immediately after each function.

4. **Register in functions.php**: Add to the `$child_theme_inc_files` array:
   ```php
   $child_theme_inc_files = [
       // ... existing modules ...
       '/inc/{module_name}.php',  // {brief description}
   ];
   ```

5. **Update Module Map**: Add the new module to `rules/php.md` Module Map table.

6. **Test**: Visit the site to verify no PHP errors and the new functionality works.
