<?php

require_once __DIR__ . '/../config/database.php';

class Category
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Lấy tất cả danh mục
    public function getAll()
    {
        $sql = "SELECT 
                    c.id,
                    c.name,
                    c.slug,
                    c.description,
                    c.status,
                    c.created_at,
                    COUNT(p.id) AS post_count
                FROM categories c
                LEFT JOIN posts p ON c.id = p.category_id
                GROUP BY 
                    c.id,
                    c.name,
                    c.slug,
                    c.description,
                    c.status,
                    c.created_at
                ORDER BY c.id DESC";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy một danh mục
    public function getById($id)
    {
        $sql = "SELECT 
                    c.id,
                    c.name,
                    c.slug,
                    c.description,
                    c.status,
                    c.created_at,
                    COUNT(p.id) AS post_count
                FROM categories c
                LEFT JOIN posts p ON c.id = p.category_id
                WHERE c.id = ?
                GROUP BY 
                    c.id,
                    c.name,
                    c.slug,
                    c.description,
                    c.status,
                    c.created_at";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục
    public function add($name, $slug, $description, $status)
    {
        $sql = "INSERT INTO categories
                (name, slug, description, status)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $name,
            $slug,
            $description,
            $status
        ]);
    }

    // Sửa danh mục
    public function update($id, $name, $slug, $description, $status)
    {
        $sql = "UPDATE categories
                SET name = ?,
                    slug = ?,
                    description = ?,
                    status = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $name,
            $slug,
            $description,
            $status,
            $id
        ]);
    }

    // Xóa danh mục
    public function delete($id)
    {
        $sql = "DELETE FROM categories
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    // Tìm kiếm
public function search($keyword, $status = 'all')
{
    $sql = "SELECT 
                c.id,
                c.name,
                c.slug,
                c.description,
                c.status,
                c.created_at,
                COUNT(p.id) AS post_count
            FROM categories c
            LEFT JOIN posts p ON c.id = p.category_id
            WHERE (
                c.name LIKE ?
                OR c.slug LIKE ?
            )";

    $params = [
        '%' . $keyword . '%',
        '%' . $keyword . '%'
    ];

    if ($status !== 'all') {
        $sql .= " AND c.status = ?";
        $params[] = $status;
    }

    $sql .= " GROUP BY 
                c.id,
                c.name,
                c.slug,
                c.description,
                c.status,
                c.created_at
              ORDER BY c.id DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}