<?php
session_start();

// Setup connection with database
include_once 'include/database/credentials.php';
require_once 'include/database/actions.php';

$videoPath = 'videos/';

// fetch all videos from database
$videos = dbQuery("SELECT * FROM videos");

// Shuffle the videos array to display in random order
shuffle($videos);

// Check if the user is logged in
//if (!isset($_SESSION['users'])) {
//    header('Location: php/login.php');
//    exit;
//}

// Get user data from the SESSION
//$email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.json"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/video.css" type="text/css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <script src="js/main.js" defer></script>
    <script src="js/camera.js"></script>
    <title>Meticulous</title>
</head>

<body>


<header class="header">
    <a href="index.php">
        <img src="images/logo.png" alt="Meticulous Logo" class="logo">
    </a>

    <a href="settings.html">
        <img src="images/settings-icon.png" alt="Meticulous Settings icon" class="settings">
    </a>
</header>

<dialog>
    <p>Give some permissions to continue using Meticilous</p>
    <div>
        <button>Decline</button>
        <button style="background-color: green;"><strong>Show Permissions</strong></button>
    </div>
</dialog>

<!-- main part of the app -->
<div class="app__videos">
    <!--  for loop grabbing the video's from the shuffled list  -->
    <?php foreach ($videos

    as $index => $video): ?>
    <div class="video" id="video-<?= $video['id']; ?>">
        <!-- comments removed due to errors inside the video tag. -->
        <!-- video has to be played inline in the div -->
        <!-- no whitespace as cover image -->
        <!-- keeps looping video -->
        <video class="video__player" data-index="<?= $index + 1; ?>"
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

            <div class="videoSidebar__button save-button">
                <span class="material-icons"> bookmark_border </span>
                <p><?= $video['saves'] ?></p>
            </div>

            <div class="videoSidebar__button">
                <span class="material-icons"> share </span>
                <p><?= $video['shares'] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <dialog id="location-popup">
        <p id="location-text"></p>
        <button id="close-location-popup">CLOSE</button>
    </dialog>

</body>

</html>