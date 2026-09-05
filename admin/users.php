<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
requireRole(['admin']);

$allowedRoles = ['reader', 'author', 'editor'];
$allowedStatuses = ['active', 'locked'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $action = (string) ($_POST['action'] ?? '');
    try {
        if (!$userId || $userId === (int) (currentUser()['id'] ?? 0)) {
            throw new RuntimeException('Không thể thay đổi tài khoản Admin đang đăng nhập.');
        }
        $find = db()->prepare('SELECT u.status,r.code AS role FROM users u JOIN roles r ON r.id=u.role_id WHERE u.id=:id');
        $find->execute(['id' => $userId]);
        $target = $find->fetch();
        if (!$target) throw new RuntimeException('Không tìm thấy tài khoản.');
        if ($target['role'] === 'admin') throw new RuntimeException('Không thể thay đổi một Admin khác tại màn hình này.');

        if ($action === 'change_role') {
            $role = (string) ($_POST['role'] ?? '');
            if (!in_array($role, $allowedRoles, true)) throw new RuntimeException('Vai trò không hợp lệ.');
            $update = db()->prepare('UPDATE users SET role_id=(SELECT id FROM roles WHERE code=:role LIMIT 1) WHERE id=:id');
            $update->execute(['role' => $role, 'id' => $userId]);
            $_SESSION['admin_notice'] = 'Đã cập nhật vai trò tài khoản.';
        } elseif ($action === 'toggle_status') {
            $nextStatus = $target['status'] === 'active' ? 'locked' : 'active';
            $update = db()->prepare('UPDATE users SET status=:status WHERE id=:id');
            $update->execute(['status' => $nextStatus, 'id' => $userId]);
            $_SESSION['admin_notice'] = $nextStatus === 'locked' ? 'Đã khóa tài khoản.' : 'Đã mở khóa tài khoản.';
        } else {
            throw new RuntimeException('Thao tác không hợp lệ.');
        }
    } catch (Throwable $exception) {
        $_SESSION['admin_error'] = $exception instanceof RuntimeException ? $exception->getMessage() : 'Không thể cập nhật tài khoản.';
    }
    redirect('users.php');
}

$keyword = trim((string) ($_GET['q'] ?? ''));
$roleFilter = (string) ($_GET['role'] ?? '');
$statusFilter = (string) ($_GET['status'] ?? '');
$conditions = [];
$parameters = [];
if ($keyword !== '') { $conditions[] = '(u.full_name LIKE :keyword OR u.email LIKE :keyword)'; $parameters['keyword'] = '%' . $keyword . '%'; }
if (in_array($roleFilter, array_merge(['admin'], $allowedRoles), true)) { $conditions[] = 'r.code=:role'; $parameters['role'] = $roleFilter; }
if (in_array($statusFilter, $allowedStatuses, true)) { $conditions[] = 'u.status=:status'; $parameters['status'] = $statusFilter; }
$where = $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';
$statement = db()->prepare('SELECT u.id,u.full_name,u.email,u.status,u.created_at,r.code AS role,r.name AS role_name FROM users u JOIN roles r ON r.id=u.role_id' . $where . ' ORDER BY u.created_at DESC LIMIT 50');
$statement->execute($parameters);
$users = $statement->fetchAll();

$notice = $_SESSION['admin_notice'] ?? '';
$error = $_SESSION['admin_error'] ?? '';
unset($_SESSION['admin_notice'], $_SESSION['admin_error']);
$pageTitle = 'Quản lý tài khoản';
$adminPage = 'users';
require __DIR__ . '/_header.php';
?>
<section class="admin-heading"><div><p>NGƯỜI DÙNG VÀ PHÂN QUYỀN</p><h1>Quản lý tài khoản</h1><span>Tìm kiếm, cấp vai trò và kiểm soát trạng thái đăng nhập.</span></div></section>
<?php if ($notice !== ''): ?><div class="admin-alert success"><?= e($notice) ?></div><?php endif; ?>
<?php if ($error !== ''): ?><div class="admin-alert error"><?= e($error) ?></div><?php endif; ?>
<section class="admin-panel account-panel">
<form class="admin-filters" method="get">
<label class="admin-search"><span>⌕</span><input type="search" name="q" value="<?= e($keyword) ?>" placeholder="Tìm theo tên hoặc email"></label>
<select name="role" aria-label="Lọc vai trò"><option value="">Tất cả vai trò</option><option value="admin" <?= $roleFilter === 'admin' ? 'selected' : '' ?>>Quản trị viên</option><option value="editor" <?= $roleFilter === 'editor' ? 'selected' : '' ?>>Biên tập viên</option><option value="author" <?= $roleFilter === 'author' ? 'selected' : '' ?>>Tác giả</option><option value="reader" <?= $roleFilter === 'reader' ? 'selected' : '' ?>>Độc giả</option></select>
<select name="status" aria-label="Lọc trạng thái"><option value="">Tất cả trạng thái</option><option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Hoạt động</option><option value="locked" <?= $statusFilter === 'locked' ? 'selected' : '' ?>>Đã khóa</option></select>
<button class="filter-button" type="submit">Lọc tài khoản</button><?php if ($keyword !== '' || $roleFilter !== '' || $statusFilter !== ''): ?><a class="clear-filter" href="users.php">Xóa lọc</a><?php endif; ?>
</form>
<div class="account-summary"><strong><?= count($users) ?></strong><span>tài khoản được hiển thị</span><small>Tài khoản đăng ký mới luôn là Độc giả.</small></div>
<div class="admin-table-wrap"><table class="admin-table account-table"><thead><tr><th>Người dùng</th><th>Vai trò hiện tại</th><th>Trạng thái</th><th>Ngày tạo</th><th>Thao tác</th></tr></thead><tbody>
<?php foreach ($users as $user): $protected = $user['role'] === 'admin'; ?><tr>
<td><div class="user-cell"><span><?= e(mb_strtoupper(mb_substr($user['full_name'], 0, 1))) ?></span><div><b><?= e($user['full_name']) ?></b><small><?= e($user['email']) ?></small></div></div></td>
<td><?php if ($protected): ?><span class="role-chip admin-role">Quản trị viên</span><?php else: ?><form class="role-form" method="post"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="user_id" value="<?= (int) $user['id'] ?>"><input type="hidden" name="action" value="change_role"><select name="role"><option value="reader" <?= $user['role'] === 'reader' ? 'selected' : '' ?>>Độc giả</option><option value="author" <?= $user['role'] === 'author' ? 'selected' : '' ?>>Tác giả</option><option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Biên tập viên</option></select><button type="submit">Lưu</button></form><?php endif; ?></td>
<td><span class="status-chip <?= e($user['status']) ?>"><?= $user['status'] === 'active' ? 'Hoạt động' : 'Đã khóa' ?></span></td><td><?= e(date('d/m/Y', strtotime($user['created_at']))) ?></td>
<td><?php if (!$protected): ?><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="user_id" value="<?= (int) $user['id'] ?>"><input type="hidden" name="action" value="toggle_status"><button class="status-action <?= $user['status'] === 'active' ? 'lock' : 'unlock' ?>" type="submit"><?= $user['status'] === 'active' ? 'Khóa' : 'Mở khóa' ?></button></form><?php else: ?><span class="protected-note">Được bảo vệ</span><?php endif; ?></td></tr><?php endforeach; ?>
<?php if ($users === []): ?><tr><td colspan="5"><div class="admin-empty"><strong>Không tìm thấy tài khoản</strong><span>Hãy thử từ khóa hoặc bộ lọc khác.</span></div></td></tr><?php endif; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/_footer.php'; ?>
