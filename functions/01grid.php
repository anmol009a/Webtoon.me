<?php

// ==========================================================
// reading img files in a directory
$webtoon_cover_dir = 'C:\xampp\htdocs\webtoonworld.xyz\img\cover\\';
$webtoon_covers = scandir($webtoon_cover_dir); // produces an array of files

$webtoon_cover_dir = 'img/cover/';
// img sizes
$webtoon_cover_sizes = ['-209x300.jpg', '-208x300.jpg', '-193x278.jpg', '-175x238.jpg', '-125x180.jpg', '-110x150.jpg',  '-110x150.jpg'];

$website_url = 'https://www.webtoon.xyz/read/';

// loop to print webtoons
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['title'];
    // slicing title if too large
    // if (strlen($webtoon_title) > 30) {
    //     $webtoon_title = substr($webtoon_title, 0, 32) . '...';
    // }

    // 
    $webtoon_chapter1 = (int)$row['chapters'];
    $webtoon_chapter2 = $webtoon_chapter1 - 1;

    // 
    $webtoon_url = $website_url . str_replace(" ", "-", $webtoon_title) . '/';
    $webtoon_chapter_url = $webtoon_url . 'chapter-';


    $webtoon_cover_title = str_replace(" ", "-", $webtoon_title);
    $webtoon_cover_source = $webtoon_cover_dir . $webtoon_cover_title . '-175x238.jpg';

    $k = 0;
    while ($k < count($webtoon_cover_sizes)) {

        if (in_array($webtoon_cover_title . $webtoon_cover_sizes[$k], $webtoon_covers, 0)) {
            $webtoon_cover_source = $webtoon_cover_dir . $webtoon_cover_title . $webtoon_cover_sizes[$k];
            $k = count($webtoon_cover_sizes);
        }
        $k++;
    }

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
        <a href="" target="_blank"><img src="' . $webtoon_cover_source . '" class="card-img-top img-fluid" style="width: 160px; border-radius: 3px;" alt="..."></a>        <div class="card-body p-0">
        <h5 class="card-title fs-6 ms-1 py-2 fw-bold"><a href="" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
        <a href="' . $webtoon_chapter1 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter1 . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
        <a href="' . $webtoon_chapter2 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter2 . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
        </div>
        </div>
        </div>';
    } elseif ($interval < 7) {

        echo '<div class="col">
        <div class="webtoon-card">
            <a href="" target="_blank"><img src="' . $webtoon_cover_source . '" class="card-img-top img-fluid" style="width: 160px; border-radius: 3px;" alt="..."></a>        <div class="card-body p-0">
            <h5 class="card-title fs-6 ms-1 py-2 fw-bold"><a href="" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
            <a href="' . $webtoon_chapter1 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter1 . '</a><span class="badge bg-danger ms-2 new-badge">New</span>
            <a href="' . $webtoon_chapter2 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter2 . '</a>
            </div>
        </div>
        </div>';
    } else {
        echo '<div class="col">
        <div class="webtoon-card">
            <a href="" target="_blank"><img src="' . $webtoon_cover_source . '" class="card-img-top img-fluid" style="width: 160px; border-radius: 3px;" alt="..."></a>        
            <div class="card-body p-0">
            <h5 class="card-title fs-6 ms-1 py-2 fw-bold">
            <a href="" class="text-decoration-none text-reset" target="_blank">' . $webtoon_title . '</a></h5>
            <a href="' . $webtoon_chapter1 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter1 . '</a>
            <a href="' . $webtoon_chapter2 . '/" class="btn btn-sm btn-secondary btn-chapter mb-1" target="_blank">Chapter ' . $webtoon_chapter2 . '</a>
            </div>
        </div>
        </div>';
    }
}
