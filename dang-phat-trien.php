<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';
$features = [
    'thay-doi' => 'Chi tiết thay đổi đáng chú ý',
    'danh-sach-bai' => 'Danh sách bài viết công khai',
    'bai-minh-hoa' => 'Bài viết minh họa',
    'tin-khoa' => 'Tin khoa',
    'hoc-tap' => 'Học tập',
    'co-hoi' => 'Cơ hội',
    'su-kien' => 'Sự kiện',
    'huong-dan' => 'Hướng dẫn',
    'impact-box' => 'Impact Box',
    'faq' => 'Câu hỏi thường gặp',
    'lien-he' => 'Liên hệ',
    'gop-y' => 'Góp ý',
];
$key = (string) ($_GET['feature'] ?? 'tinh-nang');
$feature = $features[$key] ?? 'Tính năng này';
$pageTitle = 'Đang phát triển';
require __DIR__ . '/includes/header.php';
?>
<section class="public-detail"><div class="site-shell"><div class="public-state"><span>ĐANG PHÁT TRIỂN</span><h1><?= e($feature) ?></h1><p>Phần này đang chờ chức năng từ branch phụ trách. Nội dung sẽ được bổ sung sau khi tích hợp và kiểm thử.</p><a href="index.php">← Quay lại trang chủ</a></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
