# ERD nhóm - Website tin tức/blog Nhịp Khoa

```mermaid
erDiagram
    roles ||--o{ users : "phân quyền"
    users ||--o{ posts : "viết"
    users o|--o{ posts : "duyệt"
    categories ||--o{ posts : "phân loại"
    users o|--o{ comments : "gửi"
    posts ||--o{ comments : "có"
    users ||--o{ impact_box_items : "lưu"
    posts ||--o{ impact_box_items : "được lưu"

    roles {
        TINYINT id PK
        VARCHAR code UK
        VARCHAR name
    }

    users {
        INT id PK
        TINYINT role_id FK
        VARCHAR email UK
        VARCHAR password_hash
        VARCHAR full_name
        ENUM status
        DATETIME created_at
    }

    categories {
        INT id PK
        VARCHAR slug UK
        VARCHAR name UK
        ENUM status
    }

    posts {
        INT id PK
        INT category_id FK
        INT author_id FK
        INT reviewer_id FK
        VARCHAR title
        VARCHAR slug UK
        TEXT summary
        LONGTEXT content
        ENUM status
        DATETIME published_at
        DATETIME created_at
        DATETIME updated_at
    }

    comments {
        BIGINT id PK
        INT post_id FK
        INT user_id FK
        TEXT content
        ENUM status
        DATETIME created_at
    }

    impact_box_items {
        BIGINT id PK
        INT user_id FK
        INT post_id FK
        VARCHAR note
        DATETIME created_at
    }
```

## Ràng buộc chính

- Email người dùng, mã vai trò, tên/slug danh mục và slug bài viết là duy nhất.
- Mỗi bài viết phải thuộc một danh mục và một tác giả đã tồn tại.
- Một người chỉ lưu một bài viết vào Impact Box một lần nhờ
  `UNIQUE(user_id, post_id)`.
- Người duyệt bài và người gửi bình luận có thể là `NULL` khi chưa duyệt hoặc
  khi hỗ trợ bình luận khách.

## Dữ liệu không lưu dư thừa

- Không lưu tên tác giả và tên danh mục trực tiếp trong `posts`; lấy bằng `JOIN`.
- Không lưu tổng số bình luận; dùng `COUNT(comments.id)` khi cần thống kê.
- Không lưu trạng thái “đã lưu” trong `posts`; xác định từ `impact_box_items`.
