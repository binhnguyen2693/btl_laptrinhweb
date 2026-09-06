<?php
require_once '../config/database.php';
include '../includes/header.php';
$q=trim($_GET['q']??'');
$per_page=6;
$page=isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$total_posts=0;
$posts=[];
if($q!==''){
$keyword='%'.$q.'%';
$count_sql="SELECT COUNT(*) FROM posts p JOIN categories c ON p.category_id=c.id JOIN users u ON p.author_id=u.id WHERE p.status='published' AND c.status='active' AND (p.title LIKE ? OR p.summary LIKE ? OR p.content LIKE ? OR c.name LIKE ? OR u.full_name LIKE ?)";
$count_stmt=$pdo->prepare($count_sql);
$count_stmt->execute([$keyword,$keyword,$keyword,$keyword,$keyword]);
$total_posts=(int)$count_stmt->fetchColumn();
$total_pages=max(1,(int)ceil($total_posts/$per_page));
if($page>$total_pages){
$page=$total_pages;
}
$offset=($page-1)*$per_page;
$sql="SELECT p.id,p.title,p.summary,p.thumbnail,p.created_at,p.published_at,c.name AS category_name,c.slug AS category_slug,u.full_name AS author FROM posts p JOIN categories c ON p.category_id=c.id JOIN users u ON p.author_id=u.id WHERE p.status='published' AND c.status='active' AND (p.title LIKE ? OR p.summary LIKE ? OR p.content LIKE ? OR c.name LIKE ? OR u.full_name LIKE ?) ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT ? OFFSET ?";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(1,$keyword,PDO::PARAM_STR);
$stmt->bindValue(2,$keyword,PDO::PARAM_STR);
$stmt->bindValue(3,$keyword,PDO::PARAM_STR);
$stmt->bindValue(4,$keyword,PDO::PARAM_STR);
$stmt->bindValue(5,$keyword,PDO::PARAM_STR);
$stmt->bindValue(6,$per_page,PDO::PARAM_INT);
$stmt->bindValue(7,$offset,PDO::PARAM_INT);
$stmt->execute();
$posts=$stmt->fetchAll();
}else{
$total_pages=1;
}
?>
<main class="container">
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:25px;gap:20px;flex-wrap:wrap;">
<div>
<h1 style="font-size:28px;font-weight:800;color:var(--brown-dark);letter-spacing:-0.5px;margin-bottom:4px;text-transform:uppercase;">KẾT QUẢ TÌM KIẾM</h1>
<p style="font-size:12px;color:#6B625D;">Các bài viết phù hợp với từ khóa bạn đang tìm kiếm.</p>
</div>
<div style="width:100%;max-width:360px;">
<form action="tim-kiem.php" method="GET" style="position:relative;display:flex;align-items:center;">
<input type="text" name="q" value="<?=htmlspecialchars($q)?>" placeholder="Nhập từ khóa..." style="width:100%;padding:8px 36px 8px 14px;border:1.5px solid var(--brown);border-radius:8px;font-size:13px;outline:none;background:#fff;">
<button type="submit" style="position:absolute;right:10px;background:none;border:none;cursor:pointer;color:var(--brown);font-size:14px;">🔍</button>
</form>
<?php if($q!==''): ?>
<span style="font-size:10px;color:#8C827A;display:block;margin-top:4px;text-align:right;">
<?=$total_posts?> kết quả tìm thấy với từ khóa "<?=htmlspecialchars($q)?>"
</span>
<?php endif; ?>
</div>
</div>
<?php if($q===''): ?>
<div class="box" style="padding:35px 20px;text-align:center;">
<h2 style="font-size:18px;color:var(--brown-dark);margin-bottom:8px;">Nhập từ khóa để tìm kiếm</h2>
<p style="font-size:12px;color:var(--muted);">Bạn có thể tìm kiếm theo tiêu đề, nội dung, danh mục hoặc tác giả.</p>
</div>
<?php elseif($posts): ?>
<div style="display:flex;flex-direction:column;gap:18px;">
<?php foreach($posts as $post): ?>
<?php
$date=$post['published_at']??$post['created_at'];
$fallback='https://images.unsplash.com/photo-1531482615713-2afd69097998?w=500&auto=format&fit=crop';
?>
<article class="box" style="display:flex;gap:20px;align-items:center;padding:18px;border-radius:14px;border:1.5px solid var(--border);box-shadow:none;background:#fff;">
<div style="width:220px;height:120px;flex-shrink:0;overflow:hidden;border-radius:10px;background:#eee;">
<?php if($post['thumbnail']): ?>
<img src="../<?=htmlspecialchars($post['thumbnail'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='<?=$fallback?>'">
<?php else: ?>
<img src="<?=$fallback?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:100%;object-fit:cover;">
<?php endif; ?>
</div>
<div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;min-height:120px;">
<div>
<span style="font-size:10px;font-weight:800;color:#6C8065;letter-spacing:0.5px;text-transform:uppercase;display:block;margin-bottom:4px;"><?=htmlspecialchars($post['category_name'])?></span>
<h2 class="card-title" style="font-size:16px;font-weight:700;color:var(--brown-dark);margin-bottom:6px;line-height:1.35;"><?=htmlspecialchars($post['title'])?></h2>
<p class="card-desc" style="font-size:11px;line-height:1.5;color:#5E5752;"><?=htmlspecialchars($post['summary'])?></p>
</div>
<div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;font-size:10px;color:#8C827A;">
<span><?=date('d/m/Y',strtotime($date))?> &nbsp;•&nbsp; <?=htmlspecialchars($post['author'])?></span>
<a href="chi-tiet-bai-viet.php?id=<?= (int)$post['id'] ?>&from=tim-kiem" style="color:var(--brown-dark);font-weight:600;font-size:11px;">Xem bài →</a>
</div>
</div>
</article>
<?php endforeach; ?>
</div>
<?php if($total_pages>1): ?>
<div style="display:flex;justify-content:center;align-items:center;gap:6px;margin:30px 0 10px 0;">
<?php if($page>1): ?>
<a href="?q=<?=urlencode($q)?>&page=<?=$page-1?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&lt;</a>
<?php endif; ?>
<?php for($i=1;$i<=$total_pages;$i++): ?>
<a href="?q=<?=urlencode($q)?>&page=<?=$i?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;background:<?=$i===$page?'var(--brown)':'transparent'?>;color:<?=$i===$page?'#fff':'var(--brown-dark)'?>;font-size:11px;font-weight:<?=$i===$page?'700':'400'?>;"><?=$i?></a>
<?php endfor; ?>
<?php if($page<$total_pages): ?>
<a href="?q=<?=urlencode($q)?>&page=<?=$page+1?>" style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--brown);border-radius:6px;color:var(--brown);font-size:11px;">&gt;</a>
<?php endif; ?>
</div>
<?php endif; ?>
<?php elseif($q!==''): ?>
<div class="box" style="padding:35px 20px;text-align:center;">
<h2 style="font-size:18px;color:var(--brown-dark);margin-bottom:8px;">Không tìm thấy bài viết</h2>
<p style="font-size:12px;color:var(--muted);">Không có bài viết nào phù hợp với từ khóa "<?=htmlspecialchars($q)?>".</p>
</div>
<?php endif; ?>
</main>
<style>
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

