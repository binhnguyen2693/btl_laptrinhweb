<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class Category
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function forSelect(): array
    {
        return $this->pdo->query('SELECT id, name FROM categories ORDER BY id ASC')->fetchAll();
    }
}
