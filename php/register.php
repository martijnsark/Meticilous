<?php
if (isset($_POST['submit'])) {
    /** @var mysqli $db */
    require_once "includes/database.php";
    $errors = array();
    // Get form data
    $email = mysqli_escape_string($db, $_POST['email']);
    $firstName = mysqli_escape_string($db, $_POST['first_name']);
    $lastName = mysqli_escape_string($db, $_POST['last_name']);
    $password = mysqli_escape_string($db, $_POST['password']);

    // Server-side validation
    if ($email == "") {
        $errors['email'] = "Please enter an email.";
    }
    if ($firstName == "") {
        $errors['first_name'] = "Please enter a firstname.";
    }
    if ($lastName == "") {
        $errors['last_name'] = "Please enter a lastname.";
    }
    if ($password == "") {
        $errors['password'] = "Please enter a password.";
    }
    // If data valid
    // Check if the email is already in use
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Email is already in use
        $errors['email'] = "This email is already registered.";
    } elseif (empty($errors)) {
        // create a secure password, with the PHP function password_hash()
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // store the new user in the database.

        $insertQuery = "INSERT INTO `users`(`id`, `email`, `password`, `first_name`, `last_name`) 
          VALUES ('','$email','$hashedPassword','$firstName','$lastName')";

        if (mysqli_query($db, $insertQuery)) {
            // Redirect to login page
            header('location: login.php');
            // Exit the code
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h2>Register</h2>

<form class="column is-6" action="" method="post">

    <!-- First name -->
    <label for="first_name">First name</label>
    <input id="first_name" type="text" name="first_name" value="<?= $firstName ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['first_name'] ?? '' ?></p>

    <!-- Last name -->
    <label for="last_name">Last name</label>
    <input class="input" id="last_name" type="text" name="last_name" value="<?= $lastName ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['last_name'] ?? '' ?></p>

    <!-- Email -->
    <label for="email">Email</label>
    <input class="input" id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['email'] ?? '' ?></p>

    <!-- Password -->
    <label for="password">Password</label>
    <input class="input" id="password" type="password" name="password"/>
    <span><i></i></span>
    <p><?= $errors['password'] ?? '' ?></p>

    <!-- Submit -->
    <button type="submit" name="submit">Register</button>

    <a href="login.php">Login</a>

</form>

</body>
</html>
