<?php

// Function to write image into file
$img = file_get_contents($img_url); // downloading img
$img_path = "img/" . $webtoon_title . $img_ext; // path and img name where img will be stored

if ($img) { //check if img link works

    if (file_put_contents($img_path, $img)) {   // storing img
        echo "Img Saved! : $webtoon_title";
        echo "<br>";
    } else {    // if img name contain special characters then name replaced by w_id
        // fetching last w_id
        $sql2 = "SELECT `w_id` FROM `webtoons` ORDER BY `webtoons`.`w_id` DESC LIMIT 1";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $webtoon_id = $row2['w_id'] + 1; //  increment wid 

        $img_path = "img/" . $webtoon_id . $img_ext;    // path and img name where img will be stored
        if (file_put_contents($img_path, $img)) {  // storing img
            echo "Img Saved! : $webtoon_title";
            echo "<br>";
        } else {
            echo "Failed to save img : $webtoon_title";
            echo "<br>";
        }
    }
} else {
    echo "Failed to download img : $webtoon_title";
    echo "<br>";
}