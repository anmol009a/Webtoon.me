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

function download_file($url, $file_name)
{
    // Use file_get_contents() function to get the file
    // from url and use file_put_contents() function to
    // save the file by using basename
    if (file_put_contents($file_name, file_get_contents($url))) {
        echo "File downloaded successfully";
        echo "<br>";
    } else {
        echo "File downloading failed.";
        echo "<br>";
        echo "<br>";
    }
}

function open_file($file_name)
{
    // ---------------------------------------------------------------------
    $fptr = fopen($file_name, "r");  // opening file in read mode
    $content = fread($fptr, filesize($file_name));   // reading contents of the file
    fclose($fptr);  // closing file
    return $content;
}
