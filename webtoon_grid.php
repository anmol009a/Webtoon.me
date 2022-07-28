<?php
include "partials/_dbconnect.php";
include "functions.php";


// fetching webtoon record if exits with w_id
$stmt = $conn->prepare("SELECT * FROM `chapters` WHERE `w_id`= ? ORDER BY `c_no` DESC LIMIT 2");
$stmt->bind_param("i", $webtoon_id);

// $sql = "SELECT * FROM `webtoons`";
$sql = "SELECT * from `webtoons` ORDER BY `last_mod` DESC LIMIT 30";
$result = mysqli_query($conn, $sql);

// loop to print webtoons
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['w_title'];
    $webtoon_cover = $row['w_cover'];
    $webtoon_link = $row['w_link'];
    $webtoon_id = $row['w_id'];

    // fetching chapter details
    $stmt->execute();
    $result2 = $stmt->get_result();
    for ($i = 0; $i < 2; $i++) {
        $row2 = $result2->fetch_assoc();
        $chapter_no[$i] = $row2['c_no'];
        $chapter_link[$i] = $row2['c_link'];

        // ---------------------------------------------------------------------------------
        $c_posted_on[$i] = new DateTime($row2['c_posted_on']);  // convert the string to a date variable
        $current_date = new DATETIME(date("Y-m-d H:i:s"));  // Current Date
        
        $interval[$i] = post_date_format($current_date,$c_posted_on[$i]);

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
            <span>
                <a href="' . $chapter_link[0] . '" target="_blank"><button type="button"
                        class="btn btn-outline-dark chapter-btn">Chapter '
        . $chapter_no[0] . '</button></a>
            </span>
            <span class="post-on">' . $interval[0] . '</span>
        </div>
        <div class="chapter-item mt-2">
            <span>
                <a href="' . $chapter_link[1] . '" target="_blank">
                    <button type="button" class="btn btn-outline-dark chapter-btn">Chapter ' . $chapter_no[1] . '</button>
                </a>
            </span>
            <span class="post-on">' . $interval[1] . '</span>
        </div>
    </div>
</div>';
}
