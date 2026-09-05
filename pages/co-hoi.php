<?php include '../includes/header.php'; ?>

<!-- Logic xử lý dữ liệu PHP -->
<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 3; // 3 bài viết mỗi trang
$offset = ($page - 1) * $limit;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nhip_khoa_db;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy tổng số bài viết thuộc danh mục Cơ hội
    $sql_count = "SELECT COUNT(*) FROM posts WHERE category_slug = 'co-hoi'";
    $total_rows = $pdo->query($sql_count)->fetchColumn();
    $total_pages = ceil($total_rows / $limit);

    // Lấy danh sách bài viết thuộc danh mục Cơ hội
    $sql_posts = "SELECT * FROM posts 
                  WHERE category_slug = 'co-hoi' 
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql_posts);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Dữ liệu mẫu chuẩn 100% theo ảnh giao diện
    $total_pages = 5;
    $posts = [
        [
            'id' => 1,
            'title' => 'Cơ hội thực tập tại các doanh nghiệp công nghệ dành cho sinh viên',
            'description' => 'Nhiều doanh nghiệp đang mở rộng chương trình thực tập dành cho sinh viên, tạo điều kiện để tích lũy kinh nghiệm và làm quen với môi trường làm việc thực tế.',
            'image_url' => 'assets/images/internship-opp.jpg',
            'created_at' => '2026-09-12',
            'views' => 320
        ],
        [
            'id' => 2,
            'title' => 'Học bổng khuyến khích học tập kỳ I năm 2026',
            'description' => 'Thông tin về chương trình học bổng dành cho sinh viên có thành tích học tập tốt và tích cực tham gia các hoạt động của khoa.',
            'image_url' => 'assets/images/scholarship.jpg',
            'created_at' => '2026-08-12',
            'views' => 320
        ],
        [
            'id' => 3,
            'title' => 'Cơ hội việc làm IT Full-time sau khi tốt nghiệp',
            'description' => 'Các vị trí việc làm phù hợp dành cho sinh viên năm cuối và sinh viên mới tốt nghiệp đang tìm kiếm cơ hội phát triển nghề nghiệp.',
            'image_url' => 'assets/images/job-opp.jpg',
            'created_at' => '2026-08-10',
            'views' => 320
        ]
    ];
}
?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">Trang chủ / <b>Cơ hội</b></div>

    <!-- Header danh mục Cơ Hội -->
    <div class="category-header-text">
        <h1>Cơ hội</h1>
        <p>Học bổng, thực tập, việc làm và các cơ hội phát triển bản thân dành cho sinh viên.</p>
    </div>

    <!-- Layout 2 cột chính -->
    <div class="news-layout">
        
        <!-- CỘT TRÁI: Danh sách bài viết Cơ hội -->
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
                <a href="co-hoi.php?page=<?= max(1, $page - 1) ?>">&lt;</a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="co-hoi.php?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                <a href="co-hoi.php?page=<?= min($total_pages, $page + 1) ?>">&gt;</a>
            </div>
        </main>

        <!-- CỘT PHẢI: Widget Danh Mục & Cơ Hội Nổi Bật -->
        <aside class="news-sidebar">
            
            <!-- Khối Danh Mục -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">DANH MỤC</h3>
                <ul class="sidebar-menu">
                    <li><a href="tin-khoa.php">Tin khoa</a></li>
                    <li><a href="hoc-tap.php">Học tập & Nghiên cứu</a></li>
                    <li><a href="co-hoi.php" class="active">Cơ hội</a></li>
                    <li><a href="su-kien.php">Sự kiện</a></li>
                    <li><a href="thong-tin-thay-doi.php">Thông tin thay đổi</a></li>
                </ul>
            </div>

            <!-- Khối Cơ Hội Nổi Bật -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">CƠ HỘI NỔI BẬT</h3>
                <div class="latest-posts-list">
                    
                    <div class="latest-post-item">
                        <img src="assets/images/featured-opp1.jpg" alt="Thumnail">
                        <div class="latest-post-info">
                            <h4><a href="chi-tiet-bai-viet.php?id=1">Cơ hội thực tập tại doanh nghiệp công nghệ</a></h4>
                            <span class="date">12/08/2026</span>
                        </div>
                    </div>

                    <div class="latest-post-item">
                        <img src="assets/images/featured-opp2.jpg" alt="Thumnail">
                        <div class="latest-post-info">
                            <h4><a href="chi-tiet-bai-viet.php?id=2">Học bổng hỗ trợ sinh viên có thành tích tốt</a></h4>
                            <span class="date">10/08/2026</span>
                        </div>
                    </div>

                    <div class="latest-post-item">
                        <img src="assets/images/featured-opp3.jpg" alt="Thumnail">
                        <div class="latest-post-info">
                            <h4><a href="chi-tiet-bai-viet.php?id=3">Workshop xây dựng CV và kỹ năng phỏng vấn</a></h4>
                            <span class="date">08/08/2026</span>
                        </div>
                    </div>

                </div>
            </div>

        </aside>

    </div>
</div>

<?php include '../includes/footer.php'; ?>