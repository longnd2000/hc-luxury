---
description: PHP coding standards, module organization, and debugging rules.
---

# PHP Rules

## Function Location & Module Organization

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
| `inc/template-tags.php` | Template Helpers | Display helpers, archive title filters, conditional functions |
| `inc/breadcrumbs.php` | Breadcrumbs | Global breadcrumb system. Use `lx_get_breadcrumbs()` in templates. |

| `inc/shortcodes.php` | Shortcodes | `add_shortcode()` registrations (create when needed) |
| `inc/admin.php` | Admin Customization | Admin menus, dashboard widgets, admin hooks (create when needed) |
| `inc/security.php` | Security & Cleanup | Remove WP version, disable XML-RPC, head cleanup (create when needed) |
| `inc/api.php` | REST API | Custom REST endpoints (create when needed) |

### Template Organization
1. **Elementor Layouts (Theme Builder)**: Toàn bộ bố cục Single, Archive, Search phải được build trong Elementor Theme Builder.
2. **Template Parts (Item Loops)**: `/templates/parts/{name}.php` (e.g., `post_card.php`). Vẫn sử dụng để chứa markup cho 1 item trong vòng lặp (được gọi từ Elementor Widget).
3. **No Hardcoded Layouts**: Tuyệt đối không code bố cục trang trong `single.php`, `archive.php` hay thư mục `templates/layouts/`.


### Module Rules
1. **One domain per file** — never mix unrelated hooks in the same file.
2. **Create on demand** — files marked "(create when needed)" should only be created when the first function of that domain is added.
3. **Adding a new module**: Create the file in `/inc`, then add it to the `$child_theme_inc_files` array in `functions.php`.
4. **No logic in functions.php**: `functions.php` must never contain hook callbacks, filters, or business logic — only constants and `require_once` statements.

## Function Naming
- All functions MUST be prefixed with `child_theme_` (e.g., `child_theme_register_event_cpt()`).

## File Header
Every `/inc` file must start with a doc block:
```php
<?php
/**
 * [Domain Name]
 *
 * @package Child_Theme
 */
```

## Hook Attachment
Each function must have its `add_action()` / `add_filter()` call **immediately after** the function definition, in the same file.

## Internationalization (i18n)
All static strings in code MUST be wrapped in the translation function: `__('Your Text', 'child-theme')`.

## Debugging

- **Standard function**: Always use `write_log()` (defined in `inc/helpers.php`) for debugging. **Never** use `var_dump()`, `print_r()`, `error_log()`, or `echo` for debug output.
- **Syntax**:
  ```php
  write_log($variable);                    // Basic log
  write_log($variable, 'My Label');         // With label
  write_log($array_or_object, 'Data');      // Arrays/objects auto-formatted
  ```
- **Log location**: `wp-content/debug.log`
- **Cleanup**: Remove all `write_log()` calls after debugging is complete. Debug logs must never remain in production code.
