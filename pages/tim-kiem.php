<?php include '../includes/header.php'; ?>

<!-- Kết nối CSDL & Xử lý logic tìm kiếm -->
<?php
// Lấy từ khóa từ URL (mặc định là "học tập" nếu chưa có)
$keyword = isset($_GET['q']) ? trim($_GET['q']) : 'học tập';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 3; // 3 bài viết trên 1 trang
$offset = ($page - 1) * $limit;

// Kết nối CSDL (điều chỉnh thông tin kết nối phù hợp với dự án của bạn)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nhip_khoa_db;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Đếm tổng số bài viết
    $sql_count = "SELECT COUNT(*) FROM posts WHERE title LIKE :kw OR description LIKE :kw";
    $stmt_count = $pdo->prepare($sql_count);
    $stmt_count->execute(['kw' => "%$keyword%"]);
    $total_rows = $stmt_count->fetchColumn();
    $total_pages = ceil($total_rows / $limit);

    // Lấy bài viết theo trang
    $sql_posts = "SELECT * FROM posts 
                  WHERE title LIKE :kw OR description LIKE :kw 
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset";
    $stmt_posts = $pdo->prepare($sql_posts);
    $stmt_posts->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
    $stmt_posts->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt_posts->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt_posts->execute();
    $posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Trường hợp chưa kết nối CSDL, sử dụng dữ liệu tĩnh chuẩn theo ảnh
    $total_rows = 9;
    $total_pages = 5;
    $posts = [
        [
            'id' => 1,
            'category_name' => 'NGHIÊN CỨU KHOA HỌC',
            'title' => 'Sinh viên và những cơ hội tham gia nghiên cứu khoa học tại khoa',
            'description' => 'Khám phá các đề tài nghiên cứu và cơ hội đồng hành cùng giảng viên, giúp sinh viên nâng cao kiến thức và tích lũy kinh nghiệm chuyên môn.',
            'image_url' => 'assets/images/research.jpg',
            'created_at' => '2026-08-13'
        ],
        [
            'id' => 2,
            'category_name' => 'SỰ KIỆN',
            'title' => 'Hội thảo nghiên cứu khoa học dành cho sinh viên trong khoa',
            'description' => 'Cơ hội để sinh viên tìm hiểu về hoạt động nghiên cứu khoa học, gặp gỡ giảng viên và khám phá những hướng nghiên cứu phù hợp với chuyên ngành.',
            'image_url' => 'assets/images/event.jpg',
            'created_at' => '2026-08-13'
        ],
        [
            'id' => 3,
            'category_name' => 'HỌC TẬP',
            'title' => 'Những điều sinh viên cần biết khi bắt đầu một đề tài nghiên cứu',
            'description' => 'Từ cách lựa chọn chủ đề, tìm kiếm tài liệu đến xây dựng kế hoạch thực hiện, những gợi ý cơ bản giúp sinh viên tự tin hơn khi bắt đầu một đề tài nghiên cứu.',
            'image_url' => 'assets/images/study.jpg',
            'created_at' => '2026-08-13'
        ]
    ];
}
?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">Trang chủ / <b>Tìm kiếm</b></div>

    <!-- Header phần tìm kiếm -->
    <div class="search-header">
        <div class="search-title">
            <h1>KẾT QUẢ TÌM KIẾM</h1>
            <p>Các bài viết phù hợp với từ khóa bạn đang tìm kiếm.</p>
        </div>
        <div class="search-box-wrap">
            <form class="search-input-group" action="tim-kiem.php" method="GET">
                <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Nhập từ khóa...">
                <button type="submit">🔍</button>
            </form>
            <div class="search-count">
                <?= sprintf("%02d", count($posts)) ?> kết quả tìm thấy với từ khóa "<?= htmlspecialchars($keyword) ?>"
            </div>
        </div>
    </div>

    <!-- Danh sách các bài viết dạng Card -->
    <div class="card-list">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($post['image_url'] ?? 'assets/images/default.jpg') ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                    <div class="card-content">
                        <div>
                            <div class="card-category"><?= htmlspecialchars($post['category_name']) ?></div>
                            <div class="card-title"><?= htmlspecialchars($post['title']) ?></div>
                            <div class="card-desc"><?= htmlspecialchars($post['description']) ?></div>
                        </div>
                        <div class="card-footer">
                            <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                            <a href="chi-tiet-bai-viet.php?id=<?= $post['id'] ?>">Xem bài &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; margin: 40px 0; color: #666;">Không tìm thấy bài viết nào phù hợp.</p>
        <?php endif; ?>
    </div>

    <!-- Thanh phân trang -->
    <div class="pagination">
        <a href="tim-kiem.php?q=<?= urlencode($keyword) ?>&page=<?= max(1, $page - 1) ?>">&lt;</a>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="tim-kiem.php?q=<?= urlencode($keyword) ?>&page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
        <a href="tim-kiem.php?q=<?= urlencode($keyword) ?>&page=<?= min($total_pages, $page + 1) ?>">&gt;</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>