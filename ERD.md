# ERD cá nhân – Khổng Thị Lý

## Chức năng phụ trách

- Quản lý bình luận
- Quản lý danh mục
- Impact Box

## Sơ đồ ERD

```mermaid
erDiagram
    USERS ||--o{ POSTS : "tạo"
    USERS ||--o{ COMMENTS : "viết"
    CATEGORIES ||--o{ POSTS : "phân loại"
    POSTS ||--o{ COMMENTS : "có"

    USERS {
        int id PK
        varchar name
        varchar email UK
        varchar password
        varchar role
        varchar status
        timestamp created_at
    }

    CATEGORIES {
        int id PK
        varchar name
        varchar slug UK
        text description
        timestamp created_at
    }

    POSTS {
        int id PK
        int user_id FK
        int category_id FK
        varchar title
        varchar slug UK
        varchar thumbnail
        text content
        varchar status
        timestamp created_at
        timestamp updated_at
        timestamp published_at
    }

    COMMENTS {
        int id PK
        int post_id FK
        int user_id FK
        text content
        varchar status
        timestamp created_at
    }
```

## Mối quan hệ

### Users – Posts

Một người dùng có thể tạo nhiều bài viết.

**Khóa liên kết:** `posts.user_id → users.id`

### Users – Comments

Một người dùng có thể viết nhiều bình luận.

**Khóa liên kết:** `comments.user_id → users.id`

### Categories – Posts

Một danh mục có thể chứa nhiều bài viết.

**Khóa liên kết:** `posts.category_id → categories.id`

### Posts – Comments

Một bài viết có thể có nhiều bình luận.

**Khóa liên kết:** `comments.post_id → posts.id`

## Các bảng liên quan đến chức năng cá nhân

### Quản lý bình luận

Chức năng quản lý bình luận sử dụng:

- `comments`: lưu nội dung và trạng thái bình luận.
- `users`: xác định người viết bình luận.
- `posts`: xác định bài viết được bình luận.

### Quản lý danh mục

Chức năng quản lý danh mục sử dụng:

- `categories`: lưu thông tin danh mục.
- `posts`: xác định các bài viết thuộc danh mục.

### Impact Box

Impact Box liên quan đến việc người dùng lưu và quản lý các bài viết mà họ quan tâm.