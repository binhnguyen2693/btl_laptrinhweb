<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';
$posts = [];
try {
    $posts = db()->query("SELECT p.title,p.summary,p.published_at,c.name AS category_name,u.full_name AS author_name FROM posts p JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.author_id WHERE p.status='published' AND c.status='active' ORDER BY p.published_at DESC LIMIT 4")->fetchAll();
} catch (PDOException $exception) {
    $posts = [];
}
$demoPosts = [
 ['category_name'=>'HỌC TẬP','title'=>'Bí quyết học hiệu quả trong giai đoạn nước rút cuối cấp','summary'=>'Những phương pháp khoa học giúp bạn tối ưu thời gian ôn tập và cải thiện kết quả.','image'=>'home-card-1.png'],
 ['category_name'=>'CƠ HỘI','title'=>'Học bổng khuyến khích học tập HK2/2024–2025','summary'=>'Thông tin chi tiết về điều kiện và cách thức nộp hồ sơ học bổng.','image'=>'article-3.jpg'],
 ['category_name'=>'HƯỚNG DẪN','title'=>'Hướng dẫn tra cứu lịch học và phòng học','summary'=>'Các bước tra cứu nhanh trên cổng thông tin sinh viên.','image'=>'article-2.jpg'],
 ['category_name'=>'SỰ KIỆN','title'=>'Talkshow: Kỹ năng thuyết trình ấn tượng','summary'=>'Đăng ký tham gia talkshow cùng chuyên gia.','image'=>'article-4.jpg'],
];
if ($posts === []) $posts = $demoPosts;
$pageTitle='Trang chủ'; require __DIR__.'/includes/header.php';
?>
<section class="figma-hero"><div class="site-shell hero-layout"><div class="hero-copy"><p>CẬP NHẬT · ĐỔI MỚI · TÁC ĐỘNG</p><h1>ĐIỀU GÌ<br>ĐANG THAY ĐỔI?</h1><i></i><div>Nơi cập nhật những thông tin quan trọng, cơ hội và hướng dẫn mới nhất dành riêng cho sinh viên Khoa CNTT.<br>Hiểu đúng – Hành động kịp thời – Tạo ra tác động.</div><div class="hero-buttons"><a href="#articles">Tìm thông tin →</a><a href="#featured">Xem bài mới</a></div></div><div class="hero-photo"><img src="assets/images/figma/home-hero.png" alt="Sinh viên trao đổi và học tập trong khuôn viên trường"></div></div></section>

<section id="featured" class="home-section soft-section"><div class="site-shell"><div class="section-title"><h2>Thay đổi đáng chú ý</h2><a href="#">Xem tất cả →</a></div><div class="change-grid">
<article class="change-card urgent"><span>CẦN THỰC HIỆN</span><h3>Đăng ký học phần HK2/2024–2025</h3><p>Sinh viên thực hiện đăng ký học phần trực tuyến trên hệ thống từ ngày 20/05 đến 27/05.</p><div class="mini-meta">♙ Đối tượng: Tất cả sinh viên<br>◷ Hạn chót: 27/05/2026</div><div class="impact"><strong>Impact Summary</strong><p>Ảnh hưởng đến ai: Tất cả sinh viên Khoa CNTT</p><p>Cần làm gì: Đăng nhập hệ thống, chọn học phần phù hợp</p></div><a href="#">Xem chi tiết →</a></article>
<article class="change-card warning"><span>CẦN CHÚ Ý</span><h3>Điều chỉnh lịch thi giữa kỳ một số học phần</h3><p>Lịch thi giữa kỳ của một số học phần sẽ được điều chỉnh từ tuần 9 sang tuần 10.</p><div class="mini-meta">♙ Đối tượng: Sinh viên các lớp liên quan<br>◷ Hạn chót: 19/05/2026</div><a href="#">Xem chi tiết →</a></article>
<article class="change-card info"><span>THÔNG TIN</span><h3>Hướng dẫn sử dụng cổng hỗ trợ sinh viên</h3><p>Cổng hỗ trợ sinh viên mới chính thức đi vào hoạt động từ ngày 15/05/2025.</p><div class="mini-meta">♙ Đối tượng: Tất cả sinh viên<br>◷ Thời gian: Toàn thời gian</div><a href="#">Xem chi tiết →</a></article>
</div></div></section>

<section id="articles" class="home-section"><div class="site-shell"><div class="section-title"><h2>Bài viết và hướng dẫn</h2><a href="#">Xem tất cả →</a></div><div class="article-grid">
<?php foreach ($posts as $index=>$post): $image=$post['image'] ?? $demoPosts[$index]['image']; ?><article class="article-card"><img src="assets/images/figma/<?= e($image) ?>" alt=""><div><div class="article-meta"><span><?= e($post['category_name']) ?></span><span><?= isset($post['published_at']) ? e(date('d/m/Y',strtotime($post['published_at']))) : '12/05/2026' ?></span></div><h3><?= e($post['title']) ?></h3><p><?= e($post['summary']) ?></p><div class="article-actions"><small>◷ 5 phút đọc</small><a class="save-button" href="<?= empty($_SESSION['user']) ? 'dang-nhap.php' : '#' ?>" aria-label="Lưu bài viết vào Impact Box" title="Lưu bài viết">♡</a></div></div></article><?php endforeach; ?>
</div></div></section>

<section id="topics" class="topic-section"><div class="site-shell topic-grid"><article><img src="assets/images/figma/icon-study.png" alt=""><div><h3>Học tập</h3><p>Lịch học, học phần, hướng dẫn học tập và tài liệu</p><a href="#">Khám phá →</a></div></article><article><img src="assets/images/figma/icon-opportunity.svg" alt=""><div><h3>Cơ hội</h3><p>Học bổng, tuyển dụng, thực tập và cuộc thi.</p><a href="#">Khám phá →</a></div></article><article><img src="assets/images/figma/icon-event.svg" alt=""><div><h3>Sự kiện</h3><p>Hội thảo, workshop và hoạt động nổi bật.</p><a href="#">Khám phá →</a></div></article><article><img src="assets/images/figma/icon-impact.svg" alt=""><div><h3>Impact Box</h3><p>Dự án, sáng kiến và câu chuyện tác động.</p><a href="#">Khám phá →</a></div></article></div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
