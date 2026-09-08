<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class ImpactBox
{
    private PDO $pdo;

    /**
     * Khởi tạo kết nối database
     */
    public function __construct()
    {
        $this->pdo = db();

        if (!$this->pdo instanceof PDO) {
            die('LỖI: db() không trả về PDO');
        }
    }


    /**
     * =========================================================
     * LẤY DANH SÁCH IMPACT BOX CỦA USER
     * =========================================================
     *
     * Chỉ hiển thị:
     * - Bài viết đã xuất bản
     * - Danh mục đang hoạt động
     * - Bài viết do chính user đó lưu
     */
    public function getByUser(int $userId): array
    {
        $sql = "
            SELECT
                ib.id,
                ib.user_id,
                ib.post_id,
                ib.note,
                ib.created_at,

                p.title,
                p.slug,
                p.thumbnail,

                c.name AS category_name

            FROM impact_box_items ib

            INNER JOIN posts p
                ON ib.post_id = p.id

            INNER JOIN categories c
                ON p.category_id = c.id

            WHERE ib.user_id = ?
              AND p.status = 'published'
              AND c.status = 'active'

            ORDER BY ib.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * =========================================================
     * KIỂM TRA BÀI VIẾT ĐÃ ĐƯỢC USER LƯU CHƯA
     * =========================================================
     *
     * Đồng thời kiểm tra bài viết còn:
     * - published
     * - category active
     */
    public function exists(
        int $userId,
        int $postId
    ): bool {
        $sql = "
            SELECT
                ib.id

            FROM impact_box_items ib

            INNER JOIN posts p
                ON ib.post_id = p.id

            INNER JOIN categories c
                ON p.category_id = c.id

            WHERE ib.user_id = ?
              AND ib.post_id = ?
              AND p.status = 'published'
              AND c.status = 'active'

            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $userId,
            $postId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }


    /**
     * =========================================================
     * KIỂM TRA BÀI VIẾT CÓ ĐƯỢC PHÉP LƯU KHÔNG
     * =========================================================
     *
     * Bài viết chỉ hợp lệ nếu:
     * - tồn tại
     * - status = published
     * - category status = active
     */
    public function canSavePost(int $postId): bool
    {
        $sql = "
            SELECT
                p.id

            FROM posts p

            INNER JOIN categories c
                ON p.category_id = c.id

            WHERE p.id = ?
              AND p.status = 'published'
              AND c.status = 'active'

            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $postId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }


    /**
     * =========================================================
     * THÊM BÀI VIẾT VÀO IMPACT BOX
     * =========================================================
     */
    public function add(
        int $userId,
        int $postId,
        ?string $note = null
    ): bool {
        $sql = "
            INSERT INTO impact_box_items
            (
                user_id,
                post_id,
                note
            )

            VALUES
            (
                ?,
                ?,
                ?
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $userId,
            $postId,
            $note
        ]);
    }


    /**
     * =========================================================
     * XÓA BÀI VIẾT KHỎI IMPACT BOX
     * =========================================================
     *
     * Chỉ xóa bài viết thuộc user đang đăng nhập.
     */
    public function delete(
        int $userId,
        int $postId
    ): bool {
        $sql = "
            DELETE FROM impact_box_items

            WHERE user_id = ?
              AND post_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $userId,
            $postId
        ]);
    }


    /**
     * =========================================================
     * THÊM / SỬA GHI CHÚ
     * =========================================================
     */
    public function updateNote(
        int $userId,
        int $postId,
        ?string $note
    ): bool {
        $sql = "
            UPDATE impact_box_items

            SET note = ?

            WHERE user_id = ?
              AND post_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $note,
            $userId,
            $postId
        ]);
    }


    /**
     * =========================================================
     * XÓA GHI CHÚ
     * =========================================================
     */
    public function clearNote(
        int $userId,
        int $postId
    ): bool {
        $sql = "
            UPDATE impact_box_items

            SET note = NULL

            WHERE user_id = ?
              AND post_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $userId,
            $postId
        ]);
    }


    /**
     * =========================================================
     * LẤY MỘT BÀI VIẾT TRONG IMPACT BOX
     * =========================================================
     *
     * Chỉ lấy nếu:
     * - thuộc user
     * - bài viết published
     * - danh mục active
     */
    public function getOne(
        int $userId,
        int $postId
    ): ?array {
        $sql = "
            SELECT
                ib.id,
                ib.user_id,
                ib.post_id,
                ib.note,
                ib.created_at,

                p.title,
                p.slug,
                p.thumbnail,
                p.category_id,

                c.name AS category_name

            FROM impact_box_items ib

            INNER JOIN posts p
                ON ib.post_id = p.id

            INNER JOIN categories c
                ON p.category_id = c.id

            WHERE ib.user_id = ?
              AND ib.post_id = ?
              AND p.status = 'published'
              AND c.status = 'active'

            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $userId,
            $postId
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false
            ? $result
            : null;
    }
}

