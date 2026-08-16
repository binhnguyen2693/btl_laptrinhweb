<?php
declare(strict_types=1);


$danhSachBaiViet = [
    1 => [
        'tieuDe' => 'Công nghệ AI đang thay đổi cuộc sống như thế nào?',
        'chuyenMuc' => 'Công nghệ',
        'tacGia' => 'Nguyễn Văn An'
    ],

    2 => [
        'tieuDe' => 'Những xu hướng công nghệ nổi bật năm 2026',
        'chuyenMuc' => 'Công nghệ',
        'tacGia' => 'Trần Minh Anh'
    ],

    3 => [
        'tieuDe' => 'Kinh nghiệm học tập hiệu quả cho sinh viên',
        'chuyenMuc' => 'Giáo dục',
        'tacGia' => 'Lê Hoàng Nam'
    ],

    4 => [
        'tieuDe' => 'Những địa điểm du lịch đáng trải nghiệm',
        'chuyenMuc' => 'Đời sống',
        'tacGia' => 'Phạm Thu Hà'
    ]
];



$binhLuan = [];

$thongBao = '';
$loaiThongBao = '';

$articleId = 0;
$username = '';
$content = '';


function validateComment(
    int $articleId,
    string $username,
    string $content,
    array $danhSachBaiViet
): string {

    if ($articleId === 0) {
        return 'Vui lòng chọn bài viết muốn bình luận.';
    }

    if (!isset($danhSachBaiViet[$articleId])) {
        return 'Bài viết không tồn tại.';
    }

    if ($username === '') {
        return 'Vui lòng nhập tên của bạn.';
    }

    if ($content === '') {
        return 'Vui lòng nhập nội dung bình luận.';
    }

    if (strlen($username) > 50) {
        return 'Tên không được vượt quá 50 ký tự.';
    }

    if (strlen($content) > 500) {
        return 'Nội dung bình luận không được vượt quá 500 ký tự.';
    }

    return '';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Nhận dữ liệu từ form
    $articleId = (int) ($_POST['article_id'] ?? 0);

    $username = trim($_POST['username'] ?? '');

    $content = trim($_POST['content'] ?? '');


    // Gọi hàm tự định nghĩa
    $loi = validateComment(
        $articleId,
        $username,
        $content,
        $danhSachBaiViet
    );


    if ($loi !== '') {

        // Có lỗi
        $thongBao = $loi;
        $loaiThongBao = 'error';

    } else {

        // Tạo bình luận mới
        $binhLuanMoi = [
            'article_id' => $articleId,
            'username' => $username,
            'content' => $content,

            // Bình luận mới phải chờ xét duyệt
            'status' => 'pending'
        ];


        // Thêm bình luận vào mảng
        $binhLuan[] = $binhLuanMoi;


        // Thông báo cho người dùng
        $thongBao =
            'Bình luận của bạn đã được gửi thành công và đang chờ xét duyệt.';

        $loaiThongBao = 'success';


        // Xóa dữ liệu form sau khi gửi thành công
        $articleId = 0;
        $username = '';
        $content = '';
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

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

    <style>
        .comment-page {
            max-width: 850px;
            margin: 40px auto;
        }

        .comment-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .comment-box h1 {
            margin-top: 0;
        }

        .comment-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .comment-form label {
            font-weight: 600;
            margin-top: 10px;
        }

        .comment-form input,
        .comment-form select,
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .comment-form textarea {
            min-height: 140px;
            resize: vertical;
        }

        .comment-form button {
            margin-top: 15px;
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .message {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .message.error {
            background: #ffe5e5;
            color: #b00020;
        }

        .message.success {
            background: #e5f7e9;
            color: #176b2c;
        }

        .article-info {
            margin-top: 25px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        .article-info h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .comment-status {
            margin-top: 25px;
            padding: 15px;
            background: #fff8df;
            border-left: 4px solid #e0aa00;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<main class="container comment-page">

    <nav>
        <a href="../index.php">Trang chủ</a>

        <a href="../about.php">
            Giới thiệu nhóm
        </a>

        <a href="index.php">
            Bình luận
        </a>

        <a href="../admin/quan-ly-bai-viet.php">
            Quản lý bài viết
        </a>
    </nav>


    <section class="comment-box">

        <h1>Gửi bình luận</h1>

        <p>
            Chia sẻ ý kiến của bạn về bài viết trên StoryHub.
        </p>


        <?php if ($thongBao !== ''): ?>

            <div class="message <?= htmlspecialchars($loaiThongBao) ?>">
                <?= htmlspecialchars($thongBao) ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            class="comment-form"
        >

            <!-- Chọn bài viết -->

            <label for="article_id">
                Chọn bài viết
            </label>

            <select
                id="article_id"
                name="article_id"
                required
            >

                <option value="">
                    -- Chọn bài viết muốn bình luận --
                </option>


                <?php foreach ($danhSachBaiViet as $id => $baiViet): ?>

                    <option
                        value="<?= $id ?>"
                        <?= $articleId === $id ? 'selected' : '' ?>
                    >

                        <?= htmlspecialchars($baiViet['tieuDe']) ?>

                    </option>

                <?php endforeach; ?>

            </select>


            <!-- Tên người bình luận -->

            <label for="username">
                Tên của bạn
            </label>

            <input
                id="username"
                type="text"
                name="username"
                maxlength="50"
                value="<?= htmlspecialchars($username) ?>"
                placeholder="Nhập tên của bạn"
                required
            >


            <!-- Nội dung bình luận -->

            <label for="content">
                Nội dung bình luận
            </label>

            <textarea
                id="content"
                name="content"
                maxlength="500"
                placeholder="Nhập bình luận của bạn..."
                required
            ><?= htmlspecialchars($content) ?></textarea>


            <button type="submit">
                Gửi bình luận
            </button>

        </form>


        <?php if ($articleId !== 0 && isset($danhSachBaiViet[$articleId])): ?>

            <section class="article-info">

                <h2>
                    Bài viết được chọn
                </h2>

                <p>
                    <strong>
                        Tiêu đề:
                    </strong>

                    <?= htmlspecialchars(
                        $danhSachBaiViet[$articleId]['tieuDe']
                    ) ?>
                </p>

                <p>
                    <strong>
                        Chuyên mục:
                    </strong>

                    <?= htmlspecialchars(
                        $danhSachBaiViet[$articleId]['chuyenMuc']
                    ) ?>
                </p>

                <p>
                    <strong>
                        Tác giả:
                    </strong>

                    <?= htmlspecialchars(
                        $danhSachBaiViet[$articleId]['tacGia']
                    ) ?>
                </p>

            </section>

        <?php endif; ?>


        <?php if (count($binhLuan) > 0): ?>

            <section class="comment-status">

                <h2>
                    Trạng thái bình luận
                </h2>

                <?php foreach ($binhLuan as $item): ?>

                    <p>
                        <strong>
                            <?= htmlspecialchars($item['username']) ?>
                        </strong>
                    </p>

                    <p>
                        <?= htmlspecialchars($item['content']) ?>
                    </p>

                    <p>
                        Trạng thái:
                        <strong>
                            Chờ xét duyệt
                        </strong>
                    </p>

                <?php endforeach; ?>

            </section>

        <?php endif; ?>

    </section>

</main>

</body>
</html>