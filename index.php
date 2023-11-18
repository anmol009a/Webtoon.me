<?php
session_start();

?>

<!doctype html>
<html lang="en">

<head>
    <?php
    include "partials/_header.php";
    ?>
    <title>Webtoon World</title>
</head>

<body>
    <!-- Navbar -->
    <?php
    include "partials/_navbar.php";
    ?>

    <!-- about us -->
    <section class="container pt-5">
        <h2>Welcome to WebtoonWorld!</h2>
        <?php
        if (isset($_SESSION['loggedin'])) {
            echo "<p>You are logged in as <b>";
            echo $_SESSION['username'] . ".</b></p>";
        }
        ?>

        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Inventore maxime nobis expedita omnis facere aperiam consequuntur, excepturi, modi, porro natus hic amet odit facilis quasi labore alias! Sunt vero quisquam, laborum eum molestiae nemo in neque adipisci, suscipit maiores repellendus veritatis. Nisi reprehenderit officia ipsum facilis voluptatem ratione, quaerat praesentium!</p>
    </section>
    <!-- Latest Comics -->
    <div class="container pt-2">
        <h2 class="text-center">Latest Comics</h2>
        <hr>
        <!--  -->
        <div id="post-listing" class="row row-cols-2 row-cols-md-3 row-cols-lg-6">
            <!--  -->
            <?php
            include "webtoon_grid.php";
            ?>
        </div>

        <button id="load-more-btn" class="btn btn-dark w-100" type="button">Load More</button>

    </div>

    <!-- footer -->
    <?php include "partials/_footer.php"; ?>
</body>

<script src="js/script.js"></script>
<script src="js/add_to_favourite.js"></script>

</html>