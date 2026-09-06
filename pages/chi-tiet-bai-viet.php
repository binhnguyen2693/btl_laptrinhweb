<?php
require_once '../config/database.php';
include '../includes/header.php';

$id=isset($_GET['id'])?(int)$_GET['id']:0;

$stmt=$pdo->prepare("SELECT p.id,p.title,p.summary,p.content,p.image,p.created_at,u.name AS author,c.name AS category FROM posts p JOIN users u ON p.author_id=u.id JOIN categories c ON p.category_id=c.id WHERE p.id=?");
$stmt->execute([$id]);
$post=$stmt->fetch();

if(!$post){
echo '<div class="box"><h2>Không tìm thấy bài viết</h2><p>Bài viết không tồn tại hoặc đã bị xóa.</p></div>';
include '../includes/footer.php';
exit;
}
?>

<div class="intro small">
<h1><?=htmlspecialchars($post['title'])?></h1>
<p>📅 <?=date('d/m/Y',strtotime($post['created_at']))?> &nbsp; • &nbsp; ✍️ <?=htmlspecialchars($post['author'])?> &nbsp; • &nbsp; 📂 <?=htmlspecialchars($post['category'])?></p>
</div>

<div class="box">
<?php if(!empty($post['image'])): ?>
<div style="width:100%;max-height:400px;overflow:hidden;border-radius:8px;margin-bottom:20px;">
<img src="../<?=htmlspecialchars($post['image'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;max-height:400px;object-fit:cover;">
</div>
<?php endif; ?>

<h2 class="card-title"><?=htmlspecialchars($post['title'])?></h2>

<p class="card-desc" style="font-weight:600;margin:15px 0;">
<?=htmlspecialchars($post['summary'])?>
</p>

<div style="font-size:15px;line-height:1.8;">
<?=nl2br(htmlspecialchars($post['content']))?>
</div>

<div style="margin-top:25px;">
<a href="tin-khoa.php" class="btn-outline-brown">← Quay lại Tin Khoa</a>
</div>
</div>

<?php include '../includes/footer.php'; ?>