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
- **Section Wrapper**: Tất cả các widget dạng section phải được bọc trong cấu trúc:
  ```html
  <section class="lx_wrap">
      <div class="lx_con">
          <!-- Nội dung widget -->
      </div>
  </section>
  ```
- **Spacing**: `.lx_wrap` mặc định có `padding: 120px 4% !important`. `.lx_con` có `max-width: 1200px`.

## Slider UI Standards (Slick Slider)
Để đảm bảo tính nhất quán và không gây lỗi cuộn ngang, mọi slider phải tuân thủ:

### 1. Arrow Positioning (Nút điều hướng)
- **PC (> 1200px)**: `left/right: -40px` (nằm ngoài khung).
- **Tablet (768px - 1199px)**: `left/right: -16px` (thò ra một chút nhưng không gây scroll ngang).
- **Mobile (< 768px)**: `left/right: 10px` (nằm hẳn bên trong khung).
- **Hover Fix**: Luôn sử dụng `transform: translateY(-50%) scale(1.1) !important` để tránh lỗi "giật" nút.

### 2. Dot Spacing (Chấm phân trang)
- Khoảng cách mặc định: `bottom: -35px` đến `-50px`.
- Gap giữa các dots: `10px`.

### 3. Gutter Management (Khoảng cách Item)
- Slider container: `margin: 0 -15px !important` (hoặc con số tương ứng).
- Slider item: `padding: 0 15px !important`.
- **Lưu ý**: Phải bọc nội dung item trong một `div` trống bên ngoài để Slick không can thiệp vào layout của card.

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

## Breakpoints & Responsive Design
Tất cả các mốc responsive phải đồng bộ với thiết lập của Elementor và quy định của Bootstrap. Chúng ta gộp màn hình thành 3 mốc chính:
- **PC (>= 1200px):** Hiển thị mặc định (dùng code cơ bản, không nằm trong max-width media query).
- **Tablet (768px - 1199px):** Gộp chung màn hình Tablet và Laptop nhỏ.
- **Mobile (<= 767px):** Màn hình điện thoại.

### 1. Trong SCSS (Media Queries)
Sử dụng các biến đã khai báo trong `main.scss` (`$bp-mobile: 767px`, `$bp-laptop: 1200px`):
```scss
// 1. Tablet & Laptop nhỏ (dưới 1200px)
@media (max-width: #{$bp-laptop}) { ... }

// 2. Mobile (dưới 767px)
@media (max-width: #{$bp-mobile}) { ... }
```
*(Lưu ý: Bỏ qua điểm ngắt 1024px để giảm thiểu lượng code và dễ bảo trì).*

### 2. Trong PHP (Bootstrap Grid)
Chỉ sử dụng **Bootstrap Grid Only** cho việc chia cột trong PHP templates (không sử dụng trong Elementor Widget). Các class tương ứng với 3 mốc trên:
- **Mobile (< 768px):** Sử dụng `col-*` (vd: `col-12`).
- **Tablet (768px - 1199px):** Sử dụng `col-md-*`.
- **PC (>= 1200px):** Sử dụng `col-xl-*`.
*(Tuyệt đối bỏ qua và KHÔNG sử dụng các class `col-sm-*` hoặc `col-lg-*` để giữ cấu trúc chia cột đơn giản, thống nhất).*

## Consolidated Grid Patterns (Standard)
Để đảm bảo tính thẩm mỹ "Premium" và nhất quán cho toàn bộ Kit, mọi widget mới phải tuân thủ:

### 1. Gutters (Khoảng cách cột)
- Luôn sử dụng class `.lx_g32` thay vì `g-4` mặc định để có khoảng cách **32px** chuẩn giữa các item.
- Cấu trúc: `<div class="row lx_g32">`.

### 2. Section Header (Tiêu đề Section)
- Phần tiêu đề và mô tả (Header section) luôn căn giữa và chỉ chiếm **8 cột** trên PC để nội dung không bị quá dài, dễ đọc hơn.
- Cấu trúc: 
  ```html
  <div class="row justify-content-center">
      <div class="col-xl-8 lx_text_center">
          <h2 class="lx_heading">...</h2>
          <p>...</p>
      </div>
  </div>
  ```

### 3. Responsive Columns (Chia cột mặc định)
Trừ các trường hợp đặc biệt, cấu trúc chia cột chuẩn cho các grid (Lợi ích, Tính năng, Quy trình) là:
- **Mobile (< 768px):** 1 cột (`col-12`).
- **Tablet (768px - 1199px):** 2 cột (`col-md-6`).
- **PC (>= 1200px):** 4 cột (`col-xl-3`).
