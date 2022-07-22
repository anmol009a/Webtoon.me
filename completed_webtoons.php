<?php
include 'partials/_dbconnect.php';
?>

<!doctype html>
<html lang="en">

<head>
    <?php include 'partials/_header.php'; ?>
</head>

<body id="body-theme" class="bg-dark text-light">

    <!-- Navbar -->
    <?php include 'partials/_navbar.php'; ?>

    <div class="container my-3">
        
        <!--  -->
        <h2 class="d-inline">Completed Webtoons</h2>
        <hr>
        <!-- webtoons grid -->
        <div class="row row-cols-2  row-cols-md-4 row-cols-xl-6">
            <?php
            // $sql = "SELECT * FROM `webtoons`";
            $sql = "SELECT * FROM `webtoons` where `webtoons`.`completed`= '1' ORDER BY `lastUpdated` DESC";
            $result = mysqli_query($conn, $sql);

            // 
            include 'webtoon_grid.php';

            ?>

        </div>
    </div>

    <!-- footer -->
    <?php include 'partials/_footer.php'; ?>

    <!-- JAVASCRIPT -->
    <?php include 'js/_bootstrap_script.php'; ?>

</body>

</html>