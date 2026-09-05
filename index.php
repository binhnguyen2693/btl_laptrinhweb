<?php include 'includes/header.php'; ?>

<!-- KHỐI 1: HERO BANNER -->
<section class="hero-section">
    <div class="container">
        <div class="hero-wrapper">
            <div class="hero-content">
                <span class="sub-title-red">CẬP NHẬT • ĐỔI MỚI • TÁC ĐỘNG</span>
                <h1 class="hero-heading">ĐIỀU GÌ<br>ĐANG THAY ĐỔI?</h1>
                <p class="hero-desc">
                    Nơi cập nhật những thông tin quan trọng, cơ hội và hướng dẫn mới nhất dành riêng cho sinh viên Khoa CNTT.<br>
                    Hiểu đúng - Hành động kịp thời - Tạo ra tác động.
                </p>
                <div class="hero-buttons">
                    <a href="thong-tin-thay-doi.php" class="btn-primary-brown">Tìm thông tin &rarr;</a>
                    <a href="hoc-tap.php" class="btn-outline-brown">Xem bài viết</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="assets/images/hero-students.jpg" alt="Sinh viên Khoa CNTT">
            </div>
        </div>
    </div>
</section>

<!-- KHỐI 2: THAY ĐỔI ĐÁNG CHÚ Ý -->
<section class="changes-section">
    <div class="container">
        <div class="section-header-flex">
            <h2 class="section-heading-bold">Thay đổi đáng chú ý</h2>
            <a href="thong-tin-thay-doi.php" class="view-all-link">Xem tất cả &rarr;</a>
        </div>

        <div class="changes-grid-3col">
            
            <!-- Thẻ 1: CẦN THỰC HIỆN (Có Impact Summary) -->
            <div class="change-card bg-light-red">
                <span class="badge-tag tag-red">CẦN THỰC HIỆN</span>
                <h3 class="card-title">Đăng ký học phần HK2/2024–2025</h3>
                <p class="card-desc">Sinh viên thực hiện đăng ký học phần trực tuyến trên hệ thống từ ngày 20/05 đến 27/05.</p>
                
                <div class="card-info-list">
                    <div class="info-item">👤 <b>Đối tượng:</b> Tất cả sinh viên</div>
                    <div class="info-item">⏰ <b>Hạn chót:</b> 27/05/2025</div>
                </div>

                <!-- Impact Summary -->
                <div class="impact-summary-box">
                    <div class="summary-header">Impact Summary</div>
                    <div class="summary-item">👤 <span><b>Ảnh hưởng đến ai:</b> Tất cả sinh viên Khoa CNTT</span></div>
                    <div class="summary-item">📋 <span><b>Cần làm gì:</b> Đăng ký học phần đúng hạn để việc học không gián đoạn.</span></div>
                    <div class="summary-item red-text">📅 <span><b>Hạn chót:</b> 27/05/2025</span></div>
                </div>

                <a href="chi-tiet-thay-doi.php?id=1" class="card-link">Xem chi tiết &rarr;</a>
            </div>

            <!-- Thẻ 2: CẦN CHÚ Ý -->
            <div class="change-card bg-light-yellow">
                <span class="badge-tag tag-yellow">CẦN CHÚ Ý</span>
                <h3 class="card-title">Điều chỉnh lịch thi giữa kỳ một số học phần</h3>
                <p class="card-desc">Lịch thi giữa kỳ của một số học phần sẽ được điều chỉnh từ tuần 8 sang tuần 10.</p>
                
                <div class="card-info-list">
                    <div class="info-item">👤 <b>Đối tượng:</b> Sinh viên học HP: DKT1101, DKT2102, DKT3201</div>
                    <div class="info-item">⏰ <b>Hạn chót:</b> Theo lịch mới</div>
                </div>

                <a href="chi-tiet-thay-doi.php?id=2" class="card-link">Xem chi tiết &rarr;</a>
            </div>

            <!-- Thẻ 3: THÔNG TIN -->
            <div class="change-card bg-light-green">
                <span class="badge-tag tag-green">THÔNG TIN</span>
                <h3 class="card-title">Hướng dẫn sử dụng cổng hỗ trợ sinh viên</h3>
                <p class="card-desc">Cổng hỗ trợ sinh viên mới chính thức đi vào hoạt động từ ngày 15/05/2025.</p>
                
                <div class="card-info-list">
                    <div class="info-item">👤 <b>Đối tượng:</b> Toàn thể sinh viên</div>
                    <div class="info-item">⏰ <b>Hạn chót:</b> 15/05/2025</div>
                </div>

                <a href="chi-tiet-thay-doi.php?id=3" class="card-link">Xem chi tiết &rarr;</a>
            </div>

        </div>
    </div>
