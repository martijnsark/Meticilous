<?php
session_start();
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$videoId = $_GET['videoId'] ?? '';
$user = $_SESSION['user'] ?? null;

/** @var int $videoId */
// Route the request based on the action parameter
switch ($action) {
    case 'addLike':
        include_once 'likes.php';
        handleAddLike($videoId);
        break;
    case 'removeLike':
        include_once 'likes.php';
        handleRemoveLike($videoId);
        break;
    case 'addShare':
        include_once 'shares.php';
        handleAddShare($videoId);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}