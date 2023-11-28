<?php
function timeElapsedString(DateTime $from_timestamp, DateTime $to_timestamp = null): string
{
    
    if ($to_timestamp === null) {
        $to_timestamp = new DateTime();
    }

    $interval = $to_timestamp->diff($from_timestamp); // Calculate the difference

    // Interval format decision
    if ($interval->days > 8) {
        // If days > 8, print date
        $formattedInterval = date_format($to_timestamp, "M d, Y");
    } elseif ($interval->days > 0) {
        // Calculate days
        $formattedInterval = $interval->days ==1? $interval->format('%d day ago'):$interval->format('%d days ago');
    } elseif ($interval->h > 0) {
        // Calculate hours
        $formattedInterval = $interval->h ==1?$interval->format('%h hour ago'):$interval->format('%h hours ago');
    } elseif ($interval->i > 0) {
        // Calculate minutes
        $formattedInterval = $interval->i == 1?$interval->format('%i minute ago'):$interval->format('%i minutes ago');
    } else {
        // Calculate seconds
        $formattedInterval =  $interval->format('%s seconds ago');
    }
    return $formattedInterval;
}
