<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class User
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT u.id, u.email, u.password_hash, u.full_name, u.status, r.code AS role
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             WHERE u.email = :email
             LIMIT 1'
        );
        $statement->execute(['email' => $email]);
        return $statement->fetch() ?: null;
    }

    public function createReader(string $fullName, string $email, string $passwordHash): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO users (role_id, email, password_hash, full_name)
             SELECT id, :email, :password_hash, :full_name
             FROM roles
             WHERE code = 'reader'
             LIMIT 1"
        );
        $statement->execute([
            'email' => $email,
            'password_hash' => $passwordHash,
            'full_name' => $fullName,
        ]);
        return $statement->rowCount() === 1;
    }

    public function status(int $id): ?string
    {
        $statement = $this->pdo->prepare('SELECT status FROM users WHERE id = ? LIMIT 1');
        $statement->execute([$id]);
        $status = $statement->fetchColumn();
        return is_string($status) ? $status : null;
    }
}
