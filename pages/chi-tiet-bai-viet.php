<?php
declare(strict_types=1);
if(session_status()===PHP_SESSION_NONE){session_start();}
require_once '../config/database.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$from=$_GET['from']??'';
$stmt=$pdo->prepare("SELECT p.id,p.title,p.summary,p.content,p.thumbnail,p.created_at,u.full_name AS author,c.name AS category,c.slug AS category_slug FROM posts p JOIN users u ON p.author_id=u.id JOIN categories c ON p.category_id=c.id WHERE p.id=? AND p.status='published'");
$stmt->execute([$id]);
$post=$stmt->fetch();
if(!$post){
echo '<main class="container"><div class="intro small"><h2>Không tìm thấy bài viết</h2><p>Bài viết không tồn tại hoặc đã bị xóa.</p></div></main>';
include '../includes/footer.php';
exit;
}
$user_id=$_SESSION['user_id']??null;
$comment_message='';
if($_SERVER['REQUEST_METHOD']==='POST'){
if(isset($_POST['submit_comment'])){
$name=trim($_POST['name']??'');
$content=trim($_POST['content']??'');
if($name===''){
$comment_message='Vui lòng nhập tên.';
}elseif($content===''){
$comment_message='Vui lòng nhập nội dung bình luận.';
}elseif(mb_strlen($name)>120){
$comment_message='Tên không được vượt quá 120 ký tự.';
}elseif(mb_strlen($content)>1000){
$comment_message='Bình luận không được vượt quá 1000 ký tự.';
}else{
if($user_id){
$stmt=$pdo->prepare("INSERT INTO comments(post_id,user_id,guest_name,content,status) VALUES(?,?,NULL,?,'pending')");
$stmt->execute([$id,$user_id,$content]);
}else{
$stmt=$pdo->prepare("INSERT INTO comments(post_id,user_id,guest_name,content,status) VALUES(?,NULL,?,?,'pending')");
$stmt->execute([$id,$name,$content]);
}
$comment_message='Bình luận đã được gửi và đang chờ duyệt.';
}
}
if(isset($_POST['save_comment'])){
$comment_id=(int)($_POST['comment_id']??0);
if(!$user_id){
$comment_message='Vui lòng đăng nhập để lưu bình luận.';
}elseif($comment_id>0){
$stmt=$pdo->prepare("SELECT id FROM comments WHERE id=? AND post_id=? AND status='approved'");
$stmt->execute([$comment_id,$id]);
$comment=$stmt->fetch();
if($comment){
$stmt=$pdo->prepare("SELECT id FROM impact_box_items WHERE user_id=? AND post_id=? AND note=?");
$stmt->execute([$user_id,$id,'comment_'.$comment_id]);
$saved=$stmt->fetch();
if($saved){
$stmt=$pdo->prepare("DELETE FROM impact_box_items WHERE id=?");
$stmt->execute([$saved['id']]);
}else{
$stmt=$pdo->prepare("INSERT INTO impact_box_items(user_id,post_id,note) VALUES(?,?,?)");
$stmt->execute([$user_id,$id,'comment_'.$comment_id]);
}
}
}
}
}
$stmt=$pdo->prepare("SELECT c.id,c.content,c.guest_name,c.created_at,u.full_name FROM comments c LEFT JOIN users u ON c.user_id=u.id WHERE c.post_id=? AND c.status='approved' ORDER BY c.created_at DESC");
$stmt->execute([$id]);
$comments=$stmt->fetchAll();
$saved_comments=[];
if($user_id&&!empty($comments)){
foreach($comments as $comment){
$stmt=$pdo->prepare("SELECT id FROM impact_box_items WHERE user_id=? AND post_id=? AND note=?");
$stmt->execute([$user_id,$id,'comment_'.$comment['id']]);
if($stmt->fetch()){$saved_comments[$comment['id']]=true;}
}
}
$stmt=$pdo->prepare("SELECT p.id,p.title,p.thumbnail,p.created_at FROM posts p WHERE p.category_id=(SELECT category_id FROM posts WHERE id=?) AND p.id!=? AND p.status='published' ORDER BY p.created_at DESC LIMIT 3");
$stmt->execute([$id,$id]);
$related_posts=$stmt->fetchAll();
$category_pages=[
'tin-khoa'=>'tin-khoa.php',
'hoc-tap'=>'hoc-tap.php',
'co-hoi'=>'co-hoi.php',
'su-kien'=>'su-kien.php'
];
$category_names=[
'tin-khoa'=>'Tin khoa',
'hoc-tap'=>'Học tập',
'co-hoi'=>'Cơ hội',
'su-kien'=>'Sự kiện'
];
if(isset($category_pages[$from])){
$back_page=$category_pages[$from];
$back_name=$category_names[$from];
}else{
$back_page=$category_pages[$post['category_slug']]??'index.php';
$back_name=$category_names[$post['category_slug']]??'Trang chủ';
}
include '../includes/header.php';
?>

