<?php
$posts = [
    [
        "title" => "Học PHP cơ bản",
        "author" => "Nguyễn An",
        "category" => "Lập trình"
    ],
    [
        "title" => "HTML và CSS",
        "author" => "Trần Bình",
        "category" => "Web"
    ],
    [
        "title" => "Tìm hiểu JavaScript",
        "author" => "Lê Anh",
        "category" => "Lập trình"
    ]
];
function searchPost($posts, $keyword)
{
    $result = [];
    foreach ($posts as $post) {
        if (stripos($post["title"], $keyword) !== false) {
            $result[] = $post;
        }
    }
    return $result;
}
$keyword = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST["keyword"];
}
$result = searchPost($posts, $keyword);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm bài viết</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 30px;
        }
        .container {
            width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
        }
        input {
            width: 70%;
            padding: 10px;
        }
        button {
            padding: 10px 20px;
            background: #7A2E25;
            color: white;
            border: none;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #7A2E25;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>TÌM KIẾM BÀI VIẾT</h1>
    <form method="POST">
        <input
            type="text"
            name="keyword"
            placeholder="Nhập tên bài viết..."
            value="<?php echo $keyword; ?>"
        >
        <button type="submit">Tìm kiếm</button>
    </form>
    <table>
        <tr>
            <th>STT</th>
            <th>Tiêu đề</th>
            <th>Tác giả</th>
            <th>Chuyên mục</th>
        </tr>
        <?php if (count($result) > 0): ?>
            <?php foreach ($result as $index => $post): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $post["title"]; ?></td>
                    <td><?php echo $post["author"]; ?></td>
                    <td><?php echo $post["category"]; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Không tìm thấy bài viết</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>