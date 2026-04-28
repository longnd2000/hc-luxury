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
