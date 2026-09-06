</main>

<footer style="background-color: #43211B; color: #ffffff; padding: 40px 0 20px; font-size: 14px; line-height: 1.6; margin-top: 50px;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: 2.2fr 1fr 1.2fr 2fr; gap: 30px;">
        
        <!-- Cột 1: Logo & Slogan -->
        <div>
            <?php $logo_f = file_exists('../assets/images/logo.png') ? '../assets/images/logo.png' : 'assets/images/logo.png'; ?>
            <img src="<?php echo $logo_f; ?>?v=<?php echo time(); ?>" alt="Nhịp Khoa Logo" style="height: 40px; width: auto; display: block; margin-bottom: 16px;">
            <p style="margin: 0 0 6px 0; color: #e0e0e0;">Cổng thông tin chính thức của khoa CNTT.</p>
            <p style="margin: 0; color: #e0e0e0;">Cập nhật - Kết nối - Tạo tác động.</p>
        </div>

        <!-- Cột 2: Khám phá -->
        <div>
            <h4 style="font-size: 15px; font-weight: bold; margin: 0 0 12px 0; color: #ffffff;">Khám phá</h4>
            <?php $p_f = file_exists('../assets/css/style.css') ? '' : 'pages/'; ?>
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <a href="<?php echo $p_f; ?>tin-khoa.php" style="color: #d0d0d0; text-decoration: none;">Tin khoa</a>
                <a href="<?php echo $p_f; ?>hoc-tap.php" style="color: #d0d0d0; text-decoration: none;">Học tập</a>
                <a href="<?php echo $p_f; ?>co-hoi.php" style="color: #d0d0d0; text-decoration: none;">Cơ hội</a>
                <a href="<?php echo $p_f; ?>su-kien.php" style="color: #d0d0d0; text-decoration: none;">Sự kiện</a>
                <a href="<?php echo $p_f; ?>hop-tac-dong.php" style="color: #d0d0d0; text-decoration: none;">Hộp tác động</a>
            </div>
        </div>

        <!-- Cột 3: Hỗ trợ -->
        <div>
            <h4 style="font-size: 15px; font-weight: bold; margin: 0 0 12px 0; color: #ffffff;">Hỗ trợ</h4>
            <div style="display: flex; flex-direction: column; gap: 6px; color: #d0d0d0;">
                <span style="cursor: pointer;">Hướng dẫn sử dụng</span>
                <span style="cursor: pointer;">Câu hỏi thường gặp</span>
                <span style="cursor: pointer;">Liên hệ</span>
                <span style="cursor: pointer;">Góp ý</span>
            </div>
        </div>

        <!-- Cột 4: Liên hệ -->
        <div>
            <h4 style="font-size: 15px; font-weight: bold; margin: 0 0 12px 0; color: #ffffff;">Liên hệ</h4>
            <div style="display: flex; flex-direction: column; gap: 8px; color: #d0d0d0;">
                <div style="display: flex; gap: 8px; align-items: flex-start;">
                    <i class="fa-solid fa-location-dot" style="margin-top: 4px;"></i>
                    <span>Số 98 phố Dương Quảng Hàm, phường Nghĩa Đô, Hà Nội.</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <i class="fa-regular fa-envelope"></i>
                    <span>support@nhipkhoa.edu.com</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <i class="fa-solid fa-phone"></i>
                    <span>(012) 3456 7899</span>
                </div>
                <div style="margin-top: 4px; color: #b0b0b0;">Thứ 2 - Thứ 6: 8:00 - 17:00</div>
            </div>
        </div>
    </div>

    <!-- Dòng bản quyền chân trang -->
    <div style="max-width: 1280px; margin: 30px auto 0; padding: 15px 20px 0; border-top: 1px solid rgba(255, 255, 255, 0.15); display: flex; justify-content: space-between; font-size: 13px; color: #b0b0b0;">
        <span>© 2026 NHIPKHOA Faculty. All rights reserved.</span>
        <div style="display: flex; gap: 15px;">
            <span style="cursor: pointer;">Chính sách bảo mật</span>
            <span>|</span>
            <span style="cursor: pointer;">Điều khoản sử dụng</span>
        </div>
    </div>
</footer>
</body>
</html>