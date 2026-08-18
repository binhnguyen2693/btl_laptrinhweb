<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../config/csrf.php';

$commentModel = new Comment($pdo);

$csrfToken = generateCsrfToken();
$filter = $_GET['status'] ?? 'all';

$thongBao = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $csrfTokenPost = $_POST['csrf_token'] ?? '';

    if (!verifyCsrfToken($csrfTokenPost)) {

        $thongBao = 'Yêu cầu không hợp lệ. CSRF token không đúng.';

    } else {

        $commentId = (int) ($_POST['comment_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($commentId <= 0) {

            $thongBao = 'ID bình luận không hợp lệ.';

        } else {

            $result = $commentModel->updateStatus($commentId, $status);

            if ($result) {

                $thongBao = 'Cập nhật trạng thái bình luận thành công.';

            } else {

                $thongBao = 'Không thể cập nhật trạng thái bình luận.';
            }
        }
    }
}

if ($filter === 'all') {

    $binhLuan = $commentModel->getAll();

} else {

    $binhLuan = $commentModel->getByStatus($filter);
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý bình luận - StoryHub</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>

        body {
            background: #f7f3ee;
        }

        .comment-page {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .comment-header {
            margin-bottom: 25px;
        }

        .comment-header h1 {
            margin-bottom: 8px;
        }

        .comment-header p {
            color: #666;
        }

        .comment-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .comment-filter a {
            display: inline-block;
            padding: 8px 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
        }

        .comment-filter a:hover {
            background: #f0f0f0;
        }

        .message {
            background: #e5f7e9;
            color: #176b2c;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .comment-table-wrapper {
            background: white;
            border-radius: 12px;
            padding: 20px;
            overflow-x: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .comment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .comment-table th,
        .comment-table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }

        .comment-table th {
            background: #f5f1ec;
        }

        .comment-content {
            max-width: 350px;
            word-break: break-word;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-hidden {
            background: #e2e3e5;
            color: #383d41;
        }

        .action-button {
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 2px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

    </style>

</head>

<body>

<main class="comment-page">

    <div class="comment-header">

        <h1>Quản lý bình luận</h1>

        <p>Quản lý các bình luận của người dùng trên StoryHub.</p>

    </div>


    <?php if ($thongBao !== ''): ?>

        <div class="message">

            <?= htmlspecialchars($thongBao, ENT_QUOTES, 'UTF-8') ?>

        </div>

    <?php endif; ?>


    <div class="comment-filter">

        <a href="binhluan.php">Tất cả</a>

        <a href="binhluan.php?status=pending">Chờ duyệt</a>

        <a href="binhluan.php?status=approved">Đã hiển thị</a>

        <a href="binhluan.php?status=hidden">Đã ẩn</a>

    </div>


    <div class="comment-table-wrapper">

        <table class="comment-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Người bình luận</th>
                    <th>Bài viết</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Thời gian</th>
                    <th>Thao tác</th>
                </tr>

            </thead>

            <tbody>

            <?php if (count($binhLuan) === 0): ?>

                <tr>

                    <td colspan="7" class="empty">
                        Không có bình luận nào.
                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($binhLuan as $item): ?>

                    <tr>

                        <!-- ID -->

                        <td>
                            <?= (int) $item['id'] ?>
                        </td>


                        <!-- NGƯỜI BÌNH LUẬN -->

                        <td>
                            <?= htmlspecialchars($item['user_name'] ?? 'Không xác định', ENT_QUOTES, 'UTF-8') ?>
                        </td>


                        <!-- BÀI VIẾT -->

                        <td>
                            <?= htmlspecialchars($item['post_title'] ?? 'Bài viết không tồn tại', ENT_QUOTES, 'UTF-8') ?>
                        </td>


                        <td class="comment-content">
                            <?= htmlspecialchars($item['content'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>


                        <td>

                            <?php if ($item['status'] === 'pending'): ?>

                                <span class="status status-pending">
                                    Chờ duyệt
                                </span>

                            <?php elseif ($item['status'] === 'approved'): ?>

                                <span class="status status-approved">
                                    Đã hiển thị
                                </span>

                            <?php else: ?>

                                <span class="status status-hidden">
                                    Đã ẩn
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= htmlspecialchars($item['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>


                        <td>

                            <?php if ($item['status'] === 'pending'): ?>


                                <button
                                    type="button"
                                    class="action-button btn-duyet"
                                    data-id="<?= (int) $item['id'] ?>"
                                    data-csrf="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    Duyệt
                                </button>


                                <button
                                    type="button"
                                    class="action-button hide-button"
                                    data-id="<?= (int) $item['id'] ?>"
                                    data-csrf="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    Ẩn
                                </button>


                            <?php elseif ($item['status'] === 'approved'): ?>


                                <button
                                    type="button"
                                    class="action-button hide-button"
                                    data-id="<?= (int) $item['id'] ?>"
                                    data-csrf="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    Ẩn
                                </button>


                            <?php elseif ($item['status'] === 'hidden'): ?>

                                <button
                                    type="button"
                                    class="action-button show-button"
                                    data-id="<?= (int) $item['id'] ?>"
                                    data-csrf="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    Hiển thị
                                </button>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</main>


<script>


document.querySelectorAll('.btn-duyet').forEach(function(button) {

    button.addEventListener('click', function() {

        const commentId = this.dataset.id;
        const csrfToken = this.dataset.csrf;

        const formData = new FormData();

        formData.append('comment_id', commentId);
        formData.append('csrf_token', csrfToken);

        fetch('api/duyet-binh-luan.php', {
            method: 'POST',
            body: formData
        })

        .then(response => response.json())

        .then(data => {

            if (data.success) {

                alert(data.message);
                location.reload();

            } else {

                alert(data.message);
            }

        })

        .catch(error => {

            console.error(error);
            alert('Có lỗi xảy ra khi duyệt bình luận.');

        });

    });

});


document.querySelectorAll('.hide-button').forEach(function(button) {

    button.addEventListener('click', function() {

        const commentId = this.dataset.id;
        const csrfToken = this.dataset.csrf;

        const formData = new FormData();

        formData.append('comment_id', commentId);
        formData.append('csrf_token', csrfToken);
        formData.append('status', 'hidden');

        fetch('api/duyet-binh-luan.php', {
            method: 'POST',
            body: formData
        })

        .then(response => response.json())

        .then(data => {

            if (data.success) {

                alert(data.message);
                location.reload();

            } else {

                alert(data.message);
            }

        })

        .catch(error => {

            console.error(error);
            alert('Có lỗi xảy ra khi ẩn bình luận.');

        });

    });

});



document.querySelectorAll('.show-button').forEach(function(button) {

    button.addEventListener('click', function() {

        const commentId = this.dataset.id;
        const csrfToken = this.dataset.csrf;

        const formData = new FormData();

        formData.append('comment_id', commentId);
        formData.append('csrf_token', csrfToken);
        formData.append('status', 'approved');

        fetch('api/duyet-binh-luan.php', {
            method: 'POST',
            body: formData
        })

        .then(response => response.json())

        .then(data => {

            if (data.success) {

                alert(data.message);
                location.reload();

            } else {

                alert(data.message);
            }

        })

        .catch(error => {

            console.error(error);
            alert('Có lỗi xảy ra khi hiển thị bình luận.');

        });

    });

});

</script>

</body>
</html>