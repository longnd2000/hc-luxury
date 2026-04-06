# Custom Post Types

## `event` (Event)

| Property | Value |
|---|---|
| **Slug** | `event` |
| **Archive** | `/event/` |
| **Supports** | title, editor, thumbnail, excerpt |
| **Hierarchical** | No |
| **Menu Icon** | `dashicons-calendar-alt` |
| **Menu Position** | 5 |
| **Registration** | `inc/post-types.php` → `child_theme_register_event_post_type()` |

### ACF Field Group
- **Event Details** (`group_event_details`)
  - `event_start_date` — Date Picker (d/m/Y, required)
  - `event_end_date` — Date Picker (d/m/Y, required)
  - `event_location` — Text (required)

### Templates
- `archive-event.php` — Event archive listing
- Uses component: `event_card.php`
