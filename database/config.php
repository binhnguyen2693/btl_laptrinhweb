<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SITE_NAME', 'Cổng thông tin khoa');
define('BASE_URL', '/web_nhom/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'web_nhom');
define('DB_USER', 'root');
define('DB_PASS', '');

date_default_timezone_set('Asia/Ho_Chi_Minh');
?>