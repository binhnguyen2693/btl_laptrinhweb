<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';

$postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$post = null;
if ($postId) {
    try {
        $statement = db()->prepare("SELECT p.id,p.title,p.summary,p.content,p.thumbnail,p.published_at,p.updated_at,c.name AS category_name,u.full_name AS author_name FROM posts p JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.author_id WHERE p.id=:id AND p.status='published' AND c.status='active' LIMIT 1");
        $statement->execute(['id' => $postId]);
        $post = $statement->fetch() ?: null;
    } catch (PDOException $exception) {
        $post = null;
    }
}

if ($post === null) http_response_code(404);
$pageTitle = $post['title'] ?? 'Không tìm thấy bài viết';
require __DIR__ . '/includes/header.php';
?>
<section class="public-detail"><div class="site-shell">
<?php if ($post === null): ?>
<div class="public-state"><span>404</span><h1>Không tìm thấy bài viết</h1><p>Bài viết không tồn tại, chưa được duyệt hoặc đã bị ẩn.</p><a href="index.php#articles">← Quay lại trang chủ</a></div>
<?php else: ?>
<a class="detail-back" href="index.php#articles">← Quay lại bài viết</a><article class="detail-article"><div class="detail-meta"><span><?= e($post['category_name']) ?></span><span><?= e(date('d/m/Y', strtotime($post['published_at'] ?: $post['updated_at']))) ?></span></div><h1><?= e($post['title']) ?></h1><p class="detail-byline">Tác giả: <?= e($post['author_name']) ?></p><?php if (!empty($post['thumbnail'])): ?><img class="detail-cover" src="assets/uploads/<?= e($post['thumbnail']) ?>" alt=""><?php endif; ?><p class="detail-summary"><?= e($post['summary']) ?></p><div class="detail-content"><?= nl2br(e($post['content'])) ?></div></article>
<?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
