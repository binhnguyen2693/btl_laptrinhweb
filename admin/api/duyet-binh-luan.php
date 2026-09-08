<?php

declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';

requireRole(['admin']);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../models/Comment.php';

$pdo = db();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không được phép.'
    ]);

    exit;
}

verifyCsrf();

$commentId = (int) ($_POST['comment_id'] ?? 0);
$status = $_POST['status'] ?? '';
$action = $_POST['action'] ?? '';

if ($commentId <= 0) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'ID bình luận không hợp lệ.'
    ]);

    exit;
}


$commentModel = new Comment($pdo);

// Xử lý xóa bình luận
if ($action === 'delete') {

    $result = $commentModel->delete($commentId);

    if ($result) {

        echo json_encode([
            'success' => true,
            'message' => 'Xóa bình luận thành công.'
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            'success' => false,
            'message' => 'Không thể xóa bình luận.'
        ]);
    }

    exit;
}


// Xử lý cập nhật trạng thái
$allowedStatuses = [
    'approved',
    'hidden'
];

if (!in_array($status, $allowedStatuses, true)) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Trạng thái không hợp lệ.'
    ]);

    exit;
}

$result = $commentModel->updateStatus(
    $commentId,
    $status
);

if ($result) {

    if ($action === 'hide') {

        $message = 'Ẩn bình luận thành công.';

    } elseif ($action === 'show') {

        $message = 'Hiển thị bình luận thành công.';

    } elseif ($action === 'approve') {

        $message = 'Duyệt bình luận thành công.';

    } else {

        $message = 'Cập nhật trạng thái bình luận thành công.';
    }

    echo json_encode([
        'success' => true,
        'message' => $message,
        'status' => $status
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Không thể cập nhật trạng thái bình luận.'
    ]);
}