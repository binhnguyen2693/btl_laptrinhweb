<?php
require_once '../config/database.php';
include '../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT p.id, p.title, p.summary, p.content, p.image, p.created_at, u.name AS author, c.name AS category FROM posts p JOIN users u ON p.author_id = u.id JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo '<main class="container"><div class="intro small"><h2>Không tìm thấy bài viết</h2><p>Bài viết không tồn tại hoặc đã bị xóa.</p></div></main>';
    include '../includes/footer.php';
    exit;
}
?>

<main class="container">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size: 14px; color: var(--muted); margin-bottom: 15px;">
            <a href="../index.php">Trang chủ</a> / <a href="tin-khoa.php"><?=htmlspecialchars($post['category'])?></a> / <span style="color: var(--brown); font-weight: 600;">Chi tiết bài viết</span>
        </div>

        <!-- Bố cục 2 cột (Giống cấu trúc features trong style.css) -->
        <div class="features">
            
            <!-- CỘT TRÁI: Nội dung chi tiết bài viết -->
            <div class="main-content">
                <article>
                    <div style="color: var(--brown); font-size: 13px; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                        <?=htmlspecialchars($post['category'])?> & Nghiên cứu
                    </div>
                    
                    <h1 class="card-title" style="font-size: var(--font-section); margin-bottom: 10px;">
                        <?=htmlspecialchars($post['title'])?>
                    </h1>
                    
                    <p style="color: var(--muted); font-size: 14px; margin-bottom: 20px;">
                        📅 <?=date('d/m/Y', strtotime($post['created_at']))?> &nbsp; • &nbsp; Tác giả: <?=htmlspecialchars($post['author'])?> &nbsp; • &nbsp; 6 phút đọc
                    </p>

                    <?php if(!empty($post['image'])): ?>
                    <div style="width: 100%; max-height: 420px; overflow: hidden; border-radius: 8px; margin-bottom: 20px;">
                        <img src="../<?=htmlspecialchars($post['image'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width: 100%; height: auto; max-height: 420px; object-fit: cover;" onerror="this.style.display='none';">
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($post['summary'])): ?>
                    <p style="font-weight: 600; font-size: 16px; color: var(--brown-dark); margin-bottom: 20px; line-height: 1.6;">
                        <?=htmlspecialchars($post['summary'])?>
                    </p>
                    <?php endif; ?>

                    <div style="font-size: 15px; line-height: 1.8; color: var(--text);">
                        <?=nl2br(htmlspecialchars($post['content']))?>
                    </div>

                    <div style="margin-top: 30px;">
                        <a href="tin-khoa.php" class="btn-outline-brown">← Quay lại danh sách</a>
                    </div>
                </article>
            </div>

            <!-- CỘT PHẢI: Bình luận, Form viết bình luận & Bài viết liên quan -->
            <div class="sidebar-content">
                
                <!-- Box Bình luận -->
                <div class="box">
                    <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--brown-dark);">Bình luận (3)</h3>
                    
                    <!-- Item bình luận 1 -->
                    <div style="display: flex; gap: 12px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #ccc; overflow: hidden; flex-shrink: 0;">
                            <img src="../assets/images/trang-chu.jpg" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 14px; color: var(--brown-dark);">Nguyễn Minh Anh</div>
                            <div style="font-size: 13px; color: var(--text); margin: 3px 0;">Bài viết rất hữu ích, đặc biệt là phần lập kế hoạch học tập.</div>
                            <div style="font-size: 11px; color: var(--muted);">14/08/2026</div>
                        </div>
                    </div>

                    <!-- Item bình luận 2 -->
                    <div style="display: flex; gap: 12px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #ccc; overflow: hidden; flex-shrink: 0;">
                            <img src="../assets/images/trang-chu.jpg" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 14px; color: var(--brown-dark);">Trần Hoàng Nam</div>
                            <div style="font-size: 13px; color: var(--text); margin: 3px 0;">Phần về quản lý thời gian rất thực tế, mình sẽ thử áp dụng.</div>
                            <div style="font-size: 11px; color: var(--muted);">14/08/2026</div>
                        </div>
                    </div>
                </div>

                <!-- Box Viết bình luận -->
                <div class="box">
                    <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--brown-dark);">Viết bình luận</h3>
                    <form action="" method="POST">
                        <div style="margin-bottom: 10px;">
                            <input type="text" placeholder="Nguyễn Văn A" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 4px; font-size: 13px; outline: none; background: #fafafa;">
                        </div>
                        <div style="margin-bottom: 12px;">
                            <textarea placeholder="Viết bình luận..." rows="3" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 4px; font-size: 13px; outline: none; resize: vertical; background: #fafafa;"></textarea>
                        </div>
                        <div style="text-align: right;">
                            <button type="submit" class="btn-primary-brown" style="font-size: 13px; padding: 6px 16px;">Gửi bình luận</button>
                        </div>
                    </form>
                </div>

                <!-- Box Bài viết liên quan -->
                <div class="box">
                    <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--brown-dark);">Bài viết liên quan</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
                        <a href="#" style="display: flex; gap: 10px; align-items: center; color: var(--text);">
                            <span style="width: 50px; height: 40px; background: #ddd; border-radius: 4px; flex-shrink: 0; overflow:hidden;"><img src="../assets/images/trang-chu.jpg" style="width:100%;height:100%;object-fit:cover;"></span>
                            <span>Cách ghi nhớ kiến thức khi học trực tuyến <br><small style="color:var(--muted)">13/08/2026</small></span>
                        </a>
                        <a href="#" style="display: flex; gap: 10px; align-items: center; color: var(--text);">
                            <span style="width: 50px; height: 40px; background: #ddd; border-radius: 4px; flex-shrink: 0; overflow:hidden;"><img src="../assets/images/trang-chu.jpg" style="width:100%;height:100%;object-fit:cover;"></span>
                            <span>Làm thế nào để đạt điểm A các môn chuyên ngành? <br><small style="color:var(--muted)">11/08/2026</small></span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>