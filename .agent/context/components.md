# Reusable Components

All components live in `/components/` — flat structure, one file per component.
See `rules/templates.md` for usage rules.

---

## `post_card.php`

**CSS Class**: `.cs_post_item`
**Type**: Requires parent variables (use `include()`)
**Used in**: `archive.php`, `search.php`, `single.php`, `category_section_widget.php`

**Expected Variables**:
| Variable | Type | Description |
|---|---|---|
| `$img` | string | Post thumbnail URL |
| `$title` | string | Post title |
| `$excerpt` | string | Trimmed excerpt |
| `$link` | string | Post permalink |
| `$categories` | array | WP category objects from `get_the_category()` |

---

## `event_card.php`

**CSS Class**: `.event_item`
**Type**: Requires parent variables (use `include()`)
**Used in**: `archive-event.php`, `event_widget.php`

**Expected Variables**:
| Variable | Type | Description |
|---|---|---|
| `$img` | string | Event thumbnail URL |
| `$title` | string | Event title |
| `$link` | string | Event permalink |
| `$month_num` | string | Month number for badge (e.g., '01') |
| `$day_num` | string | Day number for badge (e.g., '15') |
| `$date_range` | string | Formatted date range (e.g., '01/04/2026 - 05/04/2026') |
| `$location` | string | Event location (optional, from ACF) |
| `$status_text` | string | Status label (e.g., 'SẮP DIỄN RA') |
| `$status_class` | string | Status CSS class (upcoming\|active\|finished) |

---

## `sidebar_latest_posts.php`

**CSS Class**: `.lx_archive_sidebar_col`
**Type**: Self-contained (has own `WP_Query`)
**Used in**: `archive.php`, `archive-event.php`, `search.php`

**Expected Variables**: None — runs its own query for 5 latest posts.

**Include**:
```php
include(get_stylesheet_directory() . '/components/sidebar_latest_posts.php');
// or
get_template_part('components/sidebar_latest_posts');
```
