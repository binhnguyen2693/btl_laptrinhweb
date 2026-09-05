<?php
require_once __DIR__ . '/app.php';
$pageTitle = $pageTitle ?? 'Nhịp Khoa';
$user = $_SESSION['user'] ?? null;
?>
<!doctype html><html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> - Nhịp Khoa</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e($basePath ?? '') ?>assets/css/style.css">
</head><body>
<div class="announcement"><div class="site-shell"><span>Thông báo: Kỳ đăng ký học phần bắt đầu từ ngày 20/05.</span><a href="#featured">Xem chi tiết →</a></div></div>
<header class="figma-header"><div class="site-shell header-inner">
    <a class="figma-logo" href="<?= e($basePath ?? '') ?>index.php"><img src="<?= e($basePath ?? '') ?>assets/images/figma/brand-logo.png" alt="Nhịp Khoa - The Faculty Post"></a>
    <nav class="desktop-nav" aria-label="Điều hướng chính">
        <a class="active" href="<?= e($basePath ?? '') ?>index.php">Trang chủ</a><a href="#">Tin khoa</a><a href="#">Học tập</a><a href="#">Cơ hội</a><a href="#">Sự kiện</a><a href="#articles">Hướng dẫn</a><a href="#topics">Hộp tác động</a>
    </nav>
    <div class="header-actions"><button class="search-circle" aria-label="Tìm kiếm"><img src="<?= e($basePath ?? '') ?>assets/images/figma/icon-search.svg" alt=""></button>
    <?php if ($user === null): ?><a class="login-pill" href="<?= e($basePath ?? '') ?>dang-nhap.php"><img src="<?= e($basePath ?? '') ?>assets/images/figma/icon-user.svg" alt="">Đăng nhập</a>
    <?php else: ?><span class="welcome">Chào, <?= e($user['full_name']) ?></span><?php if (($user['role'] ?? '') === 'admin'): ?><a href="<?= e($basePath ?? '') ?>admin/dashboard.php">Quản trị</a><?php endif; ?><form method="post" action="<?= e($basePath ?? '') ?>dang-xuat.php" class="inline-form"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><button class="link-button" type="submit">Đăng xuất</button></form><?php endif; ?>
    </div><button class="mobile-menu" aria-label="Mở menu">☰</button>
</div></header>
<main>
