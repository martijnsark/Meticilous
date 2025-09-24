<?php
$action = $_GET['action'] ?? '';
header('Content-Type: application/json');

// Route the request based on the action parameter
switch ($action) {
    case 'addShare':
        $videoId = $_GET['videoId'] ?? '';
        handleAddShare($videoId);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

// Function to handle adding a share to a video
function handleAddShare($videoId): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }

    include_once '../include/database/credentials.php';
    $videoId = mysqli_real_escape_string($db, $videoId);
    $query = "UPDATE videos SET shares = shares + 1 WHERE id = $videoId";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if ($affectedRows == !1) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add share']);
        return false;
    }
    mysqli_close($db);

    echo json_encode(['status' => 'success', 'message' => 'Share added successfully']);
    return true;
}