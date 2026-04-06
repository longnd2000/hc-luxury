---
description: ACF (Advanced Custom Fields) management and configuration rules.
---

# ACF Rules

## JSON Sync Only
Field groups must be managed via the WordPress Admin UI and synchronized through the `/acf-json` directory.

## No PHP Registration
Never use `acf_add_local_field_group()` in any PHP file. Register fields via JSON or Admin UI only.

## ACF Pro Version
Standardized version: **ACF Pro 6.2** for all custom field implementations.

## Field Verification
Always verify field existence before usage. If data (title, content, image, etc.) is missing, DO NOT render the container element.

```php
// ✅ Correct
$value = get_field('field_name');
if ($value) {
    echo '<div>' . $value . '</div>';
}

// ❌ Wrong — renders empty container
echo '<div>' . get_field('field_name') . '</div>';
```

## Date Format
- Standard format: `d/m/Y` (e.g., `15/12/2026`).
- Use this for ACF Date Picker settings (`display_format` and `return_format`).
- PHP Parsing: If using `strtotime()`, replace slashes with dashes: `str_replace('/', '-', $date)`.
