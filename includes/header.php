<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHỊP KHOA - Cổng thông tin khoa CNTT</title>
    
    <?php
        $current_file = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
        $in_pages = strpos($current_file, '/pages/') !== false;

        $root_path = $in_pages ? '../' : '';

        $css_path   = $root_path . 'assets/css/style.css';
        $logo_path  = $root_path . 'assets/images/logo.png';
        $index_path = $root_path . 'index.php';
        $login_path = $root_path . 'dang-nhap.php';
        $pages_dir  = $root_path . 'pages/';
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header style="background-color: #7A2E25; width: 100%; padding: 14px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between;">
            
            <a href="<?php echo $index_path; ?>" style="display: flex; align-items: center; text-decoration: none;">
                <img src="<?php echo $logo_path; ?>?v=<?php echo time(); ?>" alt="Nhịp Khoa Logo" style="height: 44px; width: auto; display: block;">
            </a>

            <nav style="display: flex; gap: 20px; font-size: var(--font-base);">
                <a href="<?php echo $root_path; ?>index.php" style="color: #FFFFFF; text-decoration: none;" ...>Trang chủ</a>
                <a href="tin-khoa.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'tin-khoa.php') ? 'active' : ''; ?>">Tin khoa</a>
                <a href="hoc-tap.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'hoc-tap.php') ? 'active' : ''; ?>">Học tập</a>
                <a href="co-hoi.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'co-hoi.php') ? 'active' : ''; ?>">Cơ hội</a>
                <a href="su-kien.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'su-kien.php') ? 'active' : ''; ?>">Sự kiện</a>
</nav>

            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="<?php echo $pages_dir; ?>tim-kiem.php" style="color: #FFFFFF; width: 34px; height: 34px; border: 1.5px solid #FFFFFF; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 14px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <a href="<?php echo $login_path; ?>" style="background-color: #FFFFFF; color: #4A1C16; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-regular fa-user"></i> Đăng nhập
                </a>
            </div>

        </div>
    </header>

    <main class="container">