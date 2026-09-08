<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    // Không dùng C:\xampp\tmp vì thư mục đó có thể bị giới hạn quyền ghi.
    // Mỗi project dùng một thư mục session riêng trong vùng tạm của Windows.
    $sessionDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'nhip_khoa_sessions';

    if (!is_dir($sessionDirectory) && !mkdir($sessionDirectory, 0775, true) && !is_dir($sessionDirectory)) {
        http_response_code(500);
        exit('Không thể tạo thư mục lưu phiên đăng nhập.');
    }

    session_save_path($sessionDirectory);
    session_start();
}
if (!defined('BASE_URL')) {
    // Derive the project URL from the executed file, including nested API routes.
    $projectRoot = str_replace('\\', '/', dirname(__DIR__));
    $scriptFile = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
    $scriptUrl = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $relativeScript = str_starts_with($scriptFile, $projectRoot . '/')
        ? substr($scriptFile, strlen($projectRoot) + 1)
        : basename($scriptUrl);
    $urlRoot = str_replace('\\', '/', dirname($scriptUrl, substr_count($relativeScript, '/') + 1));
    define('BASE_URL', rtrim($urlRoot, '/.') . '/');
}
require_once __DIR__ . '/../config/database.php';

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void
{
    $sentToken = (string) ($_POST['csrf_token'] ?? '');
    $savedToken = (string) ($_SESSION['csrf_token'] ?? '');
    if ($savedToken === '' || !hash_equals($savedToken, $sentToken)) {
        http_response_code(419);
        exit('Phiên làm việc không hợp lệ. Vui lòng quay lại và thử lại.');
    }
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}
