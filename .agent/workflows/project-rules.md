---
description: Project coding standards and rules
---

# Project Rules & Standards

These rules must be followed for all future tasks in this project:

## 1. Image Handling
- Always use the `<img>` tag for images.
- Must include `alt`, `width`, and `height` attributes in HTML.
- In CSS, images must have `width: 100% !important;` and `height: 100% !important;` (or as appropriate) to override HTML attributes.
- Images should follow a fixed aspect ratio. Default is **4:3** unless specifically requested otherwise.
- **No CSS Effects**: Images must remain static. Do not add any hover animations, transitions, or scaling effects to images.

## 2. Widget Creation
- When creating a new widget, always follow the format and structure of `duplicate_widget.php` as the standard template.
- Path: `widgets/template/`

## 3. CSS Standards
- All CSS for the project must be added to `/assets/scss/_style.scss`.
- CSS class names must follow the **snake_case** format (e.g., `.my_custom_class`).

## 4. PHP Functions & Hooks
- All custom PHP functions, actions, and filters must be placed in `functions.php`.

## 5. Coding Practices
- **Do NOT** use default WordPress escaping functions such as `esc_html()`, `esc_url()`, `esc_attr()`, etc. Output variables directly.
- **Strict Data Validation**: Always check if data exists or is non-empty before rendering its associated HTML. If data is missing (e.g., empty title, empty content, or no image), the entire container or tag for that data should not be displayed on the frontend.

## 6. Typography & Colors
- **Headings (Multiples of 4)**:
  - `h1`: 32px
  - `h2`: 28px
  - `h3`: 24px
  - `h4`: 20px
  - `h5`: 16px
  - `h6`: 12px
- **Standard Text**: 16px (default)
- **Smaller Text**: 12px, 8px (as needed)
- **Default Text Color**: `#000000` (unless specified otherwise)

## 7. Heading Consistency
- Whenever a heading tag (`h1`-`h6`) is changed in PHP templates, the tương ứng CSS `font-size` for that class must be updated immediately in `_style.scss` to match the sizes defined in Rule 6. Do not leave font-sizes from previous heading levels.

## 8. ACF Pro 6.2 Standards
- Use **ACF Pro 6.2** for all custom fields.
- Field groups must be synchronized via the `/acf-json` directory.
- All custom fields used in widgets must be checked for existence before rendering, following Rule 5.

## 9. Iconography Standard
- Use **FontAwesome Free 6.x** for all icons.
- Common prefixes: `fas` (solid), `far` (regular), `fab` (brands).
- Icons should be consistent in size and color within components (e.g., using `16px` width for alignment in `_style.scss`).

## 10. Elementor Specifics (from duplicate_widget.php)
- Class names for widgets should be snake_case.
- Include necessary `get_name()`, `get_title()`, `get_icon()`, and `get_categories()`.
- Use `_register_controls()` for settings.
- Use `render()` for output.
- If JS is needed, follow the jQuery pattern in `duplicate_widget.php` using the `elementor/frontend/init` hook.

## 11. Standard Date Format
- Use the **`d/m/Y`** format for all date inputs and displays (e.g., `15/12/2026`).
- This applies to ACF Date Picker settings and frontend PHP rendering.
- For PHP parsing, use `str_replace('/', '-', $date)` before `strtotime()` to ensure correct day-month interpretation.

## 12. Global Layout Standard
- **`.section_box`**: Structural padding wrapper.
  - `width: 100%`, `padding: 0 4%`, `box-sizing: border-box`.
- **`.py_section`**: Vertical spacing wrapper.
  - `padding: 80px 0` (top and bottom).
- **Usage Rule**:
  - **USE** `.section_box` và **`.py_section`** thường kết hợp cùng nhau trên thẻ ngoài cùng (thẻ `<section>` hoặc `<main>`) để bao quát toàn bộ padding của một khối (Trên/Dưới 80px, Trái/Phải 4%).
  - **`.container`**: Luôn nằm trong cùng để giới hạn độ rộng nội dung tối đa 1200px và căn giữa.
  - **KHÔNG sử dụng** các class này trong **Elementor widgets** hoặc **Shortcodes**.
