<?php
include "partials/_dbconnect.php";
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

        <?php

        /*
        // Initialize a file URL to the variable
        // $url = 'https://www.webtoon.xyz/';   // dont works

        // $url = 'https://reaperscans.com/';  // works
        // https://reaperscans.com/series/the-great-mage-that-returned-after-4000-years
        // https://reaperscans.com/series/the-great-mage-that-returned-after-4000-years/chapter-101/

        // $url = 'https://asurascans.com/';    // dont works
        // https://www.asurascans.com/comics/the-first-order/
        // https://www.asurascans.com/the-first-order-chapter-19/

        // https://zeroscans.com/
        // https://zeroscans.com/comics/204586-omniscient-readers-point-of-view
        // https://zeroscans.com/comics/204586-omniscient-readers-point-of-view/1/14

        // https://alpha-scans.org/
        // https://alpha-scans.org/manga/trapped-in-a-webnovel-as-a-good-for-nothing/
        // https://alpha-scans.org/tower-of-god-chapter-516/
        */

        $url = ['https://reaperscans.com/', 'https://zeroscans.com/', 'https://alpha-scans.org/'];

        foreach ($url as $key) {

            // Use basename() function to return the base name of file
            $file_name = basename($key);

            // Use file_get_contents() function to get the file
            // from url and use file_put_contents() function to
            // save the file by using base name
            if (file_put_contents($file_name, file_get_contents($key))) {
                echo "File downloaded successfully";
                echo "<br>";
            } else {
                echo "File downloading failed.";
                echo "<br>";
            }

            // ---------------------------------------------------------------------
            $fptr = fopen($file_name, "r");  // opening file in read mode
            $content = fread($fptr, filesize($file_name));   // reading contents of the file
            fclose($fptr);  // closing file

            // ------------------------------------------------------------------------------------------------
            // $regex = "/https\:\/\/asurascans.com\/comics\/([a-z \-]{3,50})\//"; // used grouping to seperate title || returns grouped str at 1 index
            // $regex = ["/(https\:\/\/reaperscans.com\/series\/([a-z \-]{3,50}))\/chapter-([0-9]{1,3})/",];
            // $regex = "/https\:\/\/zeroscans.com\/comics\/([0-9]{1,9})([a-z -]{3,90})/"; // used grouping to seperate title || returns grouped str at 1 index
            // $regex = "/https\:\/\/alpha-scans.org\/manga\/([a-z -]{3,50})/"; // used grouping to seperate title || returns grouped str at 1 index
            // https://alpha-scans.org/manga/trapped-in-a-webnovel-as-a-good-for-nothing/

            $chapter_url_reaper_scans = "/https:\/\/reaperscans.com\/series\/([\w -]{3,100})\/chapter-([\d]{1,3})/";
            $chapter_url_zero_scans = "/https\:\/\/zeroscans.com\/comics\/[\d]{1,9}([\w \d -]{3,90})\/1\/([\d]{1,3})/";
            $chapter_url_alpha_scans = "/https\:\/\/alpha-scans.org\/([a-z 0-9 -]{3,90})chapter-([\d]{1,3})/";
            // $chapter_url_reaper_scans = 
            $regex = [$chapter_url_reaper_scans, $chapter_url_zero_scans, $chapter_url_alpha_scans];

            foreach ($regex as $key) {

                if (preg_match_all($key, $content, $matches)) {

                    // echo $regex;
                    $toReplace = "/-/";
                    $replaceString = " ";
                    $matches[1] = preg_replace($toReplace, $replaceString, $matches[1]);
                    $matches[1] = explode("  ", ucwords(implode("  ", $matches[1])));

                    /*
                    foreach ($matches[0] as $value) {
                        echo $value;
                        echo "<br>";
                    }
                    
                    foreach ($matches[1] as $value) {
                        echo $value;
                        echo "<br>";
                    }
                    foreach ($matches[2] as $value) {
                        echo $value;
                        echo "<br>";
                    }
                    */

                    for ($i = 0; $i < count($matches[0]); $i++) {
                        $webtoon_title = $matches[1][$i];
                        $webtoon_chapters = $matches[2][$i];
                        // $webtoon_url = $matches[0][$i];
                        // $chapter_url = $matches[1][$i];

                        // $sql = "SELECT * FROM `webtoons`";
                        $sql = "SELECT * FROM `demo` WHERE `demo`.`title` = '$webtoon_title'";
                        $result = mysqli_query($conn, $sql);

                        $row = mysqli_fetch_assoc($result);
                        if ($webtoon_chapters > $row['chapters']) {

                            $sql = "UPDATE `webtoons` SET `chapters` = '$webtoon_chapters' WHERE `webtoons`.`title` = '$webtoon_title'";
                            $result = mysqli_query($conn, $sql);

                            // echo $sql;

                            if ($result) {
                                echo "Updated: " . $webtoon_title . " - " . $webtoon_chapters;
                                echo "<br>";
                            } else {
                                echo "Failed: " . $webtoon_title . " || " . mysqli_error($conn);
                                echo "<br>";
                            }
                        } else {
                            echo "Already Updated: " . $webtoon_title;
                            echo "<br>";
                        }
                    }
                } else {
                    echo "none";
                    echo "<br>";
                }
            }
        }
        ?>

    </div>

    <!-- footer -->
    <?php include 'partials/_footer.php'; ?>

    <!-- JAVASCRIPT -->
    <?php include 'js/_bootstrap_script.php'; ?>

    <!-- theme -->
    <script>
        // targetting theme button
        var themeButton = document.getElementById('theme-button');

        // function to switch themes
        themeButton.onclick = function toggleTheme() {
            // fetching current theme
            let currentTheme = document.getElementById('body-theme');
            // checking current theme and then changing theme
            if (currentTheme.className === 'bg-dark text-light') {
                currentTheme.className = ''; // changing theme class to light
                themeButton.innerText = 'Dark Mode'; // changing theme button text 
            } else {
                currentTheme.className = 'bg-dark text-light'; // changing theme class to Dark
                themeButton.innerText = 'Light Mode'; // changing theme button text 
            }
            console.log(currentTheme);
        }
    </script>
</body>

</html>