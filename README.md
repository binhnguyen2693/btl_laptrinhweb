# Bài tập lớn Lập trình web

## Đề tài

Nhóm chọn đề tài **Website tin tức/blog có trang quản trị**.

Website có phần xem bài viết cho người dùng và phần quản trị để nhóm có thể
thêm, sửa, xóa bài viết.

## Thành viên

| MSSV | Họ và tên | Phần phụ trách |
| --- | --- | --- |
| 224001812 | Khổng Thị Lý | Chuyên mục |
| 224001828 | Trần Hà Như Quỳnh | Tác giả, người dùng |
| 224001819 | Trần Nguyễn Bình Nguyên | Bài viết |
| 224001843 | Đặng Ánh Tuyết | Bình luận |

## Đối tượng dữ liệu chính

- Bài viết.
- Chuyên mục.
- Tác giả, người dùng.
- Bình luận.

## Chức năng dự kiến

- Xem danh sách và chi tiết bài viết.
- Xem bài viết theo danh mục.
- Tìm kiếm bài viết.
- Đăng nhập trang quản trị.
- Thêm, sửa, xóa bài viết và danh mục.

## Đã thực hiện đến hết Buổi 2

- Tạo cấu trúc project và trang giới thiệu nhóm.
- Thống nhất các đối tượng dữ liệu chính và phân công thành viên.
- Tích hợp form nhập bài viết vào trang quản trị.
- Nhận dữ liệu form bằng PHP và tổ chức dữ liệu bằng mảng.
- Dùng hàm, điều kiện và vòng lặp để xác định trạng thái, hiển thị bài viết.

## Công nghệ sử dụng

- HTML, CSS, JavaScript.
- PHP và MySQL.
- XAMPP.

## Cấu trúc thư mục

```text
btl_laptrinhweb/
├── index.php
├── about.php
├── admin/
│   └── quan-ly-bai-viet.php
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

6. Trang quản lý bài viết đã tích hợp:

   ```text
   http://localhost/btl_laptrinhweb/admin/quan-ly-bai-viet.php
   ```

Buổi 2 sử dụng mảng PHP nên dữ liệu mới chỉ hiển thị sau khi gửi form và chưa
được lưu lại. Nhóm sẽ kết nối MySQL ở các buổi sau.

