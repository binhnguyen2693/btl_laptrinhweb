<?php
declare(strict_types=1);

session_start();

/*
|--------------------------------------------------------------------------
| IMPACT BOX - TEST GIAO DIỆN
|--------------------------------------------------------------------------
|
| File này chỉ dùng để test giao diện Impact Box.
|
| Chưa kết nối:
| - Database
| - Đăng nhập
| - Phân quyền
| - ImpactBoxController
|
| Dữ liệu bên dưới là dữ liệu giả.
|
*/


/*
|--------------------------------------------------------------------------
| DỮ LIỆU BÀI VIẾT GIẢ
|--------------------------------------------------------------------------
*/

$items = [

    [
        'id' => 1,
        'user_id' => 1,
        'post_id' => 101,
        'note' => 'Bài viết này khá hữu ích, cần đọc lại.',
        'created_at' => '2026-09-06 15:30:00',
        'title' => 'Hướng dẫn học tập hiệu quả dành cho sinh viên',
        'slug' => 'huong-dan-hoc-tap-hieu-qua',
        'thumbnail' => '',
        'category_name' => 'Học tập'
    ],

    [
        'id' => 2,
        'user_id' => 1,
        'post_id' => 102,
        'note' => null,
        'created_at' => '2026-09-05 10:20:00',
        'title' => 'Cơ hội việc làm dành cho sinh viên năm cuối',
        'slug' => 'co-hoi-viec-lam-danh-cho-sinh-vien',
        'thumbnail' => '',
        'category_name' => 'Cơ hội'
    ],

    [
        'id' => 3,
        'user_id' => 1,
        'post_id' => 103,
        'note' => 'Nhớ xem lại thông tin của sự kiện này.',
        'created_at' => '2026-09-04 14:15:00',
        'title' => 'Sự kiện nổi bật dành cho sinh viên trong tháng',
        'slug' => 'su-kien-noi-bat-trong-thang',
        'thumbnail' => '',
        'category_name' => 'Sự kiện'
    ],

    [
        'id' => 4,
        'user_id' => 1,
        'post_id' => 104,
        'note' => null,
        'created_at' => '2026-09-03 09:00:00',
        'title' => 'Tin tức mới nhất của khoa',
        'slug' => 'tin-tuc-moi-nhat-cua-khoa',
        'thumbnail' => '',
        'category_name' => 'Tin khoa'
    ],

    [
        'id' => 5,
        'user_id' => 1,
        'post_id' => 105,
        'note' => 'Có thể tham khảo cho bài tập.',
        'created_at' => '2026-09-02 16:40:00',
        'title' => 'Kinh nghiệm làm bài và ôn thi hiệu quả',
        'slug' => 'kinh-nghiem-lam-bai-va-on-thi',
        'thumbnail' => '',
        'category_name' => 'Học tập'
    ],

    [
        'id' => 6,
        'user_id' => 1,
        'post_id' => 106,
        'note' => null,
        'created_at' => '2026-09-01 11:10:00',
        'title' => 'Các chương trình thực tập dành cho sinh viên',
        'slug' => 'cac-chuong-trinh-thuc-tap',
        'thumbnail' => '',
        'category_name' => 'Cơ hội'
    ],

    [
        'id' => 7,
        'user_id' => 1,
        'post_id' => 107,
        'note' => 'Sự kiện này khá đáng chú ý.',
        'created_at' => '2026-08-31 13:25:00',
        'title' => 'Ngày hội sinh viên và các hoạt động sắp tới',
        'slug' => 'ngay-hoi-sinh-vien',
        'thumbnail' => '',
        'category_name' => 'Sự kiện'
    ],

    [
        'id' => 8,
        'user_id' => 1,
        'post_id' => 108,
        'note' => null,
        'created_at' => '2026-08-30 08:45:00',
        'title' => 'Thông báo quan trọng dành cho sinh viên',
        'slug' => 'thong-bao-quan-trong',
        'thumbnail' => '',
        'category_name' => 'Tin khoa'
    ],

    [
        'id' => 9,
        'user_id' => 1,
        'post_id' => 109,
        'note' => 'Đọc kỹ phần hướng dẫn.',
        'created_at' => '2026-08-29 17:30:00',
        'title' => 'Phương pháp quản lý thời gian học tập',
        'slug' => 'phuong-phap-quan-ly-thoi-gian',
        'thumbnail' => '',
        'category_name' => 'Học tập'
    ],

    [
        'id' => 10,
        'user_id' => 1,
        'post_id' => 110,
        'note' => null,
        'created_at' => '2026-08-28 12:00:00',
        'title' => 'Cơ hội tham gia chương trình thực tế',
        'slug' => 'co-hoi-tham-gia-chuong-trinh',
        'thumbnail' => '',
        'category_name' => 'Cơ hội'
    ]

];


