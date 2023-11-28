<?php
require_once 'visit_counter.php';
require_once 'config.php';
date_default_timezone_set(TIME_ZONE);
?>

<!doctype html>
<html lang="en">

<head>
    <?php
    include "components/header.php";
    ?>
    <title>
        <?= WEBSITE_TITLE ?>
    </title>

</head>

<body>
    <!-- Navbar -->
    <?php
    include "components/navbar.php";
    ?>

    <!-- about us -->
    <section class="container pt-5">
        <h2>Welcome to <?= WEBSITE_TITLE ?></h2>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Inventore maxime nobis expedita omnis facere
            aperiam consequuntur, excepturi, modi, porro natus hic amet odit facilis quasi labore alias! Sunt vero
            quisquam, laborum eum molestiae nemo in neque adipisci, suscipit maiores repellendus veritatis. Nisi
            reprehenderit officia ipsum facilis voluptatem ratione, quaerat praesentium!
        </p>
    </section>

    <!-- Latest Comics -->
    <div class="container overflow-hidden pb-5">
        <h2>Latest Webtoons</h2>
        <hr>
        <?php 
        require_once __DIR__ . '/vendor/autoload.php';
        use Anmol\Webtoon\Crud\WebtoonCrud;
    
        // create an object of WebtoonCrud Class
        $db = new WebtoonCrud(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $webtoons = $db->getWebtoons();
        include('components/webtoon_list.php');?>
    </div>

    <?php include "components/scroll_to_top_btn.php"; ?>

    <!-- footer -->
    <?php include "components/footer.php"; ?>
</body>


</html>