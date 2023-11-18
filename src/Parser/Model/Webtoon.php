<?php
namespace Anmol\Webtoon\Parser\Model;

class Webtoon
{
    public $title;
    public $url;
    public $cover_url;
    public $chapters;
    
    function __construct(string $title, string $url, string $cover_url, array|null $chapters = [])
    {
        $this->title = $title;
        $this->url = $url;
        $this->cover_url = $cover_url;
        $this->chapters = $chapters;
    }
}