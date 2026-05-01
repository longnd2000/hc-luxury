---
description: Elementor widget development standards and specificity rules.
---

# Elementor Rules

## Widget Templates
Follow the structure of `widgets/template/duplicate_widget.php` as the master template for all new widgets.

## Widget Class Conventions
- Use `snake_case` for widget class names.
- Required methods: `get_name()`, `get_title()`, `get_icon()`, `get_categories()`.
- Use `_register_controls()` for settings and `render()` for frontend output.
- Implement JS logic using the `elementor/frontend/init` hook (refer to the jQuery pattern in `duplicate_widget.php`).

## Naming Conventions
- **Naming Rule**: Widgets must be named based on their **Vietnamese Category Name** followed by a version suffix (V1, V2, V3, etc.).
- **Consistency**: This ensures clarity for the end-user and a predictable file structure for developers.
- **Title Format**: `LX — {Vietnamese Label} V{Number}` (e.g., `LX — Số liệu V1`).
- **Slug/Name Format**: `lx_{vietnamese_slug}_v{number}` (e.g., `lx_so_lieu_v1`).
- **File Name**: `lx_{vietnamese_slug}_v{number}.php`.
- **Class Name**: `LX_{Vietnamese_Slug}_V{Number}_Widget`.

## Widget Registration
- **File Location**: Widget files MUST live in subfolders corresponding to their category: `widgets/template/{lx_category_slug}/{widget_name}.php`.
- **Registration**: Register in `widgets/index.php` using `$widgets_manager->register(new \Widget_Class())`.
- **Categorization**: Assign to one of the 17 **LX Business Categories** below.


| Slug | Label | Dùng cho |
|---|---|---|
| `lx_banner` | LX — Banner | Hero banners, slider chính |
| `lx_khach_hang` | LX — Khách hàng | Logo khách hàng, testimonial logos |
| `lx_doi_tac` | LX — Đối tác | Logo đối tác, partner grid |
| `lx_van_de` | LX — Vấn đề | Pain points, problem statements |
| `lx_giai_phap` | LX — Giải pháp | Solution sections |
| `lx_loi_ich` | LX — Lợi ích | Benefits, why-us sections |
| `lx_tinh_nang` | LX — Tính năng | Feature lists, feature grids |
| `lx_dich_vu` | LX — Dịch vụ | Service cards, service lists |
| `lx_quy_trinh` | LX — Quy trình | Process steps, timelines |
| `lx_danh_gia` | LX — Đánh giá | Reviews, testimonials, ratings |
| `lx_bang_gia` | LX — Bảng giá | Pricing tables, plan cards |
| `lx_faqs` | LX — FAQs | Accordion FAQs |
| `lx_cta` | LX — CTA | Call-to-action banners |
| `lx_lien_he` | LX — Liên hệ | Contact forms, maps, contact info |
| `lx_dynamic` | LX — Năng động | Theme Builder (Single, Archive, Search) |


## Strict CSS Isolation (UI Kit Strategy)
- This theme is built as a highly reusable **UI Kit**.
- **NO ELEMENTOR STYLING CONTROLS**: Do **NOT** add controls for Typography, Color, Margin, or Padding in the widget's PHP file.
- All styles must be defined using strict SCSS classes starting with the `lx_` prefix (e.g., `lx_card`, `lx_title_primary`).
- Elementor's sole purpose is to provide the content input (Text, Images, Toggles) and act as a structural drag-and-drop wrapper.

## Slider Configuration (JS)
- **Synchronization**: `slidesToScroll` phải luôn bằng `slidesToShow` ở mọi breakpoint để đảm bảo hiệu ứng trượt khớp với số lượng item hiển thị.
- **Initialization**: Luôn sử dụng lệnh `unslick` trước khi khởi tạo lại trong Elementor Editor.
- **Hooks**: Sử dụng `elementorFrontend.hooks.addAction('frontend/element_ready/...')` thay vì `$(window).on('load')`.

## Specificity Override
Elementor injects global heading styles via `.elementor-kit-{id} h1-h6` selectors (specificity `0,1,1`), which override single-class selectors (specificity `0,1,0`). When custom `font-size` or `font-weight` on heading elements is being overridden by Elementor, use `!important` to enforce. This applies to all custom heading classes inside Elementor widget templates and theme templates.

## Layout Restriction
Do **NOT** use global layout classes (`.section_box`, `.py_section`, `.container`) inside Elementor Widgets or Shortcodes.
