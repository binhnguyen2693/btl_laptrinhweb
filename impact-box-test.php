<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/controllers/ImpactBoxController.php';

$userId = 1;

$controller = new ImpactBoxController();

$thongBao = '';
$loi = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postId = (int)($_POST['post_id'] ?? 0);
    $note = trim($_POST['note'] ?? '');

    if ($postId <= 0) {
        $loi = 'Vui lòng nhập ID bài viết.';
    } elseif ($controller->add(
        $userId,
        $postId,
        $note !== '' ? $note : null
    )) {
        $thongBao = 'Đã lưu bài viết vào Impact Box!';
    } else {
        $loi = 'Bài viết này đã được lưu rồi.';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Test Impact Box</title>
</head>

<body>

<h1>Test Impact Box</h1>

<p>
    Trang này dùng để kiểm tra chức năng lưu bài viết vào Impact Box.
</p>

<?php if ($thongBao !== ''): ?>
    <p style="color: green;">
        <?= htmlspecialchars($thongBao) ?>
    </p>
<?php endif; ?>

<?php if ($loi !== ''): ?>
    <p style="color: red;">
        <?= htmlspecialchars($loi) ?>
    </p>
<?php endif; ?>

<hr>

<h2>Lưu bài viết</h2>

<form method="POST">

    <p>
        <label for="post_id">
            ID bài viết
        </label>
        <br>

        <input
            type="number"
            id="post_id"
            name="post_id"
            min="1"
            required
        >
    </p>

    <p>
        <label for="note">
            Ghi chú
        </label>
        <br>

        <textarea
            id="note"
            name="note"
            rows="5"
            cols="50"
            placeholder="Nhập ghi chú..."
        ></textarea>
    </p>

    <button type="submit">
        Lưu vào Impact Box
    </button>

</form>

<br>

<a href="views/impact-box.php">
    Xem Impact Box của tôi
</a>

</body>

</html>