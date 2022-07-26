<?php

function save_img($img_url, $img_name, $img_path)
{
    $img = file_get_contents($img_url); // downloading img
    
    if ($img) { //check if img link works
        // Function to write image into file
        file_put_contents($img_path, $img);    // storing img
        echo "Img Saved! : $img_name";
        echo "<br>";
    } else {
        echo "Failed to download img : $img_name";
        echo "<br>";
    }
}
