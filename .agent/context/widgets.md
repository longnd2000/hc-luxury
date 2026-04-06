# Custom Elementor Widgets

All widget files live in `widgets/template/`.
Registered in `widgets/index.php` via `elementor/widgets/register` hook.
Custom category: `custom_widgets_theme`.

See `rules/elementor.md` for development standards.
Master template: `duplicate_widget.php`.

---

## Active Widgets

| Class Name | File | Description |
|---|---|---|
| `Image_Gallery_Widget` | `image_gallery_widget.php` | Image gallery display |
| `Youtube_Iframe_Slider_Widget` | `youtube_iframe_slider.php` | YouTube video slider |
| `Company_Highlight_Widget` | `company_highlight_widget.php` | Company highlights section |
| `featured_posts_widget` | `featured_posts_widget.php` | Featured posts display |
| `category_section_widget` | `category_section_widget.php` | Category section with posts |
| `event_widget` | `event_widget.php` | Event listing widget |

## Templates (Non-Widget)

| File | Description |
|---|---|
| `duplicate_widget.php` | Master template for creating new widgets |
| `template_file.php` | General template file |
| `widget_table.php` | Table display widget |
