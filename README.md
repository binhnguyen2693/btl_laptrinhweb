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
- Bình luận và quản lý bình luận.
- Lưu bài viết vào Impact Box và thêm ghi chú.

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
- Form hiện vẫn dùng tài khoản mẫu để kiểm tra validation. CSDL cho tài khoản
  đã được thiết kế ở Buổi 4 và sẽ được kết nối với PHP ở bước tiếp theo.

Tài khoản thử nghiệm:

```text
Email: admin@nhipkhoa.vn
Mật khẩu: Admin@123
```

## Thiết kế CSDL - Buổi 4

CSDL `nhip_khoa` gồm 6 bảng chính:

- `roles`, `users`: tài khoản và phân quyền.
- `categories`, `posts`: danh mục, nội dung và quy trình duyệt bài.
- `comments`: bình luận và trạng thái kiểm duyệt.
- `impact_box_items`: bài viết người dùng đã lưu kèm ghi chú.

ERD và mô tả quan hệ: [`database/erd.md`](database/erd.md).

Các file chạy CSDL:

- [`database/schema.sql`](database/schema.sql): tạo database, bảng và ràng buộc.
- [`database/seed.sql`](database/seed.sql): dữ liệu thử bằng tiếng Việt.

Phần thiết kế bảng `roles`, `users` và dữ liệu tài khoản do Trần Nguyễn Bình
Nguyên thực hiện. Các thành viên tiếp tục rà soát bảng thuộc chức năng của mình
trước khi tích hợp vào `main`.

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
│   ├── erd.md
│   ├── schema.sql
│   └── seed.sql
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

## Cách chạy CSDL local

Mở CMD tại thư mục project và vào MySQL Command Line:

```bat
C:\xampp\mysql\bin\mysql.exe -u root
```

Nếu tài khoản `root` có mật khẩu, dùng:

```bat
C:\xampp\mysql\bin\mysql.exe -u root -p
```

Trong màn hình MySQL, chạy đúng thứ tự:

```sql
SOURCE database/schema.sql;
SOURCE database/seed.sql;
USE nhip_khoa;
SHOW TABLES;
```

`schema.sql` phải chạy trước để tạo bảng; `seed.sql` chạy sau để thêm dữ liệu
thử. Cả hai file dùng `utf8mb4` nên lưu được tiếng Việt.

Hiện tại project đã có cấu trúc ban đầu, trang giới thiệu, form đăng nhập và bộ
script CSDL. Các thành viên sẽ tiếp tục tích hợp chức năng của mình vào schema
chung.

