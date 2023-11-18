<?php

// start session
session_start();

// check if it is a valid request
if ($_SERVER["REQUEST_METHOD"] != "POST" && !isset($_SESSION['loggedin'])) {
    // to-do
    exit();
}


// connect to database
require_once '../partials/_dbconnect.php';

// get data
$user_id = $_SESSION['user_id'];
$webtoon_id = $_POST['webtoon_id'];

// sql to insert user favourite webtoon
$sql = "INSERT INTO users_favourite_webtoon (user_id, webtoon_id)  VALUES ($user_id, $webtoon_id)";

try {
    // execute sql
    if (mysqli_query($conn, $sql)) {
        echo 'Bookmark Added!';
    }
} catch (\mysqli_sql_exception $exception) {
    echo $exception->getMessage();
}
