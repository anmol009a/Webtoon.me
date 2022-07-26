<?php

// fetch webtoon records if exits
$sql3 = "SELECT `w_id`, `w_title`,`w_cover` FROM `webtoons`where `webtoons`.`w_title`='$webtoon_title'";

// fetching last w_id
$sql2 = "SELECT `w_id` FROM `webtoons` ORDER BY `webtoons`.`w_id` DESC LIMIT 1";

// insert webtoon into db
$sql = "INSERT INTO `webtoons` (`w_title`, `w_link`, `w_cover`) VALUES ('$webtoon_title', '$webtoon_link', '$img_path')";

// update webtoon cover    
$sql = "UPDATE `webtoons` SET `w_cover` = '$img_path' WHERE `webtoons`.`w_id` = $w_id";

// fetch current w_id
$sql = "SELECT `w_id`,`w_title` FROM `webtoons` where `webtoons`.`w_link` LIKE '%$webtoon_title%'";


// fetch last c_no of webtoon
$sql = "SELECT `c_no` FROM `chapters` where `chapters`.`w_id` = '$webtoon_id' ORDER BY `c_no` DESC LIMIT 1";

// insert chapters into db
$sql = "INSERT INTO `chapters` (`c_no`, `c_link`, `w_id`) VALUES ('$chapter_no', '$chapter_link', '$webtoon_id')";

// upadte w_title
$sql = "UPDATE `webtoons` SET `w_title` = '$webtoon_title', `chapters` = '$chapters' WHERE `webtoons`.`sno` = $sno";
