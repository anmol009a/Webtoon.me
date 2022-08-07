<!doctype html>
<html lang="en">

<head>
    <?php
    include "partials/_header.php";
    ?>
</head>

<body>
    <!-- Navbar -->
    <?php
    include "partials/_navbar.php";
    ?>

    <!-- Latest Comics -->
    <div class="container pt-2">
        <h2 class="text-center">Latest Comics</h2>
        <hr>
        <!--  -->
        <div class="post-listing row row-cols-2 row-cols-md-4 row-cols-lg-6">
            <!--  -->
            <?php
            include "webtoon_grid.php";
            ?>
        </div>

        <a href="index.php" id="load-more-btn" class="btn btn-outline-dark" type="submit" name="p" value="1">Load More</a>

    </div>

    <?php include "partials/_footer.php"; ?>
</body>

</html>