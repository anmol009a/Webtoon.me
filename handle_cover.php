<?php
require_once "partials/_dbconnect.php";
require_once "functions.php";


$sql = "SELECT * FROM `cover_details`";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_id = $row['w_id'];
    $webtoon_title = $row['w_id'];
    $cover_url = $row['cover_url'];
    $cover_path = $row['cover_path'];

    if (!$cover_path) {
        $img_ext = '/.[\w]{3,4}/';
        $img_ext = preg_match($img_ext, $cover_url, $matches);
        $cover_path = "img/" . $webtoon_title . $img_ext;
        save_img($cover, $webtoon_title, $cover_path);
    }

    echo "<hr>";
    echo "Webtoon ID : $webtoon_title<br>";
    echo "Webtoon Title : $webtoon_title<br>";
    echo "Cover Url : $webtoon_title<br>";
    echo "Cover Path : $webtoon_title<br>";
}