/*
|--------------------------------------------------------------------------
| PHÂN TRANG
|--------------------------------------------------------------------------
*/

$itemsPerPage = 8;

$currentPage = isset($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;

$totalItems = count($items);

$totalPages = max(
    1,
    (int) ceil(
        $totalItems / $itemsPerPage
    )
);

if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$start = ($currentPage - 1) * $itemsPerPage;

$pageItems = array_slice(
    $items,
    $start,
    $itemsPerPage
);

?>

<!DOCTYPE html>

<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Impact Box - Test</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f5f5f5;

            color: #222;
        }


        /* =========================
           HEADER
        ========================= */

        .story-header {

            width: 100%;

            background: #7d2e24;

            color: white;
        }


        .story-header-inner {

            max-width: 1100px;

            margin: 0 auto;

            min-height: 55px;

            display: flex;

            align-items: center;

            gap: 22px;

            padding: 0 18px;
        }


        .story-logo {

            font-size: 17px;

            font-weight: bold;

            white-space: nowrap;
        }


        .story-nav {

            display: flex;

            align-items: center;

            gap: 20px;

            flex: 1;
        }


        .story-nav a {

            color: white;

            text-decoration: none;

            font-size: 12px;
        }


        .story-nav a:hover {

            text-decoration: underline;
        }


        .story-login {

            color: white;

            text-decoration: none;

            font-size: 12px;

            white-space: nowrap;
        }


        /* =========================
           MAIN
        ========================= */

        .impact-container {

            max-width: 1100px;

            margin: 0 auto;

            padding:
                35px
                20px
                50px;
        }


        .impact-heading {

            margin-bottom: 20px;
        }


        .impact-heading h1 {

            margin:
                0
                0
                7px;

            font-size: 25px;

            color: #222;
        }


        .impact-heading p {

            margin: 0;

            color: #666;

            font-size: 13px;
        }


        /* =========================
           TOOLBAR
        ========================= */

        .impact-toolbar {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 18px;

            flex-wrap: wrap;
        }


        .impact-search {

            flex: 1;

            min-width: 230px;

            height: 34px;

            border:
                1px solid #ccc;

            border-radius: 3px;

            padding:
                0
                10px;

            font-size: 12px;

            background: white;
        }


        .search-button {

            height: 34px;

            padding:
                0
                15px;

            border: none;

            border-radius: 3px;

            background: #7d2e24;

            color: white;

            font-size: 12px;

            cursor: pointer;
        }


        .search-button:hover {

            background: #65241c;
        }


        .impact-select {

            height: 34px;

            min-width: 120px;

            border:
                1px solid #ccc;

            background: white;

            padding:
                0
                8px;

            font-size: 12px;

            border-radius: 3px;
        }


        .explore-button {

            height: 34px;

            padding:
                0
                15px;

            border: none;

            border-radius: 3px;

            background: #7d2e24;

            color: white;

            font-size: 12px;

            text-decoration: none;

            display: inline-flex;

            align-items: center;

            justify-content: center;
        }


        .explore-button:hover {

            background: #65241c;
        }


        /* =========================
           IMPACT LIST
        ========================= */

        .impact-list {

            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(0, 1fr)
                );

            gap: 16px;
        }


        /* =========================
           CARD
        ========================= */

        .impact-card {

            background: white;

            border:
                1px solid #ddd;

            border-radius: 4px;

            overflow: hidden;

            display: flex;

            flex-direction: column;

            height: 400px;
        }


        /* =========================
           IMAGE
        ========================= */

        .card-image-link {

            display: block;

            height: 150px;

            flex-shrink: 0;

            text-decoration: none;

            color: inherit;
        }


        .impact-card-image,
        .impact-card-no-image {

            width: 100%;

            height: 150px;

            display: block;

            object-fit: cover;
        }


        .impact-card-no-image {

            background: #eee;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #999;

            font-size: 12px;
        }


        /* =========================
           BODY
        ========================= */

        .impact-card-body {

            display: flex;

            flex-direction: column;

            flex: 1;

            min-height: 0;
        }


        .impact-card-content {

            height: 150px;

            flex-shrink: 0;

            padding: 10px;

            overflow: hidden;
        }


        .impact-card-actions {

            height: 150px;

            flex-shrink: 0;

            padding: 10px;

            border-top:
                1px solid #eee;

            display: flex;

            flex-direction: column;

            justify-content: flex-start;

            overflow: hidden;
        }


        /* =========================
           CATEGORY
        ========================= */

        .impact-category {

            display: inline-block;

            width: fit-content;

            margin-bottom: 7px;

            padding:
                3px
                7px;

            background: #f2e5e1;

            color: #7d2e24;

            font-size: 9px;

            font-weight: bold;

            border-radius: 2px;
        }


        /* =========================
           TITLE
        ========================= */

        .impact-card-title {

            margin: 0;

            height: 41px;

            font-size: 15px;

            line-height: 1.35;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }


        .impact-card-title a {

            color: #222;

            text-decoration: none;
        }


        .impact-card-title a:hover {

            color: #7d2e24;
        }


        /* =========================
           NOTE
        ========================= */

        .impact-note {

            background: #fafafa;

            border-left:
                3px solid #7d2e24;

            padding:
                6px
                7px;

            margin:
                4px
                0
                0;

            font-size: 11px;

            line-height: 1.35;

            color: #555;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }


        .no-note {

            color: #888;

            font-size: 11px;

            margin:
                5px
                0
                8px;
        }


        /* =========================
           META
        ========================= */

        .impact-meta {

            height: 25px;

            margin:
                4px
                0
                0;

            padding:
                4px
                0
                0;

            border-top:
                1px solid #eee;

            display: flex;

            justify-content: space-between;

            align-items: center;

            font-size: 9px;

            color: #888;

            flex-shrink: 0;
        }


        .impact-date {

            margin: 0;

            font-size: 9px;

            color: #888;
        }


        .impact-saved {

            color: #7d2e24;

            font-size: 10px;

            font-weight: bold;
        }


        /* =========================
           ACTION BUTTONS
        ========================= */

        .impact-actions {

            display: flex;

            gap: 5px;

            flex-wrap: wrap;

            margin-top: 8px;
        }


        .impact-actions button {

            border: none;

            border-radius: 3px;

            padding:
                6px
                8px;

            font-size: 10px;

            cursor: pointer;

            line-height: 1.2;
        }


        .edit-button {

            background: #7d2e24;

            color: white;
        }


        .edit-button:hover {

            background: #65241c;
        }


        .delete-button {

            background: #f1eeee;

            color: #7d2e24;

            border:
                1px solid #ddd !important;
        }


        .delete-button:hover {

            background: #e4d8d4;
        }


        /* =========================
           EMPTY
        ========================= */

        .impact-empty {

            background: #fffaf7;

            border:
                1px solid #e4ddd8;

            min-height: 220px;

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding: 30px;
        }


        .empty-icon {

            width: 52px;

            height: 52px;

            border:
                2px dashed #e0a16f;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            position: relative;

            color: #e0a16f;

            margin-bottom: 13px;

            font-size: 24px;
        }


        .empty-plus {

            position: absolute;

            right: -5px;

            bottom: -3px;

            width: 16px;

            height: 16px;

            background: #e0a16f;

            color: white;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 14px;

            font-weight: bold;

            line-height: 1;
        }


        /* =========================
           PAGINATION
        ========================= */

        .impact-pagination {

            display: flex;

            justify-content: center;

            gap: 5px;

            margin-top: 20px;
        }


        .impact-pagination span,
        .impact-pagination a {

            min-width: 25px;

            height: 25px;

            display: flex;

            justify-content: center;

            align-items: center;

            border:
                1px solid #ddd;

            background: white;

            color: #555;

            text-decoration: none;

            font-size: 11px;

            border-radius: 2px;
        }


        .impact-pagination .active {

            background: #7d2e24;

            color: white;

            border-color: #7d2e24;
        }


        /* =========================
           MODAL
        ========================= */

        .note-modal {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(
                    0,
                    0,
                    0,
                    0.48
                );

            align-items: center;

            justify-content: center;

            z-index: 9999;
        }


        .note-modal-box {

            width: 430px;

            max-width:
                calc(
                    100% - 30px
                );

            background: #fffaf5;

            padding: 24px;

            position: relative;

            border-radius: 3px;

            box-shadow:
                0
                10px
                35px
                rgba(
                    0,
                    0,
                    0,
                    0.25
                );
        }


        .note-modal-close {

            position: absolute;

            top: 12px;

            right: 15px;

            border: none;

            background: none;

            font-size: 20px;

            cursor: pointer;

            color: #222;
        }


        .note-modal-box h2 {

            margin:
                0
                0
                7px;

            font-size: 17px;
        }


        .note-modal-description {

            color: #666;

            font-size: 11px;

            padding-bottom: 12px;

            border-bottom:
                1px solid #ddd;

            margin-bottom: 13px;
        }


        .modal-post {

            display: flex;

            gap: 10px;

            margin-bottom: 15px;
        }


        .modal-post-image {

            width: 105px;

            height: 70px;

            object-fit: cover;

            border-radius: 2px;
        }


        .modal-post-info {

            flex: 1;
        }


        .modal-post-category {

            display: inline-block;

            background: #f2e5e1;

            color: #7d2e24;

            font-size: 8px;

            padding:
                3px
                5px;

            margin-bottom: 5px;
        }


        .modal-post-title {

            margin: 0;

            font-size: 12px;

            line-height: 1.35;
        }


        .note-form-group {

            margin-bottom: 15px;
        }


        .note-form-group label {

            display: block;

            margin-bottom: 6px;

            font-weight: bold;

            font-size: 11px;
        }


        .note-form-group textarea {

            width: 100%;

            min-height: 75px;

            padding: 9px;

            border:
                1px solid #ccc;

            resize: vertical;

            font-family: Arial, sans-serif;

            font-size: 11px;

            background: white;
        }


        .note-counter {

            text-align: right;

            color: #888;

            font-size: 9px;

            margin-top: 3px;
        }


        .note-modal-actions {

            display: flex;

            justify-content: flex-end;

            gap: 8px;
        }


        .modal-cancel,
        .modal-submit {

            padding:
                8px
                15px;

            border-radius: 2px;

            cursor: pointer;

            font-size: 10px;
        }


        .modal-cancel {

            background: white;

            border:
                1px solid #ccc;
        }


        .modal-submit {

            background: #7d2e24;

            border:
                1px solid #7d2e24;

            color: white;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .impact-list {

                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );
            }


            .story-nav {

                gap: 10px;
            }
        }


        @media (max-width: 600px) {

            .impact-list {

                grid-template-columns: 1fr;
            }


            .story-header-inner {

                height: auto;

                padding-top: 12px;

                padding-bottom: 12px;

                flex-wrap: wrap;
            }


            .story-nav {

                order: 3;

                width: 100%;

                flex-wrap: wrap;
            }


            .impact-toolbar {

                flex-direction: column;

                align-items: stretch;
            }


            .impact-search {

                width: 100%;
            }


            .search-button,
            .impact-select,
            .explore-button {

                width: 100%;
            }
        }

    </style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="story-header">

    <div class="story-header-inner">

        <div class="story-logo">
            NEMCHUA36
        </div>


        <nav class="story-nav">

            <a href="#">
                Trang chủ
            </a>

            <a href="#">
                Tin khoa
            </a>

            <a href="#">
                Học tập
            </a>

            <a href="#">
                Cơ hội
            </a>

            <a href="#">
                Sự kiện
            </a>

            <a href="impact-box-test.php">
                Impact Box
            </a>

        </nav>


        <a
            href="#"
            class="story-login"
        >
            🔍 Đăng nhập
        </a>

    </div>

