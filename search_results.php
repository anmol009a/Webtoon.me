<!doctype html>
<html lang="en">

<head>
    <?php include './partials/_header.php'; ?>
</head>

<body>

    <!-- Navbar -->
    <?php include './partials/_navbar.php'; ?>

    <!-- Search Results -->
    <div class="container pt-2">
        <h2 class="text-center">Search Results</h2>
        <hr>
        <!--  -->
        <div class="post-listing row row-cols-2 row-cols-md-4 row-cols-lg-6">
            <?php
            require_once './partials/_dbconnect.php';
            include_once './webtoon_crud_php/src/WebtoonCrud.php';
            include_once './functions.php';

            use WebtoonCrud\WebtoonCrud;

            $searchString = $_GET['s'];

            // initialize crud operations
            $webtoon_crud = new WebtoonCrud($conn);

            // get webtoons data with 2 chapters
            $webtoons = $webtoon_crud->search_webtoon($searchString, 30);


            if (isset($webtoons[0])) {
                // loop to print webtoons
                foreach ($webtoons as $webtoon) {
                    $webtoon_id     =   $webtoon->id;
                    $webtoon_title  =   $webtoon->title;
                    $webtoon_url    =   $webtoon->url;
                    $cover_url      =   $webtoon->cover_url;
                    $chapters       =   $webtoon->chapters;

                    // code to display webtoons
                    echo '
                    <div class="post-item-details col mb-5">
                        <div class="container-post-img">
                            <a href="' . $webtoon_url . '" target="_blank" title="' . $webtoon_title . '">
                                <img class="post-img" src="' . $cover_url . '" alt="' . $webtoon_title . '">
                            </a>
                        </div>
                        <div class="post-details">
                            <div class="container-post-title mt-2">
                                <h5 class="post-title">
                                    <a href="' . $webtoon_url . '" target="_blank">' . $webtoon_title . '
                                    </a>
                                </h5>
                            </div>
                            <div class="chapter-list">';

                    foreach ($chapters as $chapter) {
                        // ---------------------------------------------------------------------------------
                        $chapter_created_at = new DateTime($chapter->created_at);  // convert the string to a date variable
                        $current_date = new DATETIME("now");  // Current Date

                        $interval = post_date_format($current_date, $chapter_created_at);

                        echo '
                                <div class="chapter-item mt-2">
                                    <span>
                                        <a href="' . $chapter->url . '" target="_blank">
                                            <button type="button" class="btn btn-outline-dark chapter-btn overflow-hidden">Chapter' . $chapter->number . '</button>
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
            } else {
                echo "No Webtoons found for '$searchString'";
            }
            ?>
        </div>
    </div>
    
    <!-- footer -->
    <?php include './partials/_footer.php'; ?>
    <!-- JAVASCRIPT -->
    <?php include './js/_bootstrap_script.php'; ?>
</body>

</html>