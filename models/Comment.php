<?php

class Comment
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getAll(): array
    {
        $sql = "
            SELECT
                c.id,
                c.content,
                c.status,
                c.created_at,
                u.name AS user_name,
                p.title AS post_title
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN posts p ON c.post_id = p.id
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function getByStatus(string $status): array
    {
        $allowedStatuses = [
            'pending',
            'approved',
            'hidden'
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            return [];
        }

        $sql = "
            SELECT
                c.id,
                c.content,
                c.status,
                c.created_at,
                u.name AS user_name,
                p.title AS post_title
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN posts p ON c.post_id = p.id
            WHERE c.status = :status
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':status' => $status
        ]);

        return $stmt->fetchAll();
    }

    public function updateStatus(
        int $commentId,
        string $status
    ): bool {

        $allowedStatuses = [
            'pending',
            'approved',
            'hidden'
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            return false;
        }

        $sql = "
            UPDATE comments
            SET status = :status
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':status' => $status,
            ':id' => $commentId
        ]);
    }
public function create(
    int $postId,
    int $userId,
    string $content
): bool {

    $sql = "
        INSERT INTO comments (
            post_id,
            user_id,
            content,
            status
        )
        VALUES (
            :post_id,
            :user_id,
            :content,
            'pending'
        )
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        ':post_id' => $postId,
        ':user_id' => $userId,
        ':content' => $content
    ]);
}
public function search(
    string $keyword = '',
    string $status = 'all',
    int $postId = 0
): array {

    $sql = "
        SELECT
            c.id,
            c.content,
            c.status,
            c.created_at,
            u.name AS user_name,
            p.title AS post_title
        FROM comments c
        LEFT JOIN users u ON c.user_id = u.id
        LEFT JOIN posts p ON c.post_id = p.id
        WHERE 1 = 1
    ";

    $params = [];

    if ($keyword !== '') {
        $sql .= "
            AND (
                c.content LIKE :content_keyword
                OR u.name LIKE :user_keyword
                OR p.title LIKE :post_keyword
            )
        ";

        $keywordValue = '%' . $keyword . '%';

        $params[':content_keyword'] = $keywordValue;
        $params[':user_keyword'] = $keywordValue;
        $params[':post_keyword'] = $keywordValue;
    }

    if ($status !== 'all') {

        $allowedStatuses = [
            'pending',
            'approved',
            'hidden'
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            return [];
        }

        $sql .= " AND c.status = :status";
        $params[':status'] = $status;
    }

    if ($postId > 0) {
        $sql .= " AND c.post_id = :post_id";
        $params[':post_id'] = $postId;
    }

    $sql .= " ORDER BY c.created_at DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}


public function getPosts(): array
{
    $sql = "
        SELECT id, title
        FROM posts
        ORDER BY title ASC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}
public function delete(int $commentId): bool
{
    $sql = "
        DELETE FROM comments
        WHERE id = :id
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $commentId
    ]);
}
}