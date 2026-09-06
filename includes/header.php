<?php
require_once __DIR__ . '/../config/config.php';

$pageTitle = $pageTitle ?? 'Trang web';
$displayName = $_SESSION['full_name'] ?? 'Tác giả';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

   <link rel="stylesheet"
      href="<?= BASE_URL ?>assets/css/common.css">

<?php if (!empty($pageCss)): ?>
    <link rel="stylesheet"
          href="<?= BASE_URL ?>assets/css/<?= htmlspecialchars($pageCss) ?>">
<?php endif; ?>
</head>

<body>

<header class="site-header">
    <div class="header-container">

       <img
    src="<?= BASE_URL ?>assets/images/logo.svg"
    alt="Nhịp Khoa"
    class="logo-image"
>

        <!-- Menu -->
        <nav class="main-menu">
            <a href="<?= BASE_URL ?>author/dashboard.php"
               class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
                Tổng quan
            </a>

            <a href="<?= BASE_URL ?>author/posts.php"
               class="<?= $currentPage === 'posts.php' ? 'active' : '' ?>">
                Bài viết của tôi
            </a>

            <a href="<?= BASE_URL ?>author/create.php"
               class="<?= $currentPage === 'create.php' ? 'active' : '' ?>">
                Tạo bài viết
            </a>
        </nav>

        <!-- Bên phải -->
        <div class="header-right">
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="user-info">
                <i class="fa-regular fa-circle-user user-icon"></i>
                <span><?= htmlspecialchars($displayName) ?></span>
                <i class="fa-solid fa-chevron-down arrow-icon"></i>
            </div>
        </div>

    </div>
</header>

<main class="main-content">