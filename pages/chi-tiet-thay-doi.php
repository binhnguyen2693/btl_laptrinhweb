<?php
require_once '../config/database.php';
include '../includes/header.php';
$sql_related="SELECT p.id,p.title,p.thumbnail,p.created_at,p.published_at FROM posts p JOIN categories c ON p.category_id=c.id WHERE p.status='published' AND c.status='active' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT 3";
$stmt_related=$pdo->query($sql_related);
$related_posts=$stmt_related->fetchAll();
?>
<main class="container">

<div style="display:flex;gap:24px;background:#fff;padding:24px;border-radius:16px;border:1.5px solid var(--border);">
<div style="flex:1;max-width:62%;">
<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#D97706;color:#fff;font-size:10px;font-weight:700;border-radius:12px;margin-bottom:10px;">
⚠️ THÔNG TIN THAY ĐỔI
</span>
<h1 style="font-size:22px;font-weight:800;color:var(--brown-dark);line-height:1.35;margin-bottom:8px;">Lịch hội thảo nghiên cứu khoa học được chuyển sang ngày 25/08/2026</h1>
<div style="font-size:10.5px;color:#8C827A;margin-bottom:18px;">
<span>Cập nhật lần cuối: 16/08/2026</span> &nbsp;•&nbsp; <span>Người đăng: Ban tổ chức</span> &nbsp;•&nbsp; <span>325 lượt xem</span>
</div>
<div style="display:flex;align-items:center;justify-content:space-between;background:#FFFBEB;border:1px dashed #F59E0B;border-radius:10px;padding:12px 16px;margin-bottom:20px;">
<div style="display:flex;align-items:center;gap:12px;">
<div>
<span style="font-size:9px;color:#B45309;text-transform:uppercase;font-weight:700;display:block;">THỜI GIAN CŨ</span>
<span style="font-size:12px;font-weight:700;color:#78350F;text-decoration:line-through;">20/08/2026</span>
</div>
<span style="color:#F59E0B;font-weight:700;">→</span>
<div>
<span style="font-size:9px;color:#B45309;text-transform:uppercase;font-weight:700;display:block;">THỜI GIAN MỚI</span>
<span style="font-size:12px;font-weight:800;color:#D97706;">25/08/2026</span>
</div>
</div>
<div style="border-left:1px solid #FCD34D;padding-left:16px;">
<span style="font-size:9px;color:#B45309;text-transform:uppercase;font-weight:700;display:block;">ĐỐI TƯỢNG ẢNH HƯỞNG</span>
<span style="font-size:11px;font-weight:700;color:#78350F;">Sinh viên đã đăng ký</span>
</div>
</div>
<div style="font-size:11px;line-height:1.6;color:#4A423D;display:flex;flex-direction:column;gap:12px;">
<div>
<strong style="color:var(--brown-dark);text-transform:uppercase;font-size:10.5px;">NỘI DUNG THAY ĐỔI</strong>
<p style="margin-top:2px;">Ban tổ chức thông báo thay đổi lịch tổ chức Hội thảo nghiên cứu khoa học sinh viên năm 2026. Lịch hội thảo sẽ được chuyển từ ngày 20/08/2026 sang ngày 25/08/2026.</p>
</div>
<div>
<strong style="color:var(--brown-dark);text-transform:uppercase;font-size:10.5px;">AI BỊ ẢNH HƯỞNG?</strong>
<p style="margin-top:2px;">Sinh viên đã đăng ký tham dự Hội thảo nghiên cứu khoa học sinh viên năm 2026.</p>
</div>
<div>
<strong style="color:var(--brown-dark);text-transform:uppercase;font-size:10.5px;">CẦN LÀM GÌ?</strong>
<p style="margin-top:2px;">Sinh viên vui lòng kiểm tra lại lịch trình và sắp xếp thời gian để tham dự đúng ngày mới. Nếu có thắc mắc, liên hệ Ban tổ chức để được hỗ trợ.</p>
</div>
</div>
<div style="margin-top:20px;padding-top:12px;border-top:1px dashed #DDD;">
<span style="font-size:10px;font-weight:700;color:var(--brown-dark);text-transform:uppercase;display:block;margin-bottom:6px;">NGUỒN THÔNG TIN</span>
<span style="padding:4px 10px;background:#F5F2EE;border-radius:12px;font-size:10px;color:#6B625D;display:inline-block;">Thông báo của khoa Công nghệ thông tin</span>
</div>
<div style="margin-top:25px;">
<h4 style="font-size:12px;font-weight:800;color:var(--brown-dark);margin-bottom:10px;">BÀI VIẾT LIÊN QUAN</h4>
<?php if($related_posts): ?>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
<?php foreach($related_posts as $related): ?>
<?php
$related_date=$related['published_at']??$related['created_at'];
$fallback='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=100&auto=format&fit=crop';
?>
<a href="chi-tiet-bai-viet.php?id=<?= (int)$related['id'] ?>&from=chi-tiet-thay-doi" style="border:1px solid #DDD;border-radius:8px;padding:6px;text-decoration:none;display:flex;gap:6px;align-items:center;">
<?php if($related['thumbnail']): ?>
<img src="../<?=htmlspecialchars($related['thumbnail'])?>" alt="<?=htmlspecialchars($related['title'])?>" style="width:40px;height:32px;object-fit:cover;border-radius:4px;" onerror="this.src='<?=$fallback?>'">
<?php else: ?>
<img src="<?=$fallback?>" alt="<?=htmlspecialchars($related['title'])?>" style="width:40px;height:32px;object-fit:cover;border-radius:4px;">
<?php endif; ?>
<div>
<h5 style="font-size:9px;font-weight:700;color:var(--brown-dark);margin:0;line-height:1.2;"><?=htmlspecialchars($related['title'])?></h5>
<span style="font-size:8px;color:#8C827A;"><?=date('d/m/Y',strtotime($related_date))?></span>
</div>
</a>
<?php endforeach; ?>
</div>
<?php else: ?>
<p style="font-size:10px;color:var(--muted);">Chưa có bài viết liên quan.</p>
<?php endif; ?>
</div>
</div>
<div style="flex:1;display:flex;flex-direction:column;gap:20px;">
<div style="border:1.5px solid #8B0000;border-radius:12px;padding:16px;background:#FFF;">
<h3 style="font-size:13px;font-weight:800;color:#8B0000;text-transform:uppercase;margin-bottom:12px;letter-spacing:0.5px;">TÓM TẮT THAY ĐỔI</h3>
<table style="width:100%;font-size:10.5px;border-collapse:collapse;">
<tr style="border-bottom:1px dashed #EEE;">
<td style="padding:6px 0;color:#6B625D;width:40%;">Nội dung thay đổi</td>
<td style="padding:6px 0;text-align:right;font-weight:700;color:var(--brown-dark);">Thay đổi ngày tổ chức</td>
</tr>
<tr style="border-bottom:1px dashed #EEE;">
<td style="padding:6px 0;color:#6B625D;">Thời gian áp dụng</td>
<td style="padding:6px 0;text-align:right;font-weight:700;color:var(--brown-dark);">Từ ngày 16/08/2026</td>
</tr>
<tr style="border-bottom:1px dashed #EEE;">
<td style="padding:6px 0;color:#6B625D;">Đối tượng</td>
<td style="padding:6px 0;text-align:right;font-weight:700;color:var(--brown-dark);">Sinh viên đăng ký tham dự hội thảo</td>
</tr>
<tr style="border-bottom:1px dashed #EEE;">
<td style="padding:6px 0;color:#6B625D;">Mức độ ảnh hưởng</td>
<td style="padding:6px 0;text-align:right;">
<span style="padding:2px 8px;border:1px solid #F59E0B;border-radius:10px;color:#D97706;font-size:9.5px;font-weight:700;">Trung bình</span>
</td>
</tr>
<tr>
<td style="padding:6px 0;color:#6B625D;">Cần làm gì?</td>
<td style="padding:6px 0;text-align:right;font-weight:700;color:var(--brown-dark);">Kiểm tra lịch và có mặt đúng thời gian mới</td>
</tr>
</table>
</div>
<div>
<h3 style="font-size:13px;font-weight:800;color:var(--brown-dark);margin-bottom:12px;">Bình luận (2)</h3>
<div style="display:flex;flex-direction:column;gap:10px;">
<div style="display:flex;gap:10px;border-bottom:1px solid #EEE;padding-bottom:8px;">
<div style="width:30px;height:30px;border-radius:50%;background:#DDD;overflow:hidden;flex-shrink:0;">
<img src="../assets/images/user-1.png" alt="Nguyễn Minh Anh" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop'">
</div>
<div>
<h4 style="font-size:10.5px;font-weight:700;color:var(--brown-dark);margin:0;">Nguyễn Minh Anh</h4>
<p style="font-size:10px;color:#5E5752;margin:2px 0;">Cảm ơn khoa đã thông báo sớm để sinh viên sắp xếp thời gian ạ.</p>
<span style="font-size:8.5px;color:#8C827A;">14/08/2026</span>
</div>
</div>
<div style="display:flex;gap:10px;">
<div style="width:30px;height:30px;border-radius:50%;background:#DDD;overflow:hidden;flex-shrink:0;">
<img src="../assets/images/user-2.png" alt="Trần Hoàng Nam" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop'">
</div>
<div>
<h4 style="font-size:10.5px;font-weight:700;color:var(--brown-dark);margin:0;">Trần Hoàng Nam</h4>
<p style="font-size:10px;color:#5E5752;margin:2px 0;">Mình đã cập nhật lại lịch, cảm ơn vì đã thông báo.</p>
<span style="font-size:8.5px;color:#8C827A;">14/08/2026</span>
</div>
</div>
</div>
</div>
<div style="border:1.5px solid var(--brown);border-radius:12px;padding:12px;background:#FAF8F5;">
<span style="font-size:9.5px;font-weight:800;color:var(--brown-dark);text-transform:uppercase;display:block;margin-bottom:6px;">VIẾT BÌNH LUẬN</span>
<div style="display:flex;flex-direction:column;gap:6px;">
<input type="text" placeholder="Nguyễn Văn A" style="padding:5px 8px;border:1px solid #DDD;border-radius:6px;font-size:10.5px;background:#fff;outline:none;">
<textarea placeholder="Viết bình luận..." rows="2" style="padding:5px 8px;border:1px solid #DDD;border-radius:6px;font-size:10.5px;background:#fff;outline:none;resize:none;"></textarea>
<div style="text-align:right;">
<button type="button" onclick="alert('Chức năng gửi bình luận sẽ được kết nối khi trang thông tin thay đổi có mã bài viết riêng.')" style="padding:4px 12px;background:var(--brown);color:#fff;border:none;border-radius:6px;font-size:9.5px;font-weight:700;cursor:pointer;">Gửi bình luận</button>
</div>
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
main.container>div[style*="display:flex"]>div{
max-width:100%!important;
width:100%;
}
}
@media(max-width:600px){
main.container>div[style*="display:flex"]{
padding:15px!important;
}
main.container h1{
font-size:19px!important;
}
main.container table{
font-size:9.5px!important;
}
}
</style>
<?php include '../includes/footer.php'; ?>

