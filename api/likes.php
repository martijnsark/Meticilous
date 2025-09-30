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
    // Prevent duplicate likes
    $checkQuery = "SELECT id FROM likes WHERE user_id = $userId AND target_type = 'video' AND target_id = $videoId";
    $checkResult = mysqli_query($db, $checkQuery);
    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Already liked']);
        mysqli_close($db);
        return false;
    }

    // Add like to likes table
    $query = "INSERT INTO likes (user_id, target_type, target_id) VALUES ($userId, 'video', $videoId)";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if (!$result && !$affectedRows) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add like']);
        mysqli_close($db);
        return false;
    }
    // update likes count in videos table
    $updateQuery = "UPDATE videos SET likes = likes + 1 WHERE id = $videoId";
    mysqli_query($db, $updateQuery);
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
    // Remove like from likes table
    $query = "DELETE FROM likes WHERE user_id = $userId AND target_type = 'video' AND target_id = $videoId";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if (!$result || !$affectedRows) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove like']);
        mysqli_close($db);
        return false;
    }
    // update likes count in videos table
    $updateQuery = "UPDATE videos SET likes = GREATEST(likes - 1, 0) WHERE id = $videoId";
    mysqli_query($db, $updateQuery);
    mysqli_close($db);

    echo json_encode(['status' => 'success', 'message' => 'Like removed successfully', 'id' => $videoId]);
    return true;
}

function checkLiked($videoId, $user): bool
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
    // Check if like exists in likes table
    $checkQuery = "SELECT id FROM likes WHERE user_id = $userId AND target_type = 'video' AND target_id = $videoId";
    $checkResult = mysqli_query($db, $checkQuery);
    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        mysqli_close($db);
        echo json_encode(['status' => 'success', 'liked' => true]);
        return true;
    }

    mysqli_close($db);
    echo json_encode(['status' => 'success', 'liked' => false]);
    return false;
}

// Setup connection with database
//include_once '../include/database/credentials.php';

