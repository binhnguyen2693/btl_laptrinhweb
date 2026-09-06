<?php include '../includes/header.php'; ?>
<main class="container">
  <div style="font-size:12px; color:var(--muted); margin-bottom:12px;">
    <a href="../index.php">Trang chủ</a> / <span style="color:var(--brown); font-weight:600;">Tìm kiếm</span>
  </div>
  <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:25px; gap:20px; flex-wrap:wrap;">
    <div>
      <h1 style="font-size:28px; font-weight:800; color:var(--brown-dark); letter-spacing:-0.5px; margin-bottom:4px; text-transform:uppercase;">KẾT QUẢ TÌM KIẾM</h1>
      <p style="font-size:12px; color:#6B625D;">Các bài viết phù hợp với từ khóa bạn đang tìm kiếm.</p>
    </div>
    <div style="width:100%; max-width:360px;">
      <form action="tim-kiem.php" method="GET" style="position:relative; display:flex; align-items:center;">
        <input type="text" name="q" value="học tập" placeholder="Nhập từ khóa..." style="width:100%; padding:8px 36px 8px 14px; border:1.5px solid var(--brown); border-radius:8px; font-size:13px; outline:none; background:#fff;">
        <button type="submit" style="position:absolute; right:10px; background:none; border:none; cursor:pointer; color:var(--brown); font-size:14px;">🔍</button>
      </form>
      <span style="font-size:10px; color:#8C827A; display:block; margin-top:4px; text-align:right;">3 kết quả tìm thấy với từ khóa "học tập"</span>
    </div>
  </div>
  <div style="display:flex; flex-direction:column; gap:18px;">
    <article class="box" style="display:flex; gap:20px; align-items:center; padding:18px; border-radius:14px; border:1.5px solid var(--border); box-shadow:none; background:#fff;">
      <div style="width:220px; height:120px; flex-shrink:0; overflow:hidden; border-radius:10px; background:#eee;">
        <img src="../assets/images/tin-khoa-1.png" alt="Nghiên cứu khoa học" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1531482615713-2afd69097998?w=500&auto=format&fit=crop'">
      </div>
      <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; min-height:120px;">
        <div>
          <span style="font-size:10px; font-weight:800; color:#6C8065; letter-spacing:0.5px; text-transform:uppercase; display:block; margin-bottom:4px;">NGHIÊN CỨU KHOA HỌC</span>
          <h2 class="card-title" style="font-size:16px; font-weight:700; color:var(--brown-dark); margin-bottom:6px;">Sinh viên và những cơ hội tham gia nghiên cứu khoa học tại khoa</h2>
          <p class="card-desc" style="font-size:11px; line-height:1.5; color:#5E5752;">Khám phá các đề tài nghiên cứu và cơ hội đồng hành cùng giảng viên, giúp sinh viên nâng cao kiến thức và tích lũy kinh nghiệm chuyên môn.</p>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:10px; color:#8C827A;">
          <span>13/08/2026</span>
          <a href="chi-tiet-thay-doi.php" style="color:var(--brown-dark); font-weight:600; font-size:11px;">Xem bài →</a>
        </div>
      </div>
    </article>
    <article class="box" style="display:flex; gap:20px; align-items:center; padding:18px; border-radius:14px; border:1.5px solid var(--border); box-shadow:none; background:#fff;">
      <div style="width:220px; height:120px; flex-shrink:0; overflow:hidden; border-radius:10px; background:#eee;">
        <img src="../assets/images/tin-khoa-2.png" alt="Sự kiện" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&auto=format&fit=crop'">
      </div>
      <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; min-height:120px;">
        <div>
          <span style="font-size:10px; font-weight:800; color:#6C8065; letter-spacing:0.5px; text-transform:uppercase; display:block; margin-bottom:4px;">SỰ KIỆN</span>
          <h2 class="card-title" style="font-size:16px; font-weight:700; color:var(--brown-dark); margin-bottom:6px;">Hội thảo nghiên cứu khoa học dành cho sinh viên trong khoa</h2>
          <p class="card-desc" style="font-size:11px; line-height:1.5; color:#5E5752;">Cơ hội để sinh viên tìm hiểu về hoạt động nghiên cứu khoa học, gặp gỡ giảng viên và khám phá những hướng nghiên cứu phù hợp với chuyên ngành.</p>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:10px; color:#8C827A;">
          <span>13/08/2026</span>
          <a href="chi-tiet-thay-doi.php" style="color:var(--brown-dark); font-weight:600; font-size:11px;">Xem bài →</a>
        </div>
      </div>
    </article>
    <article class="box" style="display:flex; gap:20px; align-items:center; padding:18px; border-radius:14px; border:1.5px solid var(--border); box-shadow:none; background:#fff;">
      <div style="width:220px; height:120px; flex-shrink:0; overflow:hidden; border-radius:10px; background:#eee;">
        <img src="../assets/images/tin-khoa-3.png" alt="Học tập" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=500&auto=format&fit=crop'">
      </div>
      <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; min-height:120px;">
        <div>
          <span style="font-size:10px; font-weight:800; color:#6C8065; letter-spacing:0.5px; text-transform:uppercase; display:block; margin-bottom:4px;">HỌC TẬP</span>
          <h2 class="card-title" style="font-size:16px; font-weight:700; color:var(--brown-dark); margin-bottom:6px;">Những điều sinh viên cần biết khi bắt đầu một đề tài nghiên cứu</h2>
          <p class="card-desc" style="font-size:11px; line-height:1.5; color:#5E5752;">Từ cách lựa chọn chủ đề, tìm kiếm tài liệu đến xây dựng kế hoạch thực hiện, những gợi ý cơ bản giúp sinh viên tự tin hơn khi bắt đầu một đề tài nghiên cứu.</p>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:10px; color:#8C827A;">
          <span>13/08/2026</span>
          <a href="chi-tiet-thay-doi.php" style="color:var(--brown-dark); font-weight:600; font-size:11px;">Xem bài →</a>
        </div>
      </div>
    </article>
  </div>
  <div style="display:flex; justify-content:center; align-items:center; gap:6px; margin:30px 0 10px 0;">
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--brown); border-radius:6px; color:var(--brown); font-size:11px;">&lt;</a>
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; background:var(--brown); color:#fff; font-size:11px; font-weight:700;">1</a>
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--brown); border-radius:6px; color:var(--brown-dark); font-size:11px;">2</a>
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--brown); border-radius:6px; color:var(--brown-dark); font-size:11px;">3</a>
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--brown); border-radius:6px; color:var(--brown-dark); font-size:11px;">4</a>
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--brown); border-radius:6px; color:var(--brown-dark); font-size:11px;">5</a>
    <a href="#" style="width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--brown); border-radius:6px; color:var(--brown); font-size:11px;">&gt;</a>
  </div>
</main>
<?php include '../includes/footer.php'; ?>