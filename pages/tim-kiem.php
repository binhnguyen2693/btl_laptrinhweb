<?php include '../includes/header.php'; ?>

<section class="search-card">
    <div class="search-heading">
        <h1>KẾT QUẢ TÌM KIẾM</h1>
        <p>Các bài viết phù hợp với từ khóa bạn đang tìm kiếm.</p>
    </div>
    <form class="search-form" action="tim-kiem.php" method="GET">
        <div class="form-field">
            <input type="text" name="q" value="học tập" placeholder="Nhập từ khóa tìm kiếm...">
        </div>
        <button type="submit" class="search-button">Tìm kiếm lại</button>
    </form>
</section>

<section class="search-result">
    <div class="result-heading">
        <h2>Tìm thấy 3 kết quả cho từ khóa "học tập"</h2>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Danh mục</th>
                    <th>Tiêu đề bài viết</th>
                    <th>Ngày đăng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NGHIÊN CỨU KHOA HỌC</td>
                    <td>Sinh viên và những cơ hội tham gia nghiên cứu khoa học tại khoa</td>
                    <td>13/08/2026</td>
                    <td><a href="chi-tiet-bai-viet.php" class="button">Xem bài</a></td>
                </tr>
                <tr>
                    <td>SỰ KIỆN</td>
                    <td>Hội thảo nghiên cứu khoa học dành cho sinh viên trong khoa</td>
                    <td>13/08/2026</td>
                    <td><a href="chi-tiet-thay-doi.php" class="button">Xem bài</a></td>
                </tr>
                <tr>
                    <td>HỌC TẬP</td>
                    <td>Những điều sinh viên cần biết khi bắt đầu một đề tài nghiên cứu</td>
                    <td>13/08/2026</td>
                    <td><a href="chi-tiet-bai-viet.php" class="button">Xem bài</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php include '../includes/footer.php'; ?>