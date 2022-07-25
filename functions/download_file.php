<?php

$url = 'https://reaperscans.com/latest-comic/';

 // Use basename() function to return the base name of file
 $file_name = basename($url);

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
