<?php

require_once __DIR__ . '/vendor/autoload.php';

use Anmol\WebtoonParser\WebtoonParser;
use Anmol\WebtoonCrud\WebtoonCrud;


// create an object of WebtoonParser Class
const api_key = 'tGxzjnY4_xe_';
$api = new WebtoonParser(api_key);

//  fetch all webtoon runs data
$webtoon_data = $api->get_all_webtoon_run_data();

// delete webtoon runs
$api->delete_all_webtoon_run();

// start new webtoon runs
$api->run_all_webtoon_projects();

// connect to db
require_once './partials/_dbconnect.php';

// create an object of WebtoonCrud Class
$db = new WebtoonCrud($conn);

// insert or update webtoon data
$db->insert_webtoons_data($webtoon_data);

echo "end";