<main class="container">
<div class="container">
<div class="features">
<div class="main-content">
<article>
<div style="color:var(--brown);font-size:13px;font-weight:700;text-transform:uppercase;margin-bottom:6px;">
<?=htmlspecialchars($post['category'])?> & Nghiên cứu
</div>
<h1 class="card-title" style="font-size:var(--font-section);margin-bottom:10px;">
<?=htmlspecialchars($post['title'])?>
</h1>
<p style="color:var(--muted);font-size:14px;margin-bottom:20px;">
📅 <?=date('d/m/Y',strtotime($post['created_at']))?> &nbsp; • &nbsp; Tác giả: <?=htmlspecialchars($post['author'])?> &nbsp; • &nbsp; 6 phút đọc
</p>
<?php if(!empty($post['thumbnail'])): ?>
<div style="width:100%;max-height:420px;overflow:hidden;border-radius:8px;margin-bottom:20px;">
<img src="../<?=htmlspecialchars($post['thumbnail'])?>" alt="<?=htmlspecialchars($post['title'])?>" style="width:100%;height:auto;max-height:420px;object-fit:cover;" onerror="this.style.display='none';">
</div>
<?php endif; ?>
<?php if(!empty($post['summary'])): ?>
<p style="font-weight:600;font-size:16px;color:var(--brown-dark);margin-bottom:20px;line-height:1.6;">
<?=htmlspecialchars($post['summary'])?>
</p>
<?php endif; ?>
<div class="article-content">
<?= $post['content'] ?>
</div>
<div style="margin-top:30px;">
<a href="<?=htmlspecialchars($back_page)?>" class="btn-outline-brown">← Quay lại <?=htmlspecialchars($back_name)?></a>
</div>
</article>
</div>
<div class="sidebar-content">
<div class="box">
<h3 style="font-size:18px;margin-bottom:15px;color:var(--brown-dark);">Bình luận (<?=count($comments)?>)</h3>
<?php if($comment_message): ?>
<div style="margin-bottom:15px;padding:10px;background:#FFF8EC;border:1px solid var(--border);border-radius:5px;font-size:13px;">
<?=htmlspecialchars($comment_message)?>
</div>
<?php endif; ?>
<?php if(empty($comments)): ?>
<div style="font-size:13px;color:var(--muted);padding:10px 0;">Chưa có bình luận nào.</div>
<?php else: ?>
<?php foreach($comments as $comment): ?>
<div style="display:flex;gap:12px;margin-bottom:15px;padding-bottom:15px;border-bottom:1px solid var(--border);">
<div style="width:36px;height:36px;border-radius:50%;background:#ccc;overflow:hidden;flex-shrink:0;">
<img src="../assets/images/nguoi-dung-1.png" alt="Avatar" style="width:100%;height:100%;object-fit:cover;">
</div>
<div style="flex:1;">
<div style="font-weight:600;font-size:14px;color:var(--brown-dark);">
<?=htmlspecialchars($comment['full_name']??$comment['guest_name']??'Người dùng')?>
</div>
<div style="font-size:13px;color:var(--text);margin:3px 0;">
<?=nl2br(htmlspecialchars($comment['content']))?>
</div>
<div style="font-size:11px;color:var(--muted);">
<?=date('d/m/Y H:i',strtotime($comment['created_at']))?>
</div>
<?php if($user_id): ?>
<form method="POST" style="margin-top:6px;">
<input type="hidden" name="comment_id" value="<?= (int)$comment['id'] ?>">
<button type="submit" name="save_comment" class="btn-outline-brown" style="font-size:11px;padding:4px 9px;cursor:pointer;">
<?=isset($saved_comments[$comment['id']])?'Đã lưu':'Lưu bình luận'?>
</button>
</form>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="box">
<h3 style="font-size:16px;margin-bottom:12px;color:var(--brown-dark);">Viết bình luận</h3>
<form action="" method="POST">
<div style="margin-bottom:10px;">
<input type="text" name="name" placeholder="Nguyễn Văn A" maxlength="120" required style="width:100%;padding:8px 12px;border:1px solid var(--border);border-radius:4px;font-size:13px;outline:none;background:#fafafa;">
</div>
<div style="margin-bottom:12px;">
<textarea name="content" placeholder="Viết bình luận..." rows="3" maxlength="1000" required style="width:100%;padding:8px 12px;border:1px solid var(--border);border-radius:4px;font-size:13px;outline:none;resize:vertical;background:#fafafa;"></textarea>
</div>
<div style="text-align:right;">
<button type="submit" name="submit_comment" class="btn-primary-brown" style="font-size:13px;padding:6px 16px;">Gửi bình luận</button>
</div>
</form>
</div>
<div class="box">
<h3 style="font-size:16px;margin-bottom:12px;color:var(--brown-dark);">Bài viết liên quan</h3>
<div style="display:flex;flex-direction:column;gap:10px;font-size:13px;">
<?php if(!empty($related_posts)): ?>
<?php foreach($related_posts as $related): ?>
<a href="chi-tiet-bai-viet.php?id=<?= (int)$related['id'] ?>&from=<?=htmlspecialchars($from)?>" style="display:flex;gap:10px;align-items:center;color:var(--text);">
<span style="width:50px;height:40px;background:#ddd;border-radius:4px;flex-shrink:0;overflow:hidden;">
<?php if(!empty($related['thumbnail'])): ?>
<img src="../<?=htmlspecialchars($related['thumbnail'])?>" style="width:100%;height:100%;object-fit:cover;">
<?php endif; ?>
</span>
<span><?=htmlspecialchars($related['title'])?><br><small style="color:var(--muted)"><?=date('d/m/Y',strtotime($related['created_at']))?></small></span>
</a>
<?php endforeach; ?>
<?php else: ?>
<span style="color:var(--muted);">Chưa có bài viết liên quan.</span>
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>
</main>
<?php include '../includes/footer.php'; ?>
<style>
.article-content{
font-size:17px;
line-height:1.9;
color:var(--text);
}
.article-content p{
font-size:17px;
line-height:1.9;
margin:0 0 20px;
}
.article-content h2{
font-size:25px;
line-height:1.4;
color:var(--brown-dark);
margin:32px 0 14px;
}
.article-content h3{
font-size:21px;
line-height:1.5;
color:var(--brown-dark);
margin:26px 0 12px;
}
.article-content ul,.article-content ol{
padding-left:25px;
margin:10px 0 22px;
}
.article-content li{
font-size:17px;
line-height:1.8;
margin-bottom:9px;
}
.article-content blockquote{
margin:25px 0;
padding:16px 20px;
background:#FFF8EC;
border-left:4px solid var(--brown);
color:var(--brown-dark);
font-style:italic;
}
.article-content strong{
color:var(--brown-dark);
}
</style>
