<?php

require_once __DIR__ . '/../controllers/CategoryController.php';

$controller = new CategoryController();

$keyword = trim($_GET['keyword'] ?? '');
$status = $_GET['status'] ?? 'all';

if ($keyword !== '' || $status !== 'all') {
    $categories = $controller->search($keyword, $status);
} else {
    $categories = $controller->index();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>

    <style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 40px;
        font-family: Arial, sans-serif;
        background: #faf8f5;
        color: #1e293b;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .description {
        margin: 0 0 30px;
        color: #6b7280;
        font-size: 15px;
    }

    /* THANH TÌM KIẾM */

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    .search-box input,
    .search-box select {
        height: 42px;
        padding: 0 14px;
        border: 1px solid #ddd8d2;
        border-radius: 7px;
        background: #ffffff;
        color: #374151;
        font-size: 14px;
        outline: none;
    }

    .search-box input {
        width: 280px;
    }

    .search-box select {
        width: 190px;
        cursor: pointer;
    }

    .search-box input:focus,
    .search-box select:focus {
        border-color: #991b1b;
        box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.08);
    }

    /* NÚT */

    button,
    .btn-add {
        height: 42px;
        padding: 0 18px;
        border: none;
        border-radius: 7px;
        background: #991b1b;
        color: #ffffff;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    button:hover,
    .btn-add:hover {
        background: #7f1d1d;
    }

    /* KHUNG BẢNG */

    .table-box {
        background: #ffffff;
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    /* HEADER BẢNG */

    th {
        background: #f7f4f0;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        padding: 15px;
        border-bottom: 1px solid #e5e0da;
    }

    /* NỘI DUNG BẢNG */

    td {
        padding: 15px;
        border-bottom: 1px solid #eee9e4;
        font-size: 14px;
        color: #374151;
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    /* TRẠNG THÁI */

    .status-active,
    .status-hidden {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-hidden {
        background: #f1f5f9;
        color: #475569;
    }

    /* THAO TÁC */

    .actions a {
        color: #2563eb;
        text-decoration: none;
        margin-right: 10px;
    }

    .actions a:hover {
        text-decoration: underline;
    }

    /* KHÔNG CÓ DỮ LIỆU */

    .empty {
        text-align: center;
        color: #64748b;
        padding: 30px;
    }

</style>
</head>

<body>

    <div class="container">

    <h1>Quản lý danh mục</h1>

    <p class="description">
        Quản lý các danh mục bài viết trong hệ thống.
    </p>


    <!-- TÌM KIẾM -->
    <div class="top-bar">

<form method="GET" class="search-box">

        <input
            type="text"
            name="keyword"
            placeholder="Tìm kiếm danh mục..."
            value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
        >

        <select name="status">
            <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>
                Tất cả trạng thái
            </option>

            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>
                Hiển thị
            </option>

            <option value="hidden" <?= $status === 'hidden' ? 'selected' : '' ?>>
                Ẩn
            </option>
        </select>

        <button type="submit">
            Tìm kiếm
        </button>

    </form>

    <a href="category-add.php" class="btn-add">
    + Thêm danh mục
</a>

</div>

<div class="table-box">

    <br><br>

    <!-- DANH SÁCH -->
    <table border="1" cellpadding="8" cellspacing="0">

        <thead>
            <tr>
                <th>STT</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Số bài viết</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>

        <?php if (empty($categories)): ?>

            <tr>
                <td colspan="7">
                    Không có danh mục nào.
                </td>
            </tr>

        <?php else: ?>

            <?php foreach ($categories as $index => $category): ?>

                <tr>

                    <td>
                        <?= $index + 1 ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $category['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $category['slug'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= (int)$category['post_count'] ?>
                    </td>

                    <td>

                        <?php if ($category['status'] === 'active'): ?>

    <span class="status-active">Hiển thị</span>

<?php else: ?>

    <span class="status-hidden">Ẩn</span>

<?php endif; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $category['created_at'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td class="actions">
                        <a href="category-edit.php?id=<?= (int)$category['id'] ?>">
                            Sửa
                        </a>

                        |

                        <a
                            href="category-delete.php?id=<?= (int)$category['id'] ?>"
                        >
                            Xóa
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

    </table>
    </div>

</body>
</html>