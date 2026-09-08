<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/app.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/controllers/ImpactBoxController.php';

requireLogin();

$user = currentUser();

$userId = (int) ($user['id'] ?? 0);

if ($userId <= 0) {
    redirect(BASE_URL . 'dang-nhap.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . 'views/impact-box.php');
    exit;
}

verifyCsrf();

$action = (string) ($_POST['action'] ?? '');
$postId = (int) ($_POST['post_id'] ?? 0);

if ($postId <= 0) {
    redirect(BASE_URL . 'views/impact-box.php');
    exit;
}

$controller = new ImpactBoxController();


switch ($action) {

    case 'add':

        $note = trim(
            (string) ($_POST['note'] ?? '')
        );

        $controller->add(
            $userId,
            $postId,
            $note !== '' ? $note : null
        );

        break;


    case 'delete':

        $controller->delete(
            $userId,
            $postId
        );

        break;


    case 'update_note':

        $note = trim(
            (string) ($_POST['note'] ?? '')
        );

        $controller->updateNote(
            $userId,
            $postId,
            $note
        );

        break;


    case 'clear_note':

        $controller->clearNote(
            $userId,
            $postId
        );

        break;


    default:

        redirect(BASE_URL . 'views/impact-box.php');
        exit;
}

redirect(BASE_URL . 'views/impact-box.php');
exit;