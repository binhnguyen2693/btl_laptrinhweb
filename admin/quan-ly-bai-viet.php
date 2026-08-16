<?php

$danhSachBaiViet = [];
$thongBaoLoi = '';

function xacDinhTrangThai($noiDung)
{
    if (strlen($noiDung) >= 100) {
        return 'Sẵn sàng đăng';
    }

    return 'Bản nháp';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieuDe = trim($_POST['tieuDe'] ?? '');
    $chuyenMuc = trim($_POST['chuyenMuc'] ?? '');
    $tacGia = trim($_POST['tacGia'] ?? '');
    $noiDung = trim($_POST['noiDung'] ?? '');

    if ($tieuDe === '' || $chuyenMuc === '' || $tacGia === '' || $noiDung === '') {
        $thongBaoLoi = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $baiViet = [
            'tieuDe' => $tieuDe,
            'chuyenMuc' => $chuyenMuc,
            'tacGia' => $tacGia,
            'noiDung' => $noiDung,
            'trangThai' => xacDinhTrangThai($noiDung)
        ];

        $danhSachBaiViet[] = $baiViet;
    }
}

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý bài viết</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="container">
        <nav>
            <a href="../index.php">Trang chủ</a>
            <a href="../about.php">Giới thiệu nhóm</a>
            <a href="quan-ly-bai-viet.php">Quản lý bài viết</a>
            <a href="binhluan.php">Bình luận</a>
            <a href="timkiembaiviet.php">Tìm kiếm bài viết</a>
        </nav>

        <section class="intro small">
            <h1>Quản lý bài viết</h1>
            <p>Nhập thông tin bài viết mới cho website tin tức/blog.</p>
        </section>

        <section class="box">
            <h2>Thêm bài viết</h2>

            <?php if ($thongBaoLoi !== ''): ?>
                <p class="error"><?= htmlspecialchars($thongBaoLoi) ?></p>
            <?php endif; ?>

            <form method="POST">
                <label for="tieuDe">Tiêu đề</label>
                <input id="tieuDe" type="text" name="tieuDe" required>

                <label for="chuyenMuc">Chuyên mục</label>
                <select id="chuyenMuc" name="chuyenMuc" required>
                    <option value="">-- Chọn chuyên mục --</option>
                    <option value="Tin tức">Tin tức</option>
                    <option value="Công nghệ">Công nghệ</option>
                    <option value="Đời sống">Đời sống</option>
                    <option value="Giáo dục">Giáo dục</option>
                </select>

                <label for="tacGia">Tác giả</label>
                <input id="tacGia" type="text" name="tacGia" required>

                <label for="noiDung">Nội dung</label>
                <textarea id="noiDung" name="noiDung" required></textarea>

                <button type="submit">Thêm bài viết</button>
            </form>
        </section>

        <?php if (count($danhSachBaiViet) > 0): ?>
            <section class="box">
                <h2>Danh sách bài viết</h2>

                <table>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Chuyên mục</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                    </tr>

                    <?php foreach ($danhSachBaiViet as $baiViet): ?>
                        <tr>
                            <td><?= htmlspecialchars($baiViet['tieuDe']) ?></td>
                            <td><?= htmlspecialchars($baiViet['chuyenMuc']) ?></td>
                            <td><?= htmlspecialchars($baiViet['tacGia']) ?></td>
                            <td><?= htmlspecialchars($baiViet['trangThai']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
