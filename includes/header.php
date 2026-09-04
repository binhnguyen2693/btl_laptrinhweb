<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHỊP KHOA - Cổng thông tin khoa CNTT</title>
    
    <?php
        $in_pages = file_exists('../assets/css/style.css');
        $css_path   = $in_pages ? '../assets/css/style.css' : 'assets/css/style.css';
        $logo_path  = $in_pages ? '../assets/images/logo.png' : 'assets/images/logo.png';
        $index_path = $in_pages ? '../index.php' : 'index.php';
        $login_path = $in_pages ? '../dang-nhap.php' : 'dang-nhap.php';
        $pages_dir  = $in_pages ? '' : 'pages/';
    ?>
    
    <link rel="stylesheet" href="<?php echo $css_path; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="site-header" style="background-color: #6A2B23; padding: 10px 30px; min-height: 90px; display: flex; align-items: center;">
        <div class="header-container" style="max-width: 1200px; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">
            <a href="<?php echo $index_path; ?>" style="display: flex; align-items: center; text-decoration: none;">
                <img src="<?php echo $logo_path; ?>" alt="Nhịp Khoa Logo" style="height: 40px; width: auto; display: block;">
            </a>

            <!-- Menu chính -->
            <nav class="main-nav" style="display: flex; gap: 20px;">
                <a href="<?php echo $index_path; ?>" style="color: white; text-decoration: none; font-weight: bold; padding: 8px 12px;">Trang chủ</a>
                <a href="<?php echo $pages_dir; ?>tin-khoa.php" style="color: white; text-decoration: none; padding: 8px 12px;">Tin khoa</a>
                <a href="<?php echo $pages_dir; ?>hoc-tap.php" style="color: white; text-decoration: none; padding: 8px 12px;">Học tập</a>
                <a href="<?php echo $pages_dir; ?>co-hoi.php" style="color: white; text-decoration: none; padding: 8px 12px;">Cơ hội</a>
                <a href="<?php echo $pages_dir; ?>su-kien.php" style="color: white; text-decoration: none; padding: 8px 12px;">Sự kiện</a>
                <a href="<?php echo $pages_dir; ?>hop-tac-dong.php" style="color: white; text-decoration: none; padding: 8px 12px;">Hộp tác động</a>
            </nav>

            <!-- Công cụ -->
            <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
                <a href="<?php echo $pages_dir; ?>tim-kiem.php" style="color: white; font-size: 18px;"><i class="fa-solid fa-magnifying-glass"></i></a>
                <a href="<?php echo $login_path; ?>" style="background: white; color: #6A2B23; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-weight: bold;"><i class="fa-regular fa-user"></i> Đăng nhập</a>
            </div>
        </div>
    </header>

    <main class="main-container" style="max-width: 1200px; margin: 30px auto; padding: 0 15px;">