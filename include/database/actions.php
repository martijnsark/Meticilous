<?php

/** @var mysqli $db */
//executes a select query only and returns the results as an associative array
function dbQuery($query): array
{
    global $db;

    $result = mysqli_query($db, $query)
    or die('Error ' . mysqli_error($db) . ' with query ' . $query);

    $results = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

    mysqli_close($db);

    if (mysqli_num_rows($result) == 0) {
        return [];
    }

    return $results ?? [];
}


// test
//include_once 'credentials.php';
//$test = dbQuery("UPDATE videos SET shares = shares + 1 WHERE id = 1");
//print_r($test);
