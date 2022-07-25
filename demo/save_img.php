<?php

$url = 'https://reaperscans.com/wp-content/uploads/2022/05/Ending_Maker-1.jpg';
$img_path = "img/pop.jpg";

// Function to write image into file
if (file_put_contents($img_path, file_get_contents($url))) {
    echo "File downloaded! : $img_title";
    echo "<br>";
} else {
    echo "Failed $url";
    echo "<br>";
}
