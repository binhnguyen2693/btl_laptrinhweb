<?php
require_once __DIR__ . '/app.php';
$pageTitle = $pageTitle ?? 'Nhịp Khoa';
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> - Nhịp Khoa</title>
    <link rel="stylesheet" href="<?= e($basePath ?? '') ?>assets/css/style.css">
</head>
<body>
<header class="site-header">
    <nav class="container main-nav" aria-label="Điều hướng chính">
        <a class="brand" href="<?= e($basePath ?? '') ?>index.php">NHỊP KHOA</a>
        <div class="nav-links">
            <a href="<?= e($basePath ?? '') ?>index.php">Trang chủ</a>
            <a href="<?= e($basePath ?? '') ?>about.php">Giới thiệu</a>
            <?php if ($user === null): ?>
                <a href="<?= e($basePath ?? '') ?>dang-nhap.php">Đăng nhập</a>
                <a class="nav-button" href="<?= e($basePath ?? '') ?>dang-ky.php">Đăng ký</a>
            <?php else: ?>
                <?php if (($user['role'] ?? '') === 'admin'): ?>
                    <a href="<?= e($basePath ?? '') ?>admin/dashboard.php">Quản trị</a>
                <?php endif; ?>
                <span>Xin chào, <?= e($user['full_name']) ?></span>
                <form method="post" action="<?= e($basePath ?? '') ?>dang-xuat.php" class="inline-form">
                    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                    <button class="link-button" type="submit">Đăng xuất</button>
                </form>
            <?php endif; ?>
        </div>
    </nav>
</header>
<main class="container page-content">
