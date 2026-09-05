<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';
if (!empty($_SESSION['user'])) {
    redirect('index.php');
}

$email = '';
$errors = [];
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

$pageTitle = 'Đăng nhập';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-card">
    <h1>Đăng nhập</h1>
    <p>Dùng tài khoản đã đăng ký để sử dụng chức năng phù hợp với vai trò.</p>
    <?php if ($notice !== ''): ?><div class="message success"><?= e($notice) ?></div><?php endif; ?>
    <?php if ($flashError !== ''): ?><div class="message error"><?= e($flashError) ?></div><?php endif; ?>
    <?php if (isset($errors['login'])): ?><div class="message error"><?= e($errors['login']) ?></div><?php endif; ?>
    <form method="post" class="auth-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Email<input type="email" name="email" maxlength="150" autocomplete="email" value="<?= e($email) ?>" required>
            <?php if (isset($errors['email'])): ?><small class="field-error"><?= e($errors['email']) ?></small><?php endif; ?>
        </label>
        <label>Mật khẩu<input type="password" name="password" minlength="8" maxlength="72" autocomplete="current-password" required>
            <?php if (isset($errors['password'])): ?><small class="field-error"><?= e($errors['password']) ?></small><?php endif; ?>
        </label>
        <button class="primary-button" type="submit">Đăng nhập</button>
    </form>
    <p class="auth-switch">Chưa có tài khoản? <a href="dang-ky.php">Đăng ký độc giả</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
