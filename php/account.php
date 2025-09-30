<?php
session_start();

// check of iemand is ingelogd
if (!isset($_SESSION['user'])) {
    // niet ingelogd → terugsturen naar login
    header("Location: login.php");
    exit;
}

// je kan nu de data gebruiken
$username = $_SESSION['user'];
?>


<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Welkom, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>

</body>
</html>
