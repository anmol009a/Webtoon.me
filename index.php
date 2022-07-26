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
        <div class="post-listing row row-cols-6">
            <!--  -->
            <?php
            include "webtoon_grid.php";
            ?>
        </div>
    </div>

    <?php include "partials/_footer.php"; ?>
</body>

</html>