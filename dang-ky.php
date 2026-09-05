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

$pageTitle = 'Đăng ký';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-card">
    <h1>Tạo tài khoản độc giả</h1>
    <p>Tài khoản đăng ký công khai luôn là Độc giả. Chỉ Admin được cấp vai trò khác.</p>
    <?php if (isset($errors['register'])): ?><div class="message error"><?= e($errors['register']) ?></div><?php endif; ?>
    <form method="post" class="auth-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Họ và tên<input type="text" name="full_name" maxlength="120" value="<?= e($values['full_name']) ?>" required>
            <?php if (isset($errors['full_name'])): ?><small class="field-error"><?= e($errors['full_name']) ?></small><?php endif; ?>
        </label>
        <label>Email<input type="email" name="email" maxlength="150" value="<?= e($values['email']) ?>" required>
            <?php if (isset($errors['email'])): ?><small class="field-error"><?= e($errors['email']) ?></small><?php endif; ?>
        </label>
        <label>Mật khẩu<input type="password" name="password" minlength="8" maxlength="72" required>
            <?php if (isset($errors['password'])): ?><small class="field-error"><?= e($errors['password']) ?></small><?php endif; ?>
        </label>
        <label>Nhập lại mật khẩu<input type="password" name="password_confirmation" minlength="8" maxlength="72" required>
            <?php if (isset($errors['password_confirmation'])): ?><small class="field-error"><?= e($errors['password_confirmation']) ?></small><?php endif; ?>
        </label>
        <button class="primary-button" type="submit">Đăng ký</button>
    </form>
    <p class="auth-switch">Đã có tài khoản? <a href="dang-nhap.php">Đăng nhập</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
