<?php
include "partials/_dbconnect.php";


// -------------------------------------------------------------------------------
// if (isset($_GET['webtoon_offset'])) {
//     $webtoon_offset = $_GET['webtoon_offset'];
// } else {
//     $webtoon_offset = 0;
// }

// short hand to write above code
$webtoon_offset = isset($_GET['webtoon_offset']) ? $_GET['webtoon_offset'] : 0;

// $sql = "SELECT * FROM `webtoons`";
if ($webtoon_offset) {
    $sql = "SELECT * FROM `webtoons` ORDER BY `lastUpdated` DESC LIMIT 20 OFFSET $webtoon_offset";
    $result = mysqli_query($conn, $sql);
}





// loop to print webtoons
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['title'];
    $webtoon_chapter1 = (int)$row['chapters'];
    $webtoon_chapter2 = $webtoon_chapter1 - 1;
    $webtoon_source = $row['webtoon_url'];
    $webtoon_cover_source = $row['cover'];


    // ---------------------------------------------------------------------------------
    // DATE-TIME
    // DateTime.$lastUpdated = DateTime.Parse($row['lastUpdatd']);  ||| not works

    $lastUpdated = new DateTime($row['lastUpdated']);       // Last Updated || convert the string to a date variable
    $currentDate = new DATETIME(date("Y-m-d H:i:s"));     // Current Date

    $interval = $lastUpdated->diff($currentDate);   // Calculate the difference
    $interval = $interval->format('%a'); // +2 days  || very imp: this converts $interval of object type into string;


    if ($interval < 7) {

        echo '<div class="col">
        <div class="webtoon-card">
        <a href="" target="_blank"><img width="175" height="238" src="' . $webtoon_cover_source . '" class="card-img-top img-fluid" style="width: 160px; border-radius: 3px;" alt="..."></a>        <div class="card-body p-0">
        <h5 class="card-title fs-6 ms-1 py-2 fw-bold"><a href="' . $webtoon_source . '" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
        <a href="' . $webtoon_chapter1 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter1 . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
        <a href="' . $webtoon_chapter2 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter2 . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
        </div>
        </div>
        </div>';
    } elseif ($interval < 7) {

        echo '<div class="col">
        <div class="webtoon-card">
            <a href="" target="_blank"><img width="175" height="238" src="' . $webtoon_cover_source . '" class="card-img-top img-fluid" style="width: 160px; border-radius: 3px;" alt="..."></a>        <div class="card-body p-0">
            <h5 class="card-title fs-6 ms-1 py-2 fw-bold"><a href="' . $webtoon_source . '" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
            <a href="' . $webtoon_chapter1 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter1 . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
            <a href="' . $webtoon_chapter2 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter2 . '</a>
            </div>
        </div>
        </div>';
    } else {
        echo '<div class="col">
        <div class="webtoon-card">
            <a href="" target="_blank"><img width="175" height="238" src="' . $webtoon_cover_source . '" class="card-img-top img-fluid" style="width: 160px; border-radius: 3px;" alt="..."></a>        
            <div class="card-body p-0">
            <h5 class="card-title fs-6 ms-1 py-2 fw-bold">
            <a href="' . $webtoon_source . '" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
            <a href="' . $webtoon_chapter1 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter1 . '</a>
            <a href="' . $webtoon_chapter2 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter2 . '</a>
            </div>
        </div>
        </div>';
    }
}
