# Bài tập lớn Lập trình web

## Đề tài

Nhóm chọn đề tài **Website tin tức/blog có trang quản trị**.

Website có phần xem bài viết cho người dùng và phần quản trị để nhóm có thể
thêm, sửa, xóa bài viết.

## Thành viên

| MSSV | Họ và tên | Phần phụ trách |
| --- | --- | --- |
| 224001812 | Khổng Thị Lý | Impact Box, bình luận và quản lý danh mục |
| 224001828 | Trần Hà Như Quỳnh | Bài viết và quy trình kiểm duyệt |
| 224001819 | Trần Nguyễn Bình Nguyên | Người dùng và giao diện chung của trang quản trị |
| 224001843 | Đặng Ánh Tuyết | Giao diện công khai và tìm kiếm |

## Phân công thiết kế và phát triển

### Trần Nguyễn Bình Nguyên - Người 1

- Thiết kế và phát triển phần đăng nhập, người dùng/tác giả.
- Xây dựng giao diện chung của trang quản trị.
- Tích hợp các chức năng vào project chung.

### Trần Hà Như Quỳnh - Người 2

- Dashboard tác giả.
- Form tạo và sửa bài viết.
- Màn hình biên tập viên duyệt bài.
- Xử lý các trạng thái của bài viết.

### Đặng Ánh Tuyết - Người 3

- Trang danh mục và trang kết quả tìm kiếm.
- Trang chi tiết bài viết.
- Hiển thị khi chưa có bài viết.
- Responsive trên thiết bị di động.
- Khối Impact Summary.

### Khổng Thị Lý - Người 4

- Modal lưu bài viết vào Impact Box.
- Trang Impact Box và trạng thái trống.
- Modal sửa ghi chú.
- Giao diện và chức năng quản lý bình luận.
- Giao diện quản lý danh mục.

## Đối tượng dữ liệu chính

- Bài viết.
- Chuyên mục.
- Tác giả, người dùng.
- Bình luận.
- Impact Box và ghi chú.

## Chức năng dự kiến

- Xem danh sách và chi tiết bài viết.
- Xem bài viết theo danh mục.
- Tìm kiếm bài viết.
- Đăng nhập trang quản trị.
- Thêm, sửa, xóa bài viết và danh mục.
- Gửi bài viết để biên tập viên kiểm duyệt.
- Quản lý trạng thái bản nháp, chờ duyệt và đã đăng.
- Theo dõi tác giả.
- Bình luận và quản lý bình luận.
- Lưu bài viết vào Impact Box và thêm ghi chú.
- Hiển thị responsive trên thiết bị di động.

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
7. Trang tìm kiếm bài viết đã tích hợp:

   ```text
   http://localhost/btl_laptrinhweb/admin/timkiembaiviet.php
   ```

Buổi 2 sử dụng mảng PHP nên dữ liệu mới chỉ hiển thị sau khi gửi form và chưa
được lưu lại. Nhóm sẽ kết nối MySQL ở các buổi sau.

