<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/public-posts.php';

function sanitizePostContent(string $content): string
{
    $allowedTags = '<p><h2><h3><ul><ol><li><blockquote><strong><em><b><i><br>';
    return strip_tags($content, $allowedTags);
}

$postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$post = null;
$related = [];
$comments = [];
$loadError = false;
$commentError = '';
$commentSuccess = '';
$context = publicContext();

if ($postId && $postId > 0) {
    try {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT p.*,c.name AS category_name,c.slug AS category_slug,u.full_name AS author_name FROM posts p JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.author_id WHERE p.id=? AND p.status='published' AND c.status='active' LIMIT 1");
        $stmt->execute([$postId]);
        $post = $stmt->fetch() ?: null;
        if ($post) {
            $stmt = $pdo->prepare("SELECT c.id,c.content,c.created_at,u.full_name FROM comments c JOIN users u ON u.id=c.user_id WHERE c.post_id=? AND c.status='approved' ORDER BY c.created_at DESC");
            $stmt->execute([$postId]);
            $comments = $stmt->fetchAll();
            $stmt = $pdo->prepare("SELECT p.id,p.title,p.thumbnail,p.published_at,p.created_at FROM posts p JOIN categories c ON c.id=p.category_id WHERE p.category_id=? AND p.id<>? AND p.status='published' AND c.status='active' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT 3");
            $stmt->execute([$post['category_id'], $postId]);
            $related = $stmt->fetchAll();
        }
    } catch (PDOException $exception) {
        $loadError = true;
    }
}

$currentUser = currentUser();
if ($post && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_submit'])) {
    try {
        verifyCsrf();
        if ($currentUser === null) {
            $commentError = 'Vui lòng đăng nhập để bình luận.';
        } else {
            $stmt = $pdo->prepare("SELECT status FROM users WHERE id=? LIMIT 1");
            $stmt->execute([$currentUser['id']]);
            $userStatus = $stmt->fetchColumn();
            if ($userStatus !== 'active') {
                $commentError = 'Tài khoản của bạn không còn hoạt động nên không thể bình luận.';
            } else {
                $content = trim((string) ($_POST['content'] ?? ''));
                if ($content === '') {
                    $commentError = 'Vui lòng nhập nội dung bình luận.';
                } elseif (mb_strlen($content) > 1000) {
                    $commentError = 'Bình luận không được vượt quá 1000 ký tự.';
                } else {
                    $userId = $currentUser['id'];
                    $stmt = $pdo->prepare("INSERT INTO comments (post_id,user_id,content,status,created_at) VALUES (?,?,?, 'pending',NOW())");
                    $stmt->execute([$postId, $userId, $content]);
                    $_SESSION['comment_success'] = 'Bình luận đã được gửi và đang chờ duyệt.';
                    redirect(publicDetailUrl($postId, $context));
                }
            }
        }
    } catch (PDOException $exception) {
        $commentError = 'Không thể lưu bình luận. Vui lòng thử lại.';
    }
}

if (!empty($_SESSION['comment_success'])) {
    $commentSuccess = (string) $_SESSION['comment_success'];
    unset($_SESSION['comment_success']);
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
<div class="public-content"><?= sanitizePostContent((string) $post['content']) ?></div>
</article><aside class="public-sidebar"><section><h2>Bài viết liên quan</h2>
<?php foreach ($related as $item): ?>
<a class="public-related" href="<?= e(publicDetailUrl((int) $item['id'], $context)) ?>"><img src="<?= e(publicPostImage($item['thumbnail'])) ?>" alt="" data-public-image><span><?= e($item['title']) ?><small><?= e(publicPostDate($item)) ?></small></span></a>
<?php endforeach; ?>
<?php if (!$related): ?><p>Chưa có bài viết liên quan.</p><?php endif; ?>
</section><section><h2>Danh mục</h2><nav aria-label="Danh mục bài viết"><?php foreach (PUBLIC_CATEGORIES as $slug => $name): ?><a href="pages/<?= e($slug) ?>.php"><?= e($name) ?></a><?php endforeach; ?></nav></section>
<section><h2>Bình luận (<?= count($comments) ?>)</h2>
<?php if ($commentSuccess): ?><div class="comment-success"><?= e($commentSuccess) ?></div><?php endif; ?>
<?php if ($commentError): ?><div class="comment-error"><?= e($commentError) ?></div><?php endif; ?>
<div class="comments-list">
<?php if (!$comments): ?><p>Chưa có bình luận nào.</p><?php else: ?>
<?php foreach ($comments as $comment): ?>
<article class="comment-item">
<div class="comment-avatar"><?= e(mb_substr($comment['full_name'] ?? 'U', 0, 1)) ?></div>
<div class="comment-body">
<strong><?= e($comment['full_name'] ?? 'Người dùng') ?></strong>
<p><?= nl2br(e($comment['content'])) ?></p>
<small><?= e(date('d/m/Y H:i', strtotime($comment['created_at']))) ?></small>
</div>
</article>
<?php endforeach; ?>
<?php endif; ?>
</div>
<?php if ($currentUser === null): ?>
<div style="text-align:center; padding:15px; background:#fffaf7; border:1px solid #ead7cf; border-radius:8px; margin-top:15px;">
<p style="margin:0 0 10px; font-size:14px; color:#47352e;">Vui lòng đăng nhập để tham gia bình luận.</p>
<a href="dang-nhap.php" style="display:inline-block; padding:8px 16px; background:#913328; color:#fff; border-radius:6px; font-weight:600; text-decoration:none;">Đăng nhập</a>
</div>
<?php else: ?>
<form method="post" class="comment-form" id="commentForm">
<input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
<p class="comment-user">Đang bình luận với tên: <strong><?= e($currentUser['full_name']) ?></strong></p>
<div class="comment-field">
<textarea name="content" maxlength="1000" placeholder="Viết bình luận..." id="commentContent"></textarea>
<span class="comment-error" id="commentContentError"></span>
</div>
<button type="submit" name="comment_submit">Gửi bình luận</button>
</form>
<script>
document.getElementById('commentForm')?.addEventListener('submit',function(e){
    const content=document.getElementById('commentContent');
    const contentError=document.getElementById('commentContentError');
    let valid=true;
    if(content.value.trim()===''){
        contentError.textContent='Vui lòng nhập nội dung bình luận.';
        content.style.borderColor='#b42318';
        valid=false;
    }else{
        contentError.textContent='';
        content.style.borderColor='';
    }
    if(!valid){
        e.preventDefault();
    }
});
</script>
<?php endif; ?>
</section>
</aside></div>
<?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>