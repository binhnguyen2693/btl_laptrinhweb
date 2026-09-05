<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? 'Quản trị';
$adminPage = $adminPage ?? '';
$adminUser = currentUser();
?>
<!doctype html><html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($pageTitle) ?> - Nhịp Khoa</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin.css"></head><body class="admin-body">
<div class="admin-layout"><aside class="admin-sidebar">
<a class="admin-brand" href="dashboard.php"><img src="../assets/images/figma/brand-logo-white.png" alt="Nhịp Khoa"></a>
<p class="admin-label">KHU VỰC QUẢN TRỊ</p>
<nav class="admin-nav" aria-label="Điều hướng quản trị">
<a class="<?= $adminPage === 'dashboard' ? 'active' : '' ?>" href="dashboard.php"><span>⌂</span>Tổng quan</a>
<a class="<?= $adminPage === 'users' ? 'active' : '' ?>" href="users.php"><span>♙</span>Tài khoản</a>
<span class="admin-nav-disabled"><b>▤</b>Bài viết<small>Sắp có</small></span><span class="admin-nav-disabled"><b>◫</b>Chuyên mục<small>Sắp có</small></span><span class="admin-nav-disabled"><b>◌</b>Bình luận<small>Sắp có</small></span>
</nav><div class="admin-sidebar-note"><strong>Nhịp Khoa</strong><span>Quản lý nội dung an toàn, rõ ràng và đúng vai trò.</span></div>
</aside><div class="admin-workspace"><header class="admin-topbar">
<div><span class="admin-kicker">ADMIN PANEL</span><strong><?= e($pageTitle) ?></strong></div>
<div class="admin-profile"><span class="admin-avatar"><?= e(mb_strtoupper(mb_substr((string) ($adminUser['full_name'] ?? 'A'), 0, 1))) ?></span><span class="admin-profile-copy"><b><?= e($adminUser['full_name'] ?? 'Admin') ?></b><small>Quản trị viên</small></span>
<form method="post" action="../dang-xuat.php"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><button type="submit">Đăng xuất</button></form></div>
</header><main class="admin-main">
