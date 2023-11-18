<!doctype html>
<html lang="en">

<head>
    <?php include './component/header.php'; ?>
</head>

<body>

    <!-- Navbar -->
    <?php include './component/navbar.php'; ?>

    <!-- Search Results -->
    <div class="container pt-2">
        <h2 class="text-center">Search Results</h2>
        <hr>
        <!--  -->
        <div class="post-listing row row-cols-2 row-cols-md-4 row-cols-lg-6">
            <?php
            require_once __DIR__ . '/vendor/autoload.php';
            require_once 'config.php';

            use Anmol\Webtoon\Crud\WebtoonCrud;

            $searchString = $_GET['s'];

            // initialize crud operations
            $webtoon_crud = new WebtoonCrud(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

            // get webtoons data with 2 chapters
            $webtoons = $webtoon_crud->searchWebtoon($searchString);


            if (isset($webtoons[0])) {
                foreach ($webtoons as $webtoon)
                    include './component/webtoon.php';
            }
            else{
                echo 'No Webtoons found for <b>'.$searchString.'</b>';
            } ?>
        </div>
    </div>

    <!-- footer -->
    <?php include './component/footer.php'; ?>
    <!-- JAVASCRIPT -->
</body>

</html>