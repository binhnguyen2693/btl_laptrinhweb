<?php

declare(strict_types=1);

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Comment.php';
require_once __DIR__ . '/../../config/csrf.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không được phép.'
    ]);

    exit;
}


$csrfToken = $_POST['csrf_token'] ?? '';

if (!verifyCsrfToken($csrfToken)) {

    http_response_code(403);

    echo json_encode([
        'success' => false,
        'message' => 'CSRF token không hợp lệ.'
    ]);

    exit;
}


$commentId = (int) ($_POST['comment_id'] ?? 0);
$status = $_POST['status'] ?? 'approved';

if ($commentId <= 0) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'ID bình luận không hợp lệ.'
    ]);

    exit;
}


$commentModel = new Comment($pdo);

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

    $message = $status === 'hidden'
        ? 'Ẩn bình luận thành công.'
        : 'Duyệt bình luận thành công.';

    echo json_encode([
        'success' => true,
        'message' => $message,
        'status' => $status
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Không thể duyệt bình luận.'
    ]);
}