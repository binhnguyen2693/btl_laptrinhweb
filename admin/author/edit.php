<?php
require_once __DIR__ . '/../config/database.php';

/* Tạm giả lập tác giả, xóa khi merge Login */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['full_name'] = 'Nguyễn Văn A';
    $_SESSION['role'] = 'author';
}

$authorId = $_SESSION['user_id'];
$postId = (int)($_GET['id'] ?? 0);

$error = '';
$success = '';

if ($postId <= 0) {
    die('Bài viết không hợp lệ.');
}

/* Lấy danh sách chuyên mục */
$stmt = $pdo->query("
    SELECT id, name
    FROM categories
    ORDER BY id ASC
");

$categories = $stmt->fetchAll();

/* Lấy bài viết */
$stmt = $pdo->prepare("
    SELECT *
    FROM posts
    WHERE id = ?
      AND author_id = ?
");

$stmt->execute([$postId, $authorId]);
$post = $stmt->fetch();

if (!$post) {
    die('Không tìm thấy bài viết hoặc bạn không có quyền chỉnh sửa bài này.');
}

/* Chỉ cho phép sửa bài nháp hoặc bài bị từ chối */
if (!in_array($post['status'], ['draft', 'rejected'])) {
    die('Bài viết này không được phép chỉnh sửa.');
}

/* Lưu lý do từ chối cũ để hiển thị */
$oldEditorNote = $post['editor_note'];

/* Xử lý form */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* =========================
       XÓA BÀI VIẾT
    ========================= */
    if (isset($_POST['delete_post'])) {

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                DELETE FROM posts
                WHERE id = ?
                  AND author_id = ?
            ");

            $stmt->execute([
                $postId,
                $authorId
            ]);

            if ($stmt->rowCount() === 0) {
                throw new Exception('Không thể xóa bài viết.');
            }

            $pdo->commit();

            /* Xóa ảnh sau khi DB đã xóa thành công */
            if (!empty($post['thumbnail'])) {
                $imagePath =
                    __DIR__ .
                    '/../assets/uploads/' .
                    $post['thumbnail'];

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $_SESSION['success'] =
                'Bài viết đã được xóa thành công.';

            header(
                'Location: ' .
                BASE_URL .
                'author/posts.php'
            );

            exit;

        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $error =
                'Không thể xóa bài viết: ' .
                $e->getMessage();
        }
    }

    /* =========================
       CẬP NHẬT BÀI VIẾT
    ========================= */
    if (!isset($_POST['delete_post'])) {

        $title =
            trim($_POST['title'] ?? '');

        $categoryId =
            (int)($_POST['category_id'] ?? 0);

        $summary =
            trim($_POST['summary'] ?? '');

        $content =
            trim($_POST['content'] ?? '');

        $action =
            $_POST['action'] ?? 'draft';

        /*
         * Lưu nháp -> draft
         * Gửi duyệt -> pending
         */
        if ($action === 'submit') {
            $newStatus = 'pending';
        } else {
            $newStatus = 'draft';
        }

        /* Giữ ảnh cũ mặc định */
        $thumbnail = $post['thumbnail'];
        $newThumbnail = null;

        /* Validation */
        if ($title === '') {

            $error =
                'Vui lòng nhập tiêu đề bài viết.';

        } elseif ($categoryId <= 0) {

            $error =
                'Vui lòng chọn chuyên mục.';

        } elseif ($content === '') {

            $error =
                'Vui lòng nhập nội dung bài viết.';
        }

        /* =========================
           UPLOAD ẢNH MỚI
        ========================= */
        if (
            $error === '' &&
            isset($_FILES['thumbnail']) &&
            $_FILES['thumbnail']['error']
                !== UPLOAD_ERR_NO_FILE
        ) {

            if (
                $_FILES['thumbnail']['error']
                !== UPLOAD_ERR_OK
            ) {

                $error =
                    'Có lỗi khi tải ảnh lên.';

            } else {

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                $fileType = mime_content_type(
                    $_FILES['thumbnail']['tmp_name']
                );

                if (!in_array(
                    $fileType,
                    $allowedTypes,
                    true
                )) {

                    $error =
                        'Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.';

                } elseif (
                    $_FILES['thumbnail']['size']
                    > 5 * 1024 * 1024
                ) {

                    $error =
                        'Ảnh không được lớn hơn 5MB.';

                } else {

                    $extensions = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/webp' => 'webp'
                    ];

                    $newThumbnail =
                        'post_' .
                        time() .
                        '_' .
                        uniqid() .
                        '.' .
                        $extensions[$fileType];

                    $uploadDir =
                        __DIR__ .
                        '/../assets/uploads/';

                    if (!is_dir($uploadDir)) {
                        mkdir(
                            $uploadDir,
                            0777,
                            true
                        );
                    }

                    $uploadPath =
                        $uploadDir .
                        $newThumbnail;

                    if (!move_uploaded_file(
                        $_FILES['thumbnail']['tmp_name'],
                        $uploadPath
                    )) {

                        $error =
                            'Không thể lưu ảnh mới.';

                    } else {

                        $thumbnail =
                            $newThumbnail;
                    }
                }
            }
        }

        /* =========================
           UPDATE DATABASE
        ========================= */
        if ($error === '') {

            try {

                $stmt = $pdo->prepare("
                    UPDATE posts
                    SET
                        category_id = ?,
                        title = ?,
                        summary = ?,
                        thumbnail = ?,
                        content = ?,
                        status = ?,
                        editor_note = NULL
                    WHERE id = ?
                      AND author_id = ?
                ");

                $stmt->execute([
                    $categoryId,
                    $title,
                    $summary,
                    $thumbnail,
                    $content,
                    $newStatus,
                    $postId,
                    $authorId
                ]);

                /*
                 * Nếu upload ảnh mới thành công
                 * thì xóa ảnh cũ.
                 */
                if (
                    $newThumbnail !== null &&
                    !empty($post['thumbnail'])
                ) {

                    $oldImage =
                        __DIR__ .
                        '/../assets/uploads/' .
                        $post['thumbnail'];

                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }

                /* GỬI DUYỆT */
                if ($newStatus === 'pending') {

                    $_SESSION['success'] =
                        'Bài viết đã được cập nhật và gửi duyệt thành công.';

                    header(
                        'Location: ' .
                            BASE_URL .
                            'author/view.php?id=' .
                            $postId
                    );

                    exit;
                }

                /* LƯU NHÁP */
                $success =
                    'Bài viết đã được cập nhật và lưu nháp thành công.';

                /*
                 * Lấy lại dữ liệu mới nhất
                 * để form hiển thị đúng.
                 */
                $stmt = $pdo->prepare("
                    SELECT *
                    FROM posts
                    WHERE id = ?
                      AND author_id = ?
                ");

                $stmt->execute([
                    $postId,
                    $authorId
                ]);

                $post = $stmt->fetch();

                $oldEditorNote = null;

                /* Xóa POST để form lấy dữ liệu từ DB */
                $_POST = [];

            } catch (PDOException $e) {

                /*
                 * Nếu DB lỗi nhưng đã upload ảnh mới
                 * thì xóa file vừa upload.
                 */
                if ($newThumbnail !== null) {

                    $newImagePath =
                        __DIR__ .
                        '/../assets/uploads/' .
                        $newThumbnail;

                    if (file_exists(
                        $newImagePath
                    )) {
                        unlink(
                            $newImagePath
                        );
                    }
                }

                $error =
                    'Lỗi database: ' .
                    $e->getMessage();
            }
        }
    }
}

$pageTitle = 'Chỉnh sửa bài viết';
$pageCss = 'edit.css';

include __DIR__ . '/../includes/header.php';
?>

<div class="edit-page-container">

    <div class="edit-page-header">

        <a
            href="<?= BASE_URL ?>author/view.php?id=<?= $post['id'] ?>"
            class="back-link"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại
        </a>

        <h1>Chỉnh sửa bài viết</h1>

        <p>
            Mã bài:
            <strong>
                <?= 'BV' . str_pad(
                    $post['id'],
                    3,
                    '0',
                    STR_PAD_LEFT
                ) ?>
            </strong>
        </p>

    </div>

    <?php if ($success !== ''): ?>

        <div class="form-success">

            <i class="fa-solid fa-circle-check"></i>

            <?= htmlspecialchars($success) ?>

        </div>

    <?php endif; ?>

    <?php if ($error !== ''): ?>

        <div class="form-error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>

    <?php if (
        !empty($oldEditorNote) &&
        $post['status'] === 'rejected'
    ): ?>

        <div class="rejected-note">

            <div class="rejected-note-title">

                <i class="fa-solid fa-circle-exclamation"></i>

                Lý do bài viết bị từ chối

            </div>

            <p>
                <?= nl2br(
                    htmlspecialchars(
                        $oldEditorNote
                    )
                ) ?>
            </p>

        </div>

    <?php endif; ?>

    <form
        method="POST"
        enctype="multipart/form-data"
        class="edit-post-form"
        id="editPostForm"
    >

        <div class="form-group">

            <label for="title">
                Tiêu đề
                <span>*</span>
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars(
                    $_POST['title'] ??
                    $post['title']
                ) ?>"
                placeholder="Nhập tiêu đề bài viết..."
            >

        </div>

        <div class="form-group">

            <label for="category_id">
                Chuyên mục
                <span>*</span>
            </label>

            <select
                id="category_id"
                name="category_id"
            >

                <option value="">
                    -- Chọn chuyên mục --
                </option>

                <?php
                $selectedCategory =
                    $_POST['category_id'] ??
                    $post['category_id'];
                ?>

                <?php foreach (
                    $categories as $category
                ): ?>

                    <option
                        value="<?= $category['id'] ?>"
                        <?= $selectedCategory
                            == $category['id']
                            ? 'selected'
                            : '' ?>
                    >

                        <?= htmlspecialchars(
                            $category['name']
                        ) ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="form-group">

            <label for="summary">
                Tóm tắt
            </label>

            <textarea
                id="summary"
                name="summary"
                rows="3"
                maxlength="300"
                placeholder="Nhập tóm tắt bài viết..."
            ><?= htmlspecialchars(
                $_POST['summary'] ??
                $post['summary']
            ) ?></textarea>

            <small>
                Tối đa 300 ký tự.
            </small>

        </div>

        <div class="form-group">

            <label>
                Ảnh đại diện
            </label>

            <?php if (
                !empty($post['thumbnail'])
            ): ?>

                <div class="current-image">

                    <p>Ảnh hiện tại</p>

                    <img
                        src="<?= BASE_URL ?>assets/uploads/<?= htmlspecialchars(
                            $post['thumbnail']
                        ) ?>"
                        alt="Ảnh đại diện hiện tại"
                    >

                </div>

            <?php endif; ?>

            <label
                class="upload-box"
                for="thumbnail"
            >

                <i class="fa-regular fa-image"></i>

                <div>

                    <strong>
                        Chọn ảnh mới
                    </strong>

                    <p>
                        JPG, PNG hoặc WEBP - tối đa 5MB
                    </p>

                    <p>
                        Không chọn ảnh mới thì giữ ảnh hiện tại.
                    </p>

                </div>

            </label>

            <input
                type="file"
                id="thumbnail"
                name="thumbnail"
                accept=".jpg,.jpeg,.png,.webp"
                hidden
            >

            <div
                id="imagePreview"
                class="image-preview"
            ></div>

        </div>

        <div class="form-group">

            <label for="content">
                Nội dung
                <span>*</span>
            </label>

            <textarea
                id="content"
                name="content"
                rows="15"
                placeholder="Nhập nội dung bài viết..."
            ><?= htmlspecialchars(
                $_POST['content'] ??
                $post['content']
            ) ?></textarea>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                name="delete_post"
                value="1"
                class="delete-button"
                onclick="
                    return confirm(
                        'Bạn có chắc chắn muốn xóa bài viết này không?'
                    );
                "
            >

                <i class="fa-regular fa-trash-can"></i>

                Xóa bài

            </button>

            <div class="form-actions-right">

                <a
                    href="<?= BASE_URL ?>author/view.php?id=<?= $post['id'] ?>"
                    class="cancel-button"
                >
                    Hủy
                </a>

                <button
                    type="submit"
                    name="action"
                    value="draft"
                    class="draft-button"
                >

                    <i class="fa-regular fa-floppy-disk"></i>

                    Lưu nháp

                </button>

                <button
                    type="submit"
                    name="action"
                    value="submit"
                    class="submit-button"
                >

                    <i class="fa-regular fa-paper-plane"></i>

                    Gửi duyệt

                </button>

            </div>

        </div>

    </form>

</div>

<script>
const thumbnailInput =
    document.getElementById('thumbnail');

const imagePreview =
    document.getElementById('imagePreview');

thumbnailInput.addEventListener(
    'change',
    function() {

        const file = this.files[0];

        if (!file) {
            imagePreview.innerHTML = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {

            imagePreview.innerHTML =
                '<p>Ảnh mới</p>' +
                '<img src="' +
                e.target.result +
                '" alt="Ảnh mới">';
        };

        reader.readAsDataURL(file);
    }
);
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>