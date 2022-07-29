<?php

// get webtoons file content
$file_name = 'www.asurascans.com';
$content = open_file($file_name);


if (preg_match_all($regex6, $content, $matches)) {

    // fetch w_id with w_title in w_links
    $stmt = $conn->prepare("SELECT `w_id`,`w_title` FROM `webtoons` where `webtoons`.`w_link` LIKE ?");
    $stmt->bind_param("s", $webtoon_title);

    // fetch c_no with w_id
    $stmt1 = $conn->prepare("SELECT c_no FROM `chapters` where `chapters`.`w_id` = ? ORDER BY `c_no` DESC LIMIT 1");
    $stmt1->bind_param("i", $webtoon_id);

    // update c_no
    $stmt3 = $conn->prepare("UPDATE chapters SET c_no = ? WHERE w_id = ?");
    $stmt3->bind_param("di", $chapter_no, $webtoon_id);

    // insert chapter into db
    $stmt2 = $conn->prepare("INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES (?, ?, ?)");
    $stmt2->bind_param("dss", $chapter_no, $chapter_link, $webtoon_id);

    // update w_link, w_last_mod
    $stmt4 = $conn->prepare("UPDATE webtoons SET w_link = ?, last_mod = CURRENT_TIMESTAMP WHERE w_id = ?");
    $stmt4->bind_param("si", $webtoon_link, $webtoon_id);

    // ===================================================
    for ($i = count($matches[0]) - 1; $i > -1; $i--) {
        $chapter_link = $matches[1][$i];
        $webtoon_link = $matches[2][$i];
        $webtoon_title = $matches[3][$i];
        $chapter_no = $matches[5][$i];

        $search = ["-", "chapter"];
        $webtoon_title = "%" . str_replace($search, "%", $webtoon_title) . "%"; //  making title searchable in links

        // fetch current w_id
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $webtoon_id = $row['w_id'];


        if ($webtoon_id) {
            // fetch last c_no of webtoon
            $stmt1->execute();
            $result = $stmt1->get_result();
            $row = $result->fetch_assoc();
            $c_no = isset($row['c_no']) ? $row['c_no'] : 0;

            if ($c_no < $chapter_no) {

                $webtoon_title = $matches[2][$i];

                // insert chapters into db
                $result = $stmt2->execute(); // insert chapter into db            

                if ($result) {
                    echo "Inserted Chapter : $webtoon_title";
                    echo "<br>";
                    $stmt4->execute(); // update webtoon last_mod
                } else {
                    echo "Failed to Insert Chapter : $webtoon_title || " . mysqli_error($conn);
                    echo "<br>";
                }
            }
        }
    }
} else {
    echo "No Match";
    echo "<br>";
}
echo "END";
echo "<br>";
