<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>¡WARNING!</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/jumpscare.css">
</head>
<body>

<div class="login-wrapper">
    <div class="login-container">
        <img class="logo" src="../images/logo.png" alt="logo">
        <h1>¡W@RNING!</h1>
        <p>You've shared your: location, camera & microphone</p>

        <div class="back-container">
            <a href="../index.php" class="back-button">
                <a href="https://nordsecurity.com/blog/app-permissions-you-should-avoid-giving" class="back-button">
                </a>
        </div>
    </div>
</div>

<!--earrape-->
<audio id="bg-sound" autoplay loop>
    <source src="../sound/earrapesound.mp3" type="audio/mpeg">
</audio>

<script>
    // automatisch afspelen
    window.addEventListener("load", () => {
        const audio = document.getElementById("bg-sound");
        audio.volume = 0.7;
        audio.play().catch(err => {
            console.warn("Autoplay geblokkeerd, wacht op eerste klik:", err);
            document.body.addEventListener("click", () => {
                audio.play();
            }, {once: true});
        });
    });
</script>

</body>
</html>


