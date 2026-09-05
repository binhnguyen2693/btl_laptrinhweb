<?php
declare(strict_types=1);
$basePath = '../';
require_once __DIR__ . '/../includes/auth.php';
requireRole(['admin']);

$counts = ['users' => 0, 'posts' => 0, 'pending' => 0];
try {
    $counts['users'] = (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $counts['posts'] = (int) db()->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    $counts['pending'] = (int) db()->query("SELECT COUNT(*) FROM posts WHERE status = 'pending'")->fetchColumn();
} catch (PDOException $exception) {
    // Khung trang vẫn dùng được nếu dữ liệu thống kê chưa sẵn sàng.
}

$pageTitle = 'Dashboard quản trị';
require __DIR__ . '/../includes/header.php';
?>
<section class="section-heading"><div><p class="eyebrow">ADMIN</p><h1>Tổng quan hệ thống</h1></div></section>
<div class="stat-grid">
    <article><strong><?= $counts['users'] ?></strong><span>Tài khoản</span></article>
    <article><strong><?= $counts['posts'] ?></strong><span>Bài viết</span></article>
    <article><strong><?= $counts['pending'] ?></strong><span>Bài chờ duyệt</span></article>
</div>
<section class="permission-note"><h2>Phạm vi Người 1</h2><p>Khung quản trị và kiểm tra quyền Admin đã hoạt động. Các thành viên khác sẽ gắn chức năng của họ vào đây.</p></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
