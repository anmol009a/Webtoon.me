<?php
require_once "partials/_dbconnect.php";

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


function run($api_key, $project_token)
{
    // Run a parsehub project:
    $parsehub = new Parsehub($api_key);
    $options = array();
    $run_obj = $parsehub->runProject($project_token, $options);
    $run_token = $run_obj->run_token;
    echo "Starting a new Run<br>";
    echo "Run Token : $run_token";
    echo "<br>";
    return $run_token;
}

function checkRunStatus($api_key, $run_token)
{
    // check run status
    // Get a particular run, Pass the run token:
    $parsehub = new Parsehub($api_key);
    $run = $parsehub->getRun($run_token);
    $run_status = $run->status;
    echo "Run Status : $run_status";
    echo "<br>";
    return $run_status;
}

function getRunData($api_key, $run_token)
{
    // Get data for a particular run, Pass the run token:
    $parsehub = new Parsehub($api_key);
    $data = $parsehub->getRunData($run_token);
    $data =  json_decode($data);    // converts json into array of object
    $webtoons =  $data->webtoon;    // array of objects
    // print_r($webtoons);
    return $webtoons;
}

function printWebtoons($webtoons)
{
    foreach ($webtoons as $webtoon) {
        $project_title = $webtoon->name;
        $webtoon_url = $webtoon->url;
        // $webtoon_cover_url = $webtoon->cover;
        $webtoon_cover_url = isset($webtoon->cover) ? $webtoon->cover : "";
        echo "<hr>Webtoon Title : $project_title<br>Webtoon URL : $webtoon_url<br>Webtoon Cover URL : $webtoon_cover_url<br>";
        if (isset($webtoon->chapter)) {
            for ($i = 0; $i < count($webtoon->chapter); $i++) {
                $chapter[$i] = $webtoon->chapter[$i]->name;
                $chapter_url[$i] = $webtoon->chapter[$i]->url;
                echo "$chapter[$i] : $chapter_url[$i]<br>";
            }
        }
    }
}

function deleteRun($api_key, $run_token)
{
    $parsehub = new Parsehub($api_key);
    $delete_run = $parsehub->deleteProjectRun($run_token);
    // var_dump($delete_run);
}

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
            printWebtoons($webtoons);

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
