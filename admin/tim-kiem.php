<?php
declare(strict_types=1);
$posts = [
    [
        'id' => 1,
        'title' => 'Chào mừng đến với Nhịp Khoa',
        'author' => 'Nguyễn Văn A',
        'category' => 'Tin khoa',
        'summary' => 'Tin tức mới nhất từ khoa.',
    ],
    [
        'id' => 2,
        'title' => 'Sinh viên khoa tham gia hoạt động học tập',
        'author' => 'Nguyễn Văn A',
        'category' => 'Học tập',
        'summary' => 'Các hoạt động học tập nổi bật của sinh viên.',
    ],
    [
        'id' => 3,
        'title' => 'Cơ hội thực tập dành cho sinh viên',
        'author' => 'Nguyễn Văn A',
        'category' => 'Cơ hội',
        'summary' => 'Thông tin về các cơ hội thực tập dành cho sinh viên.',
    ],
    [
        'id' => 4,
        'title' => 'Sự kiện nổi bật của khoa',
        'author' => 'Nguyễn Văn A',
        'category' => 'Sự kiện',
        'summary' => 'Những sự kiện đáng chú ý của khoa.',
    ],
];
function hienThiAnToan(string $giaTri): string
{
    return htmlspecialchars($giaTri, ENT_QUOTES, 'UTF-8');
}
function timKiemBaiViet(array $posts, string $tuKhoa): array
{
    $ketQua = [];
    foreach ($posts as $post) {
        if (
            stripos($post['title'], $tuKhoa) !== false ||
            stripos($post['summary'], $tuKhoa) !== false
        ) {
            $ketQua[] = $post;
        }
    }
    return $ketQua;
}
$tuKhoa = '';
$loi = '';
$ketQua = [];
$daTimKiem = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tuKhoa = trim($_POST['tuKhoa'] ?? '');
    $daTimKiem = true;
    if ($tuKhoa === '') {
        $loi = 'Vui lòng nhập từ khóa.';
    } elseif (mb_strlen($tuKhoa, 'UTF-8') > 50) {
        $loi = 'Từ khóa không được vượt quá 50 ký tự.';
    } else {
        $ketQua = timKiemBaiViet($posts, $tuKhoa);
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Tìm kiếm bài viết - Nhịp Khoa</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #FFF8EC;
            color: #222;
        }
        .container {
            width: min(1000px, 100%);
            margin: 0 auto;
        }
        .search-card {
            width: min(800px, 100%);
            margin: 30px auto;
            padding: 35px;
            background: #ffffff;
            border-radius: 15px;
            border: 2px solid #C69332;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        }
        .search-heading {
            text-align: center;
            margin-bottom: 30px;
        }
        .search-heading h1 {
            margin: 0 0 10px;
            color: #7A2E25;
            font-size: 30px;
        }
        .search-heading p {
            margin: 0;
            color: #6C8065;
            font-size: 16px;
        }
        .search-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-field label {
            font-weight: bold;
            color: #4A3028;
        }
        .form-field label span {
            color: #b91c1c;
        }
        .form-field input {
            width: 100%;
            padding: 13px 15px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 8px;
            outline: none;
        }
        .form-field input:focus {
            border-color: #7A2E25;
            box-shadow: 0 0 0 3px rgba(122, 46, 37, 0.12);
        }
        .required-note {
            margin: 0;
            color: #777;
            font-size: 14px;
        }
        .search-button {
            width: 140px;
            padding: 12px 20px;
            margin-top: 5px;
            border: none;
            border-radius: 8px;
            background: #7A2E25;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .search-button:hover {
            background: #4A3028;
        }
        .error-message {
            margin-bottom: 20px;
            padding: 13px 15px;
            border-radius: 8px;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #B91C1C;
        }
        .search-result {
            width: 100%;
            margin: 30px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 15px;
            border: 2px solid #C69332;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        }
        .result-heading {
            margin-bottom: 20px;
        }
        .result-heading h2 {
            margin: 0 0 8px;
            color: #4A3028;
        }
        .result-heading p {
            margin: 0;
            color: #666;
        }
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }
        th {
            padding: 13px;
            background: #7A2E25;
            color: white;
            border: 1px solid #6A251F;
            text-align: left;
        }
        td {
            padding: 13px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        tbody tr:nth-child(even) {
            background: #FFF8EC;
        }
        tbody tr:hover {
            background: #F4E7D2;
        }
        .no-result {
            padding: 15px;
            border-radius: 8px;
            background: #FFF8EC;
            color: #4A3028;
        }
        @media (max-width: 600px) {
            body {
                padding: 15px 10px;
            }
            .search-card,
            .search-result {
                padding: 20px;
                margin-top: 15px;
            }
            .search-heading h1 {
                font-size: 24px;
            }
            .search-button {
                width: 100%;
            }
            th,
            td {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <nav class="main-menu">
    <a href="index.php">Trang chủ</a>
    <a href="about.php">Giới thiệu nhóm</a>
    <a href="tim-kiem.php" class="active">Tìm kiếm</a>
    </nav>
<main class="container">
    <section class="search-card">
        <div class="search-heading">
            <h1>TÌM KIẾM BÀI VIẾT</h1>
            <p>
                Tìm kiếm các bài viết trong Nhịp Khoa
            </p>
        </div>
        <?php if ($loi !== ''): ?>
            <div class="error-message">
                <?= hienThiAnToan($loi) ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="search-form">
            <div class="form-field">
                <label for="tuKhoa">
                    Từ khóa <span>*</span>
                </label>
                <input
                    id="tuKhoa"
                    type="text"
                    name="tuKhoa"
                    maxlength="50"
                    value="<?= hienThiAnToan($tuKhoa) ?>"
                    placeholder="Nhập tên bài viết..."
                    autocomplete="off"
                >

            </div>
            <p class="required-note">
                Nhập từ khóa để tìm kiếm bài viết.
            </p>

            <button
                type="submit"
                class="search-button"
            >
                Tìm kiếm
            </button>
        </form>
    </section>
    <?php if ($daTimKiem && $loi === ''): ?>
        <section class="search-result">
            <div class="result-heading">
                <h2>Kết quả tìm kiếm</h2>
                <p>
                    Tìm thấy
                    <strong><?= count($ketQua) ?></strong>
                    bài viết với từ khóa
                    "<strong><?= hienThiAnToan($tuKhoa) ?></strong>"
                </p>
            </div>
            <?php if (count($ketQua) > 0): ?>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tiêu đề</th>
                                <th>Tác giả</th>
                                <th>Chuyên mục</th>
                                <th>Tóm tắt</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ketQua as $index => $post): ?>
                            <tr>
                                <td>
                                    <?= $index + 1 ?>
                                </td>
                                <td>
                                    <?= hienThiAnToan($post['title']) ?>
                                </td>
                                <td>
                                    <?= hienThiAnToan($post['author']) ?>
                                </td>
                                <td>
                                    <?= hienThiAnToan($post['category']) ?>
                                </td>
                                <td>
                                    <?= hienThiAnToan($post['summary']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-result">
                    Không tìm thấy bài viết phù hợp với từ khóa
                    "<strong><?= hienThiAnToan($tuKhoa) ?></strong>".
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>
</body>
</html>