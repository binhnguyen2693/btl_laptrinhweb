<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
requireRole(['author']);

$pdo = db();
$signedInUser = currentUser();
$authorId = (int) $signedInUser['id'];
if (!defined('BASE_URL')) define('BASE_URL', '/');
