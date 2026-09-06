<?php
require_once __DIR__ . '/../config/database.php';

/*
 * TẠM THỜI GIẢ LẬP TÁC GIẢ
 * Sau khi nhóm merge phần Login thì xóa đoạn này.
 */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['full_name'] = 'Nguyễn Văn A';
    $_SESSION['role'] = 'author';
}

$authorId = $_SESSION['user_id'];

/* Lấy thông tin tác giả */
$stmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
$stmt->execute([$authorId]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['full_name'] = $user['full_name'];
}

/* Đếm tổng số bài */
$stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE author_id = ?");
$stmt->execute([$authorId]);
$totalPosts = $stmt->fetchColumn();

/* Đếm bài nháp */
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM posts
    WHERE author_id = ? AND status = 'draft'
");
$stmt->execute([$authorId]);
$draftPosts = $stmt->fetchColumn();

/* Đếm bài chờ duyệt */
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM posts
    WHERE author_id = ? AND status = 'pending'
");
$stmt->execute([$authorId]);
$pendingPosts = $stmt->fetchColumn();

/* Đếm bài đã đăng */
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM posts
    WHERE author_id = ? AND status = 'published'
");
$stmt->execute([$authorId]);
$publishedPosts = $stmt->fetchColumn();

/* Đếm bài bị từ chối */
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM posts
    WHERE author_id = ? AND status = 'rejected'
");
$stmt->execute([$authorId]);
$rejectedPosts = $stmt->fetchColumn();

/* Lấy bài viết gần đây */
$stmt = $pdo->prepare("
    SELECT p.id, p.title, p.status, p.updated_at,
           c.name AS category_name
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.author_id = ?
    ORDER BY p.updated_at DESC
    LIMIT 3
");

$stmt->execute([$authorId]);
$recentPosts = $stmt->fetchAll();

$pageTitle = 'Trang tổng quan';
$pageCss = 'dashboard.css';

include __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-container">

    <!-- Lời chào -->
    <section class="welcome-section">
        <h1>
            Xin chào,
            <?= htmlspecialchars($_SESSION['full_name'] ?? 'Tác giả') ?>!
        </h1>
        <p>Quản lý và theo dõi các bài viết của bạn.</p>
    </section>

    <!-- Thống kê -->
    <section class="statistics">

        <div class="stat-card">
            <div class="stat-icon stat-blue">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div class="stat-info">
                <strong><?= $totalPosts ?></strong>
                <span>Tổng số bài</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-yellow">
                <i class="fa-regular fa-clipboard"></i>
            </div>
            <div class="stat-info">
                <strong><?= $draftPosts ?></strong>
                <span>Nháp</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-purple">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div class="stat-info">
                <strong><?= $pendingPosts ?></strong>
                <span>Chờ duyệt</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-green">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <div class="stat-info">
                <strong><?= $publishedPosts ?></strong>
                <span>Đã đăng</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-red">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="stat-info">
                <strong><?= $rejectedPosts ?></strong>
                <span>Từ chối</span>
            </div>
        </div>

    </section>

    <!-- Bài viết gần đây -->
    <section class="recent-posts">

        <div class="recent-header">
            <h2>Bài viết gần đây</h2>

            <a href="<?= BASE_URL ?>author/posts.php"
               class="view-all">
                Xem tất cả
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="table-wrapper">

            <table class="posts-table">

                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Chuyên mục</th>
                        <th>Ngày cập nhật</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($recentPosts)): ?>

                    <?php foreach ($recentPosts as $post): ?>

                        <?php
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
                        ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($post['title']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $post['category_name']
                                    ?? 'Chưa phân loại'
                                ) ?>
                            </td>

                            <td>
                                <?= date(
                                    'd/m/Y',
                                    strtotime($post['updated_at'])
                                ) ?>
                            </td>

                            <td>
                                <span class="status <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>

                            <td>

                                <?php if (
                                    $post['status'] === 'draft'
                                    || $post['status'] === 'rejected'
                                ): ?>

                                    <a
                                        href="<?= BASE_URL ?>author/edit.php?id=<?= $post['id'] ?>"
                                        class="action-button">
                                        Sửa
                                    </a>

                                <?php else: ?>

                                    <a
                                        href="<?= BASE_URL ?>author/view.php?id=<?= $post['id'] ?>"
                                        class="action-button">
                                        Xem
                                    </a>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="empty-post">
                            Bạn chưa có bài viết nào.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>