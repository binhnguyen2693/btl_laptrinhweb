<?php
require_once '../config/database.php';
include '../includes/header.php';
$slug='co-hoi';
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
$sql="SELECT p.id,p.title,p.summary,p.thumbnail,p.created_at,p.published_at,u.full_name AS author FROM posts p JOIN users u ON p.author_id=u.id JOIN categories c ON p.category_id=c.id WHERE c.slug=? AND c.status='active' AND p.status='published' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT ? OFFSET ?";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(1,$slug,PDO::PARAM_STR);
$stmt->bindValue(2,$per_page,PDO::PARAM_INT);
$stmt->bindValue(3,$offset,PDO::PARAM_INT);
$stmt->execute();
$posts=$stmt->fetchAll();
$sql_latest="SELECT p.id,p.title,p.thumbnail,p.created_at,p.published_at FROM posts p WHERE p.status='published' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT 3";
$stmt_latest=$pdo->query($sql_latest);
$latest_posts=$stmt_latest->fetchAll();
?>
<main class="container">
<div class="intro small">
<h1>CƠ HỘI</h1>
<p>Học bổng, thực tập, việc làm và các cơ hội phát triển bản thân dành cho sinh viên.</p>
</div>
<div style="display:flex;gap:24px;align-items:flex-start;margin-top:20px;">
<div style="flex:1;">
<div style="display:flex;flex-direction:column;gap:18px;">
<?php if($posts): ?>
<?php foreach($posts as $post): ?>
<?php
$date=$post['published_at']??$post['created_at'];
$fallback='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&auto=format&fit=crop';
?>
<article class="box" style="display:flex;gap:20px;align-items:center;padding:18px;border-radius:14px;border:1.5px solid var(--border);background:#fff;">
<div style="width:200px;height:110px;flex-shrink:0;overflow:hidden;border-radius:10px;background:#eee;">
<?php if($post['thumbnail']): ?>
<img src="../<?=htmlspecialchars($post['thumbnail'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='<?=$fallback?>'">
<?php else: ?>
<img src="<?=$fallback?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;">
<?php endif; ?>
</div>
<div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;min-height:110px;">
<div>
<h2 class="card-title" style="font-size:15px;font-weight:700;color:var(--brown-dark);margin-bottom:6px;line-height:1.3;"><?=htmlspecialchars($post['title'])?></h2>
<p class="card-desc" style="font-size:11px;line-height:1.45;color:#5E5752;"><?=htmlspecialchars($post['summary'])?></p>
</div>
<div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;font-size:10px;color:#8C827A;">
<span><?=date('d/m/Y',strtotime($date))?> &nbsp;•&nbsp; <?=htmlspecialchars($post['author'])?></span>
<a href="chi-tiet-bai-viet.php?id=<?= (int)$post['id'] ?>&from=co-hoi" style="color:var(--brown-dark);font-weight:600;font-size:11px;">Xem bài →</a>
</div>
</div>
</article>
<?php endforeach; ?>
<?php else: ?>
<div class="box">
<p>Chưa có bài viết nào trong danh mục Cơ hội.</p>
</div>
<?php endif; ?>
</div>
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
<?php
$latest_date=$latest['published_at']??$latest['created_at'];
$fallback='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&auto=format&fit=crop';
?>
<a href="chi-tiet-bai-viet.php?id=<?= (int)$latest['id'] ?>&from=co-hoi" style="display:flex;gap:10px;text-decoration:none;align-items:center;">
<?php if($latest['thumbnail']): ?>
<img src="../<?=htmlspecialchars($latest['thumbnail'])?>" alt="<?=htmlspecialchars($latest['title'])?>" style="width:60px;height:45px;object-fit:cover;border-radius:4px;flex-shrink:0;" onerror="this.src='<?=$fallback?>'">
<?php else: ?>
<img src="<?=$fallback?>" alt="<?=htmlspecialchars($latest['title'])?>" style="width:60px;height:45px;object-fit:cover;border-radius:4px;flex-shrink:0;">
<?php endif; ?>
<div>
<h4 style="font-size:11px;font-weight:700;color:var(--brown-dark);margin:0;line-height:1.3;"><?=htmlspecialchars($latest['title'])?></h4>
<span style="font-size:9px;color:var(--muted);"><?=date('d/m/Y',strtotime($latest_date))?></span>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</main>
<style>
@media(max-width:900px){
main.container>div[style*="display:flex"]{
flex-direction:column!important;
}
main.container>div[style*="display:flex"]>div[style*="width:300px"]{
width:100%!important;
}
}
@media(max-width:600px){
article.box{
flex-direction:column!important;
align-items:stretch!important;
}
article.box>div:first-child{
width:100%!important;
height:180px!important;
}
}
</style>
<?php include '../includes/footer.php'; ?>

