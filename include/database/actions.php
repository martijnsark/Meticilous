<?php
include_once 'include/database/credentials.php';
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