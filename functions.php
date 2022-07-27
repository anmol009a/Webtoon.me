<?php

function post_date_format($baseObject, $targetObject)
{
    $interval = date_diff($baseObject, $targetObject);    // Calculate the difference

    // interval format decider
    if ($interval->format('%d') > 8) {    // if days > 8, print date
        $interval = date_format($targetObject, "M d, Y");
    } elseif ($interval->format('%d') > 0) {    // calculate days
        $interval = $interval->format('%d days ago');
        echo "<br>";
    } elseif ($interval->format('%h')) {    // calculate hours
        $interval = $interval->format('%h hours ago');
    } elseif ($interval->format('%i')) {    // calculate minutes
        $interval = $interval->format('%i minutes ago');
    } else {    // calculate second
        $interval = $interval->format('%s seconds ago');
    }
    return $interval;
}

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
