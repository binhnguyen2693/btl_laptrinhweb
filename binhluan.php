<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Comment.php';

$commentModel = new Comment($pdo);

$thongBao = '';
$loaiThongBao = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postId = (int) ($_POST['post_id'] ?? 0);
    $content = trim($_POST['content'] ?? '');

    if ($postId <= 0) {

        $thongBao = 'Bài viết không hợp lệ.';
        $loaiThongBao = 'error';

    } elseif ($content === '') {

        $thongBao = 'Vui lòng nhập nội dung bình luận.';
        $loaiThongBao = 'error';

    } elseif (strlen($content) > 500) {

        $thongBao = 'Bình luận không được vượt quá 500 ký tự.';
        $loaiThongBao = 'error';

    } else {

        /*
         * Tạm dùng user_id = 1 để test.
         * Sau khi nhóm hoàn thiện đăng nhập,
         * thay bằng ID người dùng đang đăng nhập.
         */

        $userId = 1;

        $result = $commentModel->create(
            $postId,
            $userId,
            $content
        );

        if ($result) {

            $thongBao =
                'Bình luận đã được gửi và đang chờ xét duyệt.';

            $loaiThongBao = 'success';

        } else {

            $thongBao =
                'Không thể gửi bình luận.';

            $loaiThongBao = 'error';
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
        }

        .comment-box {
            width: 600px;
            max-width: 90%;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
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
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
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

    </style>

</head>

<body>

<div class="comment-box">

    <h1>Gửi bình luận</h1>

    <?php if ($thongBao !== ''): ?>

        <div class="<?= htmlspecialchars($loaiThongBao) ?>">

            <?= htmlspecialchars(
                $thongBao,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>

    <?php endif; ?>


    <form method="POST">

        <label for="post_id">
            ID bài viết
        </label>

        <input
            type="number"
            id="post_id"
            name="post_id"
            value="1"
            min="1"
            required
        >


        <label for="content">
            Nội dung bình luận
        </label>

        <textarea
            id="content"
            name="content"
            maxlength="500"
            placeholder="Nhập bình luận của bạn..."
            required
        ></textarea>


        <button type="submit">
            Gửi bình luận
        </button>

    </form>

</div>

</body>

</html>