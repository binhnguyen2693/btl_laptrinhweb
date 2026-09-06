<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../config/csrf.php';

$commentModel = new Comment($pdo);

$csrfToken = generateCsrfToken();

$keyword = trim($_GET['keyword'] ?? '');
$filter = $_GET['status'] ?? 'all';
$postId = (int) ($_GET['post_id'] ?? 0);

$danhSachBaiViet = $commentModel->getPosts();

$binhLuan = $commentModel->search(
    $keyword,
    $filter,
    $postId
);

$thongBao = '';



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
        .comment-detail-link {
    color: #333;
    text-decoration: none;
}

.comment-detail-link:hover {
    color: #8b2f25;
    text-decoration: underline;
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
        .comment-search {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: nowrap;
}

.comment-search input[type="text"] {
    width: 320px;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

.comment-search select {
    width: 180px;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #d9d9d9;
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    background: white;
    font-size: 14px;
    box-sizing: border-box;
}

.comment-search button {
    width: 90px;
    height: 42px;
    border: none;
    border-radius: 4px;
    background: #8b2f25;
    color: white;
    font-size: 14px;
    cursor: pointer;
    flex-shrink: 0;
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


    <form method="GET" class="comment-search">

    <input
        type="text"
        name="keyword"
        placeholder="Tìm theo nội dung, người bình luận hoặc bài viết..."
        value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
    >

    <select name="status">
        <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>
            Tất cả trạng thái
        </option>

        <option value="pending" <?= $filter === 'pending' ? 'selected' : '' ?>>
            Chờ duyệt
        </option>

        <option value="approved" <?= $filter === 'approved' ? 'selected' : '' ?>>
            Đã hiển thị
        </option>

        <option value="hidden" <?= $filter === 'hidden' ? 'selected' : '' ?>>
            Đã ẩn
        </option>
    </select>

    <select name="post_id">

        <option value="0">
            Tất cả bài viết
        </option>

        <?php foreach ($danhSachBaiViet as $post): ?>

            <option
                value="<?= (int) $post['id'] ?>"
                <?= $postId === (int) $post['id'] ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
            </option>

        <?php endforeach; ?>

    </select>

    <button type="submit">
        Tìm kiếm
    </button>

</form>

    <div class="comment-table-wrapper">

        <table class="comment-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Người bình luận</th>
                    <th>Bài viết</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
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
    <a
        href="chi-tiet-binh-luan.php?id=<?= (int) $item['id'] ?>"
        class="comment-detail-link"
    >
        <?= htmlspecialchars($item['post_title'] ?? 'Bài viết không tồn tại', ENT_QUOTES, 'UTF-8') ?>
    </a>
</td>

<!-- NỘI DUNG -->
<td class="comment-content">
    <a
        href="chi-tiet-binh-luan.php?id=<?= (int) $item['id'] ?>"
        class="comment-detail-link"
    >
        <?= htmlspecialchars($item['content'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </a>
</td>

                        <td>
    <?= htmlspecialchars($item['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?>
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
                                <button
                                     type="button"
                                    class="action-button delete-button"
                                    data-id="<?= (int) $item['id'] ?>"
                                     data-csrf="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                                >
                                      Xóa
                                </button>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</main>


<script>

    // =========================
    // NÚT DUYỆT
    // =========================

    document.querySelectorAll('.btn-duyet').forEach(function(button) {

        button.addEventListener('click', function() {

            const commentId = this.dataset.id;
            const csrfToken = this.dataset.csrf;

            const formData = new FormData();

            formData.append('comment_id', commentId);
            formData.append('csrf_token', csrfToken);
            formData.append('status', 'approved');
            formData.append('action', 'approve');

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


    // =========================
    // NÚT ẨN
    // =========================

    document.querySelectorAll('.hide-button').forEach(function(button) {

        button.addEventListener('click', function() {

            const confirmHide = confirm(
                'Bạn có chắc chắn muốn ẩn bình luận này không?'
            );

            if (!confirmHide) {

                return;

            }

            const commentId = this.dataset.id;
            const csrfToken = this.dataset.csrf;

            const formData = new FormData();

            formData.append('comment_id', commentId);
            formData.append('csrf_token', csrfToken);
            formData.append('status', 'hidden');
            formData.append('action', 'hide');

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


    // =========================
    // NÚT HIỂN THỊ
    // =========================

    document.querySelectorAll('.show-button').forEach(function(button) {

        button.addEventListener('click', function() {

            const commentId = this.dataset.id;
            const csrfToken = this.dataset.csrf;

            const formData = new FormData();

            formData.append('comment_id', commentId);
            formData.append('csrf_token', csrfToken);
            formData.append('status', 'approved');
            formData.append('action', 'show');

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
    document.querySelectorAll('.delete-button').forEach(function(button) {
    button.addEventListener('click', function() {

        const confirmDelete = confirm(
            'Bạn có chắc chắn muốn xóa bình luận này không? Hành động này không thể hoàn tác.'
        );

        if (!confirmDelete) {
            return;
        }

        const commentId = this.dataset.id;
        const csrfToken = this.dataset.csrf;

        const formData = new FormData();

        formData.append('comment_id', commentId);
        formData.append('csrf_token', csrfToken);
        formData.append('action', 'delete');

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
            alert('Có lỗi xảy ra khi xóa bình luận.');
        });
    });
});

</script>