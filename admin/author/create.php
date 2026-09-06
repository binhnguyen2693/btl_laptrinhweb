<?php
require_once __DIR__ . '/../config/database.php';

/* Tạm giả lập tác giả */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['full_name'] = 'Nguyễn Văn A';
    $_SESSION['role'] = 'author';
}

$authorId = $_SESSION['user_id'];
$error = '';
$success = '';

$stmt = $pdo->query("SELECT id, name FROM categories ORDER BY id ASC");
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $summary = trim($_POST['summary'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $action = $_POST['action'] ?? 'draft';
    $status = $action === 'submit' ? 'pending' : 'draft';
    $thumbnail = null;

    if ($title === '') {
        $error = 'Vui lòng nhập tiêu đề.';
    } elseif ($categoryId <= 0) {
        $error = 'Vui lòng chọn chuyên mục.';
    } elseif ($content === '') {
        $error = 'Vui lòng nhập nội dung.';
    }

    if ($error === '' && isset($_FILES['thumbnail']) &&
        $_FILES['thumbnail']['error'] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK) {
            $error = 'Có lỗi khi tải ảnh lên.';
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $fileType = mime_content_type($_FILES['thumbnail']['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                $error = 'Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.';
            } elseif ($_FILES['thumbnail']['size'] > 5 * 1024 * 1024) {
                $error = 'Ảnh không được lớn hơn 5MB.';
            } else {
                $extensions = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                $thumbnail = 'post_' . time() . '_' . uniqid() . '.' . $extensions[$fileType];
                $uploadDir = __DIR__ . '/../assets/uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!move_uploaded_file(
                    $_FILES['thumbnail']['tmp_name'],
                    $uploadDir . $thumbnail
                )) {
                    $error = 'Không thể lưu ảnh.';
                }
            }
        }
    }

    if ($error === '') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO posts
                (author_id, category_id, title, summary, thumbnail, content, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $authorId,
                $categoryId,
                $title,
                $summary,
                $thumbnail,
                $content,
                $status
            ]);

            if ($status === 'draft') {
                $success = 'Bài viết đã được lưu nháp thành công.';
            } else {
                $success = 'Bài viết đã được gửi duyệt thành công.';
            }

            /* Xóa dữ liệu form sau khi lưu thành công */
            $_POST = [];

        } catch (PDOException $e) {
            $error = 'Lỗi database: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Tạo bài viết';
$pageCss = 'create.css';

include __DIR__ . '/../includes/header.php';
?>

<div class="create-page-container">

    <div class="create-page-header">
        <h1>Tạo bài viết mới</h1>
        <p>Soạn nội dung bài viết của bạn.</p>
    </div>
<?php if ($success !== ''): ?>
    <div class="form-success">
        <i class="fa-solid fa-circle-check"></i>
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

    <?php if ($error): ?>
        <div class="form-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="post-form">

        <div class="form-group">
            <label for="title">Tiêu đề <span>*</span></label>
            <input type="text" id="title" name="title"
                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                   placeholder="Nhập tiêu đề bài viết..." required>
        </div>

        <div class="form-group">
            <label for="category_id">Chuyên mục <span>*</span></label>

            <select id="category_id" name="category_id" required>
                <option value="">-- Chọn chuyên mục --</option>

                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"
                        <?= ($_POST['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label for="summary">Tóm tắt</label>

            <textarea id="summary" name="summary" rows="3"
                      maxlength="300"
                      placeholder="Nhập mô tả ngắn về bài viết..."><?= htmlspecialchars($_POST['summary'] ?? '') ?></textarea>

            <small>Tối đa 300 ký tự.</small>
        </div>

        <div class="form-group">
            <label for="thumbnail">Ảnh đại diện</label>

            <label class="upload-box" for="thumbnail">
                <i class="fa-regular fa-image"></i>

                <div>
                    <strong>Chọn ảnh đại diện</strong>
                    <p>JPG, PNG hoặc WEBP - tối đa 5MB</p>
                </div>
            </label>

            <input type="file" id="thumbnail" name="thumbnail"
                   accept=".jpg,.jpeg,.png,.webp" hidden>

            <div id="imagePreview" class="image-preview"></div>
        </div>

        <div class="form-group">
            <label for="content">Nội dung <span>*</span></label>

            <textarea id="content" name="content" rows="15"
                      placeholder="Nhập nội dung bài viết..."
                      required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">

            <a href="<?= BASE_URL ?>author/posts.php" class="cancel-button">
                Hủy
            </a>

            <button type="submit" name="action" value="draft" class="draft-button">
                <i class="fa-regular fa-floppy-disk"></i>
                Lưu nháp
            </button>

            <button type="submit" name="action" value="submit" class="submit-button">
                <i class="fa-regular fa-paper-plane"></i>
                Gửi duyệt
            </button>

        </div>

    </form>

</div>

<script>
const input = document.getElementById('thumbnail');
const preview = document.getElementById('imagePreview');

input.addEventListener('change', function() {
    const file = this.files[0];

    if (!file) {
        preview.innerHTML = '';
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        preview.innerHTML =
            '<img src="' + e.target.result + '" alt="Ảnh đại diện">';
    };

    reader.readAsDataURL(file);
});

<?php if ($success !== ''): ?>
input.value = '';
preview.innerHTML = '';
<?php endif; ?>
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>