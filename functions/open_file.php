<?php
// ---------------------------------------------------------------------
$fptr = fopen($file_name, "r");  // opening file in read mode
$content = fread($fptr, filesize($file_name));   // reading contents of the file
fclose($fptr);  // closing file