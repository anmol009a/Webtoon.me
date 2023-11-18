<?php

require_once 'config.php';


use Anmol\Webtoon\Crud\Table\ChapterTable;
use PHPUnit\Framework\TestCase;

class ChapterTableTest extends TestCase
{
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

        $this->tableChapter = new ChapterTable($this->conn);
    }

    public function tearDown():void
    {
        $this->conn->close();
    }

    // test insert one chapter
    public function testInsertOneChapter()
    {
        $result = $this->tableChapter->insertOneChapter(24, "1", "testchapterurl");
        $this->assertIsInt($result);
    }

    // test insert many chapter
    public function testInsertManyChapter()
    {
        $chapters = [
            (object)["webtoon_id" => 1,"number" => "99", "url" => "https://asuratoon.com/6849480105-the-world-after-the-end-chapter-99/"],
            (object)["webtoon_id" => 1,"number" => "98", "url" => "https://asuratoon.com/2970937220-the-world-after-the-end-chapter-98/"],
            (object)["webtoon_id" => 1,"number" => "97", "url" => "https://asuratoon.com/2970937220-the-world-after-the-end-chapter-97/"],
            (object)["webtoon_id" => 1,"number" => "61", "url" => "https://asuratoon.com/6849480105-reaper-of-the-drifting-moon-chapter-61/"],
            (object)["webtoon_id" => 1,"number" => "60", "url" => "https://asuratoon.com/2970937220-reaper-of-the-drifting-moon-chapter-60/"],
            (object)["webtoon_id" => 1,"number" => "59", "url" => "https://asuratoon.com/2970937220-reaper-of-the-drifting-moon-chapter-59/"]
        ];
        $result = $this->tableChapter->insertManyChapter($chapters);
        $this->assertIsBool($result);
    }

    // test get chapters
    public function testgetChapters()
    {
        $result = $this->tableChapter->getChapters(1);
        $this->assertIsArray($result,"check if table empty.");
    }
}
