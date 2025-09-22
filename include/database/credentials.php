<?php

// General settings
$dbHost = "localhost";
$database = "prj_2025_2026_tle1_t2";
$dbUser = "prj_2025_2026_tle1_t2";
$dbPassword = "leimaoru";

$db = mysqli_connect($dbHost, $dbUser, $dbPassword, $database)
or die("Error: " . mysqli_connect_error());
