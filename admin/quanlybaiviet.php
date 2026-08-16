<?php

session_start();

// Nếu chưa có danh sách bài viết thì tạo mảng rỗng
if (!isset($_SESSION["baiViets"])) {
    $_SESSION["baiViets"] = [];
}

// Lấy danh sách bài viết từ session
$baiViets = $_SESSION["baiViets"];

// Hàm tạo mã bài viết
function taoMaBaiViet($soThuTu)
{
    return "BV" . str_pad($soThuTu, 3, "0", STR_PAD_LEFT);
}

// Xử lý khi gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tieuDe = trim($_POST["tieu_de"] ?? "");
    $tacGia = trim($_POST["tac_gia"] ?? "");
    $chuyenMuc = $_POST["chuyen_muc"] ?? "";
    $noiDung = trim($_POST["noi_dung"] ?? "");

    // Kiểm tra dữ liệu
    if ($tieuDe == "" || $tacGia == "" || $chuyenMuc == "" || $noiDung == "") {

        $thongBao = "Vui lòng nhập đầy đủ thông tin!";

    } else {

        // Tạo mã bài viết tiếp theo
        $soThuTu = count($baiViets) + 1;

        $maBai = taoMaBaiViet($soThuTu);

        // Tạo bài viết mới
        $baiVietMoi = [
            "ma_bai" => $maBai,
            "tieu_de" => $tieuDe,
            "tac_gia" => $tacGia,
            "chuyen_muc" => $chuyenMuc,
            "noi_dung" => $noiDung,
            "trang_thai" => "Chờ duyệt"
        ];

        // Thêm bài viết vào mảng
        $baiViets[] = $baiVietMoi;

        // Lưu lại mảng vào session
        $_SESSION["baiViets"] = $baiViets;

        $thongBao = "Gửi bài thành công!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Blog khoa</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 30px;
        }

        .container {
            width: 900px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        textarea {
            height: 150px;
        }

        button {
            padding: 10px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .thong-bao {
            margin: 20px 0;
            padding: 10px;
            background-color: #e7f3ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #eee;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>QUẢN LÝ BÀI VIẾT BLOG KHOA</h1>


    <?php if (isset($thongBao)): ?>

        <div class="thong-bao">
            <?php echo htmlspecialchars($thongBao); ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <div class="form-group">

            <label>Tiêu đề:</label>

            <input
                type="text"
                name="tieu_de"
            >

        </div>


        <div class="form-group">

            <label>Tác giả:</label>

            <input
                type="text"
                name="tac_gia"
            >

        </div>


        <div class="form-group">

            <label>Chuyên mục:</label>

            <select name="chuyen_muc">

                <option value="">
                    -- Chọn chuyên mục --
                </option>

                <option value="Tin tức khoa">
                    Tin tức khoa
                </option>

                <option value="Đào tạo">
                    Đào tạo
                </option>

                <option value="Sinh viên">
                    Sinh viên
                </option>

                <option value="Nghiên cứu khoa học">
                    Nghiên cứu khoa học
                </option>

                <option value="Hoạt động">
                    Hoạt động
                </option>

                <option value="Thông báo">
                    Thông báo
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>Nội dung:</label>

            <textarea name="noi_dung"></textarea>

        </div>


        <button type="submit">
            GỬI BÀI
        </button>

    </form>


    <?php if (count($baiViets) > 0): ?>

        <h2>Danh sách bài viết</h2>

        <table>

            <tr>

                <th>Mã bài</th>

                <th>Tiêu đề</th>

                <th>Tác giả</th>

                <th>Chuyên mục</th>

                <th>Nội dung</th>

                <th>Trạng thái</th>

            </tr>


            <?php foreach ($baiViets as $bai): ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($bai["ma_bai"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($bai["tieu_de"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($bai["tac_gia"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($bai["chuyen_muc"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($bai["noi_dung"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($bai["trang_thai"]); ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>


</div>

</body>

</html>