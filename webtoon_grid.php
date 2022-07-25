<?php
include "partials/_dbconnect.php";

// $sql = "SELECT * FROM `webtoons`";
$sql = "SELECT * from `webtoons` ORDER BY `updated_on` DESC LIMIT 20";
$result = mysqli_query($conn, $sql);


// loop to print webtoons
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['w_title'];
    $webtoon_cover = $row['w_cover'];
    $webtoon_link = $row['w_link'];
    $webtoon_id = $row['w_id'];

    // fetching chapter details
    $sql2 = "SELECT * FROM `chapters` WHERE `w_id`='$webtoon_id' ORDER BY `c_id` DESC LIMIT 2";
    $result2 = mysqli_query($conn, $sql2);
    for ($i = 0; $i < 2; $i++) {
        $row2 = mysqli_fetch_assoc($result2);
        $chapter_no[$i] = $row2['c_no'];
        $chapter_link[$i] = $row2['c_link'];

        // ---------------------------------------------------------------------------------
        // DATE-TIME
        $c_posted_on[$i] = new DateTime($row2['c_posted_on']);  // Last Updated || convert the string to a date variable
        $current_date = new DATETIME(date("Y-m-d H:i:s"));  // Current Date
        $interval[$i] = date_diff($c_posted_on[$i], $current_date);    // Calculate the difference
        $interval[$i] = $interval[$i]->format('%r%a days'); // this converts $interval[$i] of object(class) type into string;
    }

    // code to display webtoons
    echo '<div class="post-item-details col mb-5">
    <div class="container-post-img">
        <a href="' . $webtoon_link . '" target="_blank" title="' . $webtoon_title . '">
            <img class="post-img" src="' . $webtoon_cover . '" alt="' . $webtoon_title . '">
        </a>
    </div>
    <div class="post-details">
        <div class="container-post-title mt-2">
            <h5 class="post-title"><a href="' . $webtoon_link . '" target="_blank">' . $webtoon_title . '</a></h5>
        </div>
    </div>
    <div class="chapter-list">
        <div class="chapter-item mt-2">
            <span class="chapter-btn">
                <a href="' . $chapter_link[0] . '" target="_blank"><button type="button"
                        class="btn btn-outline-dark">Chapter '
        . $chapter_no[0] . '</button></a>
            </span>
            <span class="post-on">' . $interval[0] . '</span>
        </div>
        <div class="chapter-item mt-2">
            <span class="chapter-btn">
                <a href="' . $chapter_link[1] . '" target="_blank">
                    <button type="button" class="btn btn-outline-dark">Chapter ' . $chapter_no[1] . '</button>
                </a>
            </span>
            <span class="post-on">' . $interval[1] . '</span>
        </div>
    </div>
</div>';
}
