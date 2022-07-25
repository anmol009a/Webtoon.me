<?php
include "partials/_dbconnect.php";

$noresults = true;

$searchString = $_GET['s'];

$website_url = 'https://www.webtoon.xyz/read/';


$sql = "SELECT * FROM `webtoons` WHERE `title` LIKE '%$searchString%' ORDER BY `lastUpdated` DESC LIMIT 6";
$result = mysqli_query($conn, $sql);

echo '<ul class="list-group">';
while ($row = mysqli_fetch_assoc($result)) {
    $webtoon_title = $row['title'];
    $noresults = false;

    $webtoon_url = $website_url . str_replace(" ", "-", $webtoon_title) . '/';


    // Display the search result
    echo '<li class="search-item">
            <a href="' . $webtoon_url . '" class="text-decoration-none text-reset" target="_blank">
                <div class="py-1 px-2">' . $webtoon_title . '</div>
            </a>
        </li>';
}

if ($noresults) {
    echo '<li class="search-item">
                    No webtoons found
                </li>';
}
echo '</ul>';