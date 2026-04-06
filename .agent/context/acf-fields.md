# ACF Field Groups

All field groups are synced via `/acf-json/`. Never register via PHP.

---

## Event Details (`group_event_details`)

**Location**: Post Type = `event`

| Field Name | Field Key | Type | Required | Format |
|---|---|---|---|---|
| `event_start_date` | `field_660d5e941e2c4` | Date Picker | Yes | d/m/Y |
| `event_end_date` | `field_660d5ea11e2c5` | Date Picker | Yes | d/m/Y |
| `event_location` | `field_660d5ead1e2c6` | Text | Yes | — |

**Usage**:
```php
$start = get_field('event_start_date');
$end   = get_field('event_end_date');
$loc   = get_field('event_location');
```

---

## User Social Links (`group_user_social_links`)

**Location**: User Form = All

| Field Name | Field Key | Type | Required |
|---|---|---|---|
| `lx_user_avatar` | `field_660d7b0b1e2cb` | Image (URL) | No |
| `lx_user_facebook` | `field_660d6a141e2c8` | URL | No |
| `lx_user_youtube` | `field_660d6a211e2c9` | URL | No |
| `lx_user_zalo` | `field_660d6a2d1e2ca` | Text | No |

**Usage**:
```php
$avatar   = get_field('lx_user_avatar', 'user_' . $user_id);
$facebook = get_field('lx_user_facebook', 'user_' . $user_id);
$youtube  = get_field('lx_user_youtube', 'user_' . $user_id);
$zalo     = get_field('lx_user_zalo', 'user_' . $user_id);
```
