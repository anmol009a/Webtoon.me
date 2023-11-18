<?php
// set timezone
date_default_timezone_set("Asia/Kolkata");

require_once __DIR__ . '/vendor/autoload.php';

use Anmol\WebtoonCrud\WebtoonCrud;

include './functions.php';

// connect to db
include './partials/_dbconnect.php';

// pagination
$offset = isset($_GET['p']) ? $_GET['p'] * 30 : 0;

// initialize crud operations
$webtoon_crud = new WebtoonCrud($conn);

// get webtoons data with 2 chapters
$webtoons = $webtoon_crud->get_webtoons(30, $offset);

// loop to print webtoons
foreach ($webtoons as $webtoon) {
    $webtoon_id     =   $webtoon->id;
    $webtoon_title  =   $webtoon->title;
    $webtoon_url    =   $webtoon->url;
    $cover_url      =   $webtoon->cover_url;

    // code to display webtoons
    echo '
        <div id="w-' . $webtoon->id . '" class="post-item-details col mb-5">
            <div class="container-post-img">';
    if (isset($_SESSION['loggedin'])) {
        echo '
                <button id="btn-' . $webtoon->id . '" onclick="addToFavourite(this.id)" type="button" class="badge bg-success position-absolute">Fav</button>';
    }

    echo '
                <a href="' . $webtoon->url . '" target="_blank" title="' . $webtoon->title . '">
                        <img class="post-img" src="' . $cover_url . '" alt="' . $webtoon->title . '">
                </a>
            </div>
            <div class="post-details">
                <div class="container-post-title mt-2">
                    <h5 class="post-title">
                        <a href="' . $webtoon->url . '" target="_blank">' . $webtoon->title . '
                        </a>
                    </h5>
                </div>
                <div class="chapter-list">';


    foreach ($webtoon->chapters as $chapter) {
        // ---------------------------------------------------------------------------------
        // to-do - correctly dislay time
        $chapter_created_at = new DateTime($chapter->created_at);  // convert the string to a date variable
        $current_date = new DATETIME("now");  // Current Date

        $interval = post_date_format($current_date, $chapter_created_at);

        echo '
                    <div class="chapter-item mt-2">
                        <span>
                            <a href="' . $chapter->url . '" target="_blank">
                                <button type="button" class="btn btn-outline-dark chapter-btn overflow-hidden">Chapter ' . $chapter->number . '</button>
                            </a>
                        </span>
                        <span class="post-on d-block">' .  $interval . '</span>
                    </div>';
    }


    echo '
                </div>
            </div>
        </div>';
}
