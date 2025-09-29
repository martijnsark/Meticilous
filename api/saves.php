<?php
function handleAddSave($videoId, $user): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }
    if (!isset($user)) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        return false;
    }
    include_once '../include/database/credentials.php';
    $userId = $user['id'];
    $videoId = mysqli_real_escape_string($db, $videoId);
    // Prevent duplicate saves
    $checkQuery = "SELECT id FROM saves WHERE user_id = $userId AND video_id = $videoId";
    $checkResult = mysqli_query($db, $checkQuery);
    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Already saved']);
        mysqli_close($db);
        return false;
    }
    $query = "INSERT INTO saves (user_id, video_id) VALUES ($userId, $videoId)";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add save']);
        mysqli_close($db);
        return false;
    }
    mysqli_close($db);
    echo json_encode(['status' => 'success', 'message' => 'Save added successfully', 'id' => $videoId]);
    return true;
}

function handleRemoveSave($videoId, $user): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }
    if (!isset($user)) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        return false;
    }
    include_once '../include/database/credentials.php';
    $userId = $user['id'];
    $videoId = mysqli_real_escape_string($db, $videoId);
    $query = "DELETE FROM saves WHERE user_id = $userId AND video_id = $videoId";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if (!$result || !$affectedRows) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove save']);
        mysqli_close($db);
        return false;
    }
    mysqli_close($db);
    echo json_encode(['status' => 'success', 'message' => 'Save removed successfully', 'id' => $videoId]);
    return true;
}
