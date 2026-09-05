<?php include '../includes/header.php'; ?>

<!-- Logic xử lý dữ liệu PHP -->
<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nhip_khoa_db;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy chi tiết thông báo thay đổi
    $stmt = $pdo->prepare("SELECT * FROM notice_changes WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $notice = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Dữ liệu mẫu chuẩn 100% theo giao diện trong ảnh
    $notice = [
        'id' => 1,
        'title' => 'Lịch hội thảo nghiên cứu khoa học được chuyển sang ngày 25/08/2026',
        'updated_at' => '16/08/2026',
        'author' => 'Ban tổ chức',
        'views' => 325,
        'old_time' => '20/08/2026',
        'new_time' => '25/08/2026',
        'target' => 'Sinh viên đã đăng ký',
        'content_change' => 'Ban tổ chức thông báo thay đổi lịch tổ chức Hội thảo nghiên cứu khoa học sinh viên năm 2026. Lịch hội thảo sẽ được chuyển từ ngày 20/08/2026 sang ngày 25/08/2026.',
        'affected_users' => 'Sinh viên đã đăng ký tham dự Hội thảo nghiên cứu khoa học sinh viên năm 2026.',
        'action_required' => 'Sinh viên vui lòng kiểm tra lại lịch trình và sắp xếp thời gian để tham dự đúng ngày mới. Nếu có thắc mắc, liên hệ Ban tổ chức để được hỗ trợ.',
        'source' => 'Thông báo của khoa Công nghệ thông tin',
        // Dữ liệu cho bảng tóm tắt cột phải
        'summary_change_type' => 'Thay đổi ngày tổ chức',
        'summary_effective_date' => 'Từ ngày 16/08/2026',
        'summary_target' => 'Sinh viên đăng ký tham dự hội thảo',
        'summary_impact_level' => 'Trung bình',
        'summary_action' => 'Kiểm tra lịch và có mặt đúng thời gian mới'
    ];

    $comments = [
        [
            'author' => 'Nguyễn Minh Anh',
            'avatar' => 'assets/images/user1.jpg',
            'created_at' => '14/08/2026',
            'content' => 'Cảm ơn khoa đã thông báo sớm để sinh viên sắp xếp thời gian ạ.'
        ],
        [
            'author' => 'Trần Hoàng Nam',
            'avatar' => 'assets/images/user2.jpg',
            'created_at' => '14/08/2026',
            'content' => 'Mình đã cập nhật lại lịch, cảm ơn vì đã thông báo.'
        ]
    ];
}
?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        Trang chủ / <b>Chi tiết thay đổi</b>
    </div>

    <!-- Layout chính 2 cột -->
    <div class="change-detail-layout">
        
        <!-- CỘT TRÁI: Nội dung chi tiết thông báo thay đổi -->
        <main class="change-main">
            <div class="badge-change-warning">⚠ THÔNG TIN THAY ĐỔI</div>
            
            <h1 class="change-title"><?= htmlspecialchars($notice['title']) ?></h1>
            
            <div class="change-meta">
                Cập nhật lần cuối: <?= htmlspecialchars($notice['updated_at']) ?> • 
                Người đăng: <?= htmlspecialchars($notice['author']) ?> • 
                <?= htmlspecialchars($notice['views']) ?> lượt xem
            </div>

            <!-- Khung nổi bật so sánh Thời gian cũ -> Thời gian mới -->
            <div class="time-comparison-box">
                <div class="time-box">
                    <span class="label">THỜI GIAN CŨ</span>
                    <span class="value old-date"><?= htmlspecialchars($notice['old_time']) ?></span>
                </div>
                <div class="arrow">&rarr;</div>
                <div class="time-box">
                    <span class="label">THỜI GIAN MỚI</span>
                    <span class="value new-date"><?= htmlspecialchars($notice['new_time']) ?></span>
                </div>
                <div class="divider">|</div>
                <div class="time-box">
                    <span class="label">ĐỐI TƯỢNG ÁNH HƯỞNG</span>
                    <span class="value"><?= htmlspecialchars($notice['target']) ?></span>
                </div>
            </div>

            <!-- Chi tiết các mục nội dung -->
            <div class="change-body">
                <h3>NỘI DUNG THAY ĐỔI</h3>
                <p><?= htmlspecialchars($notice['content_change']) ?></p>

                <h3>AI BỊ ÁNH HƯỞNG?</h3>
                <p><?= htmlspecialchars($notice['affected_users']) ?></p>

                <h3>CẦN LÀM GÌ?</h3>
                <p><?= htmlspecialchars($notice['action_required']) ?></p>
            </div>

            <!-- Nguồn thông tin -->
            <div class="change-source-section">
                <span>NGUỒN THÔNG TIN</span><br>
                <span class="source-badge"><?= htmlspecialchars($notice['source']) ?></span>
            </div>

            <!-- Bài viết liên quan (3 thẻ nằm ngang ở dưới cột trái) -->
            <div class="related-posts-section">
                <h4 class="related-title">BÀI VIẾT LIÊN QUAN</h4>
                <div class="related-grid-3col">
                    <div class="related-card-small">
                        <img src="assets/images/related1.jpg" alt="Liên quan 1">
                        <div class="info">
                            <h5>Cách ghi chép hiệu quả khi học trên lớp</h5>
                            <span>12/08/2026</span>
                        </div>
                    </div>
                    <div class="related-card-small">
                        <img src="assets/images/related2.jpg" alt="Liên quan 2">
                        <div class="info">
                            <h5>Làm thế nào để đọc hiểu tài liệu chuyên ngành</h5>
                            <span>12/08/2026</span>
                        </div>
                    </div>
                    <div class="related-card-small">
                        <img src="assets/images/related3.jpg" alt="Liên quan 3">
                        <div class="info">
                            <h5>Kinh nghiệm làm bài tập lớn khoa học hiệu quả</h5>
                            <span>12/08/2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- CỘT PHẢI: Bảng Tóm Tắt + Bình Luận -->
        <aside class="change-sidebar">
            
            <!-- Bảng Tóm Tắt Thay Đổi -->
            <div class="summary-card">
                <h3 class="summary-title">TÓM TẮT THAY ĐỔI</h3>
                <table class="summary-table">
                    <tr>
                        <td>Nội dung thay đổi</td>
                        <td><strong><?= htmlspecialchars($notice['summary_change_type']) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Thời gian áp dụng</td>
                        <td><?= htmlspecialchars($notice['summary_effective_date']) ?></td>
                    </tr>
                    <tr>
                        <td>Đối tượng</td>
                        <td><?= htmlspecialchars($notice['summary_target']) ?></td>
                    </tr>
                    <tr>
                        <td>Mức độ ảnh hưởng</td>
                        <td><span class="badge-impact-medium"><?= htmlspecialchars($notice['summary_impact_level']) ?></span></td>
                    </tr>
                    <tr>
                        <td>Cần làm gì ?</td>
                        <td><?= htmlspecialchars($notice['summary_action']) ?></td>
                    </tr>
                </table>
            </div>

            <!-- Phần Bình Luận -->
            <div class="comments-sidebar-block">
                <h3 class="comments-title">Bình luận (<?= count($comments) ?>)</h3>

                <div class="comments-list">
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item">
                            <img src="<?= htmlspecialchars($comment['avatar']) ?>" alt="Avatar" class="comment-avatar">
                            <div class="comment-body">
                                <div class="comment-author"><?= htmlspecialchars($comment['author']) ?></div>
                                <div class="comment-text"><?= htmlspecialchars($comment['content']) ?></div>
                                <div class="comment-date"><?= htmlspecialchars($comment['created_at']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Form Nhập Bình Luận -->
                <div class="add-comment-box">
                    <h4>VIẾT BÌNH LUẬN</h4>
                    <form action="post-comment.php" method="POST">
                        <input type="hidden" name="notice_id" value="<?= $id ?>">
                        <div class="form-group">
                            <input type="text" name="author_name" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="form-group">
                            <textarea name="comment_text" rows="3" placeholder="Viết bình luận..." required></textarea>
                        </div>
                        <div class="form-action">
                            <button type="submit" class="btn-submit-comment">Gửi bình luận</button>
                        </div>
                    </form>
                </div>
            </div>

        </aside>

    </div>
</div>

<?php include '../includes/footer.php'; ?>