<?php

$path = "img/";
$file_name = 'reaperscans.com';

// ---------------------------------------------------------------------
$fptr = fopen($file_name, "r");  // opening file in read mode
$content = fread($fptr, filesize($file_name));   // reading contents of the file
fclose($fptr);  // closing file


$regex = '/title="([\w\W]{3,50})">[\s]<img width="[\d]*" height="[\d]*" data-src="(https:\/\/reaperscans\.com\/wp-content\/uploads\/[\w\W]{10,40}(\.[\w]{3,4}))/';

if (preg_match_all($regex, $content, $matches)) {

    // ===================================================
    for ($i = 0; $i < count($matches[0]); $i++) {
        $img_title = $matches[1][$i];
        $url = $matches[2][$i];
        $img_ext = $matches[3][$i];

        // Function to write image into file
        if (file_put_contents($path . $img_title . $img_ext, file_get_contents($url))) {
            echo "File downloaded!";
            echo "<br>";
        } else {
            echo "Failed";
            echo "<br>";
        }
    }
} else {
    echo "none";
    echo "<br>";
}
