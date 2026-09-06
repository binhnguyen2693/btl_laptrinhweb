<?php

require_once __DIR__ . '/../config/database.php';

class ImpactBox
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Lấy danh sách bài viết trong Impact Box của người dùng
     */
    public function getByUser($userId)
{
    $sql = "
        SELECT
            ib.id,
            ib.user_id,
            ib.post_id,
            ib.note,
            ib.created_at,
            ib.updated_at,

            p.title,
            p.slug,
            p.thumbnail,

            c.name AS category_name

        FROM impact_boxes ib

        INNER JOIN posts p
            ON ib.post_id = p.id

        INNER JOIN categories c
            ON p.category_id = c.id

        WHERE ib.user_id = ?

        ORDER BY ib.created_at DESC
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        $userId
    ]);

    return $stmt->fetchAll();
}

    /**
     * Kiểm tra bài viết đã được lưu chưa
     */
    public function exists($userId, $postId)
    {
        $sql = "
            SELECT id
            FROM impact_boxes
            WHERE user_id = ?
              AND post_id = ?
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $userId,
            $postId
        ]);

        return $stmt->fetch() !== false;
    }


    /**
     * Thêm bài viết vào Impact Box
     */
    public function add($userId, $postId, $note = null)
    {
        $sql = "
            INSERT INTO impact_boxes
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
     * Xóa bài viết khỏi Impact Box
     */
    public function delete($userId, $postId)
    {
        $sql = "
            DELETE FROM impact_boxes
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
     * Thêm hoặc sửa ghi chú
     */
    public function updateNote($userId, $postId, $note)
    {
        $sql = "
            UPDATE impact_boxes

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
     * Xóa ghi chú nhưng giữ bài viết
     * trong Impact Box
     */
    public function clearNote($userId, $postId)
    {
        $sql = "
            UPDATE impact_boxes

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
     * Lấy một bài viết cụ thể
     * trong Impact Box
     */
    public function getOne($userId, $postId)
    {
        $sql = "
            SELECT
                ib.id,
                ib.user_id,
                ib.post_id,
                ib.note,
                ib.created_at,
                ib.updated_at,

                p.title,
                p.slug,
                p.thumbnail,
                p.category_id,

                c.name AS category_name

            FROM impact_boxes ib

            INNER JOIN posts p
                ON ib.post_id = p.id

            LEFT JOIN categories c
                ON p.category_id = c.id

            WHERE ib.user_id = ?
              AND ib.post_id = ?

            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $userId,
            $postId
        ]);

        return $stmt->fetch();
    }
}