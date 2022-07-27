<?php

function post_date_format($baseObject, $targetObject)
{
    $interval = date_diff($baseObject, $targetObject);    // Calculate the difference

    // interval format decider
    if ($interval->format('%d') > 8) {    // if days > 8, print date
        $interval = date_format($targetObject, "M d, Y");
    } elseif ($interval->format('%d') < 8) {    // calculate days
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
