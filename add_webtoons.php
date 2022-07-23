<?php
include "partials/_dbconnect.php";

$file_name = 'reaperscans.com';
// ---------------------------------------------------------------------
$fptr = fopen($file_name, "r");  // opening file in read mode
$content = fread($fptr, filesize($file_name));   // reading contents of the file
fclose($fptr);  // closing file

$regex = '/title="([\w\W]{3,50})">[\s]<img width="[\d]*" height="[\d]*" data-src="(https:\/\/reaperscans\.com\/wp-content\/uploads\/[\w\W]{10,40}\.[\w]{3,4})[\w\W]{10,800}<h3 class="h5">[\s]*<a href="(https:\/\/reaperscans\.com\/series\/[\w-]{3,50}\/)/';

// title and webtoon link
// <h3 class="h5">[\s]*<a href="(https:\/\/reaperscans\.com\/series\/[\w-]{3,50}\/)">

// webtoon cover and title
// /title="([\w\W]{3,50})">[\s]<img width="[\d]*" height="[\d]*" data-src="(https:\/\/reaperscans\.com\/wp-content\/uploads\/[\w\W]{10,40}\.[\w]{3,4})"/

// title, cover, link
// /title="([\w\W]{3,50})">[\s]<img width="[\d]*" height="[\d]*" data-src="(https:\/\/reaperscans\.com\/wp-content\/uploads\/[\w\W]{10,40}\.[\w]{3,4})[\w\W]{10,800}<h3 class="h5">[\s]*<a href="(https:\/\/reaperscans\.com\/series\/[\w-]{3,50}\/)/gm


if (preg_match_all($regex, $content, $matches)) {

    // ===================================================
    for ($i = 0; $i < count($matches[0]); $i++) {
        $webtoon_title = $matches[1][$i];
        $webtoon_cover = $matches[2][$i];
        $webtoon_link = $matches[3][$i];

        $sql = "INSERT INTO `webtoons` (`w_title`, `w_link`, `w_cover`) VALUES ('$webtoon_title', '$webtoon_link', '$webtoon_cover')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Updated: " . $webtoon_title;
            echo "<br>";
        } else {
            echo "Failed: " . $webtoon_title . " || " . mysqli_error($conn);
            echo "<br>";
        }
    }
} else {
    echo "none";
    echo "<br>";
}
