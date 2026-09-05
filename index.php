<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';

$posts = [];
$databaseError = false;
try {
    $posts = db()->query(
        "SELECT p.title, p.slug, p.summary, p.published_at, c.name AS category_name, u.full_name AS author_name
         FROM posts p INNER JOIN categories c ON c.id = p.category_id
         INNER JOIN users u ON u.id = p.author_id
         WHERE p.status = 'published' AND c.status = 'active'
         ORDER BY p.published_at DESC LIMIT 6"
    )->fetchAll();
} catch (PDOException $exception) {
    $databaseError = true;
}

$pageTitle = 'Trang chủ';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <p class="eyebrow">BÁO CHÍ GIẢI THÍCH SỰ THAY ĐỔI</p>
    <h1>Điều gì vừa thay đổi và nó ảnh hưởng đến bạn thế nào?</h1>
    <p>Nhịp Khoa tổng hợp thông tin đã được biên tập viên duyệt, kèm phần tóm tắt tác động dễ hiểu.</p>
</section>
<section class="section-heading"><div><p class="eyebrow">MỚI NHẤT</p><h2>Bài viết đã xuất bản</h2></div></section>
<?php if ($databaseError): ?>
    <div class="message error">Chưa đọc được dữ liệu. Hãy bật MySQL và chạy schema.sql, seed.sql.</div>
<?php elseif ($posts === []): ?>
    <div class="empty-state"><h2>Chưa có bài viết</h2><p>Bài chỉ xuất hiện khi có trạng thái Published.</p></div>
<?php else: ?>
    <div class="post-grid">
        <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <span class="category"><?= e($post['category_name']) ?></span>
                <h2><?= e($post['title']) ?></h2>
                <p><?= e($post['summary']) ?></p>
                <small><?= e($post['author_name']) ?> · <?= e(date('d/m/Y', strtotime($post['published_at']))) ?></small>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<section class="permission-note"><h2>Khách vẫn được đọc miễn phí</h2><p>Không đăng nhập vẫn xem được bài Published. Đăng nhập chỉ cần khi bình luận, lưu bài hoặc sử dụng chức năng theo vai trò.</p></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
