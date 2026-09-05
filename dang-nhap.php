<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';
if (!empty($_SESSION['user'])) {
    redirect('index.php');
}

$email = '';
$errors = [];
$accountLocked = false;
$notice = $_SESSION['flash_success'] ?? '';
$flashError = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
        $errors['email'] = 'Vui lòng nhập email hợp lệ, tối đa 150 ký tự.';
    }
    if ($password === '' || strlen($password) < 8 || strlen($password) > 72) {
        $errors['password'] = 'Mật khẩu phải có từ 8 đến 72 ký tự.';
    }

    if ($errors === []) {
        try {
            $statement = db()->prepare(
                'SELECT u.id, u.email, u.password_hash, u.full_name, u.status, r.code AS role
                 FROM users u INNER JOIN roles r ON r.id = u.role_id
                 WHERE u.email = :email LIMIT 1'
            );
            $statement->execute(['email' => $email]);
            $user = $statement->fetch();

            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors['login'] = 'Email hoặc mật khẩu không chính xác.';
            } elseif ($user['status'] !== 'active') {
                $accountLocked = true;
                $errors['login'] = 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => (int) $user['id'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                ];
                redirect($user['role'] === 'admin' ? 'admin/dashboard.php' : 'index.php');
            }
        } catch (PDOException $exception) {
            $errors['login'] = 'Chưa kết nối được cơ sở dữ liệu. Hãy kiểm tra MySQL và cấu hình.';
        }
    }
}

?><!doctype html><html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Đăng nhập - Nhịp Khoa</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/css/style.css"></head><body class="auth-page">
<main class="auth-layout"><section class="auth-visual"><div class="auth-visual-copy"><h2>NHỊP KHOA <span>The faculty post</span></h2><i></i><p>Nhịp khoa là không gian chia sẻ học thuật<br>và kết nối tri thức. Cùng nhau lan tỏa giá trị,<br>thúc đẩy nghiên cứu và phát triển cộng đồng<br>học thuật bền vững.</p></div></section>
<section class="auth-panel"><div class="figma-auth-card"><header><h2>NHỊP KHOA <span>The faculty post</span></h2><div class="faculty-mark"><i></i><span class="faculty-symbol"><img src="assets/images/figma/brand-horse.png" alt=""></span><i></i></div><h1>Đăng nhập</h1><p>Truy cập tài khoản Nhịp Khoa</p></header>
<?php if ($notice !== ''): ?><div class="message success"><?= e($notice) ?></div><?php endif; ?><?php if ($flashError !== ''): ?><div class="message error"><?= e($flashError) ?></div><?php endif; ?><?php if (isset($errors['login'])): ?><?php if ($accountLocked): ?><div class="account-locked-message" role="alert"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M10.3 2.9 1.8 17.1A2 2 0 0 0 3.5 20h17a2 2 0 0 0 1.7-2.9L13.7 2.9a2 2 0 0 0-3.4 0Z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg><span>Tài khoản đã bị khóa.</span></div><?php else: ?><div class="message error"><?= e($errors['login']) ?></div><?php endif; ?><?php endif; ?>
<form method="post" class="figma-auth-form" novalidate><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><label>Email<input type="email" name="email" maxlength="150" autocomplete="email" placeholder="Nhập email của bạn" value="<?= e($email) ?>" required><?php if(isset($errors['email'])):?><small><?= e($errors['email']) ?></small><?php endif;?></label><label>Mật khẩu<div class="password-field"><input type="password" name="password" minlength="8" maxlength="72" autocomplete="current-password" placeholder="Nhập mật khẩu của bạn" required><button class="password-toggle" type="button" aria-label="Hiện mật khẩu" aria-pressed="false"><span class="eye-icon" aria-hidden="true"></span></button></div><?php if(isset($errors['password'])):?><small><?= e($errors['password']) ?></small><?php endif;?></label><button type="submit">Đăng nhập</button></form><p class="auth-account">Chưa có tài khoản? <a href="dang-ky.php">Đăng ký</a></p><a class="back-home" href="index.php">← Quay lại trang chủ</a><div class="security-note"><svg class="security-icon" aria-hidden="true" viewBox="0 0 24 24"><path d="M12 3 4.5 6v5.3c0 4.6 3.2 7.8 7.5 9.7 4.3-1.9 7.5-5.1 7.5-9.7V6L12 3Z"/><path d="m8.8 12 2.1 2.1 4.4-4.5"/></svg><span>Để đảm bảo an toàn, hệ thống NHỊP KHOA không bao giờ yêu cầu bạn chia sẻ mật khẩu.</span></div>
</div></section></main><script src="assets/js/password-toggle.js"></script></body></html>
