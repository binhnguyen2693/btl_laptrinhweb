<?php
declare(strict_types=1);

include 'includes/header.php'; 
?>

<section class="login-card">
    <div class="login-heading">
        <h1>ĐĂNG NHẬP</h1>
        <p>Sử dụng tài khoản sinh viên/giảng viên để truy cập hệ thống</p>
    </div>

    <form class="login-form" action="" method="POST">
        <div class="form-field">
            <label for="username">Tên đăng nhập / Email <span>*</span></label>
            <input type="text" id="username" name="username" placeholder="Nhập mã sinh viên hoặc email..." required>
        </div>

        <div class="form-field">
            <label for="password">Mật khẩu <span>*</span></label>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." required>
        </div>

        <button type="submit" class="login-button">Đăng nhập</button>
    </form>

    <div class="demo-account">
        <strong>Tài khoản thử nghiệm:</strong>
        <span>• Sinh viên: sv_demo / 123456</span>
    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>