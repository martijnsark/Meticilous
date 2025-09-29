<?php
session_start();
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$videoId = $_GET['videoId'] ?? '';
$user = $_SESSION['user'] ?? null;
$commentText = $_GET['commentText'] ?? '';

/** @var int $videoId */
// Route the request based on the action parameter
switch ($action) {
    // Likes
    case 'addLike':
        include_once 'likes.php';
        handleAddLike($videoId, $user);
        break;
    case 'removeLike':
        include_once 'likes.php';
        handleRemoveLike($videoId, $user);
        break;
    // Shares
    case 'addShare':
        include_once 'shares.php';
        handleAddShare($videoId);
        break;
    case 'addSave':
        include_once 'saves.php';
        handleAddSave($videoId, $user);
        break;
    case 'removeSave':
        include_once 'saves.php';
        handleRemoveSave($videoId, $user);
        break;
    case 'addComment':
        $commentId = $_GET['commentId'] ?? '';
        include_once 'comments.php';
        handleAddComment($videoId, $user, $commentText);
        break;
    case 'removeComment':
        $commentId = $_GET['commentId'] ?? '';
        include_once 'comments.php';
        handleRemoveComment($commentId, $user);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}