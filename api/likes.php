<?php
$videoId = $_GET['videoId'] ?? '';
$userId = $_SESSION['userId'] ?? '';

if (!isset($userId)) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

function handleAddLike($videoId): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }
    return true;
}

function handleRemoveLike($videoId): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }
    return true;
}

// Setup connection with database
//include_once '../include/database/credentials.php';

