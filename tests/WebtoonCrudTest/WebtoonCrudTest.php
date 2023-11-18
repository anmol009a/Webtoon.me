<?php

require_once 'config.php';


use Anmol\Webtoon\Crud\WebtoonCrud;
use PHPUnit\Framework\TestCase;

class WebtoonCrudTest extends TestCase
{
    private $webtoonCrud;
    private $conn;

    public function setUp(): void
    {
        // error $conn null; req once not working; file loads 4 times for req;
        // declaring req at top results in error; dont know why;        
        // Create a connection
        $this->conn = mysqli_connect(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

        // Die if connection was not successful
        if (!$this->conn)
            die("Sorry we failed to connect: " . mysqli_connect_error());

        $this->webtoonCrud =  new WebtoonCrud(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);
    }

    public function tearDown():void
    {
        $this->conn->close();
    }

    public function testInsertManyWebtoons(){
        $webtoons = [
            new class
            {
                public $title = "The World After The End";
                public $url = "https://asuratoon.com/manga/6849480105-the-world-after-the-end/";
                public $cover_url = "https://img.asuracomics.com/unsafe/fit-in/200x260/filters:format(webp)/https://asuratoon.com/wp-content/uploads/2022/02/the-world-after-the-end-cover.jpg";
            },
            new class
            {
                public $title = "Reaper of the Drifting Moon";
                public $url = "https://asuratoon.com/manga/6849480105-reaper-of-the-drifting-moon/";
                public $cover_url = "https://img.asuracomics.com/unsafe/fit-in/200x260/filters:format(webp)/https://asuratoon.com/wp-content/uploads/2022/07/Reaper-Moon-Cover-Animation_Compressed.gif";
            },
        ];
        // insert or update webtoon data
        $this->webtoonCrud->insertAllWebtoonData($webtoons);

        $this->assertIsArray($webtoons);
    }
    // test get webtoon data
    public function testGetWebtoons(){
        $webtoons = $this->webtoonCrud->getWebtoons();

        $this->assertIsArray($webtoons);
        $this->assertIsArray($webtoons[0]['chapters'], 'chapters');
    }

    // test search webtoons
    public function testSearchWebtoon(){
        $webtoons = $this->webtoonCrud->searchWebtoon("a");

        $this->assertIsArray($webtoons);
    }
}
