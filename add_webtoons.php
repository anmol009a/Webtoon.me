<?php
include "partials/_dbconnect.php";
include "functions.php";

// download webtoons file
$url = 'https://reaperscans.com/latest-comic/';
$file_name = basename($url);    // Use basename() function to return the base name of file
download_file($url,$file_name);


// get webtoons file content
$file_name = 'reaperscans.com';
$content = open_file($file_name);


include "regex.php";    // get regular expressions


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
        if ($row3) {
            $w_title = $row3['w_title'];
            $w_id = $row3['w_id'];
            $w_cover = $row3['w_cover'];
        }else {
            $w_title = null;
            $w_id = null;
            $w_cover = null;
        }
        

        // fetching last w_id
        $sql2 = "SELECT `w_id` FROM `webtoons` ORDER BY `webtoons`.`w_id` DESC LIMIT 1";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $webtoon_id = $row2['w_id'] + 1; //  increment wid 


        // inserting webtoon details into db
        if ($w_title !== $webtoon_title) {  // check if webtoon exits in db

            $img_path = "img/" . $webtoon_id . $img_ext; // path and img name where img will be stored
            save_img($img_url, $webtoon_id, $img_path);

            $sql = "INSERT INTO `webtoons` (`w_title`, `w_link`, `w_cover`) VALUES ('$webtoon_title', '$webtoon_link', '$img_path');";   // insert webtoon into db

            $sql .= "INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('0', '$webtoon_link', '$webtoon_id');";   // insert chapter into db
            
            $sql .= "INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('0', '$webtoon_link', '$webtoon_id');";   // insert webtoon into db

            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Inserted: " . $webtoon_title;
                echo "<br>";
            } else {
                echo "Failed to download webtoon : $webtoon_title || " . mysqli_error($conn);
                echo "<br>";
            }
        } else {
            $img_path = "img/" . $w_id . $img_ext; // path and img name where img will be stored
            if ($img_path !== $w_cover) {   // check if w_cover exits in db

                save_img($img_url, $w_id, $img_path);

                $sql = "UPDATE `webtoons` SET `w_cover` = '$img_path' WHERE `webtoons`.`w_id` = $w_id"; // update w_cover path    
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "Updated: " . $webtoon_title;
                    echo "<br>";
                } else {
                    echo "Failed to download webtoon : $webtoon_title || " . mysqli_error($conn);
                    echo "<br>";
                }
            } else {
                echo "Img Present : $webtoon_title";
                echo "<br>";
            }
        }
    }
} else {
    echo "No Match Found";
    echo "<br>";
}
echo "END";
echo "<br>";

mysqli_close($conn);