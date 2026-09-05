<?php include '../includes/header.php'; ?>

<!-- Logic xử lý dữ liệu PHP -->
<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 3; // 3 sự kiện ở phần bên dưới mỗi trang
$offset = ($page - 1) * $limit;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nhip_khoa_db;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy sự kiện nổi bật / sắp diễn ra đầu tiên
    $sql_featured = "SELECT * FROM events WHERE status = 'upcoming' ORDER BY event_date ASC LIMIT 1";
    $featured_event = $pdo->query($sql_featured)->fetch(PDO::FETCH_ASSOC);

    // Lấy tổng số các sự kiện khác
    $sql_count = "SELECT COUNT(*) FROM events WHERE id != :featured_id";
    $stmt_count = $pdo->prepare($sql_count);
    $stmt_count->execute(['featured_id' => $featured_event['id'] ?? 0]);
    $total_rows = $stmt_count->fetchColumn();
    $total_pages = ceil($total_rows / $limit);

    // Lấy danh sách các sự kiện khác theo trang
    $sql_other = "SELECT * FROM events 
                  WHERE id != :featured_id 
                  ORDER BY event_date ASC 
                  LIMIT :limit OFFSET :offset";
    $stmt_other = $pdo->prepare($sql_other);
    $stmt_other->bindValue(':featured_id', $featured_event['id'] ?? 0, PDO::PARAM_INT);
    $stmt_other->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt_other->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt_other->execute();
    $other_events = $stmt_other->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Dữ liệu mẫu chuẩn 100% theo thiết kế trong ảnh
    $featured_event = [
        'id' => 1,
        'status_text' => 'SẮP DIỄN RA',
        'title' => 'Hội thảo định hướng nghề nghiệp và phát triển kỹ năng cho sinh viên',
        'event_date' => '17/08/2026',
        'location' => 'Hội trường A - Khu giảng đường',
        'target' => 'Dành cho sinh viên toàn khoa',
        'description' => 'Chương trình giúp sinh viên tìm hiểu định hướng nghề nghiệp, giao lưu với khách mời và trang bị thêm những kỹ năng cần thiết cho quá trình học tập và làm việc.',
        'image_url' => 'assets/images/event-featured.jpg'
    ];

    $total_pages = 5;
    $other_events = [
        [
            'id' => 2,
            'status_text' => 'SẮP DIỄN RA',
            'title' => 'Ngày hội giao lưu sinh viên và kết nối câu lạc bộ',
            'event_date' => '28/08/2026 - 08:30',
            'location' => 'Sân trường',
            'image_url' => 'assets/images/event1.jpg'
        ],
        [
            'id' => 3,
            'status_text' => 'SẮP DIỄN RA',
            'title' => 'Workshop kỹ năng học tập hiệu quả',
            'event_date' => '30/08/2026 - 14:00',
            'location' => 'Phòng hội thảo B',
            'image_url' => 'assets/images/event2.jpg'
        ],
        [
            'id' => 4,
            'status_text' => 'SẮP DIỄN RA',
            'title' => 'Chương trình định hướng dành cho sinh viên năm nhất',
            'event_date' => '02/09/2026 - 08:00',
            'location' => 'Hội trường lớn',
            'image_url' => 'assets/images/event3.jpg'
        ]
    ];
}
?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">Trang chủ / <b>Sự kiện</b></div>

    <!-- Header danh mục Sự Kiện -->
    <div class="category-header-text">
        <h1>Sự Kiện</h1>
        <p>Cập nhật các hoạt động, chương trình và sự kiện nổi bật dành cho sinh viên.</p>
    </div>

    <!-- KHỐI 1: SỰ KIỆN SẮP DIỄN RA (Nổi bật) -->
    <section class="featured-event-section">
        <h2 class="section-title-bold">SỰ KIỆN SẮP DIỄN RA</h2>
        
        <div class="event-featured-card">
            <div class="event-featured-img">
                <img src="<?= htmlspecialchars($featured_event['image_url']) ?>" alt="<?= htmlspecialchars($featured_event['title']) ?>">
            </div>
            <div class="event-featured-content">
                <span class="badge-status-yellow"><?= htmlspecialchars($featured_event['status_text']) ?></span>
                <h3 class="title"><?= htmlspecialchars($featured_event['title']) ?></h3>
                
                <div class="event-meta-info">
                    <span>📅 <?= htmlspecialchars($featured_event['event_date']) ?></span>
                    <span>📍 <?= htmlspecialchars($featured_event['location']) ?></span>
                    <span>👥 <?= htmlspecialchars($featured_event['target']) ?></span>
                </div>
                
                <p class="desc"><?= htmlspecialchars($featured_event['description']) ?></p>
                <div class="action">
                    <a href="chi-tiet-bai-viet.php?id=<?= $featured_event['id'] ?>" class="btn-readmore-link">Xem bài &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- KHỐI 2: CÁC SỰ KIỆN KHÁC (Lưới 3 cột) -->
    <section class="other-events-section">
        <h2 class="section-title-bold">CÁC SỰ KIỆN KHÁC</h2>
        
        <div class="events-grid-3col">
            <?php foreach ($other_events as $event): ?>
                <div class="event-card">
                    <div class="event-card-thumb">
                        <img src="<?= htmlspecialchars($event['image_url']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                        <span class="badge-status-yellow-overlay"><?= htmlspecialchars($event['status_text']) ?></span>
                    </div>
                    <div class="event-card-body">
                        <h4 class="event-title">
                            <a href="chi-tiet-bai-viet.php?id=<?= $event['id'] ?>"><?= htmlspecialchars($event['title']) ?></a>
                        </h4>
                        <div class="event-info">
                            <div>📅 <?= htmlspecialchars($event['event_date']) ?></div>
                            <div>📍 <?= htmlspecialchars($event['location']) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Thanh phân trang -->
        <div class="pagination">
            <a href="su-kien.php?page=<?= max(1, $page - 1) ?>">&lt;</a>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="su-kien.php?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <a href="su-kien.php?page=<?= min($total_pages, $page + 1) ?>">&gt;</a>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>