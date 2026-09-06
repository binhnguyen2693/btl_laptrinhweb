<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/public-posts.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
redirect(publicDetailUrl($id ?: 0, publicContext(), '../'));
