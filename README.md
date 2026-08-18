# Bài tập lớn Lập trình web

## Đề tài

Nhóm chọn đề tài **Website tin tức/blog có trang quản trị**.

Website dự kiến có phần xem bài viết cho người dùng và phần quản trị để nhóm
có thể thêm, sửa, xóa bài viết.

## Thành viên

| MSSV | Họ và tên |
| --- | --- |
| 224001812 | Khổng Thị Lý |
| 224001828 | Trần Hà Như Quỳnh |
| 224001819 | Trần Nguyễn Bình Nguyên |
| 224001843 | Đặng Ánh Tuyết |

## Chức năng dự kiến

- Xem danh sách và chi tiết bài viết.
- Xem bài viết theo danh mục.
- Tìm kiếm bài viết.
- Đăng nhập trang quản trị.
- Thêm, sửa, xóa bài viết và danh mục.

## Công nghệ sử dụng

- HTML, CSS, JavaScript.
- PHP và MySQL.
- XAMPP.

## Phát triển form đăng nhập - Buổi 3

Phần đăng nhập do Trần Nguyễn Bình Nguyên thực hiện trên branch
`binhnguyen-dangnhap`, phát triển trực tiếp từ cấu trúc ban đầu của `main`.

- Route: `GET|POST /dang-nhap.php`.
- Email bắt buộc, đúng định dạng và không quá 254 ký tự.
- Mật khẩu bắt buộc, từ 8 đến 72 ký tự.
- Hiển thị lỗi tại trường tương ứng và giữ lại email khi form có lỗi.
- Không giữ lại mật khẩu sau khi gửi form.
- Dùng `htmlspecialchars()` để mã hóa dữ liệu khi hiển thị.
- Dùng `password_verify()` để kiểm tra mật khẩu đã hash.
- Dùng session để giữ trạng thái đăng nhập và hỗ trợ đăng xuất.
- Chưa sử dụng cơ sở dữ liệu.

Tài khoản thử nghiệm:

```text
Email: admin@storyhub.vn
Mật khẩu: Admin@123
```

## Cấu trúc thư mục

```text
btl_laptrinhweb/
├── index.php
├── about.php
├── dang-nhap.php
├── admin/
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
├── config/
├── database/
└── includes/
```

## Cách chạy trên máy

1. Cài XAMPP.
2. Tải project về và đặt thư mục vào `C:\xampp\htdocs`.
3. Mở XAMPP rồi bật Apache. Khi có database thì bật thêm MySQL.
4. Mở trình duyệt và truy cập:

   ```text
   http://localhost/btl_laptrinhweb/
   ```

5. Trang giới thiệu nhóm:

   ```text
   http://localhost/btl_laptrinhweb/about.php
   ```

6. Trang đăng nhập:

   ```text
   http://localhost/btl_laptrinhweb/dang-nhap.php
   ```

Hiện tại nhóm mới tạo cấu trúc ban đầu và trang giới thiệu. Các chức năng khác
sẽ được bổ sung trong quá trình làm bài tập lớn.

