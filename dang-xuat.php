<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/app.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Chỉ chấp nhận phương thức POST.');
}
verifyCsrf();
$_SESSION = [];
session_regenerate_id(true);
redirect('dang-nhap.php');
