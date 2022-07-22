<!doctype html>
<html lang="en">

<head>
    <?php include 'partials/_header.php'; ?>
</head>

<body id="body-theme" class="bg-dark text-light">

    <!-- Navbar -->
    <?php include 'partials/_navbar.php'; ?>


    <div id="box" class="container my-3">
        <!-- Welcome Message -->
        <h2>Welcome to WebtoonWorld</h2>
        <hr>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi natus quaerat sed iusto laborum placeat
            numquam velit deserunt provident porro pariatur blanditiis accusamus eveniet officiis a, quia soluta officia
            suscipit nam nulla? Aliquid debitis, architecto odit minima tenetur accusamus pariatur?</p>

        <!--  -->
        <h2 class="d-inline">Updated Webtoons</h2>
        <hr>

        <!-- webtoons grid -->
        <div id="webtoon-container" class="row row-cols-2  row-cols-md-4 row-cols-xl-4">
            <?php
            // $sql = "SELECT * FROM `webtoons`";
            $sql = "SELECT * FROM `webtoons` ORDER BY `updated_on` DESC LIMIT 20";
            $result = mysqli_query($conn, $sql);

            // 
            include 'webtoon_grid.php';

            ?>

        </div>



    </div>


    <div class="d-grid gap-2">
        <button id="loadMoreBtn" class="btn btn-success" type="button">Load More</button>
    </div>


    <!-- footer -->
    <?php include 'partials/_footer.php'; ?>

    <script>
        {
            async function getWebtoons(webtoonType) {
                // console.log('Inside getWebtoons function');
                const response = await fetch(webtoonType);
                // console.log('before response');
                const webtoons = await response.text();
                // document.getElementById("webtoon-container").innerHTML = webtoons;
                return webtoons;
            }

            // ---------------------------------
            // first time webtoon loader
            // a = getWebtoons(`webtoon_grid.php`);
            // a.then(webtoons => document.getElementById("webtoon-container").innerHTML += webtoons)

            // load more btn handler
            let webtoon_offset = 20;
            let loadMoreBtn = document.getElementById('loadMoreBtn');
            loadMoreBtn.addEventListener('click', loadMoreBtnHandler);

            function loadMoreBtnHandler() {
                console.log('You have clicked the loadMoreBtn');
                a = getWebtoons(`webtoon_grid.php?webtoon_offset=${webtoon_offset}`);
                a.then(webtoons => document.getElementById("webtoon-container").innerHTML += webtoons)
                webtoon_offset += 20;

            }
        }
    </script>

</body>

</html>