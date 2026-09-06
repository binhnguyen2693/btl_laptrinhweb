<?php
require_once __DIR__ . '/../config/database.php';

/* Tạm thời giả lập biên tập viên, sau này có đăng nhập thì xóa 3 dòng này */
$_SESSION['user_id'] = 2;
$_SESSION['full_name'] = 'Biên tập viên';
$_SESSION['role'] = 'editor';

/* Thống kê */
$stmt = $pdo->query("
    SELECT
        SUM(status IN ('pending','published','rejected')) AS total,
        SUM(status = 'pending') AS pending,
        SUM(status = 'published') AS published,
        SUM(status = 'rejected') AS rejected
    FROM posts
");
$stats = $stmt->fetch();

$total = (int)($stats['total'] ?? 0);
$pending = (int)($stats['pending'] ?? 0);
$published = (int)($stats['published'] ?? 0);
$rejected = (int)($stats['rejected'] ?? 0);

/* 3 bài chờ duyệt mới nhất */
$stmt = $pdo->query("
    SELECT
        p.id,
        p.title,
        p.thumbnail,
        p.created_at,
        u.full_name AS author_name,
        c.name AS category_name
    FROM posts p
    INNER JOIN users u ON p.author_id = u.id
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'pending'
    ORDER BY p.created_at DESC
    LIMIT 3
");
$recentPosts = $stmt->fetchAll();

$pageTitle = 'Tổng quan - Biên tập viên';
$pageCss = 'editor-dashboard.css';

include __DIR__ . '/../includes/editor-header.php';
?>

<div class="editor-dashboard-container">
    <div class="editor-welcome">
        <h1>Xin chào, biên tập viên!</h1>
        <p>Quản lý và kiểm duyệt các bài viết trên hệ thống.</p>
    </div>

    <div class="editor-statistics">
        <div class="editor-stat-card">
            <div class="editor-stat-icon stat-blue">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div class="editor-stat-info">
                <strong><?= $total ?></strong>
                <span>Tổng số bài</span>
            </div>
        </div>

        <div class="editor-stat-card">
            <div class="editor-stat-icon stat-purple">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div class="editor-stat-info">
                <strong><?= $pending ?></strong>
                <span>Chờ duyệt</span>
            </div>
        </div>

        <div class="editor-stat-card">
            <div class="editor-stat-icon stat-green">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <div class="editor-stat-info">
                <strong><?= $published ?></strong>
                <span>Đã duyệt</span>
            </div>
        </div>

        <div class="editor-stat-card">
            <div class="editor-stat-icon stat-red">
                <i class="fa-regular fa-circle-xmark"></i>
            </div>
            <div class="editor-stat-info">
                <strong><?= $rejected ?></strong>
                <span>Từ chối</span>
            </div>
        </div>
    </div>

    <section class="editor-recent-posts">
        <div class="editor-recent-header">
            <h2>Bài viết chờ duyệt mới nhất</h2>
            <a href="<?= BASE_URL ?>editor/posts.php?status=pending" class="editor-view-all">
                Xem tất cả
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="editor-table-wrapper">
            <table class="editor-posts-table">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Chuyên mục</th>
                        <th>Ngày gửi</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($recentPosts)): ?>
                    <?php foreach ($recentPosts as $post): ?>
                        <tr>
                            <td>
                                <div class="editor-title-cell">
                                    <?php if (!empty($post['thumbnail'])): ?>
                                        <img src="<?= BASE_URL ?>assets/uploads/<?= htmlspecialchars($post['thumbnail']) ?>" alt="">
                                    <?php else: ?>
                                        <div class="no-thumbnail">
                                            <i class="fa-regular fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($post['title']) ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($post['author_name']) ?></td>
                            <td><?= htmlspecialchars($post['category_name'] ?? 'Chưa phân loại') ?></td>
                            <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>editor/posts.php?view=<?= $post['id'] ?>" class="editor-view-button">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="editor-empty">
                            Hiện chưa có bài viết nào đang chờ duyệt.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>