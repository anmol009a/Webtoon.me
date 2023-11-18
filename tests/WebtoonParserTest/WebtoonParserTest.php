<?php

require_once 'config.php';

use Anmol\Webtoon\Parser\WebtoonParser;
use PHPUnit\Framework\TestCase;

class WebtoonParserTest extends TestCase
{
    protected $webtoonParser;

    public function setUp(): void
    {
        parent::setUp(); // Call the parent class's setUp method

        // Set up the Parsehub object with configuration for testing
        $this->webtoonParser = new WebtoonParser(API_KEY);
    }

    
    // test get all webtoon projects
    public function testGetAllWebtoonProjects()
    {
        $projects = $this->webtoonParser->get_all_webtoon_projects();

        $this->assertIsArray($projects);
    }

    // test run all webtoon projects
    public function testRunAllWebtoonProjects()
    {
        $projects = $this->webtoonParser->run_all_webtoon_projects();

        $this->assertIsArray($projects);
    }

    // test get all webtoon run data
    public function testGetAllWebtoonRunData()
    {
        $projects = $this->webtoonParser->get_all_webtoon_run_data();

        $this->assertIsArray($projects);
    }

    // test delete all webtoon runs
    public function testDeleteAllWebtoonRun()
    {
        $projects = $this->webtoonParser->delete_all_webtoon_run();

        $this->assertIsArray($projects);
    }

    // test get last ready run data
    public function testGetLastReadyRunData()
    {
        // get last ready run
        $last_ready_run = $this->webtoonParser->getProject(PROJECT_TOKEN)->last_ready_run;

        // check if run ready
        if (!isset($last_ready_run))
            throw new Exception("No run ready.");

        $data = $this->webtoonParser->getLastReadyRunData(PROJECT_TOKEN);

        $this->assertIsObject($data);
    }
}
