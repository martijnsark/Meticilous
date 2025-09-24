<?php
// eventueel je eigen PHP code bovenin
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Selfie maken</title>
    <script src="../js/main.js"></script>
</head>
<body>

<h1>Selfie maken</h1>

<video id="video" autoplay playsinline></video>
<button onclick="maakSelfie()">📸 Foto maken</button>
<canvas id="canvas" style="display:none;"></canvas>
<img id="snapshot" alt="Jouw foto" />

</body>
</html>
