---
description: CSS architecture, naming conventions, 4px grid system, typography, and global layout rules.
---

# CSS Rules

## File Organization
- **General page styles**: `/assets/scss/layouts/` (Chứa các biến thể giao diện trang v1, v2... được import tùy theo layout chọn trong admin).
- **Plugin custom styles**: `/assets/scss/plugins/`.
- **Widget styles (MANDATORY)**: `/assets/scss/widgets/{category}/_{name}.scss`.

- **Main entry point**: `main.scss`.



## Naming Conventions
- Use **snake_case** for all class names (e.g., `.lx_custom_container`).
- **Mandatory Prefixing**: Avoid generic class names. Prefix all custom classes with **`lx_`** (e.g., `.lx_archive_page_title`) to prevent conflicts.
- **Unique Responsibility**: Each class should have a specific, unique name that describes its role, similar to how an ID is used. This prevents style bleeding and makes overrides easier.

## Structural Rules (Mandatory)
- **NO NESTING**: Do not nest child classes inside parent classes in SCSS. All classes must be defined at the top level of the stylesheet to ensure they are independent and easy to modify.
- **Class Reuse**: Only reuse existing classes if the style is identical and intended to stay synchronized across different components. Otherwise, create a unique class.

## Isolation Policy
- Never apply custom styles to internal content tags (e.g., inside `the_content()`, `.lx_entry_content`). Maintain natural rendering for third-party plugin compatibility.

## The 4px Grid System
- **Core Requirement**: All spacing and typographic sizes MUST be multiples of 4 (4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, etc.).

## Typography Standards
- **Body Text**: `line-height: 1.5 !important`.
- **Headings (H1-H6)**: `line-height: 1.3 !important`.
- **Mandatory !important**: Mọi thuộc tính Typography (font-family, size, weight, line-height, color) và Layout (padding, border, border-radius) của theme **BẮT BUỘC** phải có `!important` để đè bẹp CSS mặc định của Elementor Kit.
- Use the `body { ... }` wrapper in `main.scss` as a specificity booster to override Elementor base styles.


## Typography Scale (Responsive Heading)

Cách viết: **Mobile-first** — luôn dùng `min-width`, không dùng `max-width`.

**2 tầng:**
- **Mặc định** (mobile + tablet, < 1200px): size nhỏ
- **PC**: `@media (min-width: 1200px)`: size lớn

| Tag | Mặc định (mobile + tablet) | PC (1200px+) |
|---|---|---|
| `h1` | 40px | 48px |
| `h2` | 32px | 40px |
| `h3` | 28px | 32px |
| `h4` | 24px | 28px |
| `h5` | 20px | 24px |
| `h6` | 18px | 20px |

- Body Text: 16px (mặc định) | Small: 12px.
- Màu chữ mặc định: `#000000`.

## Heading Hierarchy (Bắt buộc)
- `h1`: Tiêu đề trang (chỉ một `h1` mỗi trang, dùng cho SEO).
- `h2`: Tiêu đề section (tiêu đề sidebar widget, archive section, widget header).
- `h3`: Tiêu đề item trong danh sách (post card, event item, sidebar post).
- `h4`: Phụ tiêu đề (supplementary heading trong card hoặc section).

## Contextual Font-Size Overrides (List/Grid Context)
- Post/event title in list/grid: `16px` (overrides default h3 scale of 24px for visual balance within cards).
- Description/excerpt in list/grid: `12px`.
- These overrides are intentional — the heading tag (`h3`) is kept for semantic/SEO purposes, but the visual size is reduced to fit card layouts.

## Heading Consistency
When changing heading tags (`h1`-`h6`) in PHP, immediately update the corresponding CSS `font-size` in `_style.scss` to match the scale above, unless a contextual override applies.

## Global Layout Classes
- `.section_box`: Padding wrapper (`width: 100%`, `padding: 0 4%`).
- `.py_section`: Vertical spacing (`padding: 80px 0`).
- `.container`: Limits content width to `1200px` and centers it.
- **Usage Restriction**: Do not use these global layout classes inside Elementor Widgets or Shortcodes.

## Font Inheritance
**NEVER** declare `font-family` in any SCSS file. Fonts are managed centrally by **Elementor**. Inherit or use the global config.

## Bootstrap Grid (chỉ dùng Grid)
Dự án load **Bootstrap Grid Only** (`bootstrap-grid.min.css`) — không phải full Bootstrap.

### ✅ Được phép dùng
Chỉ sử dụng các class thuộc hệ lưới (layout grid):

| Nhóm | Class mẫu |
|---|---|
| Container | `.container`, `.container-fluid`, `.container-{sm│md│lg│xl│xxl}` |
| Hàng | `.row`, `.row-cols-{n}`, `.row-cols-{bp}-{n}` |
| Cột | `.col`, `.col-{n}`, `.col-{bp}-{n}`, `.col-auto` |
| Khoảng cách cột | `.g-{n}`, `.gx-{n}`, `.gy-{n}`, `.g-{bp}-{n}` |
| Căn chỉnh ngang | `.justify-content-{start│end│center│between│around│evenly}` |
| Căn chỉnh dọc | `.align-items-{start│end│center│baseline│stretch}` |
| Căn chỉnh cột đơn | `.align-self-{start│end│center│baseline│stretch}` |
| Sắp xếp | `.order-{n}`, `.order-{bp}-{n}` |
| Ẩn/hiện theo breakpoint | `.d-none`, `.d-{bp}-block`, `.d-{bp}-flex` (chỉ dùng kết hợp lưới) |

### ❌ Không được phép
Chỉ có `bootstrap-grid.min.css` được load, các class sau **không có hiệu lực** và **không được viết vào code**:
- Utility classes: `.mt-*`, `.mb-*`, `.p-*`, `.px-*`, `.py-*`, `.text-*`, `.bg-*`, `.fw-*`...
- Component classes: `.btn`, `.card`, `.navbar`, `.modal`, `.badge`, `.alert`...
- Typography classes: `.fs-*`, `.lh-*`, `.font-*`...
- Color/theme classes: `.text-primary`, `.bg-success`...

### Quy tắc áp dụng
- Dùng Bootstrap Grid cho **layout chia cột** giữa các khối nội dung.
- Mọi style về màu sắc, spacing, typography vẫn dùng **class `lx_` riêng**.
- Không sử dụng Bootstrap Grid bên trong **Elementor Widget** — Elementor tự quản lý layout cột; chỉ dùng trong **PHP templates** và **components**.