</header>



<!-- =====================================================
     MAIN
===================================================== -->

<main class="impact-container">


    <!-- TIÊU ĐỀ -->

    <section class="impact-heading">

        <h1>
            Impact Box
        </h1>

        <p>
            Những bài viết bạn đã lưu để xem lại sau.
        </p>

    </section>



    <!-- =================================================
         THANH TÌM KIẾM
    ================================================= -->

    <div class="impact-toolbar">


        <input
            type="text"
            id="impactSearch"
            class="impact-search"
            placeholder="Tìm kiếm trong Impact Box..."
        >


        <button
            type="button"
            id="impactSearchButton"
            class="search-button"
        >
            🔍 Tìm kiếm
        </button>


        <!-- DANH MỤC -->

        <select
            id="impactCategory"
            class="impact-select"
        >

            <option value="all">
                Tất cả danh mục
            </option>


            <?php

            $categories = [];

            foreach ($items as $item) {

                $categoryName =
                    $item['category_name']
                    ?? '';

                if (
                    $categoryName !== ''
                    &&
                    !in_array(
                        $categoryName,
                        $categories,
                        true
                    )
                ) {

                    $categories[] =
                        $categoryName;
                }
            }


            foreach ($categories as $category):

            ?>

                <option
                    value="<?= htmlspecialchars(
                        strtolower($category),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

                    <?= htmlspecialchars(
                        $category,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </option>

            <?php endforeach; ?>

        </select>



        <!-- SẮP XẾP -->

        <select
            id="impactSort"
            class="impact-select"
        >

            <option value="newest">
                Mới nhất
            </option>

            <option value="oldest">
                Cũ nhất
            </option>

        </select>



        <!-- KHÁM PHÁ -->

        <a
            href="#"
            class="explore-button"
        >
            Khám phá thêm bài viết
        </a>

    </div>



    <!-- =================================================
         DANH SÁCH CARD
    ================================================= -->

    <?php if (!empty($pageItems)): ?>

        <section
            class="impact-list"
            id="impactList"
        >


            <?php foreach ($pageItems as $item): ?>

                <?php

                $title =
                    $item['title']
                    ?? '';

                $note =
                    $item['note']
                    ?? '';

                $createdAt =
                    $item['created_at']
                    ?? '';

                $category =
                    $item['category_name']
                    ?? 'Impact Box';

                ?>


                <article
                    class="impact-card"

                    data-id="<?= (int)$item['id'] ?>"

                    data-title="<?= htmlspecialchars(
                        strtolower($title),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"

                    data-category="<?= htmlspecialchars(
                        strtolower($category),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"

                    data-date="<?= htmlspecialchars(
                        $createdAt,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >


                    <!-- ẢNH -->

                    <a
                        href="#"
                        class="card-image-link"
                    >

                        <?php if (
                            !empty(
                                $item['thumbnail']
                            )
                        ): ?>

                            <img
                                class="impact-card-image"

                                src="<?= htmlspecialchars(
                                    $item['thumbnail'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"

                                alt="<?= htmlspecialchars(
                                    $title,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                        <?php else: ?>

                            <div
                                class="impact-card-no-image"
                            >
                                Không có ảnh
                            </div>

                        <?php endif; ?>

                    </a>



                    <!-- BODY -->

                    <div class="impact-card-body">


                        <!-- NỘI DUNG -->

                        <div class="impact-card-content">


                            <span
                                class="impact-category"
                            >

                                <?= htmlspecialchars(
                                    $category,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </span>


                            <h2
                                class="impact-card-title"
                            >

                                <a href="#">

                                    <?= htmlspecialchars(
                                        $title,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </a>

                            </h2>



                            <!-- META -->

                            <div class="impact-meta">


                                <span
                                    class="impact-saved"
                                >
                                    🔖 Đã lưu
                                </span>


                                <span
                                    class="impact-date"
                                >

                                    <?php

                                    if (
                                        !empty(
                                            $createdAt
                                        )
                                    ) {

                                        echo date(
                                            'd/m/Y • H:i',
                                            strtotime(
                                                $createdAt
                                            )
                                        );
                                    }

                                    ?>

                                </span>

                            </div>



                            <!-- GHI CHÚ -->

                            <?php if (!empty($note)): ?>

                                <div
                                    class="impact-note"
                                >

                                    <strong>
                                        Ghi chú:
                                    </strong>

                                    <?= htmlspecialchars(
                                        $note,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </div>

                            <?php else: ?>

                                <p
                                    class="no-note"
                                >
                                    Chưa có ghi chú.
                                </p>

                            <?php endif; ?>


                        </div>



                        <!-- CHỨC NĂNG -->

                        <div
                            class="impact-card-actions"
                        >


                            <!-- GHI CHÚ -->

                            <?php if (!empty($note)): ?>

                                <div
                                    class="impact-actions"
                                >

                                    <button
                                        type="button"
                                        class="edit-button"

                                        onclick='openEditNote(
                                            <?= (int)$item["id"] ?>,
                                            <?= json_encode(
                                                $note,
                                                JSON_HEX_TAG |
                                                JSON_HEX_AMP |
                                                JSON_HEX_APOS |
                                                JSON_HEX_QUOT
                                            ) ?>
                                        )'
                                    >
                                        Sửa ghi chú
                                    </button>


                                    <button
                                        type="button"
                                        class="delete-button"

                                        onclick="clearNote(
                                            <?= (int)$item['id'] ?>
                                        )"
                                    >
                                        Xóa ghi chú
                                    </button>

                                </div>

                            <?php else: ?>

                                <div
                                    class="impact-actions"
                                >

                                    <button
                                        type="button"
                                        class="edit-button"

                                        onclick="openAddNote(
                                            <?= (int)$item['id'] ?>
                                        )"
                                    >
                                        Thêm ghi chú
                                    </button>

                                </div>

                            <?php endif; ?>



                            <!-- XÓA -->

                            <div
                                class="impact-actions"
                            >

                                <button
                                    type="button"
                                    class="delete-button"

                                    onclick="removeCard(
                                        <?= (int)$item['id'] ?>
                                    )"
                                >
                                    Xóa khỏi Impact Box
                                </button>

                            </div>


                        </div>


                    </div>


                </article>


            <?php endforeach; ?>


        </section>


        <!-- =================================================
             PHÂN TRANG
        ================================================= -->

        <?php if ($totalPages > 1): ?>

            <div
                class="impact-pagination"
            >


                <?php if ($currentPage > 1): ?>

                    <a
                        href="?page=<?= $currentPage - 1 ?>"
                    >
                        ‹
                    </a>

                <?php else: ?>

                    <span>
                        ‹
                    </span>

                <?php endif; ?>



                <?php for (
                    $page = 1;
                    $page <= $totalPages;
                    $page++
                ): ?>

                    <?php if (
                        $page === $currentPage
                    ): ?>

                        <span class="active">
                            <?= $page ?>
                        </span>

                    <?php else: ?>

                        <a
                            href="?page=<?= $page ?>"
                        >
                            <?= $page ?>
                        </a>

                    <?php endif; ?>

                <?php endfor; ?>



                <?php if (
                    $currentPage < $totalPages
                ): ?>

                    <a
                        href="?page=<?= $currentPage + 1 ?>"
                    >
                        ›
                    </a>

                <?php else: ?>

                    <span>
                        ›
                    </span>

                <?php endif; ?>


            </div>

        <?php endif; ?>


    <?php endif; ?>


</main>



<!-- =====================================================
     MODAL GHI CHÚ
===================================================== -->

<div
    id="noteModal"
    class="note-modal"
>


    <div class="note-modal-box">


        <button
            type="button"
            class="note-modal-close"

            onclick="closeNoteModal()"
        >
            ×
        </button>


        <h2 id="noteModalTitle">
            Thêm ghi chú
        </h2>


        <div
            class="note-modal-description"
        >
            Bạn có thể thêm ghi chú cho bài viết này.
        </div>


        <div
            class="note-form-group"
        >

            <label for="noteInput">
                Ghi chú
            </label>


            <textarea
                id="noteInput"
                maxlength="200"
                placeholder="Nhập ghi chú của bạn..."
            ></textarea>


            <div
                class="note-counter"
                id="noteCounter"
            >
                0/200
            </div>

        </div>


        <div
            class="note-modal-actions"
        >

            <button
                type="button"
                class="modal-cancel"

                onclick="closeNoteModal()"
            >
                Hủy
            </button>


            <button
                type="button"
                class="modal-submit"

                onclick="saveNote()"
            >
                Lưu thay đổi
            </button>

        </div>


    </div>

</div>



<script>

/*
|--------------------------------------------------------------------------
| BIẾN TEST
|--------------------------------------------------------------------------
*/

let editingCardId = null;



/*
|--------------------------------------------------------------------------
| MỞ MODAL THÊM GHI CHÚ
|--------------------------------------------------------------------------
*/

function openAddNote(cardId) {

    editingCardId = cardId;

    document.getElementById(
        'noteModalTitle'
    ).textContent =
        'Thêm ghi chú';

    document.getElementById(
        'noteInput'
    ).value = '';

    updateNoteCounter();

    document.getElementById(
        'noteModal'
    ).style.display =
        'flex';
}



/*
|--------------------------------------------------------------------------
| MỞ MODAL SỬA GHI CHÚ
|--------------------------------------------------------------------------
*/

function openEditNote(cardId, note) {

    editingCardId = cardId;

    document.getElementById(
        'noteModalTitle'
    ).textContent =
        'Sửa ghi chú';

    document.getElementById(
        'noteInput'
    ).value =
        note;

    updateNoteCounter();

    document.getElementById(
        'noteModal'
    ).style.display =
        'flex';
}



/*
|--------------------------------------------------------------------------
| ĐÓNG MODAL
|--------------------------------------------------------------------------
*/

function closeNoteModal() {

    document.getElementById(
        'noteModal'
    ).style.display =
        'none';

    editingCardId = null;
}



/*
|--------------------------------------------------------------------------
| ĐẾM KÝ TỰ
|--------------------------------------------------------------------------
*/

function updateNoteCounter() {

    const input =
        document.getElementById(
            'noteInput'
        );

    const counter =
        document.getElementById(
            'noteCounter'
        );

    if (!input || !counter) {
        return;
    }

    counter.textContent =
        input.value.length +
        '/200';
}



/*
|--------------------------------------------------------------------------
| THEO DÕI TEXTAREA
|--------------------------------------------------------------------------
*/

document
    .getElementById('noteInput')
    .addEventListener(
        'input',
        updateNoteCounter
    );



/*
|--------------------------------------------------------------------------
| LƯU GHI CHÚ - CHỈ TEST GIAO DIỆN
|--------------------------------------------------------------------------
*/

function saveNote() {

    if (!editingCardId) {
        return;
    }

    const input =
        document.getElementById(
            'noteInput'
        );

    const note =
        input.value.trim();

    const card =
        document.querySelector(
            '.impact-card[data-id="' +
            editingCardId +
            '"]'
        );

    if (!card) {
        closeNoteModal();
        return;
    }


    const content =
        card.querySelector(
            '.impact-card-content'
        );


    const oldNote =
        content.querySelector(
            '.impact-note'
        );

    const noNote =
        content.querySelector(
            '.no-note'
        );


    /*
     * Nếu có ghi chú
     */

    if (note !== '') {

        if (oldNote) {

            oldNote.innerHTML =
                '<strong>Ghi chú:</strong> ' +
                escapeHtml(note);

        } else {

            const newNote =
                document.createElement(
                    'div'
                );

            newNote.className =
                'impact-note';

            newNote.innerHTML =
                '<strong>Ghi chú:</strong> ' +
                escapeHtml(note);

            if (noNote) {
                noNote.replaceWith(
                    newNote
                );
            } else {
                content.appendChild(
                    newNote
                );
            }
        }


        /*
         * Đổi nút thành "Sửa ghi chú"
         */

        const actions =
            card.querySelector(
                '.impact-card-actions'
            );

        const firstActions =
            actions.querySelector(
                '.impact-actions'
            );

        firstActions.innerHTML =
            '<button type="button" ' +
            'class="edit-button" ' +
            'onclick=\'openEditNote(' +
            editingCardId +
            ', ' +
            JSON.stringify(note) +
            ')\'>' +
            'Sửa ghi chú' +
            '</button>' +

            '<button type="button" ' +
            'class="delete-button" ' +
            'onclick="clearNote(' +
            editingCardId +
            ')">' +
            'Xóa ghi chú' +
            '</button>';

    }


    /*
     * Nếu xóa hết ghi chú
     */

    else {

        if (oldNote) {
            oldNote.remove();
        }

        if (!noNote) {

            const newNoNote =
                document.createElement(
                    'p'
                );

            newNoNote.className =
                'no-note';

            newNoNote.textContent =
                'Chưa có ghi chú.';

            content.appendChild(
                newNoNote
            );
        }


        const actions =
            card.querySelector(
                '.impact-card-actions'
            );

        const firstActions =
            actions.querySelector(
                '.impact-actions'
            );

        firstActions.innerHTML =
            '<button type="button" ' +
            'class="edit-button" ' +
            'onclick="openAddNote(' +
            editingCardId +
            ')">' +
            'Thêm ghi chú' +
            '</button>';
    }


    closeNoteModal();
}



/*
|--------------------------------------------------------------------------
| XÓA GHI CHÚ
|--------------------------------------------------------------------------
*/

function clearNote(cardId) {

    const card =
        document.querySelector(
            '.impact-card[data-id="' +
            cardId +
            '"]'
        );

    if (!card) {
        return;
    }


    const note =
        card.querySelector(
            '.impact-note'
        );

    if (note) {
        note.remove();
    }


    const content =
        card.querySelector(
            '.impact-card-content'
        );


    if (
        !content.querySelector(
            '.no-note'
        )
    ) {

        const noNote =
            document.createElement(
                'p'
            );

        noNote.className =
            'no-note';

        noNote.textContent =
            'Chưa có ghi chú.';

        content.appendChild(
            noNote
        );
    }


    const actions =
        card.querySelector(
            '.impact-card-actions'
        );

    const firstActions =
        actions.querySelector(
            '.impact-actions'
        );


    firstActions.innerHTML =
        '<button type="button" ' +
        'class="edit-button" ' +
        'onclick="openAddNote(' +
        cardId +
        ')">' +
        'Thêm ghi chú' +
        '</button>';
}



/*
|--------------------------------------------------------------------------
| XÓA CARD KHỎI GIAO DIỆN
|--------------------------------------------------------------------------
*/

function removeCard(cardId) {

    const card =
        document.querySelector(
            '.impact-card[data-id="' +
            cardId +
            '"]'
        );

    if (!card) {
        return;
    }


    const confirmed =
        confirm(
            'Bạn có chắc muốn xóa bài viết này khỏi Impact Box?'
        );


    if (!confirmed) {
        return;
    }


    card.remove();
}



/*
|--------------------------------------------------------------------------
| ESCAPE HTML
|--------------------------------------------------------------------------
*/

function escapeHtml(text) {

    const div =
        document.createElement(
            'div'
        );

    div.textContent =
        text;

    return div.innerHTML;
}



/*
|--------------------------------------------------------------------------
| TÌM KIẾM + LỌC
|--------------------------------------------------------------------------
*/

const searchInput =
    document.getElementById(
        'impactSearch'
    );

const searchButton =
    document.getElementById(
        'impactSearchButton'
    );

const categorySelect =
    document.getElementById(
        'impactCategory'
    );


function filterImpactCards() {

    const keyword =
        searchInput
            ? searchInput.value
                .trim()
                .toLowerCase()
            : '';


    const selectedCategory =
        categorySelect
            ? categorySelect.value
            : 'all';


    const cards =
        document.querySelectorAll(
            '.impact-card'
        );


    cards.forEach(
        function(card) {

            const title =
                card.dataset.title ||
                '';

            const category =
                card.dataset.category ||
                '';


            const matchKeyword =
                keyword === '' ||
                title.includes(
                    keyword
                );


            const matchCategory =
                selectedCategory === 'all' ||
                category ===
                selectedCategory;


            if (
                matchKeyword &&
                matchCategory
            ) {

                card.style.display =
                    '';

            } else {

                card.style.display =
                    'none';
            }
        }
    );
}



/*
|--------------------------------------------------------------------------
| NÚT TÌM KIẾM
|--------------------------------------------------------------------------
*/

if (searchButton) {

    searchButton.addEventListener(
        'click',
        filterImpactCards
    );
}



/*
|--------------------------------------------------------------------------
| ENTER ĐỂ TÌM
|--------------------------------------------------------------------------
*/

if (searchInput) {

    searchInput.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key ===
                'Enter'
            ) {

                event.preventDefault();

                filterImpactCards();
            }
        }
    );
}



