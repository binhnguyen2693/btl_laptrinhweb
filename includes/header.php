<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHỊP KHOA - Cổng thông tin khoa CNTT</title>
    
    <?php
        $in_pages   = file_exists('../assets/css/style.css');
        $css_path   = $in_pages ? '../assets/css/style.css' : 'assets/css/style.css';
        $logo_path  = $in_pages ? '../assets/images/logo.png' : 'assets/images/logo.png';
        $index_path = $in_pages ? '../index.php' : 'index.php';
        $login_path = $in_pages ? '../dang-nhap.php' : 'dang-nhap.php';
        $pages_dir  = $in_pages ? '' : 'pages/';
    ?>
    
    <link rel="stylesheet" href="<?php echo $css_path; ?>?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="margin: 0; padding: 0; background-color: #FAF6F0; font-family: system-ui, -apple-system, sans-serif;">

    <!-- Thanh Header phẳng màu nâu sẫm trùng khớp hoàn toàn với Footer -->
    <header style="background-color: #7A2E25; width: 100%; padding: 14px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between;">
            
            <a href="<?php echo $index_path; ?>" style="display: flex; align-items: center; text-decoration: none;">
                <img src="<?php echo $logo_path; ?>?v=<?php echo time(); ?>" alt="Nhịp Khoa Logo" style="height: 44px; width: auto; display: block;">
            </a>

            <!-- Menu trải dài phẳng, bỏ hoàn toàn khung bo xám/đỏ -->
            <nav style="display: flex; gap: 28px; align-items: center; background: none; padding: 0; border-radius: 0;">
                <a href="<?php echo $index_path; ?>" style="color: #FFFFFF; text-decoration: none; font-size: 15px; font-weight: 600;">Trang chủ</a>
                <a href="<?php echo $pages_dir; ?>tin-khoa.php" style="color: #FFFFFF; text-decoration: none; font-size: 15px;">Tin khoa</a>
                <a href="<?php echo $pages_dir; ?>hoc-tap.php" style="color: #FFFFFF; text-decoration: none; font-size: 15px;">Học tập</a>
                <a href="<?php echo $pages_dir; ?>co-hoi.php" style="color: #FFFFFF; text-decoration: none; font-size: 15px;">Cơ hội</a>
                <a href="<?php echo $pages_dir; ?>su-kien.php" style="color: #FFFFFF; text-decoration: none; font-size: 15px;">Sự kiện</a>
                <a href="<?php echo $pages_dir; ?>hop-tac-dong.php" style="color: #FFFFFF; text-decoration: none; font-size: 15px;">Hộp tác động</a>
            </nav>

            <!-- Nút tìm kiếm tròn & Đăng nhập trắng -->
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

    <main style="max-width: 1280px; margin: 30px auto; padding: 0 20px;">