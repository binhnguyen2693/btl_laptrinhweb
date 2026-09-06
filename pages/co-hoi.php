<?php
require_once '../config/database.php';
include '../includes/header.php';
$sql="SELECT p.id,p.title,p.summary,p.image,p.created_at,u.name AS author FROM posts p JOIN users u ON p.author_id=u.id JOIN categories c ON p.category_id=c.id WHERE c.slug='co-hoi' ORDER BY p.created_at DESC";
$stmt=$pdo->query($sql);
$posts=$stmt->fetchAll();
$sql_latest="SELECT p.id,p.title,p.image,p.created_at FROM posts p ORDER BY p.created_at DESC LIMIT 3";
$stmt_latest=$pdo->query($sql_latest);
$latest_posts=$stmt_latest->fetchAll();
?>
<div style="font-size:12px;color:var(--muted);margin-bottom:12px;">
<a href="../index.php">Trang chủ</a> / <span style="color:var(--brown);font-weight:600;">Cơ hội</span>
</div>
<div class="intro small">
<h1>CƠ HỘI</h1>
<p>Học bổng, thực tập, việc làm và các cơ hội phát triển bản thân dành cho sinh viên.</p>
</div>
<div style="display:flex;gap:24px;align-items:flex-start;margin-top:20px;">
<div style="flex:1;">
<div style="display:flex;flex-direction:column;gap:18px;">
<?php foreach($posts as $post): ?>
<article class="box" style="display:flex;gap:20px;align-items:center;padding:18px;border-radius:14px;border:1.5px solid var(--border);background:#fff;">
<div style="width:200px;height:110px;flex-shrink:0;overflow:hidden;border-radius:10px;background:#eee;">
<img src="../<?=htmlspecialchars($post['image'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;">
</div>
<div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;min-height:110px;">
<div>
<h2 class="card-title" style="font-size:15px;font-weight:700;color:var(--brown-dark);margin-bottom:6px;line-height:1.3;"><?=htmlspecialchars($post['title'])?></h2>
<p class="card-desc" style="font-size:11px;line-height:1.45;color:#5E5752;"><?=htmlspecialchars($post['summary'])?></p>
</div>
<div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;font-size:10px;color:#8C827A;">
<span><?=date('d/m/Y',strtotime($post['created_at']))?> &nbsp;•&nbsp; <?=htmlspecialchars($post['author'])?></span>
<a href="chi-tiet-bai-viet.php?id=<?=$post['id']?>" style="color:var(--brown-dark);font-weight:600;font-size:11px;">Xem bài →</a>
</div>
</div>
</article>
<?php endforeach; ?>
<?php if(count($posts)==0): ?>
<div class="box"><p>Chưa có bài viết nào trong danh mục Cơ hội.</p></div>
<?php endif; ?>
</div>
<div style="display:flex;justify-content:center;align-items:center;gap:6px;margin:30px 0 10px 0;">
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&lt;</a>
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;background:var(--brown);color:#fff;font-size:11px;font-weight:700;">1</a>
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown-dark);font-size:11px;">2</a>
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown-dark);font-size:11px;">3</a>
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown-dark);font-size:11px;">4</a>
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown-dark);font-size:11px;">5</a>
<a href="#" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&gt;</a>
</div>
</div>
<div style="width:300px;flex-shrink:0;display:flex;flex-direction:column;gap:20px;">
<div style="border:1.5px solid var(--brown);border-radius:12px;padding:16px;background:#fff;">
<h3 style="font-size:12px;font-weight:800;color:var(--brown-dark);text-transform:uppercase;margin-bottom:12px;border-bottom:1px solid #EEE;padding-bottom:6px;">DANH MỤC</h3>
<ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;font-size:11px;">
<li><a href="tin-khoa.php" style="color:#5E5752;text-decoration:none;">Tin khoa</a></li>
<li><a href="hoc-tap.php" style="color:#5E5752;text-decoration:none;">Học tập & Nghiên cứu</a></li>
<li><a href="co-hoi.php" style="color:var(--brown);font-weight:700;text-decoration:none;">Cơ hội</a></li>
<li><a href="su-kien.php" style="color:#5E5752;text-decoration:none;">Sự kiện</a></li>
<li><a href="chi-tiet-thay-doi.php" style="color:#5E5752;text-decoration:none;">Thông tin thay đổi</a></li>
</ul>
</div>
<div class="box">
<h3 style="font-size:14px;font-weight:700;color:var(--brown);margin-bottom:12px;text-transform:uppercase;">BÀI MỚI NHẤT</h3>
<div style="display:flex;flex-direction:column;gap:12px;">
<?php foreach($latest_posts as $latest): ?>
<a href="chi-tiet-bai-viet.php?id=<?=$latest['id']?>" style="display:flex;gap:10px;text-decoration:none;align-items:center;">
<img src="../<?=htmlspecialchars($latest['image'])?>" style="width:60px;height:45px;object-fit:cover;border-radius:4px;flex-shrink:0;">
<div>
<h4 style="font-size:11px;font-weight:700;color:var(--brown-dark);margin:0;line-height:1.3;"><?=htmlspecialchars($latest['title'])?></h4>
<span style="font-size:9px;color:var(--muted);"><?=date('d/m/Y',strtotime($latest['created_at']))?></span>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>