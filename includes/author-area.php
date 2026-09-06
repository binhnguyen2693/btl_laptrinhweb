<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
requireRole(['author']);

$pdo = db();
$signedInUser = currentUser();
$authorId = (int) $signedInUser['id'];
if (!defined('BASE_URL')) {
    // Both /author|editor/... and /project/author|editor/... are supported.
    $areaBasePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/', 2));
    define('BASE_URL', rtrim($areaBasePath, '/.') . '/');
}
