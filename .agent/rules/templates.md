---
description: Template component reusability rules — /components directory standards.
---

# Template & Component Rules

## Component Reusability (Mandatory)
Any UI block (markup) that is repeated across 2+ templates or widgets MUST be extracted into a standalone PHP partial file in the `/components` directory.

## Directory
`child-theme/components/` — flat structure, one file per component.

## Naming
`{component_name}.php` using `snake_case` (e.g., `post_card.php`, `sidebar_latest_posts.php`, `event_card.php`).

## Usage — Variable Scope Rule (CRITICAL)

### Component relying on local variables (e.g., inside a loop)
You **MUST** use `include(get_stylesheet_directory() . '/components/{name}.php');`.
This applies to both theme templates and Elementor widgets. Using `include` ensures the component inherits the local variables (like `$img`, `$title`, `$link`) defined in the parent scope.

### Self-contained components
If the component is completely self-contained (e.g., it runs its own `WP_Query` like `sidebar_latest_posts` and doesn't need parent variables), you may use `get_template_part('components/{name}');` or `include()`.

### Why not always `get_template_part`?
Under the hood, WordPress uses `load_template()` which isolates the variable scope. If you define `$title = get_the_title();` in an `archive.php` loop, that variable physically will not exist inside the component file if loaded via `get_template_part()`, throwing "Undefined variable" fatal warnings. Always default to `include()` when passing loop data.

## Data Contract
Each component file must document its expected variables at the top in a comment block:
```php
<?php
/**
 * Component: Post Card (cs_post_item)
 * Expected variables: $img, $title, $excerpt, $link, $categories
 */
?>
```

## Scope
Components only contain HTML markup and conditionals. They must NOT contain `WP_Query`, loops, or business logic — the parent template handles data fetching and passes variables to the component.

**Exception**: Self-contained components (like `sidebar_latest_posts.php`) may include their own `WP_Query` if they are designed to work independently.
