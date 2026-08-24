<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Comment.php';

$commentModel = new Comment($pdo);

$thongBao = '';
$loaiThongBao = '';


// Lấy danh sách tất cả bài viết đã được đăng
$stmt = $pdo->query("
    SELECT id, title
    FROM posts
    WHERE status = 'published'
    ORDER BY id DESC
");

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Xử lý khi người dùng gửi bình luận
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postId = (int) ($_POST['post_id'] ?? 0);
    $content = trim($_POST['content'] ?? '');

    // Kiểm tra đã chọn bài viết chưa
    if ($postId <= 0) {

        $thongBao = 'Vui lòng chọn bài viết.';
        $loaiThongBao = 'error';

    // Kiểm tra nội dung
    } elseif ($content === '') {

        $thongBao = 'Vui lòng nhập nội dung bình luận.';
        $loaiThongBao = 'error';

    } elseif (strlen($content) > 500) {

        $thongBao = 'Bình luận không được vượt quá 500 ký tự.';
        $loaiThongBao = 'error';

    } else {

        // Kiểm tra bài viết có tồn tại và đã được đăng chưa
        $stmt = $pdo->prepare("
            SELECT id
            FROM posts
            WHERE id = ?
            AND status = 'published'
        ");

        $stmt->execute([$postId]);

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {

            $thongBao = 'Bài viết không tồn tại hoặc chưa được đăng.';
            $loaiThongBao = 'error';

        } else {

            /*
             * Tạm thời dùng user_id = 1 để test.
             * Sau này nhóm có đăng nhập thì thay bằng
             * ID của người dùng đang đăng nhập.
             */

            $userId = 1;

            $result = $commentModel->create(
                $postId,
                $userId,
                $content
            );

            if ($result) {

                $thongBao = 'Bình luận đã được gửi và đang chờ xét duyệt.';
                $loaiThongBao = 'success';

            } else {

                $thongBao = 'Không thể gửi bình luận.';
                $loaiThongBao = 'error';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Gửi bình luận - StoryHub</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f7f3ee;
            margin: 0;
            padding: 0;
        }

        .comment-box {
            width: 600px;
            max-width: 90%;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: Arial, sans-serif;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: #7A2E25;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .empty {
            color: #777;
            margin-top: 10px;
        }

    </style>

</head>

<body>

<div class="comment-box">

    <h1>Gửi bình luận</h1>

    <?php if ($thongBao !== ''): ?>

        <div class="<?= htmlspecialchars($loaiThongBao, ENT_QUOTES, 'UTF-8') ?>">

            <?= htmlspecialchars($thongBao, ENT_QUOTES, 'UTF-8') ?>

        </div>

    <?php endif; ?>


    <form method="POST">

        <label for="post_id">
            Chọn bài viết
        </label>

        <select
            id="post_id"
            name="post_id"
            required
        >

            <option value="">
                -- Chọn bài viết --
            </option>

            <?php if (count($posts) > 0): ?>

                <?php foreach ($posts as $post): ?>

                    <option
                        value="<?= (int) $post['id'] ?>"
                        <?= isset($_POST['post_id']) && (int) $_POST['post_id'] === (int) $post['id'] ? 'selected' : '' ?>
                    >

                        <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>

                    </option>

                <?php endforeach; ?>

            <?php endif; ?>

        </select>


        <?php if (count($posts) === 0): ?>

            <p class="empty">
                Hiện chưa có bài viết nào được đăng.
            </p>

        <?php endif; ?>


        <label for="content">
            Nội dung bình luận
        </label>

        <textarea
            id="content"
            name="content"
            maxlength="500"
            placeholder="Nhập bình luận của bạn..."
            required
        ><?= htmlspecialchars($_POST['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>


        <button type="submit">
            Gửi bình luận
        </button>

    </form>

</div>

</body>

</html>