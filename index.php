<?php
require_once 'visit_counter.php';
require_once 'config.php';
?>

<!doctype html>
<html lang="en">

<head>
    <?php
    include "component/header.php";
    ?>
    <title>
        <?= WEBSITE_TITLE ?>
    </title>

</head>

<body>
    <!-- Navbar -->
    <?php
    include "component/navbar.php";
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

    <?php

    require_once 'config.php';
    require_once __DIR__ . '/vendor/autoload.php';

    use Anmol\Webtoon\Crud\WebtoonCrud;

    // create an object of WebtoonCrud Class
    $db = new WebtoonCrud(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);
    $webtoons = $db->getWebtoons();
    ?>
    <!-- Latest Comics -->
    <div class="container">
        <h2>Latest Webtoons</h2>
        <hr>
        <?php
        foreach ($webtoons as $webtoon)
            include './component/webtoon.php';
        ?>
    </div>

    <?php include "component/scroll_to_top_btn.php"; ?>

    <!-- footer -->
    <?php include "component/footer.php"; ?>
</body>


</html>