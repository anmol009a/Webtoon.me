<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';

use Anmol\Webtoon\Crud\WebtoonCrud;
use Anmol\Webtoon\Parser\WebtoonParser;


// create an object of WebtoonParser Class
$webtoonParser = new WebtoonParser(API_KEY);

// get last ready run
$last_ready_run = $webtoonParser->getProject(PROJECT_TOKEN)->last_ready_run;

// check if run ready
if (!isset($last_ready_run))
    die("No run ready.");

//  fetch webtoon run data
$webtoon_data = $webtoonParser->getLastReadyRunData(PROJECT_TOKEN);

// delete webtoon run
$webtoonParser->deleteProjectRun($last_ready_run->run_token);

// check if webtoon data present
if (!isset($webtoon_data->webtoons))
    die("No Data.");

// start new webtoon runs
$webtoonParser->runProject(PROJECT_TOKEN);

// create an object of WebtoonCrud Class
$db = new WebtoonCrud(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

// insert or update webtoon data
$db->insertAllWebtoonData($webtoon_data->webtoons);

echo "insert end";
