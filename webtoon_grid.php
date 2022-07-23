<?php
include "partials/_dbconnect.php";


// short hand to write above code
$webtoon_offset = isset($_GET['webtoon_offset']) ? $_GET['webtoon_offset'] : 0;

// $sql = "SELECT * FROM `webtoons`";
if ($webtoon_offset) {
    $sql = "SELECT * from webtoons ORDER BY `chapters`.`c_posted_on` DESC LIMIT 20 OFFSET $webtoon_offset";
    $result = mysqli_query($conn, $sql);
}

// loop to print webtoons
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['w_title'];
    $webtoon_cover = $row['w_cover'];
    $webtoon_link = $row['w_link'];
    $webtoon_id = $row['w_id'];

  
    $chapter_no[2];
    $chapter_link[2];

    $sql2= "SELECT * FROM `chapters` WHERE `w_id`='$webtoon_id' ORDER BY c_posted_on DESC LIMIT 2;";
    $result2 = mysqli_query($conn, $sql); 
    for($i = 0; $i<2; $i++){
        $row2 = mysqli_fetch_assoc($result2);
        $chapter_no[$i] = $row2['c_no'];
        $chapter_link[$i] = $row2['c_link'];
    }
    print_r($chapter_no);

    // ---------------------------------------------------------------------------------
    // DATE-TIME
    // DateTime.$updated_on = DateTime.Parse($row['lastUpdatd']);  ||| not works

    $updated_on = new DateTime($row['c_posted_on']);       // Last Updated || convert the string to a date variable
    $currentDate = new DATETIME(date("Y-m-d H:i:s"));     // Current Date

    $interval = $updated_on->diff($currentDate);   // Calculate the difference
    $interval = $interval->format('%a'); // +2 days  || very imp: this converts $interval of object type into string;


    if ($interval < 7) {

        echo '<div class="col">
        <div class="webtoon-card">
        <a href="" target="_blank"><img src="' . $webtoon_cover . '" class="card-img-top img-fluid cover-img" style="width: 160px; border-radius: 3px;" alt="..."></a>        <div class="card-body p-0">
        <h5 class="card-title fs-6 ms-1 py-2 fw-bold"><a href="' . $webtoon_link . '" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
        <a href="' . $chapter_link[0] . '" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $chapter_no[0] . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
        <a href="' .$chapter_no[1]. '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' .$chapter_no[1]. '</a><span class="badge bg-danger ms-2 new-badge">New</span>
        </div>
        </div>
        </div>';
    } elseif ($interval < 7) {

        echo '<div class="col">
        <div class="webtoon-card">
            <a href="" target="_blank"><img src="' . $webtoon_cover . '" class="card-img-top img-fluid cover-img" style="width: 160px; border-radius: 3px;" alt="..."></a>        <div class="card-body p-0">
            <h5 class="card-title fs-6 ms-1 py-2 fw-bold"><a href="' . $webtoon_link . '" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
            <a href="' . $chapter_link[0] . '" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $chapter_no[0] . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
            <a href="' .$chapter_link[1]. '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' .$chapter_no[1]. '</a>
            </div>
        </div>
        </div>';
    } else {
        echo '<div class="col">
        <div class="webtoon-card">
            <a href="" target="_blank"><img src="' . $webtoon_cover . '" class="card-img-top img-fluid cover-img" style="width: 160px; border-radius: 3px;" alt="..."></a>        
            <div class="card-body p-0">
            <h5 class="card-title fs-6 ms-1 py-2 fw-bold">
            <a href="' . $webtoon_link . '" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
            <a href="' . $chapter_link[0] . '" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $chapter_no[0] . '</a>
            <a href="' .$chapter_no[1]. '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' .$chapter_no[1]. '</a>
            </div>
        </div>
        </div>';
    }
}
