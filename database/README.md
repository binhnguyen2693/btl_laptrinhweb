# Cơ sở dữ liệu Nhịp Khoa

## Các file

- [`schema.sql`](schema.sql): tạo database `nhip_khoa` và 6 bảng chính.
- [`seed.sql`](seed.sql): thêm vai trò, thành viên, danh mục, bài viết và dữ liệu thử.
- [`erd.md`](erd.md): ERD của nhóm viết bằng Mermaid.

## Danh sách bảng

| Bảng | Mục đích |
| --- | --- |
| `roles` | Danh sách vai trò trong hệ thống |
| `users` | Tài khoản quản trị, biên tập viên và tác giả |
| `categories` | Danh mục bài viết |
| `posts` | Nội dung và trạng thái kiểm duyệt bài viết |
| `comments` | Bình luận và trạng thái duyệt/ẩn |
| `impact_box_items` | Bài viết người dùng đã lưu và ghi chú |

## Thứ tự chạy

```sql
SOURCE database/schema.sql;
SOURCE database/seed.sql;
```

Chạy `schema.sql` trước vì file này tạo cấu trúc bảng. Chạy `seed.sql` sau vì
dữ liệu con chỉ thêm được khi dữ liệu ở bảng cha đã tồn tại.