</section>

<!-- KHỐI 3: BÀI VIẾT VÀ HƯỚNG DẪN (4 CỘT) -->
<section class="posts-section">
    <div class="container">
        <div class="section-header-flex">
            <h2 class="section-heading-bold">Bài viết và hướng dẫn</h2>
            <a href="hoc-tap.php" class="view-all-link">Xem tất cả &rarr;</a>
        </div>

        <div class="posts-grid-4col">
            
            <!-- Card 1 -->
            <div class="post-card-item">
                <div class="thumb"><img src="assets/images/post1.jpg" alt="Bài viết"></div>
                <div class="body">
                    <div class="cat">HỌC TẬP</div>
                    <h4 class="title"><a href="chi-tiet-bai-viet.php?id=1">Bí quyết học hiệu quả trong giai đoạn nước rút cuối kỳ</a></h4>
                    <p class="desc">Những phương pháp ôn tập khoa học giúp bạn tối ưu hóa thời gian và đạt kết quả tốt nhất.</p>
                    <div class="footer"><span>5 phút đọc</span> <span class="bookmark">🔖</span></div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="post-card-item">
                <div class="thumb"><img src="assets/images/post2.jpg" alt="Bài viết"></div>
                <div class="body">
                    <div class="cat">CƠ HỘI</div>
                    <h4 class="title"><a href="chi-tiet-bai-viet.php?id=2">Học bổng khuyến khích học tập HK2/2024–2025</a></h4>
                    <p class="desc">Thông tin chi tiết về điều kiện và xét nhận học bổng cho sinh viên có thành tích học tập tốt.</p>
                    <div class="footer"><span>3 phút đọc</span> <span class="bookmark">🔖</span></div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="post-card-item">
                <div class="thumb"><img src="assets/images/post3.jpg" alt="Bài viết"></div>
                <div class="body">
                    <div class="cat">HƯỚNG DẪN</div>
                    <h4 class="title"><a href="chi-tiet-bai-viet.php?id=3">Hướng dẫn tra cứu lịch học và phòng học</a></h4>
                    <p class="desc">Các bước tra cứu nhanh trên cổng thông tin sinh viên.</p>
                    <div class="footer"><span>4 phút đọc</span> <span class="bookmark">🔖</span></div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="post-card-item">
                <div class="thumb"><img src="assets/images/post4.jpg" alt="Bài viết"></div>
                <div class="body">
                    <div class="cat">SỰ KIỆN</div>
                    <h4 class="title"><a href="chi-tiet-bai-viet.php?id=4">Talkshow: Kỹ năng thuyết trình ấn tượng</a></h4>
                    <p class="desc">Đăng ký tham gia talkshow cùng diễn giả nổi tiếng 24/05/2025.</p>
                    <div class="footer"><span>2 phút đọc</span> <span class="bookmark">🔖</span></div>
                </div>
            </div>

        </div>

        <!-- KHỐI 4: 4 Ô DANH MỤC KHÁM PHÁ Ở ĐÁY -->
        <div class="category-cards-4col">
            <div class="cat-box">
                <div class="icon">🎓</div>
                <div class="info">
                    <h4>Học tập</h4>
                    <p>Lịch học, học phần, hướng dẫn học tập và tài liệu.</p>
                    <a href="hoc-tap.php" class="link">Khám phá &rarr;</a>
                </div>
            </div>

            <div class="cat-box">
                <div class="icon">💼</div>
                <div class="info">
                    <h4>Cơ hội</h4>
                    <p>Học bổng, tuyển dụng, thực tập và trao đổi.</p>
                    <a href="co-hoi.php" class="link">Khám phá &rarr;</a>
                </div>
            </div>

            <div class="cat-box">
                <div class="icon">📅</div>
                <div class="info">
                    <h4>Sự kiện</h4>
                    <p>Hội thảo, workshop và hoạt động nổi bật.</p>
                    <a href="su-kien.php" class="link">Khám phá &rarr;</a>
                </div>
            </div>

            <div class="cat-box">
                <div class="icon">⚡</div>
                <div class="info">
                    <h4>Impact Box</h4>
                    <p>Dự án, đóng góp và câu chuyện tác động.</p>
                    <a href="thong-tin-thay-doi.php" class="link">Khám phá &rarr;</a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>