/*
|--------------------------------------------------------------------------
| LỌC DANH MỤC
|--------------------------------------------------------------------------
*/

if (categorySelect) {

    categorySelect.addEventListener(
        'change',
        filterImpactCards
    );
}



/*
|--------------------------------------------------------------------------
| SẮP XẾP
|--------------------------------------------------------------------------
*/

const sortSelect =
    document.getElementById(
        'impactSort'
    );

const impactList =
    document.getElementById(
        'impactList'
    );


if (
    sortSelect &&
    impactList
) {

    sortSelect.addEventListener(
        'change',
        function() {

            const cards =
                Array.from(
                    impactList.querySelectorAll(
                        '.impact-card'
                    )
                );


            cards.sort(
                function(a, b) {

                    const dateA =
                        new Date(
                            a.dataset.date
                        );

                    const dateB =
                        new Date(
                            b.dataset.date
                        );


                    if (
                        this.value ===
                        'oldest'
                    ) {

                        return (
                            dateA - dateB
                        );
                    }


                    return (
                        dateB - dateA
                    );

                }.bind(this)
            );


            cards.forEach(
                function(card) {

                    impactList.appendChild(
                        card
                    );
                }
            );
        }
    );
}



/*
|--------------------------------------------------------------------------
| CLICK RA NGOÀI MODAL
|--------------------------------------------------------------------------
*/

window.addEventListener(
    'click',
    function(event) {

        const modal =
            document.getElementById(
                'noteModal'
            );

        if (
            event.target ===
            modal
        ) {

            closeNoteModal();
        }
    }
);

</script>


</body>

</html>