<?php

require_once 'config.php';


use Anmol\Webtoon\Crud\Table\WebtoonTable;
use Anmol\Webtoon\Crud\Table\ChapterTable;
use PHPUnit\Framework\TestCase;

class WebtoonTableTest extends TestCase
{
    protected $tableWebtoon;
    protected $tableChapter;
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

        $this->tableWebtoon = new WebtoonTable($this->conn);
        $this->tableChapter = new ChapterTable($this->conn);
    }

    public function tearDown():void
    {
        $this->conn->close();
    }

    // test insert one webtoon
    public function testInsertOneWebtoon()
    {
        $result = $this->tableWebtoon->insertOneWebtoon("test", "testurl");

        $this->assertIsInt($result);
    }

    // test insert many webtoon
    public function testInsertManyWebtoon()
    {
        // Array of Webtoon Objects using Anonymous Classes
        $webtoons = [
            new class
            {
                public $title = "The World After The End";
                public $url = "https://asuratoon.com/manga/6849480105-the-world-after-the-end/";
                public $coverUrl = "https://img.asuracomics.com/unsafe/fit-in/200x260/filters:format(webp)/https://asuratoon.com/wp-content/uploads/2022/02/the-world-after-the-end-cover.jpg";
            },
            new class
            {
                public $title = "Reaper of the Drifting Moon";
                public $url = "https://asuratoon.com/manga/6849480105-reaper-of-the-drifting-moon/";
                public $coverUrl = "https://img.asuracomics.com/unsafe/fit-in/200x260/filters:format(webp)/https://asuratoon.com/wp-content/uploads/2022/07/Reaper-Moon-Cover-Animation_Compressed.gif";
            },
        ];

        $result = $this->tableWebtoon->insertManyWebtoon($webtoons);

        $this->assertIsArray($result);
    }

    // test get webtoon id
    public function testgetWebtoonId()
    {
        $result = $this->tableWebtoon->getWebtoonId("test");

        $this->assertIsInt($result);
    }

}
