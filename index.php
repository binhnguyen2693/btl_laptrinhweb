<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
declare(strict_types=1);
include 'includes/header.php'; 
?>

<section class="intro" style="background-color: #6A2B23; color: white; padding: 30px; border-radius: 12px; margin-bottom: 25px;">
    <h1 style="font-size: 26px; margin-bottom: 10px; color: white;">CỔNG THÔNG TIN CHÍNH THỨC KHOA CNTT</h1>
    <p style="margin-bottom: 15px;">Cập nhật - Kết nối - Tạo tác động. Nơi chia sẻ tin tức, tài liệu học tập và các cơ hội phát triển dành cho sinh viên.</p>
    <a class="button" href="pages/tin-khoa.php" style="background: white; color: #6A2B23; padding: 8px 16px; border-radius: 6px; font-weight: bold; display: inline-block; text-decoration: none;">Khám phá ngay</a>
</section>

<section class="features" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <article style="background: white; padding: 20px; border-radius: 10px; border: 1px solid #E5E7EB;">
        <h2 style="color: #6A2B23; font-size: 18px; margin-bottom: 8px;">Tin khoa & Sự kiện</h2>
        <p style="margin-bottom: 15px; font-size: 14px;">Cập nhật liên tục các thông báo, sự kiện và tin tức quan trọng từ BGH và Ban cán sự khoa.</p>
        <a href="pages/tin-khoa.php" style="color: #6A2B23; font-weight: bold; font-size: 14px; text-decoration: none;">Xem chi tiết →</a>
    </article>
    <article style="background: white; padding: 20px; border-radius: 10px; border: 1px solid #E5E7EB;">
        <h2 style="color: #6A2B23; font-size: 18px; margin-bottom: 8px;">Góc học tập & Nghiên cứu</h2>
        <p style="margin-bottom: 15px; font-size: 14px;">Chia sẻ kinh nghiệm học tập, tài liệu môn học và thông tin nghiên cứu khoa học cho sinh viên.</p>
        <a href="pages/hoc-tap.php" style="color: #6A2B23; font-weight: bold; font-size: 14px; text-decoration: none;">Xem chi tiết →</a>
    </article>
</section>

<?php 
include 'includes/footer.php'; 
?>