<?php
declare(strict_types=1);
require_once __DIR__ . '/app.php';

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function roleLandingPage(string $role): string
{
    return match ($role) {
        'admin' => 'admin/dashboard.php',
        'editor' => 'editor/dashboard.php',
        'author' => 'author/dashboard.php',
        default => 'index.php',
    };
}

function requireLogin(): void
{
    if (currentUser() === null) {
        $_SESSION['flash_error'] = 'Vui lòng đăng nhập để tiếp tục.';
        redirect('../dang-nhap.php');
    }
}

function requireRole(array $allowedRoles): void
{
    requireLogin();
    $role = currentUser()['role'] ?? 'reader';
    if (!in_array($role, $allowedRoles, true)) {
        http_response_code(403);
        exit('403 - Bạn không có quyền truy cập chức năng này.');
    }
}
