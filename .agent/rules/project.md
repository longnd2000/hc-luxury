# Triết lý Dự án: LX Landing

## 1. Mục tiêu (Project Goal)
Xây dựng một "Elementor Kit" cao cấp phục vụ việc tạo Landing Page siêu tốc, demo khách hàng và kinh doanh giao diện. Dự án tập trung vào tính thẩm mỹ, hiệu năng và sự đồng bộ tuyệt đối.

## 2. Nguyên tắc thiết kế (Design Principles)
- **Premium Aesthetics**: UI/UX phải mang lại cảm giác sang trọng, hiện đại. Ưu tiên các micro-interaction mượt mà.
- **Global Control Over Local Style**: Kiểu dáng của mọi Widget (Nút, Tiêu đề, Văn bản) phải được kiểm soát từ Theme Settings. Hạn chế tối đa việc cài đặt style thủ công trong từng Widget Elementor.
- **Granular Widgets**: Chia nhỏ các thành phần thành các Widget chuyên biệt (ví dụ: LX Archive Title, LX Post Content) để tăng khả năng tùy biến Layout trong Elementor Pro Theme Builder.

## 3. Chống ghi đè (Anti-Override)
- **Nuclear Specificity**: Do Elementor Kit có độ ưu tiên cao, mọi CSS cốt lõi của theme **BẮT BUỘC** sử dụng `!important` và bọc trong selector `body.elementor-page.elementor-default`.
- **Clean Base**: Dequeue các tệp CSS rác của Elementor Kit để giữ cho giao diện luôn sạch sẽ theo đúng ý đồ của theme.

## 4. Phát triển UI mới
Luôn sẵn sàng cập nhật các UI Trend mới nhất vào hệ thống Widget để đa dạng hóa kho thành phần, giúp người dùng có nhiều lựa chọn để tạo ra các trang demo ấn tượng.

## 5. Ngôn ngữ & Trải nghiệm Người dùng (Localization)
- **Tiếng Việt là Mặc định**: Đây là Theme dành riêng cho người dùng Việt Nam. Toàn bộ các text mặc định (default text) hiển thị ra ngoài Frontend hoặc hiển thị trong màn hình Quản trị (ví dụ: "Liên hệ", "Tìm hiểu thêm", "Đọc tiếp"...) **BẮT BUỘC** phải được sử dụng bằng Tiếng Việt để đảm bảo trải nghiệm tốt nhất và dễ hiểu nhất cho khách hàng.

## 6. Bố cục & Hệ thống Grid (Layout & Grid)
- **Sử dụng Bootstrap Grid**: Khuyến khích sử dụng hệ thống Grid của Bootstrap (`.row`, `.col-*`) bên trong các Widget để phân chia cột nhanh chóng và đồng bộ.
- **TUYỆT ĐỐI KHÔNG dùng .container**: Không được sử dụng class `.container` hoặc `.container-fluid` bên trong mã nguồn của Widget.
- **Tiêu chuẩn Container & Spacing (.lx_wrap & .lx_con)**:
    - **.lx_wrap**: Lớp bao ngoài của Section/Widget, quy định khoảng cách đệm: **Padding: 120px 4% !important**.
    - **.lx_con**: Lớp khung nội dung nằm trực tiếp sau `.lx_wrap`, quy định độ rộng tối đa: **max-width: 1200px !important** và căn giữa **margin: 0 auto !important**.
    - Cấu trúc chuẩn: `<section class="lx_wrap"><div class="lx_con"><div class="row">...</div></div></section>`.
- **Quy chuẩn Typography dùng chung (Shared Classes)**:
    - **Tiêu đề Section**: Sử dụng cặp lớp `.lx_heading.lx_heading_h2` (hoặc `h1-h6` tương ứng) để đảm bảo tính nhất quán về font-size, line-height và màu sắc trên toàn trang.
    - **Nội dung văn bản (WYSIWYG)**: Sử dụng lớp `.lx_text_editor` bọc ngoài phần nội dung trả về từ trình soạn thảo văn bản. Lớp này quản lý font-size (16px), line-height (1.5), màu sắc và định dạng cho link/list chuẩn theme.
- **Quy tắc Slick Slider**: Khi sử dụng Slick Slider, các item bên trong vòng lặp `foreach` BẮT BUỘC phải được bọc trong một thẻ `div` trung gian (ví dụ: `.lx_slider_item`). Thẻ `div` này đóng vai trò là "container" cho Slick tính toán kích thước, tránh việc các class của Slick (`slick-slide`, `slick-active`) bị ghi đè hoặc xung đột trực tiếp với các class CSS tùy chỉnh của item.
