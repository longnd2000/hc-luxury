---
description: Frontend rules — data handling, output policy, asset standards, and iconography.
---

# Frontend Rules

## Data Handling & Validation
- **Strict Validation**: Always verify data existence before rendering associated HTML. If data (title, content, image, etc.) is missing, DO NOT render the container element.
- **Output Policy**: **DO NOT** use default WordPress escaping functions like `esc_html()`, `esc_url()`, or `esc_attr()`. Output raw variables directly.

## Date Formatting
- Standard format: `d/m/Y` (e.g., `15/12/2026`).
- Use this for ACF Date Picker settings and frontend displays.
- PHP Parsing: If using `strtotime()`, replace slashes with dashes: `str_replace('/', '-', $date)`.

## Image Standards
- Always use `<img>` tags with `alt`, `width`, and `height` attributes in HTML.
- CSS override: Use `width: 100% !important;` and `height: 100% !important;` for responsiveness.
- Aspect Ratio: Default is **4:3**.
- **No Dynamic Effects**: Images must remain static. No hover animations or transitions.

## Iconography
- Use **FontAwesome Free 6.x** (prefixes: `fas`, `far`, `fab`).
- Ensure consistent size/color within components via `_style.scss`.

## Contact Form 7
- Store form configuration code in `/form-ctf7/` (e.g., `form-tu-van.php`).
- Keep all CF7-related SCSS in `_ctf7.scss`. Ensure it is `@import`ed in `main.scss`.
