<?php
require_once '../config/database.php';
include '../includes/header.php';
$slug='hoc-tap';
$per_page=6;
$page=isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$count_sql="SELECT COUNT(*) FROM posts p JOIN categories c ON p.category_id=c.id WHERE c.slug=? AND c.status='active' AND p.status='published'";
$count_stmt=$pdo->prepare($count_sql);
$count_stmt->execute([$slug]);
$total_posts=(int)$count_stmt->fetchColumn();
$total_pages=max(1,(int)ceil($total_posts/$per_page));
if($page>$total_pages){
$page=$total_pages;
}
$offset=($page-1)*$per_page;
$sql="SELECT p.id,p.title,p.summary,p.thumbnail,p.published_at,p.created_at,c.name AS category_name FROM posts p JOIN categories c ON p.category_id=c.id WHERE c.slug=? AND c.status='active' AND p.status='published' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT ? OFFSET ?";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(1,$slug,PDO::PARAM_STR);
$stmt->bindValue(2,$per_page,PDO::PARAM_INT);
$stmt->bindValue(3,$offset,PDO::PARAM_INT);
$stmt->execute();
$posts=$stmt->fetchAll();
?>
<main class="container">
<div class="intro small">
<h1>HỌC TẬP & NGHIÊN CỨU</h1>
<p>Kiến thức, nghiên cứu và kinh nghiệm học tập dành cho sinh viên khoa.</p>
</div>
<?php if($posts): ?>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:20px;">
<?php foreach($posts as $post): ?>
<?php
$date=$post['published_at']??$post['created_at'];
$thumbnail=$post['thumbnail'];
$fallback='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&auto=format&fit=crop';
?>
<article class="box" style="display:flex;flex-direction:column;justify-content:space-between;padding:0;border-radius:14px;border:1.5px solid var(--border);box-shadow:none;background:#fff;overflow:hidden;">
<div style="width:100%;height:180px;overflow:hidden;background:#eee;">
<?php if($thumbnail): ?>
<img src="../<?=htmlspecialchars($thumbnail)?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='<?=$fallback?>'">
<?php else: ?>
<img src="<?=$fallback?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;">
<?php endif; ?>
</div>
<div style="padding:16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
<div>
<span style="font-size:9.5px;font-weight:800;color:#6C8065;letter-spacing:0.5px;text-transform:uppercase;display:block;margin-bottom:6px;"><?=htmlspecialchars($post['category_name'])?></span>
<h2 class="card-title" style="font-size:15px;font-weight:700;color:var(--brown-dark);margin-bottom:8px;line-height:1.35;"><?=htmlspecialchars($post['title'])?></h2>
<p class="card-desc" style="font-size:10.5px;line-height:1.45;color:#5E5752;"><?=htmlspecialchars($post['summary'])?></p>
</div>
<div style="display:flex;justify-content:space-between;align-items:center;margin-top:15px;font-size:10px;color:#8C827A;">
<span><?=date('d/m/Y',strtotime($date))?></span>
<a href="chi-tiet-bai-viet.php?id=<?= (int)$post['id'] ?>&from=hoc-tap" style="color:var(--brown-dark);font-weight:600;font-size:10.5px;">Xem bài →</a>
</div>
</div>
</article>
<?php endforeach; ?>
</div>
<?php else: ?>
<div style="margin-top:25px;padding:35px 20px;text-align:center;border:1px solid var(--border);border-radius:14px;background:#fff;">
<h2 style="font-size:18px;color:var(--brown-dark);margin-bottom:8px;">Chưa có bài viết</h2>
<p style="font-size:13px;color:var(--muted);">Hiện chưa có bài viết học tập và nghiên cứu nào được xuất bản.</p>
</div>
<?php endif; ?>
<?php if($total_pages>1): ?>
<div style="display:flex;justify-content:center;align-items:center;gap:6px;margin:30px 0 10px 0;">
<?php if($page>1): ?>
<a href="?page=<?=$page-1?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&lt;</a>
<?php endif; ?>
<?php for($i=1;$i<=$total_pages;$i++): ?>
<a href="?page=<?=$i?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;background:<?=$i===$page?'var(--brown)':'transparent'?>;color:<?=$i===$page?'#fff':'var(--brown-dark)'?>;font-size:11px;font-weight:<?=$i===$page?'700':'400'?>;"><?=$i?></a>
<?php endfor; ?>
<?php if($page<$total_pages): ?>
<a href="?page=<?=$page+1?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&gt;</a>
<?php endif; ?>
</div>
<?php endif; ?>
</main>
<style>
@media(max-width:900px){
.container>div[style*="grid-template-columns"]{
grid-template-columns:repeat(2,1fr)!important;
}
}
@media(max-width:600px){
.container>div[style*="grid-template-columns"]{
grid-template-columns:1fr!important;
}
}
</style>
<?php include '../includes/footer.php'; ?>

