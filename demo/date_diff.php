<?php
// DATE-TIME
$date1 = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
$date2 = new DateTime('2022-07-29 01:56:41', new DateTimeZone('Asia/Kolkata'));

$interval = date_diff($date1, $date2);    // Calculate the difference
$interval = $interval->format('%r%h'); // very imp: this converts $interval of object type into string;
var_dump($date1);
echo "<br>";
var_dump($date2);
echo "<br>";
echo $interval;
echo "<br>";
