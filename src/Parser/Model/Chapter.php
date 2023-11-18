<?php

namespace Anmol\Webtoon\Parser\Model;

class Chapter
{
    public $number;
    public $url;

    function __construct(string $number, string $url)
    {
        $this->number = $number;
        $this->url = $url;
    }
}
