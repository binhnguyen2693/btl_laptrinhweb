<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void
{
    $sentToken = (string) ($_POST['csrf_token'] ?? '');
    $savedToken = (string) ($_SESSION['csrf_token'] ?? '');
    if ($savedToken === '' || !hash_equals($savedToken, $sentToken)) {
        http_response_code(419);
        exit('Phiên làm việc không hợp lệ. Vui lòng quay lại và thử lại.');
    }
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}
