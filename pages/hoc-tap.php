<?php include '../includes/header.php'; ?>

<!-- Logic xử lý dữ liệu PHP -->
<?php
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nhip_khoa_db;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy thông tin bài viết
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute(['id' => $post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lấy danh sách bình luận
    $stmt_cmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = :id ORDER BY created_at DESC");
    $stmt_cmt->execute(['id' => $post_id]);
    $comments = $stmt_cmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Dữ liệu mẫu chuẩn 100% theo ảnh giao diện
    $post = [
        'id' => 1,
        'category_name' => 'HỌC TẬP & NGHIÊN CỨU',
        'title' => 'Một số kinh nghiệm giúp sinh viên chủ động hơn trong quá trình học các môn chuyên ngành',
        'author' => 'Nguyễn An',
        'created_at' => '2026-08-14',
        'read_time' => '6 phút đọc',
        'image_url' => 'assets/images/article-detail.jpg',
        'image_caption' => 'Sinh viên chủ động tìm hiểu và trao đổi trong quá trình học tập',
        'tags' => ['Học tập', 'Sinh viên', 'Chuyên ngành', 'Kinh nghiệm']
    ];

    $comments = [
        [
            'author' => 'Nguyễn Minh Anh',
            'avatar' => 'assets/images/user1.jpg',
            'created_at' => '14/08/2026',
            'content' => 'Bài viết rất hữu ích, đặc biệt là phần lập kế hoạch học tập.'
        ],
        [
            'author' => 'Trần Hoàng Nam',
            'avatar' => 'assets/images/user2.jpg',
            'created_at' => '14/08/2026',
            'content' => 'Phần về quản lý thời gian rất thực tế, mình sẽ thử áp dụng.'
        ],
        [
            'author' => 'Lê Lan Phương',
            'avatar' => 'assets/images/user3.jpg',
            'created_at' => '14/08/2026',
            'content' => 'Mình thấy phương pháp kết hợp nhiều cách học khá phù hợp với sinh viên.'
        ]
    ];
}
?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        Trang chủ / Học tập / <b>Chi tiết bài viết</b>
    </div>

    <!-- Layout chính 2 cột -->
    <div class="article-detail-layout">
        
        <!-- CỘT TRÁI: Nội dung bài viết -->
        <main class="article-main">
            <div class="card-category"><?= htmlspecialchars($post['category_name']) ?></div>
            <h1 class="article-title"><?= htmlspecialchars($post['title']) ?></h1>
            
            <div class="article-meta">
                <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span> • 
                <span>Tác giả: <?= htmlspecialchars($post['author']) ?></span> • 
                <span><?= htmlspecialchars($post['read_time']) ?></span>
            </div>

            <div class="article-featured-image">
                <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="Ảnh bài viết">
                <p class="image-caption"><?= htmlspecialchars($post['image_caption']) ?></p>
            </div>

            <!-- Nội dung chi tiết bài viết -->
            <div class="article-content">
                <h3>1. Chủ động ngay từ đầu</h3>
                <p>Ngay khi bắt đầu một môn học, hãy dành thời gian đọc kỹ đề cương, xác định mục tiêu và những kiến thức trọng tâm. Điều này giúp bạn có định hướng rõ ràng, tránh học lan man và tiết kiệm thời gian.</p>

                <h3>2. Lập kế hoạch học tập khoa học</h3>
                <p>Chia nhỏ nội dung cần học thành từng phần và sắp xếp lịch học phù hợp với thời gian biểu cá nhân. Ưu tiên học trước những phần khó và dành thời gian ôn tập thường xuyên để ghi nhớ lâu hơn.</p>

                <h3>3. Kết hợp nhiều phương pháp học</h3>
                <p>Không chỉ học từ giáo trình, hãy tận dụng bài giảng, tài liệu tham khảo, video bài giảng và thảo luận nhóm để hiểu sâu hơn. Việc đa dạng phương pháp giúp quá trình học trở nên thú vị và hiệu quả hơn.</p>
            </div>

            <!-- Thẻ Tags -->
            <div class="article-tags">
                <?php foreach ($post['tags'] as $tag): ?>
                    <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            </div>

            <!-- Bài viết liên quan (Nằm góc dưới cột trái) -->
            <div class="related-posts-section">
                <h4 class="related-title">Bài viết liên quan</h4>
                <div class="related-grid">
                    <div class="related-card">
                        <img src="assets/images/related1.jpg" alt="Bài liên quan 1">
                        <div class="related-info">
                            <h5>Cách ghi nhớ hiệu quả khi học trên lớp</h5>
                            <span>13/08/2026</span>
                        </div>
                    </div>
                    <div class="related-card">
                        <img src="assets/images/related2.jpg" alt="Bài liên quan 2">
                        <div class="related-info">
                            <h5>Làm thế nào để đạt điểm cao bài tập lớn chuyên ngành?</h5>
                            <span>12/08/2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- CỘT PHẢI: Bình luận & Form viết bình luận -->
        <aside class="comments-sidebar">
            <h3 class="comments-title">Bình luận (<?= count($comments) ?>)</h3>

            <!-- Danh sách các bình luận -->
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

            <!-- Form Viết Bình Luận -->
            <div class="add-comment-box">
                <h4>VIẾT BÌNH LUẬN</h4>
                <form action="post-comment.php" method="POST">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    
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
        </aside>

    </div>
</div>

<?php include '../includes/footer.php'; ?>