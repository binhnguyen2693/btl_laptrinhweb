<?php include '../includes/header.php'; ?>

<!-- Logic xử lý dữ liệu PHP -->
<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 3; // 3 bài viết mỗi trang theo thiết kế giao diện
$offset = ($page - 1) * $limit;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nhip_khoa_db;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy tổng số bài viết thuộc danh mục Tin khoa
    $sql_count = "SELECT COUNT(*) FROM posts WHERE category_slug = 'tin-khoa'";
    $total_rows = $pdo->query($sql_count)->fetchColumn();
    $total_pages = ceil($total_rows / $limit);

    // Lấy danh sách bài viết trang hiện tại
    $sql_posts = "SELECT * FROM posts 
                  WHERE category_slug = 'tin-khoa' 
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql_posts);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Dữ liệu mẫu chuẩn 100% theo giao diện trong ảnh
    $total_pages = 5;
    $posts = [
        [
            'id' => 1,
            'title' => 'Khoa tổ chức hội thảo chuyên ngành dành cho sinh viên',
            'description' => 'Chương trình mang đến cơ hội giao lưu, trao đổi kiến thức và tìm hiểu những xu hướng mới trong lĩnh vực chuyên ngành, giúp sinh viên mở rộng hiểu biết và kết nối với giảng viên, chuyên gia',
            'image_url' => 'assets/images/tin-khoa-1.jpg',
            'created_at' => '2026-09-12',
            'views' => 320
        ],
        [
            'id' => 2,
            'title' => 'Sinh viên khoa đạt thành tích nổi bật trong cuộc thi học thuật',
            'description' => 'Những thành tích nổi bật của sinh viên trong các cuộc thi học thuật và hoạt động chuyên môn, góp phần lan tỏa tinh thần học tập và nghiên cứu trong toàn khoa.',
            'image_url' => 'assets/images/tin-khoa-2.jpg',
            'created_at' => '2026-08-12',
            'views' => 320
        ],
        [
            'id' => 3,
            'title' => 'Khoa triển khai hoạt động hỗ trợ sinh viên trong năm học mới',
            'description' => 'Các hoạt động hỗ trợ nhằm giúp sinh viên tiếp cận thông tin, tài liệu và những cơ hội học tập phù hợp trong năm học mới',
            'image_url' => 'assets/images/tin-khoa-3.jpg',
            'created_at' => '2026-08-10',
            'views' => 320
        ]
    ];
}
?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">Trang chủ / <b>Tin khoa</b></div>

    <!-- Header danh mục Tin Khoa -->
    <div class="category-header-text">
        <h1>TIN KHOA</h1>
        <p>Cập nhật những thông tin, hoạt động và thông báo mới nhất từ khoa dành cho sinh viên.</p>
    </div>

    <!-- Layout 2 cột chính -->
    <div class="news-layout">
        
        <!-- CỘT TRÁI: Danh sách bài viết tin khoa -->
        <main class="news-main-list">
            <?php foreach ($posts as $post): ?>
                <div class="horizontal-card">
                    <div class="card-image">
                        <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="card-content">
                        <h2 class="card-title">
                            <a href="chi-tiet-bai-viet.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                        </h2>
                        <p class="card-desc"><?= htmlspecialchars($post['description']) ?></p>
                        <div class="card-footer-info">
                            <div class="meta">
                                <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                                <span><?= htmlspecialchars($post['views']) ?> lượt xem</span>
                            </div>
                            <a href="chi-tiet-bai-viet.php?id=<?= $post['id'] ?>" class="btn-link">Xem bài &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Thanh phân trang -->
            <div class="pagination">
                <a href="tin-khoa.php?page=<?= max(1, $page - 1) ?>">&lt;</a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="tin-khoa.php?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                <a href="tin-khoa.php?page=<?= min($total_pages, $page + 1) ?>">&gt;</a>
            </div>
        </main>

        <!-- CỘT PHẢI: Widget Danh Mục & Bài Mới Nhất -->
        <aside class="news-sidebar">
            
            <!-- Khối Danh Mục -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">DANH MỤC</h3>
                <ul class="sidebar-menu">
                    <li><a href="tin-khoa.php" class="active">Tin khoa</a></li>
                    <li><a href="hoc-tap.php">Học tập & Nghiên cứu</a></li>
                    <li><a href="co-hoi.php">Cơ hội</a></li>
                    <li><a href="su-kien.php">Sự kiện</a></li>
                    <li><a href="thong-tin-thay-doi.php">Thông tin thay đổi</a></li>
                </ul>
            </div>

            <!-- Khối Bài Mới Nhất -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">BÀI MỚI NHẤT</h3>
                <div class="latest-posts-list">
                    
                    <div class="latest-post-item">
                        <img src="assets/images/tin-khoa-1.jpg" alt="Thumnail">
                        <div class="latest-post-info">
                            <h4><a href="chi-tiet-bai-viet.php?id=1">Khoa tổ chức hội thảo chuyên ngành dành cho sinh viên</a></h4>
                            <span class="date">12/09/2026</span>
                        </div>
                    </div>

                    <div class="latest-post-item">
                        <img src="assets/images/tin-khoa-2.jpg" alt="Thumnail">
                        <div class="latest-post-info">
                            <h4><a href="chi-tiet-bai-viet.php?id=2">Sinh viên khoa đạt thành tích nổi bật trong cuộc thi học thuật</a></h4>
                            <span class="date">12/08/2026</span>
                        </div>
                    </div>

                    <div class="latest-post-item">
                        <img src="assets/images/tin-khoa-3.jpg" alt="Thumnail">
                        <div class="latest-post-info">
                            <h4><a href="chi-tiet-bai-viet.php?id=3">Khoa triển khai hoạt động hỗ trợ sinh viên trong năm học mới</a></h4>
                            <span class="date">08/08/2026</span>
                        </div>
                    </div>

                </div>
            </div>

        </aside>

    </div>
</div>

<?php include '../includes/footer.php'; ?>