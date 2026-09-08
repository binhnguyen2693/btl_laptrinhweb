<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class Post
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function publishedForHome(int $limit = 4): array
    {
        $statement = $this->pdo->prepare(
            "SELECT p.id, p.title, p.summary, p.thumbnail, p.published_at, p.created_at,
                    c.name AS category_name, c.slug AS category_slug, u.full_name AS author_name
             FROM posts p
             INNER JOIN categories c ON c.id = p.category_id
             INNER JOIN users u ON u.id = p.author_id
             WHERE p.status = 'published'
               AND c.status = 'active'
               AND c.slug IN ('tin-khoa', 'hoc-tap', 'co-hoi', 'su-kien')
             ORDER BY COALESCE(p.published_at, p.created_at) DESC, p.id DESC
             LIMIT ?"
        );
        $statement->bindValue(1, max(1, $limit), PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function publishedList(?string $category, string $keyword, int $page, int $perPage = 6): array
    {
        $where = "p.status = 'published' AND c.status = 'active'";
        $arguments = [];
        if ($category !== null) {
            $where .= ' AND c.slug = ?';
            $arguments[] = $category;
        }
        if ($keyword !== '') {
            $where .= ' AND (p.title LIKE ? OR p.summary LIKE ? OR p.content LIKE ? OR c.name LIKE ? OR u.full_name LIKE ?)';
            array_push($arguments, ...array_fill(0, 5, '%' . $keyword . '%'));
        }

        $joins = ' FROM posts p INNER JOIN categories c ON c.id = p.category_id INNER JOIN users u ON u.id = p.author_id ';
        $count = $this->pdo->prepare('SELECT COUNT(*)' . $joins . 'WHERE ' . $where);
        $count->execute($arguments);
        $total = (int) $count->fetchColumn();
        $pages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $pages));

        $statement = $this->pdo->prepare(
            'SELECT p.id, p.title, p.summary, p.thumbnail, p.published_at, p.created_at,
                    c.name AS category_name, c.slug AS category_slug, u.full_name AS author_name' .
            $joins . 'WHERE ' . $where .
            ' ORDER BY COALESCE(p.published_at, p.created_at) DESC, p.id DESC LIMIT ? OFFSET ?'
        );
        foreach ($arguments as $index => $argument) {
            $statement->bindValue($index + 1, $argument, PDO::PARAM_STR);
        }
        $statement->bindValue(count($arguments) + 1, $perPage, PDO::PARAM_INT);
        $statement->bindValue(count($arguments) + 2, ($page - 1) * $perPage, PDO::PARAM_INT);
        $statement->execute();

        return [
            'posts' => $statement->fetchAll(),
            'total' => $total,
            'pages' => $pages,
            'page' => $page,
        ];
    }

    public function findPublished(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug, u.full_name AS author_name
             FROM posts p
             INNER JOIN categories c ON c.id = p.category_id
             INNER JOIN users u ON u.id = p.author_id
             WHERE p.id = ? AND p.status = 'published' AND c.status = 'active'
             LIMIT 1"
        );
        $statement->execute([$id]);
        return $statement->fetch() ?: null;
    }

    public function relatedPublished(int $categoryId, int $exceptId, int $limit = 3): array
    {
        $statement = $this->pdo->prepare(
            "SELECT p.id, p.title, p.thumbnail, p.published_at, p.created_at
             FROM posts p
             INNER JOIN categories c ON c.id = p.category_id
             WHERE p.category_id = ? AND p.id <> ?
               AND p.status = 'published' AND c.status = 'active'
             ORDER BY COALESCE(p.published_at, p.created_at) DESC, p.id DESC
             LIMIT ?"
        );
        $statement->bindValue(1, $categoryId, PDO::PARAM_INT);
        $statement->bindValue(2, $exceptId, PDO::PARAM_INT);
        $statement->bindValue(3, max(1, $limit), PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
