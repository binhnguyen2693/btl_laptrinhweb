# Trạng thái hệ thống Nhịp Khoa

## Flow đang hoạt động

1. Khách xem trang chủ và chi tiết các bài đã xuất bản.
2. Người đăng ký mới luôn nhận vai trò Độc giả.
3. Đăng nhập chuyển trang theo vai trò.
4. Tác giả tạo bài nháp, sửa bài của mình và gửi duyệt.
5. Biên tập viên hoặc Admin duyệt/từ chối bài đang chờ.
6. Bài được duyệt chuyển thành `published` và tự xuất hiện trên trang chủ.
7. Admin quản lý tài khoản, vai trò, khóa/mở khóa và truy cập quản lý bài.

## Đã hoàn thành

- Kết nối PDO, session, đăng ký, đăng nhập, đăng xuất và CSRF.
- Phân quyền Admin, Biên tập viên, Tác giả và Độc giả ở phía server.
- Trang chủ, header/footer, responsive và menu mobile.
- Dashboard Admin và quản lý tài khoản.
- Dashboard Tác giả, tạo/sửa/xem/danh sách bài cá nhân.
- Dashboard Biên tập viên, danh sách và duyệt/từ chối bài.
- Trang chi tiết công khai chỉ cho bài `published`.
- Cấu hình database riêng theo từng máy và migration chung.

## Đang chờ branch khác

- Danh sách bài theo Tin khoa/Học tập/Cơ hội/Sự kiện.
- Tìm kiếm server-side và phân trang thật.
- Chi tiết “Thay đổi đáng chú ý”.
- Impact Box/lưu bài.
- Bình luận và quản lý bình luận.
- Quản lý chuyên mục trong Admin.

Các liên kết chờ tích hợp phải dẫn tới `dang-phat-trien.php`; không dùng `href="#"`.
Sau khi merge chức năng thật, thay liên kết chờ bằng URL tương ứng và kiểm tra lại role.

## Checklist trước khi merge main

- Import `schema.sql`, `seed.sql` và migration trên database sạch.
- Thử đăng nhập đủ bốn role và thử truy cập chéo để xác nhận HTTP 403.
- Tạo bài bằng Tác giả, gửi duyệt, duyệt bằng Biên tập viên và kiểm tra trang chủ.
- Kiểm tra khóa tài khoản đang đăng nhập và đăng nhập lại.
- Kiểm tra tìm kiếm, phân trang, trạng thái rỗng và bài không tồn tại.
- Tìm toàn dự án để bảo đảm không còn `href="#"` ngoài nội dung có chủ đích.
- Kiểm tra desktop, tablet và mobile.
