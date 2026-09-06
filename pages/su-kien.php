<?php
require_once '../config/database.php';
include '../includes/header.php';
$category_slug='su-kien';
$per_page=6;
$page=max(1,(int)($_GET['page']??1));
$offset=($page-1)*$per_page;
$sql_count="SELECT COUNT(*) FROM posts p JOIN categories c ON p.category_id=c.id WHERE c.slug=? AND c.status='active' AND p.status='published'";
$stmt_count=$pdo->prepare($sql_count);
$stmt_count->execute([$category_slug]);
$total=(int)$stmt_count->fetchColumn();
$total_pages=max(1,(int)ceil($total/$per_page));
if($page>$total_pages){
$page=$total_pages;
$offset=($page-1)*$per_page;
}
$sql="SELECT p.id,p.title,p.summary,p.thumbnail,p.published_at,p.created_at
FROM posts p
JOIN categories c ON p.category_id=c.id
WHERE c.slug=? AND c.status='active' AND p.status='published'
ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC
LIMIT ? OFFSET ?";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(1,$category_slug,PDO::PARAM_STR);
$stmt->bindValue(2,$per_page,PDO::PARAM_INT);
$stmt->bindValue(3,$offset,PDO::PARAM_INT);
$stmt->execute();
$posts=$stmt->fetchAll();
function eventImage($thumbnail){
if(!$thumbnail){
return '../assets/images/su-kien-1.png';
}
if(strpos($thumbnail,'http://')===0||strpos($thumbnail,'https://')===0){
return $thumbnail;
}
return '../'.ltrim($thumbnail,'/');
}
function eventDate($date){
return date('d/m/Y',strtotime($date));
}
?>
<main class="container">
<div class="intro small">
<h1>SỰ KIỆN</h1>
<p>Cập nhật các hoạt động, chương trình và sự kiện nổi bật dành cho sinh viên.</p>
</div>
<?php if(!empty($posts)): ?>
<div style="margin-bottom:30px;margin-top:20px;">
<h2 style="font-size:14px;font-weight:800;color:var(--brown-dark);text-transform:uppercase;margin-bottom:12px;letter-spacing:0.5px;">SỰ KIỆN SẮP DIỄN RA</h2>
<?php $hot=$posts[0]; ?>
<div class="box" style="display:flex;gap:20px;padding:18px;border-radius:14px;border:1.5px solid var(--border);background:#fff;align-items:center;">
<div style="width:340px;height:180px;flex-shrink:0;overflow:hidden;border-radius:10px;background:#eee;">
<img src="<?=htmlspecialchars(eventImage($hot['thumbnail']))?>" alt="<?=htmlspecialchars($hot['title'])?>" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='../assets/images/su-kien-hot.png';">
</div>
<div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;min-height:180px;">
<div>
<span style="display:inline-block;padding:3px 8px;background:#D97706;color:#fff;font-size:9px;font-weight:700;border-radius:4px;margin-bottom:8px;text-transform:uppercase;">SẮP DIỄN RA</span>
<h3 style="font-size:16px;font-weight:800;color:var(--brown-dark);margin-bottom:8px;line-height:1.35;"><?=htmlspecialchars($hot['title'])?></h3>
<div style="display:flex;flex-wrap:wrap;gap:12px;font-size:10.5px;color:#6B625D;margin-bottom:10px;">
<span>📅 <?=eventDate($hot['published_at']??$hot['created_at'])?></span>
<span>📍 Khu giảng đường</span>
<span>👥 Dành cho sinh viên toàn khoa</span>
</div>
<p style="font-size:11px;line-height:1.45;color:#5E5752;margin:0;"><?=htmlspecialchars($hot['summary'])?></p>
</div>
<div style="text-align:right;margin-top:10px;">
<a href="chi-tiet-bai-viet.php?id=<?= (int)$hot['id'] ?>&from=su-kien" style="color:var(--brown-dark);font-weight:700;font-size:11px;">Xem bài →</a>
</div>
</div>
</div>
</div>
<div>
<h2 style="font-size:14px;font-weight:800;color:var(--brown-dark);text-transform:uppercase;margin-bottom:12px;letter-spacing:0.5px;">CÁC SỰ KIỆN KHÁC</h2>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
<?php foreach(array_slice($posts,1) as $post): ?>
<article class="box" style="display:flex;flex-direction:column;justify-content:space-between;padding:0;border-radius:14px;border:1.5px solid var(--border);background:#fff;overflow:hidden;">
<div style="width:100%;height:160px;overflow:hidden;background:#eee;position:relative;">
<img src="<?=htmlspecialchars(eventImage($post['thumbnail']))?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='../assets/images/su-kien-1.png';">
<span style="position:absolute;bottom:10px;left:10px;padding:3px 8px;background:#D97706;color:#fff;font-size:8.5px;font-weight:700;border-radius:4px;text-transform:uppercase;">SẮP DIỄN RA</span>
</div>
<div style="padding:14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
<div>
<h3 class="card-title" style="font-size:14px;font-weight:700;color:var(--brown-dark);margin-bottom:8px;line-height:1.35;"><?=htmlspecialchars($post['title'])?></h3>
<p style="font-size:11px;line-height:1.45;color:#5E5752;margin:0;"><?=htmlspecialchars($post['summary'])?></p>
</div>
<div style="font-size:10px;color:#8C827A;display:flex;flex-direction:column;gap:4px;margin-top:10px;">
<span>📅 <?=eventDate($post['published_at']??$post['created_at'])?></span>
<span>📍 Khu giảng đường</span>
</div>
<div style="text-align:right;margin-top:12px;">
<a href="chi-tiet-bai-viet.php?id=<?= (int)$post['id'] ?>&from=su-kien" class="btn-outline-brown" style="font-size:11px;padding:5px 10px;">Xem chi tiết →</a>
</div>
</div>
</article>
<?php endforeach; ?>
</div>
</div>
<?php if($total_pages>1): ?>
<div style="display:flex;justify-content:center;align-items:center;gap:6px;margin:30px 0 10px 0;">
<?php if($page>1): ?>
<a href="?page=<?=$page-1?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&lt;</a>
<?php endif; ?>
<?php for($i=1;$i<=$total_pages;$i++): ?>
<?php if($i===$page): ?>
<a href="?page=<?=$i?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;background:var(--brown);color:#fff;font-size:11px;font-weight:700;"><?=$i?></a>
<?php else: ?>
<a href="?page=<?=$i?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown-dark);font-size:11px;"><?=$i?></a>
<?php endif; ?>
<?php endfor; ?>
<?php if($page<$total_pages): ?>
<a href="?page=<?=$page+1?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&gt;</a>
<?php endif; ?>
</div>
<?php endif; ?>
<?php else: ?>
<div class="box" style="padding:30px;text-align:center;margin-top:20px;">
<p style="font-size:13px;color:#6B625D;margin:0;">Hiện chưa có sự kiện nào được công bố.</p>
</div>
<?php endif; ?>
</main>
<style>
@media(max-width:900px){
main.container>div:nth-of-type(2)>div{
grid-template-columns:repeat(2,1fr)!important;
}
}
@media(max-width:600px){
main.container>div:nth-of-type(2)>div{
grid-template-columns:1fr!important;
}
}
</style>
<?php
include '../includes/footer.php';
?>

