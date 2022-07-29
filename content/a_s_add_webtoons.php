<?php

// download webtoons file
// $url = 'https://www.asurascans.com/';
// $file_name = basename($url);    // Use basename() function to return the base name of file
// download_file($url, $file_name);


// get webtoons file content
$file_name = 'www.asurascans.com';
$content = open_file($file_name);


if (preg_match_all($regex5, $content, $matches)) {

    // ----------------------- sql prepare and bind ---------------------------

    // fetch webtoon record with webtoon title
    $stmt = $conn->prepare("SELECT w_id, w_title, w_cover FROM webtoons WHERE webtoons.w_title = ?");
    $stmt->bind_param("s", $webtoon_title);

    // insert webtoon into db
    $stmt1 = $conn->prepare("INSERT INTO webtoons (`w_title`, `w_link`, `w_cover`) VALUES (?,?,?)");
    $stmt1->bind_param("sss", $webtoon_title, $webtoon_link, $img_path);

    // insert chapter into db
    $stmt2 = $conn->prepare("INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('0', ?, ?)");
    $stmt2->bind_param("ss", $webtoon_link, $webtoon_id);

    // update w_cover path
    $stmt3 = $conn->prepare("UPDATE `webtoons` SET `w_cover` = ? WHERE `webtoons`.`w_id` = ?");
    $stmt3->bind_param("si", $img_path, $webtoon_id);


    // ===================================================
    for ($i = 0; $i < count($matches[0]); $i++) {
        $webtoon_link = $matches[1][$i];
        $webtoon_title = $matches[2][$i];
        $img_url = $matches[3][$i];
        $img_ext = $matches[4][$i];

        // fetching webtoon records if exits
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {

            $webtoon_title = $row['w_title'];
            $webtoon_id = $row['w_id'];
            $w_cover = $row['w_cover'];

            $img_path = "img/" . $webtoon_id . $img_ext; // path and img name where img will be stored
            if ($img_path !== $w_cover) {   // check if w_cover exits in db

                $stmt3->execute();  // update w_cover path    

                if ($result) {
                    save_img($img_url, $webtoon_title, $img_path);
                    echo "Updated Img: " . $webtoon_title;
                    echo "<br>";
                } else {
                    echo "Failed to download Img : $webtoon_title";
                    echo "<br>";
                }
            } else {
                echo "Img Present : $webtoon_title";
                echo "<br>";
            }
        } else {

            // inserting webtoon details into db
            $img_path = "img/" . $webtoon_id . $img_ext; // path and img name where img will be stored

            try {
                // fetch last w_id
                $sql = "SELECT w_id FROM webtoons ORDER BY w_id DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $webtoon_id = $row['w_id'] + 1;

                $img_path = "img/" . $webtoon_id . $img_ext; // path and img name where img will be stored

                // inserting webtoon details into db
                $result1 = $stmt1->execute();  // insert webtoon into db 
                $stmt2->execute(); // insert chapter into db
                $webtoon_link = $webtoon_link . "0";
                $result2 = $stmt2->execute(); // insert chapter into db

                if ($result1 && $result2) {
                    echo "Inserted webtoon: " . $webtoon_title;
                    echo "<br>";
                    save_img($img_url, $webtoon_title, $img_path);
                } else {
                    echo "Failed to download webtoon : $webtoon_title || " . mysqli_error($conn);
                    echo "<br>";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                echo "Failed to download webtoon : $webtoon_title || " . $e->getMessage();
                echo "<br>";
            }
        }
    }
    $stmt->close();
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
} else {
    echo "No Match Found";
    echo "<br>";
}
echo "END";
echo "<br>";
