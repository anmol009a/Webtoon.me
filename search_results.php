<!doctype html>
<html lang="en">

<head>
    <?php include './components/header.php'; ?>
</head>

<body>

    <!-- Navbar -->
    <?php include './components/navbar.php'; ?>

    <!-- Search Results -->
    <div class="container pt-2">
        <h2 class="text-center">Search Results</h2>
        <hr>
        <?php
        require_once __DIR__ . '/vendor/autoload.php';
        require_once 'config.php';

        use Anmol\Webtoon\Crud\WebtoonCrud;

        $searchString = $_GET['s'];

        // initialize crud operations
        $webtoon_crud = new WebtoonCrud(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

        // get webtoons data with chapters
        $webtoons = $webtoon_crud->searchWebtoon($searchString);

        if (isset($webtoons[0])) {
            include('components/webtoon_list.php');
        } else {
            echo 'No Webtoons found for <b>' . $searchString . '</b>';
        } ?>

    </div>

    <!-- footer -->
    <?php include './components/footer.php'; ?>
    <!-- JAVASCRIPT -->
</body>

</html>