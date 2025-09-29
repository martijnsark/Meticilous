<?php
/** @var mysqli $db */

// required when working with sessions
session_start();
require_once '../include/database/credentials.php';

$login = false;
// Is user logged in?

if (isset($_POST['submit'])) {
    $errors = array();

    // Get form data
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Server-side validation
    if ($email === ""){
        $errors['email'] = "Enter an email";
    }
    if ($password === ""){
        $errors['loginFailed'] = "Enter a password";
    }

    // If data valid
// If data valid
    if (empty($errors)) {
        // SELECT the user from the database, based on the email address.
        $loginQuery = "SELECT * FROM users where email = '$email'";
        $result = mysqli_query($db, $loginQuery) or die('error: ' . mysqli_error($db));

        // check if the user exists
        if (mysqli_num_rows($result) != 1){
            header('Location: register.php');
            exit;
        }

        // Get user data from result
        $user = mysqli_fetch_assoc($result);

        // Check if the provided password matches the stored password in the database
        if (password_verify($password, $user['password'])){
            // Password is correct

            // Store the user in the session
            $_SESSION['user'] = $user; // Assuming user details are stored in session

            // Redirect to secure page
            header('Location: index.php');
            exit;
        } else {
            // Password is incorrect

            //error incorrect log in
            $errors['loginFailed'] = "Incorrect login credentials";
        }
    }

// User doesn't exist

//error incorrect log in
    $errors['loginFailed'] = "User does not exist or incorrect login credentials";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Blinker:wght@100;200;300;400;600;700;800;900&family=Lilita+One&family=Press+Start+2P&display=swap" rel="stylesheet">

    <title>Log in/Register Meticilous</title>
</head>
<body>

<div class="login-wrapper">
    <div class="login-container">
        <img src="/images/logo.png" alt="Logo" class="logo">

        <h2>Log in</h2>

        <?php if ($login) { ?>
            <p><a href="logout.php">Log out</a> / <a href="index.php">Home</a></p>
        <?php } else { ?>

            <form action="" method="post">

                <label for="email">E-mail:</label>
                <input class="input" id="email" type="text" name="email" value="<?= $email ?? '' ?>" />
                <span><i></i></span>
                <p class="error"><?= $errors['email'] ?? '' ?></p>

                <label for="password">Password:</label>
                <input class="input" id="password" type="password" name="password"/>
                <span><i></i></span>

                <?php if(isset($errors['loginFailed'])) { ?>
                    <div class="error">
                        <?=$errors['loginFailed']?>
                    </div>
                <?php } ?>

                <p class="error"><?= $errors['password'] ?? '' ?></p>

                <div class="actions">
                    <button type="submit" name="submit">Log in</button>
                    <span class="or">or</span>
                    <a class="register-link" href="register.php">Register</a>
                </div>

            </form>

        <?php } ?>
    </div>
</div>

</body>
</html>
