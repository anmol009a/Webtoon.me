<?php
// ==========================================================
// reading img files in a directory
$webtoon_cover_dir = 'C:\xampp\htdocs\webtoonworld.xyz\img\cover\\';
$webtoon_covers = scandir($webtoon_cover_dir); // produces an array of files


$webtoon_cover_dir = 'img/cover/';
$webtoon_cover_sizes = ['-209x300.jpg', '-208x300.jpg', '-193x278.jpg', '-175x238.jpg', '-125x180.jpg', '-110x150.jpg',  '-110x150.jpg'];

// connecting to DB
include "../partials/_dbconnect.php";

// ---------------------------------------------------------------------------------------
$sql = "SELECT * FROM `webtoons` ORDER BY `lastUpdated` DESC";
$result = mysqli_query($conn, $sql);

// fetching data from DB
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['title'];

    $webtoon_cover_title = str_replace(" ", "-", $webtoon_title);

    $k = 0;
    while ($k < count($webtoon_cover_sizes)) {

        if (in_array($webtoon_cover_title . $webtoon_cover_sizes[$k], $webtoon_covers, 0)) {

            $webtoon_cover_source = $webtoon_cover_dir . $webtoon_cover_title . $webtoon_cover_sizes[$k];   // cover path
            echo $webtoon_cover_source;
            echo "<br>";

            // Inserting cover path into DB
            $sql = "UPDATE `webtoons` SET `cover` = '$webtoon_cover_source' WHERE `webtoons`.`title` = '$webtoon_title'";
            $result2 = mysqli_query($conn, $sql);

            if ($result2) {
                echo "Updated Cover: " . $webtoon_title;
                echo "<br>";
            } else {
                echo "Failed: " . $webtoon_title . " || " . mysqli_error($conn);
                echo "<br>";
            }
            $k = count($webtoon_cover_sizes);
        }
        $k++;
    }
}
