<?php
include "partials/_dbconnect.php";
include "functions.php";

// download webtoons file
$url = 'https://reaperscans.com/latest-comic/';
$file_name = basename($url);    // Use basename() function to return the base name of file
download_file($url, $file_name);


// get webtoons file content
$file_name = 'reaperscans.com';
$content = open_file($file_name);


include "regex.php";    // get regular expressions


if (preg_match_all($regex1, $content, $matches)) {

    // ----------------------- sql prepare and bind ---------------------------
    // fetching webtoon records if exits
    $stmt = $conn->prepare("SELECT w_id, w_title, w_cover FROM webtoons WHERE webtoons.w_title = ?");
    $stmt->bind_param("s", $webtoon_title);

    $stmt4 = $conn->prepare("SELECT `w_id` FROM `webtoons` WHERE w_id = ?");
    $stmt4->bind_param("s", $webtoon_title);

    // insert webtoon into db
    $stmt1 = $conn->prepare("INSERT INTO webtoons (`w_title`, `w_link`, `w_cover`) VALUES (?,?,?)");
    $stmt1->bind_param("sss", $webtoon_title, $webtoon_link, $img_path);

    // insert chapter into db
    $stmt2 = $conn->prepare("INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('0', ?, ?)");
    $stmt2->bind_param("ss", $webtoon_link, $webtoon_id);

    // update w_cover path
    $stmt3 = $conn->prepare("UPDATE `webtoons` SET `w_cover` = ? WHERE `webtoons`.`w_id` = ?");
    $stmt3->bind_param("si", $img_path, $w_id);

    // ===================================================
    for ($i = 0; $i < count($matches[0]); $i++) {
        $webtoon_title = $matches[1][$i];
        $img_url = $matches[2][$i];
        $img_ext = $matches[3][$i];
        $webtoon_link = $matches[4][$i];

        // fetching webtoon records if exits
        $stmt->execute();
        $result = $stmt->get_result();
        $row3 = $result->fetch_assoc();
        if ($row3) {
            $w_title = $row3['w_title'];
            $w_id = $row3['w_id'];
            $w_cover = $row3['w_cover'];

            $img_path = "img/" . $w_id . $img_ext; // path and img name where img will be stored
            if ($img_path !== $w_cover) {   // check if w_cover exits in db

                save_img($img_url, $w_id, $img_path);

                $stmt3->execute();  // update w_cover path    
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
        } else {

            // inserting webtoon details into db
            $img_path = "img/" . $webtoon_id . $img_ext; // path and img name where img will be stored
            save_img($img_url, $webtoon_id, $img_path);

            $stmt1->execute();  // insert webtoon into db


            $stmt4->execute();  // fetch w_id
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $w_id = $row['w_id']; //  increment wid 

            $stmt2->execute(); // insert chapter into db
            $stmt2->execute(); // insert chapter into db

            $result2 = $stmt2->get_result();
            if ($result && $result2) {
                echo "Inserted: " . $webtoon_title;
                echo "<br>";
            } else {
                echo "Failed to download webtoon : $webtoon_title || " . mysqli_error($conn);
                echo "<br>";
            }
        }
    }

    $stmt->close();
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    mysqli_close($conn);
} else {
    echo "No Match Found";
    echo "<br>";
}


echo "END";
echo "<br>";
