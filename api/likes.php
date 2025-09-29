<?php
function handleAddLike($videoId, $user): bool
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
    $query = "INSERT INTO likes (user_id, target_type, target_id) VALUES ($userId, 'video', $videoId)";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if (!$result && !$affectedRows) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add like']);
        return false;
    }
    mysqli_close($db);

    echo json_encode(['status' => 'success', 'message' => 'Like added successfully', 'id' => $videoId]);
    return true;
}

function handleRemoveLike($videoId, $user): bool
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
    $query = "DELETE FROM likes WHERE user_id = $userId AND target_type = 'video' AND target_id = $videoId";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if (!$result || !$affectedRows) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove like']);
        return false;
    }
    mysqli_close($db);

    echo json_encode(['status' => 'success', 'message' => 'Like removed successfully', 'id' => $videoId]);
    return true;
}

// Setup connection with database
//include_once '../include/database/credentials.php';