- These styles are defined in `main.scss` for global project use.

## 13. Font Usage Standard
- **TUYỆT ĐỐI KHÔNG** khai báo `font-family` trong bất kỳ file SCSS nào (kể cả `inherit`).
- Sử dụng các font đã được cấu hình và quản lý tập trung bởi **Elementor**.
- Việc tự ý thêm `font-family` sẽ làm mất tính đồng nhất của thiết kế và gây khó khăn khi thay đổi font chữ toàn trang.

## 14. CSS Naming Convention (Prefixing)
- **TUYỆT ĐỐI KHÔNG** sử dụng các tên class mặc định của WordPress (như `.entry-title`, `.post-content`, `.author-meta`...) hoặc của các thư viện bên thứ ba khi viết code template/shortcode.
- **QUY TẮC**: Tất cả các class phải có tiền tố riêng (ví dụ: `child-theme_`) để tránh xung đột hoặc bị ghi đè CSS bởi các plugin khác.
- Ví dụ: Thay vì `.post_breadcrumbs`, hãy dùng `.child-theme_post_breadcrumbs`.

## 15. Minimal Framework Functions & Content Styling
- **Hạn chế tối đa** việc sử dụng các hàm thoát dữ liệu mặc định của WP như `esc_url()`, `esc_html()`, `esc_attr()`...
- **BẮT BUỘC**: Tất cả các đoạn văn bản (text) cố định trong file code phải được đưa vào hàm dịch `__('Text', 'child-theme')` với Text Domain là `child-theme`.
- **TUYỆT ĐỐI KHÔNG** tự ý viết CSS can thiệp vào các thẻ bên trong vùng nội dung bài viết (`the_content()`, `.lx_entry_content`, `.lx_post_body`...). Hãy để nội dung hiển thị ở mức tự nhiên nhất để tương thích tốt với các plugin khác (như mục lục, quảng cáo, table...).

## 16. ACF Field Management (JSON Sync Only)
- **TUYỆT ĐỐI KHÔNG** sử dụng hàm `acf_add_local_field_group()` để đăng ký field bằng PHP trong `functions.php`.
- **QUY TẮC**: Mọi thay đổi hoặc tạo mới ACF Field Group phải được thực hiện thông qua giao diện Admin và lưu trữ vào thư mục `acf-json`. Nếu cần tạo bằng code, hãy tạo trực tiếp file `.json` đúng định dạng vào thư mục này để đảm bảo tính đồng bộ (Sync) và dễ quản lý.

## 17. Contact Form 7 Standards
- **Form Code Storage**: Tất cả mã nguồn cấu hình form (form tag/template) phải được lưu trữ thành các file riêng biệt trong thư mục `/form-ctf7/` (ví dụ: `contact-home.php`) để dễ quản lý và tránh trùng lặp.
- **CSS Organization**: 
    - Tất cả các tùy chỉnh CSS liên quan đến Contact Form 7 **BẮT BUỘC** phải được đặt trong file chuyên biệt `assets/scss/_ctf7.scss`.
    - **TUYỆT ĐỐI KHÔNG** thêm CSS của CF7 vào file `_style.scss`.
    - Đảm bảo file `_ctf7.scss` đã được `@import` trong `main.scss`.

## 18. 4px Grid System
- **QUY TẮC BẮT BUỘC**: Tất cả các giá trị kích thước liên quan đến không gian và typographic **PHẢI** là bội số của 4 (4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, ...).
- Các thuộc tính áp dụng bao gồm nhưng không giới hạn ở: `font-size`, `margin`, `padding`, `gap`, `border-radius`, `top/bottom/left/right` (khi dùng absolute/relative), `letter-spacing` (nếu dùng px).
- Việc tuân thủ bội số của 4 giúp giao diện đạt được tỷ lệ vàng trong thiết kế hiện đại, tăng tính chuyên nghiệp và tính nhất quán cho toàn bộ dự án.