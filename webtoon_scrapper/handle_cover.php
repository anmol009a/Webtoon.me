<?php
// $dir = "C:/xampp/htdocs/Webtoon.me/";
require_once DIR . "partials/_dbconnect.php";
require_once DIR . "functions.php";

// update covers
$stmt12  = $conn->prepare("UPDATE covers SET `cover_path` = ? WHERE `w_id` = ?");
$stmt12->bind_param("si", $img_path, $webtoon_id);


$sql = "SELECT * FROM `cover_details` WHERE cover_path IS NULL";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_id = $row['w_id'];
    $webtoon_title = $row['w_title'];
    $cover_url = $row['cover_url'];
    $cover_path = $row['cover_path'];


    if ($cover_url) {

        $img_name = preg_replace(['/[\s]/', '/[^\w-]/'], ["-", ""], $webtoon_title);
        $img_ext = '/\.(jpg|jpeg|png|webp|gif)/';

        preg_match($img_ext, $cover_url, $matches);
        $img_ext = $matches[0];
        $img_path = "img/" . $img_name . $img_ext;

        echo "<hr>";
        echo "Webtoon ID : $webtoon_id<br>";
        echo "Webtoon Title : $webtoon_title<br>";
        echo "Cover Url : $cover_url<br>";
        echo "Cover Path : $img_path<br>";


        save_img($cover_url, $webtoon_title, $img_path);
        // update cover details
        $stmt12->execute() or die($stmt12->error);
        
    }
}
