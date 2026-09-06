<?php
require_once __DIR__ . '/../config/config.php';

$pageTitle = $pageTitle ?? 'Biên tập viên - NHỊP KHOA';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/common.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/editor-common.css">

<?php if (!empty($pageCss)): ?>
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/<?= htmlspecialchars($pageCss) ?>">
<?php endif; ?>
</head>
<body>
<header class="editor-header">
    <div class="editor-header-container">
        <a href="<?= BASE_URL ?>editor/dashboard.php" class="editor-logo">
            <img src="<?= BASE_URL ?>assets/images/logo.svg" alt="Nhịp Khoa">
        </a>
        <nav class="editor-menu">
            <a href="<?= BASE_URL ?>editor/dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">Tổng quan</a>
            <a href="<?= BASE_URL ?>editor/posts.php" class="<?= $currentPage === 'posts.php' ? 'active' : '' ?>">Duyệt bài</a>
        </nav>
        <div class="editor-user">
            <i class="fa-regular fa-user"></i>
            <span>Biên tập viên</span>
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </div>
</header>
<main class="editor-main">