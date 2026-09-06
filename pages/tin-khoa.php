<?php
require_once '../config/database.php';
include '../includes/header.php';
$category_slug='tin-khoa';
$stmt=$pdo->prepare("SELECT p.id,p.title,p.summary,p.image,p.created_at,u.name AS author,c.name AS category FROM posts p JOIN users u ON p.author_id=u.id JOIN categories c ON p.category_id=c.id WHERE c.slug=? ORDER BY p.created_at DESC");
$stmt->execute([$category_slug]);
$posts=$stmt->fetchAll();
$stmt_latest=$pdo->prepare("SELECT p.id,p.title,p.image,p.created_at FROM posts p JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC LIMIT 3");
$stmt_latest->execute();
$latest_posts=$stmt_latest->fetchAll();
?>
<main class="container">
<div class="intro small">
<h1>Tin Khoa</h1>
<p>Cập nhật những thông tin, hoạt động và thông báo mới nhất từ khoa dành cho sinh viên.</p>
</div>
<div class="features">
<div class="main-content">
<?php if(count($posts)>0): ?>
<?php foreach($posts as $post): ?>
<article class="box" style="display:flex;gap:18px;align-items:flex-start;">
<div style="width:200px;height:120px;flex-shrink:0;overflow:hidden;border-radius:6px;background:#eee;">
<img src="../<?=htmlspecialchars($post['image'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none'">
</div>
<div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;min-height:120px;">
<div>
<h2 class="card-title" style="margin-top:4px;"><?=htmlspecialchars($post['title'])?></h2>
<p class="card-desc" style="font-size:12px;margin-top:6px;"><?=htmlspecialchars($post['summary'])?></p>
</div>
<div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;font-size:11px;color:var(--muted);">
<span>📅 <?=date('d/m/Y',strtotime($post['created_at']))?> • ✍️ <?=htmlspecialchars($post['author'])?></span>
<a href="chi-tiet-bai-viet.php?id=<?=$post['id']?>" style="color:var(--brown);font-weight:600;">Xem bài →</a>
</div>
</div>
</article>
<?php endforeach; ?>
<?php else: ?>
<div class="box">
<p>Chưa có bài viết thuộc danh mục Tin khoa.</p>
</div>
<?php endif; ?>
<div style="display:flex;justify-content:center;align-items:center;gap:6px;margin-top:20px;">
<a href="#" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">&lt;</a>
<a href="#" class="btn-primary-brown" style="padding:4px 10px;min-height:auto;">1</a>
<a href="#" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">2</a>
<a href="#" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">3</a>
<a href="#" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">4</a>
<a href="#" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">5</a>
<a href="#" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">&gt;</a>
</div>
</div>
<div class="sidebar-content">
<div class="box">
<h3>DANH MỤC</h3>
<ul style="list-style:none;padding:0;margin:0;font-size:13px;display:flex;flex-direction:column;gap:8px;">
<li><a href="tin-khoa.php" style="color:var(--brown);font-weight:700;">• Tin khoa</a></li>
<li><a href="hoc-tap.php">• Học tập & Nghiên cứu</a></li>
<li><a href="co-hoi.php">• Cơ hội</a></li>
<li><a href="su-kien.php">• Sự kiện</a></li>
</ul>
</div>
<div class="box">
<h3 style="font-size:14px;font-weight:700;color:var(--brown);margin-bottom:12px;text-transform:uppercase;">BÀI MỚI NHẤT</h3>
<div style="display:flex;flex-direction:column;gap:12px;">
<?php foreach($latest_posts as $latest): ?>
<a href="chi-tiet-bai-viet.php?id=<?=$latest['id']?>" style="display:flex;gap:10px;text-decoration:none;align-items:center;">
<img src="../<?=htmlspecialchars($latest['image'])?>" style="width:60px;height:45px;object-fit:cover;border-radius:4px;flex-shrink:0;" onerror="this.style.display='none'">
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
</main>
<?php include '../includes/footer.php'; ?>