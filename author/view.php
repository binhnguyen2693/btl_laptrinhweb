<?php
require_once __DIR__ . '/../includes/author-area.php';
$postId = (int)($_GET['id'] ?? 0);

if ($postId <= 0) {
    die('Bài viết không hợp lệ.');
}

/* Lấy bài viết đúng của tác giả đang đăng nhập */
$stmt = $pdo->prepare("
    SELECT p.*,
           c.name AS category_name,
           u.full_name AS author_name
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN users u ON p.author_id = u.id
    WHERE p.id = ? AND p.author_id = ?
");

$stmt->execute([$postId, $authorId]);
$post = $stmt->fetch();

if (!$post) {
    die('Không tìm thấy bài viết hoặc bạn không có quyền xem bài này.');
}

/* Hiển thị trạng thái */
switch ($post['status']) {
    case 'draft':
        $statusClass = 'draft';
        $statusText = 'Nháp';
        break;

    case 'pending':
        $statusClass = 'pending';
        $statusText = 'Chờ duyệt';
        break;

    case 'published':
        $statusClass = 'published';
        $statusText = 'Đã đăng';
        break;

    case 'rejected':
        $statusClass = 'rejected';
        $statusText = 'Từ chối';
        break;

    default:
        $statusClass = '';
        $statusText = 'Không xác định';
}

$postCode = 'BV' . str_pad($post['id'], 3, '0', STR_PAD_LEFT);

$pageTitle = 'Xem bài viết';
$pageCss = 'view.css';

include __DIR__ . '/../includes/author-header.php';
?>

<div class="view-post-container">

    <div class="view-post-top">
        <a href="<?= BASE_URL ?>author/posts.php"
           class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại
        </a>

        <div class="view-post-actions">

            <?php if ($post['status'] === 'draft' || $post['status'] === 'rejected'): ?>
                <a href="<?= BASE_URL ?>author/edit.php?id=<?= $post['id'] ?>"
                   class="edit-post-button">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Chỉnh sửa
                </a>
            <?php endif; ?>

        </div>
    </div>

    <article class="view-post-card">

        <div class="view-post-header">

            <div class="post-meta-top">
                <span class="post-view-code">
                    <?= htmlspecialchars($postCode) ?>
                </span>

                <span class="status <?= $statusClass ?>">
                    <?= htmlspecialchars($statusText) ?>
                </span>
            </div>

            <h1>
                <?= htmlspecialchars($post['title']) ?>
            </h1>

            <div class="post-information">
                <span>
                    <i class="fa-regular fa-user"></i>
                    <?= htmlspecialchars($post['author_name'] ?? 'Tác giả') ?>
                </span>

                <span>
                    <i class="fa-regular fa-folder"></i>
                    <?= htmlspecialchars($post['category_name'] ?? 'Chưa phân loại') ?>
                </span>

                <span>
                    <i class="fa-regular fa-calendar"></i>
                    <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
                </span>
            </div>

        </div>

        <?php if (!empty($post['thumbnail'])): ?>

            <div class="view-thumbnail">
                <img
                    src="<?= BASE_URL ?>assets/uploads/<?= htmlspecialchars($post['thumbnail']) ?>"
                    alt="<?= htmlspecialchars($post['title']) ?>">
            </div>

        <?php endif; ?>

        <?php if (!empty($post['summary'])): ?>

            <div class="view-summary">
                <h3>Tóm tắt</h3>

                <p>
                    <?= nl2br(htmlspecialchars($post['summary'])) ?>
                </p>
            </div>

        <?php endif; ?>

        <div class="view-content">

            <h3>Nội dung bài viết</h3>

            <div class="article-content">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>

        </div>

        <?php if (
            $post['status'] === 'rejected' &&
            !empty($post['editor_note'])
        ): ?>

            <div class="editor-note-box">

                <div class="editor-note-title">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Lý do từ chối
                </div>

                <p>
                    <?= nl2br(htmlspecialchars($post['editor_note'])) ?>
                </p>

            </div>

        <?php endif; ?>

        <div class="view-post-footer">

            <div>
                <strong>Ngày tạo:</strong>
                <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
            </div>

            <div>
                <strong>Cập nhật lần cuối:</strong>
                <?= date('d/m/Y H:i', strtotime($post['updated_at'])) ?>
            </div>

        </div>

    </article>

</div>

<?php include __DIR__ . '/../includes/role-footer.php'; ?>
