<?php

namespace Anmol\Webtoon\Parser\Model;

class Project
{
    public  $token;
    public  $title;
    public  $last_ready_run_token;

    function __construct(string $token, string $title, $last_ready_run)
    {
        $this->token = $token;
        $this->title = $title;
        $this->last_ready_run_token = $last_ready_run;
    }
}
