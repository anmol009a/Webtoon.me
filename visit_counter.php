<?php
$visit = 1;
if(file_exists("counter.txt"))
{
 $fp = fopen("counter.txt", "r");
 $visit = fread($fp, 4);
 $visit = $visit + 1;
}
$fp = fopen("counter.txt", "w");
fwrite($fp, $visit);
// echo "Total Site Visits: " . $visit;
fclose($fp);