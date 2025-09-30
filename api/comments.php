<?php
function handleAddComment($videoId, $user, $commentText): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId) || !isset($user) || empty(trim($commentText))) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }
    include_once '../include/database/credentials.php';
    $userId = $user['id'];
    $videoId = mysqli_real_escape_string($db, $videoId);
    $commentText = mysqli_real_escape_string($db, $commentText);
    $query = "INSERT INTO comments (user_id, video_id, comment) VALUES ($userId, $videoId, '$commentText')";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
        mysqli_close($db);
        return false;
    }
    $commentId = mysqli_insert_id($db);

    // update comments count in videos table
    $updateQuery = "UPDATE videos SET comments = comments + 1 WHERE id = $videoId";
    mysqli_query($db, $updateQuery);
    mysqli_close($db);
    echo json_encode(['status' => 'success', 'message' => 'Comment added successfully', 'id' => $commentId]);
    return true;
}

function handleRemoveComment($commentId, $user): bool
{
    /** @var mysqli $db */
    if (!isset($commentId) || !is_numeric($commentId) || !isset($user)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
        return false;
    }
    include_once '../include/database/credentials.php';
    $userId = $user['id'];
    $commentId = mysqli_real_escape_string($db, $commentId);
    // Only allow user to delete their own comment
    $query = "DELETE FROM comments WHERE id = $commentId AND user_id = $userId";
    $result = mysqli_query($db, $query);
    $affectedRows = mysqli_affected_rows($db);
    if (!$result || !$affectedRows) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove comment']);
        mysqli_close($db);
        return false;
    }
    mysqli_close($db);
    echo json_encode(['status' => 'success', 'message' => 'Comment removed successfully', 'id' => $commentId]);
    return true;
}

function fetchComments($videoId): bool
{
    /** @var mysqli $db */
    if (!isset($videoId) || !is_numeric($videoId)) {
        return false;
    }
    include_once '../include/database/credentials.php';
    $videoId = mysqli_real_escape_string($db, $videoId);
    $query = "SELECT c.id, c.comment, u.id AS user_id, u.username 
              FROM comments c 
              JOIN users u ON c.user_id = u.id 
              WHERE c.video_id = $videoId";
    $result = mysqli_query($db, $query);
    if (!$result) {
        mysqli_close($db);
        echo json_encode(['status' => 'error', 'message' => 'No comments found']);
        return false;
    }
    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
    mysqli_close($db);
    echo json_encode(['status' => 'success', 'comments' => $comments]);
    return true;
}