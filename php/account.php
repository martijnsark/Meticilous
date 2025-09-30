<?php
session_start();
require_once '../include/database/credentials.php';
require_once '../include/database/actions.php';

// Check of de gebruiker is ingelogd
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// User data
$user = $_SESSION['user'];
$userId = (int) $user['id'];
$videoPath = '../videos/';

// Haal alle opgeslagen video’s van deze gebruiker op
$sql = "SELECT v.* 
        FROM videos v
        INNER JOIN saves s ON v.id = s.video_id
        WHERE s.user_id = $userId";
$videos = dbQuery($sql);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account - Opgeslagen Video's</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <script src="../js/main.js" defer></script>
</head>
<body>

<header class="header">
    <a href="../index.php">
        <img src="../images/logo.png" alt="Meticulous Logo" class="logo">
    </a>
</header>
<h2>Saved videos from <?= htmlspecialchars($user['username']) ?></h2><br>
<!-- main part of the app -->
<div class="app__videos">
    <?php if (empty($videos)): ?>
        <p style="color:white; padding:20px;">Je hebt nog geen video’s opgeslagen.</p>
    <?php else: ?>
        <?php foreach ($videos as $index => $video): ?>
            <div class="video" id="video-<?= $video['id']; ?>">
                <video class="video__player"
                       data-index="<?= $index + 1; ?>"
                       playsinline
                       preload="metadata"
                       loop
                       src="<?= $videoPath . $video['filename']; ?>">
                </video>

                <!-- sidebar -->
                <div class="videoSidebar">
                    <div class="videoSidebar__button">
                        <span class="material-icons"> favorite_border </span>
                        <p><?= $video['likes'] ?></p>
                    </div>

                    <div class="videoSidebar__button">
                        <span class="material-icons"> message </span>
                        <p><?= $video['comments'] ?></p>
                    </div>

                    <div class="videoSidebar__button">
                        <span class="material-icons"> bookmark </span>
                        <p><?= $video['saves'] ?></p>
                    </div>

                    <div class="videoSidebar__button">
                        <span class="material-icons"> share </span>
                        <p><?= $video['shares'] ?></p>
                    </div>

                    <div class="videoSidebar__button account-button">
                        <a href="../index.php">
                            <span class="material-icons">arrow_back</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
