<?php
// DATE-TIME
$date1 = new DateTime();
$date2= new DateTime('now');

$interval=date_diff($date1,$date2);    // Calculate the difference
$interval = $interval->format('%r%a days'); // very imp: this converts $interval of object type into string;

echo $interval;