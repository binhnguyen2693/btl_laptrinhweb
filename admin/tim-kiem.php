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
<link rel="stylesheet" href="../assets/css/style.css">
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