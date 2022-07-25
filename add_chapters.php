<?php
// connect to db
include "partials/_dbconnect.php";

// download webtoon file
include "functions/download_file.php";

// get webtoon file content
$file_name = 'reaperscans.com';
include "functions/open_file.php";

// get regular expressions
include "regex.php";


if (preg_match_all($regex3, $content, $matches)) {

    // ===================================================
    for ($i = count($matches[0]) - 1; $i > -1; $i--) {
        $chapter_link = $matches[1][$i];
        $webtoon_title = $matches[2][$i];
        $chapter_no = $matches[3][$i];

        $webtoon_title = str_replace("-", "%", $webtoon_title); //  making title searchable 

        // fetch current w_id
        $sql = "SELECT `w_id`,`w_title` FROM `webtoons` where `webtoons`.`w_link` LIKE '%$webtoon_title%'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $webtoon_id = $row['w_id'];


        // fetch last c_no of webtoon
        $sql = "SELECT `c_no` FROM `chapters` where `chapters`.`w_id` = '$webtoon_id' ORDER BY `c_no` DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $c_no = $row['c_no'];

        if ($c_no < $chapter_no) {
            // insert chapters into db
            $sql = "INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('$chapter_no', '$chapter_link', '$webtoon_id')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Inserted Chapter : $webtoon_title";
                echo "<br>";
            } else {
                echo "Failed to Insert Chapter : $webtoon_title || " . mysqli_error($conn);
                echo "<br>";
            }
        }
    }
} else {
    echo "No Match";
    echo "<br>";
}

echo "END";
echo "<br>";
