<?php
require_once '../config/database.php';
include '../includes/header.php';
$per_page=5;
$page=isset($_GET['page'])?(int)$_GET['page']:1;
if($page<1)$page=1;
$count_sql="SELECT COUNT(*) FROM posts p JOIN categories c ON p.category_id=c.id WHERE c.slug='tin-khoa' AND p.status='published'";
$total_posts=(int)$pdo->query($count_sql)->fetchColumn();
$total_pages=max(1,(int)ceil($total_posts/$per_page));
if($page>$total_pages)$page=$total_pages;
$offset=($page-1)*$per_page;
$sql="SELECT p.id,p.title,p.summary,p.thumbnail,p.created_at,u.full_name AS author FROM posts p JOIN users u ON p.author_id=u.id JOIN categories c ON p.category_id=c.id WHERE c.slug='tin-khoa' AND p.status='published' ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(':limit',$per_page,PDO::PARAM_INT);
$stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
$stmt->execute();
$posts=$stmt->fetchAll();
$sql_latest="SELECT p.id,p.title,p.thumbnail,p.created_at FROM posts p WHERE p.status='published' ORDER BY p.created_at DESC LIMIT 3";
$stmt_latest=$pdo->query($sql_latest);
$latest_posts=$stmt_latest->fetchAll();
?>
<div class="intro small">
<h1>Tin Khoa</h1>
<p>Cập nhật những thông tin, hoạt động và thông báo mới nhất từ khoa dành cho sinh viên.</p>
</div>
<div class="features">
<div class="main-content">
<?php foreach($posts as $post): ?>
<article class="box" style="display:flex;gap:18px;align-items:flex-start;">
<div style="width:200px;height:120px;flex-shrink:0;overflow:hidden;border-radius:6px;background:#eee;">
<img src="../<?=htmlspecialchars($post['thumbnail'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;">
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
<?php if(count($posts)==0): ?>
<div class="box">
<p>Chưa có bài viết nào trong danh mục Tin khoa.</p>
</div>
<?php endif; ?>
<?php if($total_pages>1): ?>
<div style="display:flex;justify-content:center;align-items:center;gap:6px;margin-top:20px;">
<?php if($page>1): ?>
<a href="?page=<?=$page-1?>" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">&lt;</a>
<?php endif; ?>
<?php for($i=1;$i<=$total_pages;$i++): ?>
<?php if($i==$page): ?>
<a href="?page=<?=$i?>" class="btn-primary-brown" style="padding:4px 10px;min-height:auto;"><?=$i?></a>
<?php else: ?>
<a href="?page=<?=$i?>" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;"><?=$i?></a>
<?php endif; ?>
<?php endfor; ?>
<?php if($page<$total_pages): ?>
<a href="?page=<?=$page+1?>" class="btn-outline-brown" style="padding:4px 10px;min-height:auto;">&gt;</a>
<?php endif; ?>
</div>
<?php endif; ?>
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
<img src="../<?=htmlspecialchars($latest['thumbnail'])?>" style="width:60px;height:45px;object-fit:cover;border-radius:4px;flex-shrink:0;">
<div>
<h4 style="font-size:11px;font-weight:700;color:var(--brown-dark);margin:0;line-height:1.3;">
<?=htmlspecialchars($latest['title'])?>
</h4>
<span style="font-size:9px;color:var(--muted);"><?=date('d/m/Y',strtotime($latest['created_at']))?></span>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>