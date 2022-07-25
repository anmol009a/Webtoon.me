<?php
include "partials/_dbconnect.php";


include "functions/download_file.php";

$file_name = 'reaperscans.com';
include "functions/open_file.php";


include "regex.php";

if (preg_match_all($regex1, $content, $matches)) {

    // ===================================================
    for ($i = 0; $i < count($matches[0]); $i++) {
        $webtoon_title = $matches[1][$i];
        $img_url = $matches[2][$i];
        $img_ext = $matches[3][$i];
        $webtoon_link = $matches[4][$i];

        // fetching webtoon records if exits
        $sql3 = "SELECT `w_id`, `w_title`,`w_cover` FROM `webtoons`where `webtoons`.`w_title`='$webtoon_title'";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $w_title = $row3['w_title'];
        $w_id = $row3['w_id'];
        $w_cover = $row3['w_cover'];


        include "functions/save_img.php";


        // inserting webtoon details into db
        
        if ($w_title !== $webtoon_title) {

            $sql = "INSERT INTO `webtoons` (`w_title`, `w_link`, `w_cover`) VALUES ('$webtoon_title', '$webtoon_link', '$img_path')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Inserted: " . $webtoon_title;
                echo "<br>";
            } else {
                echo "Failed to download webtoon : $webtoon_title || " . mysqli_error($conn);
                echo "<br>";
            }
        } elseif ($img_path !== $w_cover) {
            $sql = "UPDATE `webtoons` SET `w_cover` = '$img_path' WHERE `webtoons`.`w_id` = $w_id;";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Updated: " . $webtoon_title;
                echo "<br>";
            } else {
                echo "Failed to download webtoon : $webtoon_title || " . mysqli_error($conn);
                echo "<br>";
            }
        }
        // echo $webtoon_title;
        echo "<br>";
    }
} else {
    echo "No Match Found";
    echo "<br>";
}
echo "END";
echo "<br>";
