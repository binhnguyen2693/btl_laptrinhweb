<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/public-posts.php';
$postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$post = null;
$related = [];
$loadError = false;
$context = publicContext();
if ($postId && $postId > 0) {
    try {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT p.*,c.name AS category_name,c.slug AS category_slug,u.full_name AS author_name FROM posts p JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.author_id WHERE p.id=? AND p.status='published' AND c.status='active' LIMIT 1");
        $stmt->execute([$postId]);
        $post = $stmt->fetch() ?: null;
        if ($post) {
            $stmt = $pdo->prepare("SELECT p.id,p.title,p.thumbnail,p.published_at,p.created_at FROM posts p JOIN categories c ON c.id=p.category_id WHERE p.category_id=? AND p.id<>? AND p.status='published' AND c.status='active' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT 3");
            $stmt->execute([$post['category_id'], $postId]);
            $related = $stmt->fetchAll();
        }
    } catch (PDOException $exception) {
        $loadError = true;
    }
}
if ($loadError) http_response_code(503);
elseif (!$post) http_response_code(404);
$pageTitle = $loadError ? 'Chưa thể tải bài viết' : ($post['title'] ?? 'Không tìm thấy bài viết');
$activeNav = $post['category_slug'] ?? '';
$publicStyles = true;
require __DIR__ . '/includes/header.php';
?>
<section class="public-pages"><div class="site-shell">
<a class="public-back" href="<?= e(publicBackUrl($context)) ?>">← Quay lại danh sách bài viết</a>
<?php if ($loadError): ?>
<div class="public-empty" role="alert"><h1>Chưa thể tải bài viết</h1><p>Kết nối dữ liệu đang gián đoạn. Vui lòng thử lại sau.</p><a href="<?= e(publicDetailUrl((int) $postId, $context)) ?>">Thử lại</a></div>
<?php elseif (!$post): ?>
<div class="public-empty"><h1>Không tìm thấy bài viết</h1><p>Bài viết không tồn tại, chưa được duyệt hoặc đã bị ẩn.</p></div>
<?php else: ?>
<div class="public-layout"><article class="public-detail-body">
<p class="public-eyebrow"><?= e($post['category_name']) ?></p><h1><?= e($post['title']) ?></h1>
<p class="public-byline"><?= e(publicPostDate($post)) ?> · Tác giả: <?= e($post['author_name']) ?></p>
<img class="public-cover" src="<?= e(publicPostImage($post['thumbnail'])) ?>" alt="" data-public-image>
<p class="public-summary"><?= e($post['summary']) ?></p>
<div class="public-content"><?= $post['content'] ?></div>
</article><aside class="public-sidebar"><section><h2>Bài viết liên quan</h2>
<?php foreach ($related as $item): ?>
<a class="public-related" href="<?= e(publicDetailUrl((int) $item['id'], $context)) ?>"><img src="<?= e(publicPostImage($item['thumbnail'])) ?>" alt="" data-public-image><span><?= e($item['title']) ?><small><?= e(publicPostDate($item)) ?></small></span></a>
<?php endforeach; ?>
<?php if (!$related): ?><p>Chưa có bài viết liên quan.</p><?php endif; ?>
</section><section><h2>Danh mục</h2><nav aria-label="Danh mục bài viết"><?php foreach (PUBLIC_CATEGORIES as $slug => $name): ?><a href="pages/<?= e($slug) ?>.php"><?= e($name) ?></a><?php endforeach; ?></nav></section></aside></div>
<?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
