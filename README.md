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

Tài khoản bị khóa để kiểm thử cảnh báo đăng nhập:

```text
Email: khoa.locked@nhipkhoa.vn hoặc lan.locked@nhipkhoa.vn
Mật khẩu: Admin@123
```

## Thiết kế CSDL - Buổi 4

### Cấu hình trên từng máy

Mọi thành viên dùng chung cấu trúc trong `database/schema.sql` và dữ liệu mẫu trong
`database/seed.sql`. Riêng thông tin kết nối có thể khác nhau trên từng máy:

1. Sao chép `config/config.local.example.php` thành `config/config.local.php`.
2. Sửa `name`, `user`, `password`, `host` hoặc `port` theo MySQL trên máy đó.
3. Không commit `config.local.php`; file này đã có trong `.gitignore`.

Nếu database đã được tạo từ trước, chạy thêm
`database/migrations/2026_09_06_role_content.sql` để bổ sung dữ liệu cần cho khu vực
Tác giả và Biên tập viên.

Biến môi trường `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` vẫn được
ưu tiên nếu máy hoặc server đã cấu hình sẵn.

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

## Tài liệu phát triển hiện tại

- [`docs/NGUOI-1-FLOW.md`](docs/NGUOI-1-FLOW.md): nhiệm vụ, cơ chế hoạt động,
  điều kiện đăng ký/đăng nhập, phân quyền và cách demo phần Người 1.
- [`docs/GITHUB-FLOW.md`](docs/GITHUB-FLOW.md): cách tổ chức `main`, `develop`,
  branch chức năng và Pull Request của cả nhóm.

Branch `feature/person1-auth-home` thay tài khoản mẫu bằng đăng ký/đăng nhập thật
qua PDO và MySQL, thêm session, CSRF, kiểm tra role, trang chủ chỉ đọc bài
`published` và khung dashboard dành cho Admin.

