<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';
if (!empty($_SESSION['user'])) {
    redirect('index.php');
}

$values = ['full_name' => '', 'email' => ''];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $values['full_name'] = trim((string) ($_POST['full_name'] ?? ''));
    $values['email'] = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');

    if (mb_strlen($values['full_name']) < 2 || mb_strlen($values['full_name']) > 120) {
        $errors['full_name'] = 'Họ tên phải có từ 2 đến 120 ký tự.';
    }
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL) || strlen($values['email']) > 150) {
        $errors['email'] = 'Vui lòng nhập email hợp lệ, tối đa 150 ký tự.';
    }
    if (strlen($password) < 8 || strlen($password) > 72) {
        $errors['password'] = 'Mật khẩu phải có từ 8 đến 72 ký tự.';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $errors['password'] = 'Mật khẩu cần có ít nhất một chữ và một số.';
    }
    if ($password !== $confirmation) {
        $errors['password_confirmation'] = 'Mật khẩu nhập lại chưa khớp.';
    }

    if ($errors === []) {
        try {
            $statement = db()->prepare(
                "INSERT INTO users (role_id, email, password_hash, full_name)
                 SELECT id, :email, :password_hash, :full_name FROM roles WHERE code = 'reader' LIMIT 1"
            );
            $statement->execute([
                'email' => $values['email'],
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'full_name' => $values['full_name'],
            ]);
            if ($statement->rowCount() !== 1) {
                throw new RuntimeException('Không tìm thấy role reader trong bảng roles.');
            }
            $_SESSION['flash_success'] = 'Đăng ký thành công. Bạn có thể đăng nhập ngay.';
            redirect('dang-nhap.php');
        } catch (Throwable $exception) {
            $errors['register'] = $exception instanceof PDOException && $exception->getCode() === '23000'
                ? 'Email này đã được sử dụng.'
                : 'Không thể đăng ký. Hãy kiểm tra kết nối cơ sở dữ liệu.';
        }
    }
}

?><!doctype html><html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Đăng ký - Nhịp Khoa</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/css/style.css"></head><body class="auth-page">
<main class="auth-layout"><section class="auth-visual"><div class="auth-visual-copy"><h2>NHỊP KHOA <span>The faculty post</span></h2><i></i><p>Nhịp khoa là không gian chia sẻ học thuật<br>và kết nối tri thức. Cùng nhau lan tỏa giá trị,<br>thúc đẩy nghiên cứu và phát triển cộng đồng<br>học thuật bền vững.</p></div></section>
<section class="auth-panel"><div class="figma-auth-card register-card"><header><h2>NHỊP KHOA <span>The faculty post</span></h2><div class="faculty-mark"><i></i><span class="faculty-symbol"><img src="assets/images/figma/brand-horse.png" alt=""></span><i></i></div><h1>Đăng ký</h1><p>Đăng ký tài khoản thành viên Nhịp Khoa</p></header><?php if(isset($errors['register'])):?><div class="message error"><?= e($errors['register']) ?></div><?php endif;?>
<form method="post" class="figma-auth-form compact" novalidate><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><label>Họ và tên<input type="text" name="full_name" maxlength="120" placeholder="Nhập họ và tên của bạn" value="<?= e($values['full_name']) ?>" required><?php if(isset($errors['full_name'])):?><small><?= e($errors['full_name']) ?></small><?php endif;?></label><label>Email<input type="email" name="email" maxlength="150" placeholder="Nhập email của bạn" value="<?= e($values['email']) ?>" required><?php if(isset($errors['email'])):?><small><?= e($errors['email']) ?></small><?php endif;?></label><label>Mật khẩu<input type="password" name="password" minlength="8" maxlength="72" placeholder="Nhập mật khẩu của bạn" required><?php if(isset($errors['password'])):?><small><?= e($errors['password']) ?></small><?php endif;?></label><label>Xác nhận mật khẩu<input type="password" name="password_confirmation" minlength="8" maxlength="72" placeholder="Nhập lại mật khẩu của bạn" required><?php if(isset($errors['password_confirmation'])):?><small><?= e($errors['password_confirmation']) ?></small><?php endif;?></label><label class="check terms"><input type="checkbox" required><span>Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a></span></label><button type="submit">Đăng ký</button></form><p class="auth-account">Đã có tài khoản? <a href="dang-nhap.php">Đăng nhập</a></p><a class="back-home" href="index.php">← Quay lại trang chủ</a><div class="role-note">Tài khoản đăng ký mặc định có vai trò thành viên</div>
</div></section></main></body></html>
