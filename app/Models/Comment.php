<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class Comment
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function approvedForPost(int $postId): array
    {
        $statement = $this->pdo->prepare(
            "SELECT comments.id, comments.content, comments.created_at, users.full_name
             FROM comments
             INNER JOIN users ON users.id = comments.user_id
             WHERE comments.post_id = ? AND comments.status = 'approved'
             ORDER BY comments.created_at DESC, comments.id DESC"
        );
        $statement->execute([$postId]);
        return $statement->fetchAll();
    }

    public function createPending(int $postId, int $userId, string $content): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO comments (post_id, user_id, content, status, created_at)
             VALUES (?, ?, ?, 'pending', NOW())"
        );
        return $statement->execute([$postId, $userId, $content]);
    }
}
