<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.json" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/video.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="js/main.js" defer></script>
    <title>Meticulous</title>
</head>

<body>

    <?php
    // list with all video's
    $videos = [
        "video1.mp4",
        "video2.mp4",
        "video3.mp4",
        "video4.mp4",
        "video5.mp4",
        "video6.mp4",
        "video7.mp4",
        "video8.mp4",
        "video9.mp4",
        "video10.mp4",
        "video11.mp4",
        "video12.mp4",
        "video13.mp4",
        "video14.mp4",
        "video15.mp4",
        "video16.mp4",
        "video17.mp4",
        "video18.mp4",
        "video19.mp4",
        "video20.mp4",
        "video21.mp4",
        "video22.mp4",
        "video23.mp4",
        "video24.mp4",
        "video25.mp4",
        "video26.mp4",
        "video27.mp4",
        "video28.mp4",
        "video29.mp4",
        "video30.mp4",
        "video31.mp4",
        "video32.mp4",
        "video33.mp4",
        "video34.mp4",
        "video35.mp4",
        "video36.mp4",
        "video37.mp4",
        "video38.mp4",
        "video39.mp4",
        "video40.mp4",
        "video41.mp4",
        "video42.mp4",
    ];

    shuffle($videos);

    ?>

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
  
<div class="app__videos">
    <?php foreach ($videos as $index => $video): ?>
        <div class="video" id="video-<?php echo $index+1; ?>">
            <video class="video__player"
                   playsinline
                   preload="metadata"
                   loop
                   src="https://github.com/martijnsark/Meticilous/raw/refs/heads/main/videos/<?php echo $video; ?>">
            </video>

                <!-- sidebar -->
                <div class="videoSidebar">
                    <div class="videoSidebar__button">
                        <span class="material-icons"> favorite_border </span>
                        <p>12</p>
                    </div>

                    <div class="videoSidebar__button">
                        <span class="material-icons"> message </span>
                        <p>23</p>
                    </div>

                    <div class="videoSidebar__button save-button">
                        <span class="material-icons"> bookmark_border </span>
                        <p>Save</p>
                    </div>

                    <div class="videoSidebar__button">
                        <span class="material-icons"> share </span>
                        <p>75</p>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
</div>

    <dialog id="location-popup" class="hidden">
        <p id="location-text"></p>
        <button id="close-location-popup">CLOSE</button>
    </dialog>

</body>

</html>