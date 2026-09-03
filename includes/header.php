<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHỊP KHOA - Cổng thông tin khoa CNTT</title>
    
    <?php
        $css_path = file_exists('assets/css/style.css') ? 'assets/css/style.css' : '../assets/css/style.css';
        $logo_path = file_exists('assets/images/logo.png') ? 'assets/images/logo.png' : '../assets/images/logo.png';
        $index_path = file_exists('index.php') ? 'index.php' : '../index.php';
        $login_path = file_exists('dang-nhap.php') ? 'dang-nhap.php' : '../dang-nhap.php';
        $pages_dir = file_exists('pages') ? 'pages/' : '';
    ?>
    
    <link rel="stylesheet" href="<?php echo $css_path; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="<?php echo $index_path; ?>" class="logo">
                <img src="<?php echo $logo_path; ?>" alt="Nhịp Khoa Logo">
            </a>

            <nav class="main-nav">
                <a href="<?php echo $index_path; ?>" class="nav-link active">Trang chủ</a>
                <a href="<?php echo $pages_dir; ?>tin-khoa.php" class="nav-link">Tin khoa</a>
                <a href="<?php echo $pages_dir; ?>hoc-tap.php" class="nav-link">Học tập</a>
                <a href="<?php echo $pages_dir; ?>co-hoi.php" class="nav-link">Cơ hội</a>
                <a href="<?php echo $pages_dir; ?>su-kien.php" class="nav-link">Sự kiện</a>
            </nav>

            <div class="header-actions">
                <a href="<?php echo $pages_dir; ?>tim-kiem.php" class="search-btn" title="Tìm kiếm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <a href="<?php echo $login_path; ?>" class="login-btn">
                    <i class="fa-regular fa-user"></i> Đăng nhập
                </a>
            </div>
        </div>
    </header>

    <main class="main-container">