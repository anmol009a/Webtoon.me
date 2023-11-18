<?php

namespace Anmol\Webtoon\Parser;

use Parsehub\Parsehub;

class WebtoonParser extends Parsehub
{
    /**
     * @var Parsehub object
     */
    private $parsehub;
    /**
     * Constructor - takes your ParseHub API key
     */
    function __construct(string $api_key)
    {
        $this->parsehub = new Parsehub($api_key);
    }

    /**
     * @return array Returns an array of std class object of Projects
     */
    function get_all_webtoon_projects(): array
    {
        return $this->parsehub->getProjectList()->projects;
    }

    /**
     * @return array Returns an array of started project_run run_tokens
     */
    function run_all_webtoon_projects(): array
    {
        $runList = [];
        // get projects
        $projectList = $this->get_all_webtoon_projects();

        foreach ($projectList as $project) {
            if ($project->last_ready_run === null) {
                // run project
                $run_obj = $this->parsehub->runProject($project->token);
                // check if run_token is null or not
                
                if (isset($run_obj)) {
                    array_push($runList, $run_obj->run_token);
                }
            }
        }
        return $runList;
    }

    /**
     * @return array Returns an array of deleted project_run run_tokens
     */
    function delete_all_webtoon_run(): array
    {
        $deleteList = [];
        $projectList = $this->get_all_webtoon_projects();   // get project list

        foreach ($projectList as $project) {
            // check if any run ready
            if (isset($project->last_ready_run)) {
                // delete run
                $delete_obj = $this->parsehub->deleteProjectRun($project->last_ready_run->run_token);
                // push deleted run int array
                array_push($deleteList, $delete_obj->run_token);
            }
        }
        return $deleteList;
    }

    /**
     * Get webtoons from all runs
     * @return array Returns an array of webtoon objects
     */
    function get_all_webtoon_run_data(): array
    {
        $webtoon_data = []; // variable to store webtoons
        $projectList = $this->get_all_webtoon_projects(); // get projectList

        // for each project
        foreach ($projectList as $project) {
            // check if last_ready_run is null
            if ($project->last_ready_run !== null) {

                // get run data
                $run_data = $this->parsehub->getRunData($project->last_ready_run->run_token);

                // push object into array
                if (isset($run_data->webtoons))
                    $webtoon_data = $webtoon_data + $run_data->webtoons;
            }
        }
        // return an array of Webtoon Class Objects
        return $webtoon_data;
    }
}
