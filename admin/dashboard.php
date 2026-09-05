<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
requireRole(['admin']);

$counts = ['users' => 0, 'posts' => 0, 'pending' => 0, 'locked' => 0];
$recentUsers = [];
try {
    $counts['users'] = (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $counts['posts'] = (int) db()->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    $counts['pending'] = (int) db()->query("SELECT COUNT(*) FROM posts WHERE status='pending'")->fetchColumn();
    $counts['locked'] = (int) db()->query("SELECT COUNT(*) FROM users WHERE status='locked'")->fetchColumn();
    $recentUsers = db()->query('SELECT u.full_name,u.email,u.status,u.created_at,r.name AS role_name FROM users u JOIN roles r ON r.id=u.role_id ORDER BY u.created_at DESC LIMIT 5')->fetchAll();
} catch (PDOException $exception) {
    $databaseError = 'Không thể tải số liệu. Hãy kiểm tra kết nối MySQL.';
}

$pageTitle = 'Tổng quan hệ thống';
$adminPage = 'dashboard';
require __DIR__ . '/_header.php';
?>
<section class="admin-heading"><div><p>XIN CHÀO, <?= e(currentUser()['full_name'] ?? 'ADMIN') ?></p><h1>Tổng quan hệ thống</h1><span>Theo dõi nhanh tài khoản và nội dung của Nhịp Khoa.</span></div><a class="admin-primary" href="users.php">Quản lý tài khoản →</a></section>
<?php if (isset($databaseError)): ?><div class="admin-alert error"><?= e($databaseError) ?></div><?php endif; ?>
<section class="admin-stats" aria-label="Thống kê hệ thống">
<article><span class="stat-icon wine">♙</span><div><small>Tổng tài khoản</small><strong><?= $counts['users'] ?></strong><p>Người dùng trong hệ thống</p></div></article>
<article><span class="stat-icon gold">▤</span><div><small>Tổng bài viết</small><strong><?= $counts['posts'] ?></strong><p>Tất cả trạng thái bài</p></div></article>
<article><span class="stat-icon green">✓</span><div><small>Chờ duyệt</small><strong><?= $counts['pending'] ?></strong><p>Cần biên tập viên xử lý</p></div></article>
<article><span class="stat-icon gray">⊘</span><div><small>Tài khoản khóa</small><strong><?= $counts['locked'] ?></strong><p>Không thể đăng nhập</p></div></article>
</section>
<section class="admin-panel"><header><div><h2>Tài khoản mới</h2><p>Năm tài khoản được tạo gần đây nhất</p></div><a href="users.php">Xem tất cả →</a></header><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Người dùng</th><th>Vai trò</th><th>Trạng thái</th><th>Ngày tạo</th></tr></thead><tbody>
<?php foreach ($recentUsers as $user): ?><tr><td><div class="user-cell"><span><?= e(mb_strtoupper(mb_substr($user['full_name'], 0, 1))) ?></span><div><b><?= e($user['full_name']) ?></b><small><?= e($user['email']) ?></small></div></div></td><td><span class="role-chip"><?= e($user['role_name']) ?></span></td><td><span class="status-chip <?= e($user['status']) ?>"><?= $user['status'] === 'active' ? 'Hoạt động' : 'Đã khóa' ?></span></td><td><?= e(date('d/m/Y', strtotime($user['created_at']))) ?></td></tr><?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/_footer.php'; ?>
