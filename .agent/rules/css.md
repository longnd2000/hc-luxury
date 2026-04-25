---
description: CSS architecture, naming conventions, 4px grid system, typography, and global layout rules for LX Landing (Premium Elementor Kit System).
---

# CSS & UI Rules for LX Landing

## Project Philosophy
LX Landing là một **Premium Elementor Kit System**. Mục tiêu là tạo ra các Landing Page chuyên nghiệp, đồng bộ để demo và thương mại hóa. Mọi mã nguồn CSS phải đảm bảo tính thẩm mỹ cao và khả năng chống ghi đè tuyệt đối từ Elementor Kit mặc định.

## File Organization
- **General page styles**: `/assets/scss/layouts/` (Chứa các biến thể giao diện trang v1, v2...).
- **Widget styles (MANDATORY)**: `/assets/scss/widgets/{category}/_{name}.scss`.
- **Main entry point**: `main.scss`.

## Specificity & Anti-Override (CRITICAL)
- **Specificity Booster**: Toàn bộ styles trong `main.scss` phải được bọc trong block `body.elementor-page.elementor-default { ... }`.
- **Mandatory !important**: Sử dụng `!important` cho tất cả các thuộc tính Typography (font, size, weight, line-height, color) và Layout (padding, border, margin, border-radius) để thắng Elementor Kit CSS.

## Typography Standards
- **Font Control**: Sử dụng biến `$font-main` (từ Theme Settings) và áp dụng `!important` cho các widget cốt lõi (Nút, Tiêu đề, Text Editor) để đảm bảo đồng bộ font toàn trang.
- **Body Text**: `line-height: 1.5 !important`, `margin-bottom: 16px !important`.
- **Headings (H1-H6)**: `line-height: 1.3 !important`, `margin-bottom: 16px !important`, `margin-top: 0 !important`.

## Naming Conventions
- Use **snake_case** for all class names (e.g., `.lx_custom_container`).
- **Mandatory Prefixing**: Prefix all custom classes with **`lx_`**.
- **Unique Responsibility**: Mỗi class đại diện cho một thành phần duy nhất, tránh dùng chung class cho các mục đích khác nhau để dễ dàng ghi đè.

## Structural Rules
- **NO NESTING**: Không lồng các class con quá sâu trong SCSS. Giữ selector phẳng (Flat) để dễ quản lý độ ưu tiên.
- **Isolation Policy**: Không áp dụng style tùy biến vào các thẻ nội dung chung chung mà không có prefix `lx_`.

## Typography Scale (Responsive Heading)
Cách viết: **Mobile-first** — luôn dùng `min-width: 1200px` cho PC.

| Tag | Mặc định (mobile + tablet < 1200px) | PC (1200px+) |
|---|---|---|
| `h1` | 40px | 48px |
| `h2` | 32px | 40px |
| `h3` | 28px | 32px |
| `h4` | 24px | 28px |
| `h5` | 20px | 24px |
| `h6` | 18px | 20px |

## Bootstrap Grid
Chỉ sử dụng **Bootstrap Grid Only** cho việc chia cột trong PHP templates. Không sử dụng Bootstrap Grid bên trong Elementor Widget.
