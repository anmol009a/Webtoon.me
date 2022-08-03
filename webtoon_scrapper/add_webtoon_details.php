<?php

// ----------------------- sql prepare and bind ---------------------------

// fetch webtoon_id with webtoon title

// update w_cover path
$stmt5 = $conn->prepare("UPDATE `webtoons` SET `last_mod` = CURRENT_TIMESTAMP WHERE `webtoons`.`w_id` = ?");
$stmt5->bind_param("i", $webtoon_id);

$stmt4 = $conn->prepare("SELECT w_id FROM webtoons WHERE w_title = ?");
$stmt4->bind_param("s", $webtoon_title);

// insert webtoon into db
$stmt1 = $conn->prepare("INSERT INTO webtoons (`w_title`, `w_link`) VALUES (?,?)");
$stmt1->bind_param("ss", $webtoon_title, $webtoon_url);

// insert chapter into db
$stmt2 = $conn->prepare("INSERT INTO `chapters` (`c_name`,`c_no`, `c_link`, `w_id`) VALUES (?, ?, ?, ?)");
$stmt2->bind_param("sdsi", $chapter_name, $chapter_no, $chapter_url, $webtoon_id);

// update cover_path path
$stmt3 = $conn->prepare("INSERT INTO covers (`cover_url`,`w_id`) VALUES (?, ?)");
$stmt3->bind_param("si", $webtoon_cover_url, $webtoon_id);

// update chapters
$stmt9 = $conn->prepare("UPDATE `chapters` SET `c_name` = ?, c_no = ?, c_link = ? WHERE `w_id` = ?");
$stmt9->bind_param("sdsi", $chapter_name, $chapter_no, $chapter_url, $webtoon_id);

// update covers
$stmt11 = $conn->prepare("UPDATE covers SET `cover_url` = ? WHERE `w_id` = ?");
$stmt11->bind_param("si", $webtoon_cover_url, $webtoon_id);


// get chapter No
$stmt10 = $conn->prepare("SELECT c_no FROM chapters WHERE w_id = ? and c_no = ?");
$stmt10->bind_param("id", $webtoon_id, $chapter_no);


foreach ($webtoons as $webtoon) {
    $webtoon_title = $webtoon->name;
    $webtoon_url = $webtoon->url;
    // $webtoon_cover_url = $webtoon->cover;
    $webtoon_cover_url = isset($webtoon->cover) ? $webtoon->cover : "";

    // fetching webtoon records if exits 
    // fetch w_id 
    $result = $stmt4->execute();
    $result = $stmt4->get_result();
    $row = $result->fetch_assoc();
    if ($row) {
        echo "<hr>";
        echo "Webtoon Present : $webtoon_title";
        echo "<br>";

        $webtoon_id = $row['w_id']; // fetch w_id 

        try {
            // update cover details
            $result = $stmt11->execute();
            if ($result) {
                echo "Updated cover details : " . $webtoon_cover_url;
                echo "<br>";
            }

            if (isset($webtoon->chapter)) {

                for ($i = 0; $i < count($webtoon->chapter); $i++) {
                    $chapter_name = $webtoon->chapter[$i]->name;
                    preg_match('/[\d]{1,3}/', $chapter_name, $matches);
                    $chapter_no = $matches[0];
                    $chapter_url = $webtoon->chapter[$i]->url;

                    // get last C-no
                    $result = $stmt10->execute();
                    $result = $stmt10->get_result();
                    $row = $result->fetch_assoc();
                    if ($row) {
                        // update chapter into db
                        $result = $stmt9->execute();
                        if ($result) {
                            echo "Updated chapter : $chapter_name";
                            echo "<br>";
                        }
                    } else {
                        $result = $stmt2->execute(); // insert chapter into db
                        if ($result) {
                            echo "Inserted Chapter : $chapter_name";
                            echo "<br>";
                        }
                    }
                }

                if ($stmt5->execute()) {
                    echo "Upadted Last_mod : $webtoon_title";
                    echo "<br>";
                }
            }
        } catch (Exception $e) {
            // echo "<br>";
            echo "Failed to insert webtoon details : " . $e->getMessage();
            echo "<br>";
        }
    } else {
        try {
            // inserting webtoon details into db
            $result1 = $stmt1->execute();  // insert webtoon into db 
            if ($result1) {
                echo "<hr>";
                echo "Inserted webtoon: " . $webtoon_title;
                echo "<br>";

                // fetch w_id 
                $stmt4->execute();
                $result = $stmt4->get_result();
                $row = $result->fetch_assoc();
                $webtoon_id = $row['w_id'];

                $result = $stmt3->execute();    // insert cover details
                if ($result) {
                    echo "Inserted cover details : " . $webtoon_cover_url;
                    echo "<br>";
                }
                if (isset($webtoon->chapter)) {

                    for ($i = 0; $i < count($webtoon->chapter); $i++) {
                        $chapter_name = $webtoon->chapter[$i]->name;
                        preg_match('/[\d]{1,3}/', $chapter_name, $matches);
                        $chapter_no = $matches[0];
                        $chapter_url = $webtoon->chapter[$i]->url;

                        $result = $stmt2->execute(); // insert chapter into db
                        if ($result) {
                            echo "Inserted Chapter : $chapter_name";
                            echo "<br>";
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Failed to insert webtoon details : " . $e->getMessage();
            echo "<br>";
        }
    }
}

$stmt1->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
