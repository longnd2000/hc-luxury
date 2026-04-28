# Custom Elementor Widgets

All widget files live in `widgets/template/`.
Registered in `widgets/index.php` via `elementor/widgets/register` hook.

See `rules/elementor.md` for development standards and category reference table.
Master template: `duplicate_widget.php`.

---

## Widget Categories

Registered in `widgets/index.php` → `child_theme_register_widget_categories()`.

| Slug | Label |
|---|---|
| `lx_banner` | LX — Banner |
| `lx_khach_hang` | LX — Khách hàng |
| `lx_doi_tac` | LX — Đối tác |
| `lx_van_de` | LX — Vấn đề |
| `lx_giai_phap` | LX — Giải pháp |
| `lx_loi_ich` | LX — Lợi ích |
| `lx_tinh_nang` | LX — Tính năng |
| `lx_dich_vu` | LX — Dịch vụ |
| `lx_quy_trinh` | LX — Quy trình |
| `lx_danh_gia` | LX — Đánh giá |
| `lx_bang_gia` | LX — Bảng giá |
| `lx_faqs` | LX — FAQs |
| `lx_cta` | LX — CTA |
| `lx_lien_he` | LX — Liên hệ |

---

## Active Widgets

| Class Name | File | Category | Description |
|---|---|---|---|
| `Image_Gallery_Widget` | `image_gallery_widget.php` | `lx_media` → reassign as needed | Image gallery display |
| `LX_Video_Reviews_Widget` | `lx_video_reviews.php` | `lx_danh_gia` | Video reviews/testimonials slider |
| `LX_Why_Choose_Us_Widget` | `lx_why_choose_us.php` | `lx_loi_ich` | "Why Choose Us" section with icons and numbers |
| `featured_posts_widget` | `featured_posts_widget.php` | `lx_dich_vu` | Featured posts display |
| `category_section_widget` | `category_section_widget.php` | `lx_dich_vu` | Category section with posts |
| `event_widget` | `event_widget.php` | `lx_dich_vu` | Event listing widget |

> ⚠️ Widgets cũ (`Image_Gallery_Widget`) đang dùng category tạm. Cập nhật `get_categories()` trong từng file widget để khớp đúng slug.

---

## Templates (Non-Widget)

| File | Description |
|---|---|
| `duplicate_widget.php` | Master template for creating new widgets |
| `template_file.php` | General template file |
| `widget_table.php` | Table display widget |

