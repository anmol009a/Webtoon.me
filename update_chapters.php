
<?php
include "partials/_dbconnect.php";

$file_name = 'reaperscans.com';
// ---------------------------------------------------------------------
$fptr = fopen($file_name, "r");  // opening file in read mode
$content = fread($fptr, filesize($file_name));   // reading contents of the file
fclose($fptr);  // closing file

$regex = '/((https:\/\/reaperscans\.com\/series\/[\w-]{3,50}\/)chapter-[\d-]{1,4}\/)" class="btn-link"> Chapter ([\d.]{1,4})/';

// chapter link and no
// /(https:\/\/reaperscans\.com\/series\/[\w-]{3,50}\/chapter-[\d-]{1,4}\/)" class="btn-link"> Chapter ([\d.]{1,4})/

if (preg_match_all($regex, $content, $matches)) {

    // ===================================================
    for ($i = count($matches[0]) - 1; $i > -1; $i--) {
        $chapter_link = $matches[1][$i];
        $webtoon_link = $matches[2][$i];
        $chapter_no = $matches[3][$i];

        // var_dump($matches[3]);


        $sql = "SELECT * FROM `webtoons` where `webtoons`.`w_link` = '$webtoon_link'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $webtoon_id = $row['w_id'];

        $sql = "SELECT * FROM `chapters` where `chapters`.`w_id` = '$webtoon_id' ORDER BY `c_posted_on` DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $c_no = $row['c_no'];

        if ($c_no < $chapter_no) {

            $sql = "INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('$chapter_no', '$chapter_link', '$webtoon_id')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Updated: " . $chapter_link;
                echo "<br>";
            } else {
                echo "Failed: " . $chapter_link . " || " . mysqli_error($conn);
                echo "<br>";
            }
        }
    }
    echo "Done";
    echo "<br>";
} else {
    echo "none";
    echo "<br>";
}
