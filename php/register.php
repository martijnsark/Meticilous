<?php
/** @var mysqli $db */
require_once '../include/database/credentials.php';

if (isset($_POST['submit'])) {
    $errors = array();
    // Get form data
    $email        = mysqli_escape_string($db, $_POST['email']);
    $firstName    = mysqli_escape_string($db, $_POST['first_name']);
    $lastName     = mysqli_escape_string($db, $_POST['last_name']);
    $password     = mysqli_escape_string($db, $_POST['password']);
    $username     = mysqli_escape_string($db, $_POST['username']);
    $phoneNumber  = mysqli_escape_string($db, $_POST['phone_number']);
    $postcode     = mysqli_escape_string($db, $_POST['postcode']);
    $address       = mysqli_escape_string($db, $_POST['address']);
    $addressNumber = mysqli_escape_string($db, $_POST['address_number']);
    $city         = mysqli_escape_string($db, $_POST['city']);
    $dna          = mysqli_escape_string($db, $_POST['dna']);
    $bank_number  = mysqli_escape_string($db, $_POST['bank_number']);
    $bsn_number   = mysqli_escape_string($db, $_POST['bsn_number']);

    // Server-side validation
    if ($email == "")     { $errors['email']      = "Please enter an email."; }
    if ($firstName == "") { $errors['first_name'] = "Please enter a firstname."; }
    if ($lastName == "")  { $errors['last_name']  = "Please enter a lastname."; }
    if ($password == "")  { $errors['password']   = "Please enter a password."; }
    if ($username == "")  { $errors['username']   = "Please enter a username."; }


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
        $insertQuery = "INSERT INTO `users`
            (`email`, `password`, `first_name`, `last_name`, `username`,
             `phone_number`, `postcode`, `address`, `address_number`,
             `city`, `dna`, `bank_number`, `bsn_number`)
            VALUES (
                '$email',
                '$hashedPassword',
                '$firstName',
                '$lastName',
                '$username',
                " . ($phoneNumber  !== '' ? "'$phoneNumber'"  : "NULL") . ",
                " . ($postcode     !== '' ? "'$postcode'"     : "NULL") . ",
                " . ($address      !== '' ? "'$address'"      : "NULL") . ",
                " . ($addressNumber!== '' ? "'$addressNumber'": "NULL") . ",
                " . ($city         !== '' ? "'$city'"         : "NULL") . ",
                " . ($dna          !== '' ? "'$dna'"          : "NULL") . ",
                " . ($bank_number  !== '' ? "'$bank_number'"  : "NULL") . ",
                " . ($bsn_number   !== '' ? "'$bsn_number'"   : "NULL") . "
            )";


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
    <label for="first_name">First name*</label>
    <input id="first_name" type="text" name="first_name" value="<?= $firstName ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['first_name'] ?? '' ?></p>

    <!-- Last name -->
    <label for="last_name">Last name*</label>
    <input class="input" id="last_name" type="text" name="last_name" value="<?= $lastName ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['last_name'] ?? '' ?></p>

    <!-- Email -->
    <label for="email">Email*</label>
    <input class="input" id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['email'] ?? '' ?></p>

    <!-- Password -->
    <label for="password">Password*</label>
    <input class="input" id="password" type="password" name="password"/>
    <span><i></i></span>
    <p><?= $errors['password'] ?? '' ?></p>

    <!-- username -->
    <label for="username">Username*</label>
    <input class="input" id="username" type="text" name="username" value="<?= $username ?? '' ?>"/>
    <span><i></i></span>
    <p><?= $errors['username'] ?? '' ?></p>

    <!-- Phone number -->
    <label hidden for="phone_number">Phone number</label>
    <input hidden class="input" id="phone_number" type="text" name="phone_number" value="<?= $phoneNumber ?? '' ?>"/>
    <span><i></i></span>

    <!-- Postcode -->
    <label hidden for="postcode">Postcode</label>
    <input hidden class="input" id="postcode" type="text" name="postcode" value="<?= $postcode ?? '' ?>"/>
    <span><i></i></span>

    <!-- Adress -->
    <label hidden for="address">Address</label>
    <input hidden class="input" id="address" type="text" name="address" value="<?= $address ?? '' ?>"/>
    <span><i></i></span>

    <!-- Adress number -->
    <label hidden for="address_number">Address number</label>
    <input hidden class="input" id="address_number" type="text" name="address_number" value="<?= $addressNumber ?? '' ?>"/>
    <span><i></i></span>

    <!-- City -->
    <label hidden for="city">City</label>
    <input hidden class="input" id="city" type="text" name="city" value="<?= $city ?? '' ?>"/>
    <span><i></i></span>

    <!-- Dna -->
    <label hidden for="dna">dna</label>
    <input hidden class="input" id="dna" type="text" name="dna" value="<?= $dna ?? '' ?>"/>
    <span><i></i></span>

    <!-- Bank number -->
    <label hidden for="bank_number">bank_number</label>
    <input hidden class="input" id="bank_number" type="text" name="bank_number" value="<?= $bank_number ?? '' ?>"/>
    <span><i></i></span>

    <!-- Bsn number -->
    <label hidden for="bsn_number">bsn_number</label>
    <input hidden class="input" id="bsn_number" type="text" name="bsn_number" value="<?= $bsn_number ?? '' ?>"/>
    <span><i></i></span>

    <!-- Submit -->
    <button type="submit" name="submit">Register</button>

    <a href="login.php">Login</a>

</form>

</body>
</html>
