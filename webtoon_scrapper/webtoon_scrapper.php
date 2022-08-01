<?php
require_once __DIR__ . "/partials/_dbconnect.php";
require_once __DIR__ . "/functions.php";

// insert parserHub project into db
$stmt = $conn->prepare("INSERT INTO parser_hub (`p_title`, `p_token`, `run_token`, `run_status`) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $project_title, $project_token, $run_token, $run_status);

// Update parserHub project into db
$stmt1 = $conn->prepare("UPDATE parser_hub SET `run_token` = ?, `run_status`= ? WHERE p_title = ?");
$stmt1->bind_param("sss", $run_token, $run_status, $project_title);

// fetch project record with project title
$stmt2 = $conn->prepare("SELECT run_token, run_status FROM parser_hub WHERE p_title = ?");
$stmt2->bind_param("s", $project_title);

require_once __DIR__ . '/vendor/autoload.php';

use Parsehub\Parsehub;


$api_key = "tGxzjnY4_xe_";
$parsehub = new Parsehub($api_key);




$projectList = $parsehub->getProjectList();
$projectList =  json_encode((array)$projectList);
$projectList =  json_decode($projectList);
$total_projects = $projectList->total_projects;
$projects = $projectList->projects;

echo "Total Projects : $total_projects";
echo "<br>";
echo "Project Details";
echo "<br>";

for ($i = 0; $i < $total_projects; $i++) {
    $project_title = $projects[$i]->title;
    $project_token = $projects[$i]->token;

    echo "<hr>";
    echo "Title : $project_title <br> Project Token : $project_token";
    echo "<br>";
    echo "<hr>";

    // fetch project record with project title
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();
    if ($row) {
        $run_token = $row['run_token'];
        echo "Run Token : $run_token";
        echo "<br>";

        // check run status
        $run_status = checkRunStatus($api_key, $run_token);

        if ($run_status === "complete") {
            // Get data for a particular run, Pass the run token:
            $webtoons =   getRunData($api_key, $run_token);    // array of objects

            // print webtoon details
            // printWebtoons($webtoons);

            // Delete a parsehub project run
            deleteRun($api_key, $run_token);
        } elseif ($run_status === "deleted") {
            // Run a parsehub project:
            $run_token = run($api_key, $project_token);

            // check run status
            $run_status = checkRunStatus($api_key, $run_token);

            // update run_token into DB
            $result = $stmt1->execute(); // insert project into db
            if ($result) {
                echo "Updated project: " . $project_title;
                echo "<br>";
            } else {
                echo "Failed to Update project : $project_title || " . mysqli_error($conn);
                echo "<br>";
            }
        } elseif ($run_status === "running" || $run_status === "queued") {
            continue;
        }
    } else {
        // Run a parsehub project:
        $run_token = run($api_key, $project_token);

        // check run status
        $run_status = checkRunStatus($api_key, $run_token);

        // insert project into DB
        $result = $stmt->execute(); // insert project into db
        if ($result) {
            echo "Updated project: " . $project_title;
            echo "<br>";
        } else {
            echo "Failed to Update project : $project_title || " . mysqli_error($conn);
            echo "<br>";
        }
    }
}

$stmt->close();
$stmt1->close();
$stmt2->close();
echo "END";
echo "<br>";
