<?php

namespace Anmol\Webtoon\Crud\Table;
use Anmol\Webtoon\Crud\Table;

class WebtoonTable extends Table
{

    /**
     * Insert webtoon
     * @param string title
     * @param string URL
     * @return int webtoon id on insert otherwise -1
     */
    function insertOneWebtoon(string $title, string $url): int
    {
        // define sql
        $getWebtoonIdSql = "SELECT webtoon_id FROM `webtoon` WHERE webtoon.title = ?;";
        $insertWetoonSql = "INSERT INTO webtoon (webtoon.title, webtoon.url)  VALUES (?, ?)";    // sql stmt	

        // prepare stmt
        $getWebtoonIdStmt = $this->conn->prepare($getWebtoonIdSql);
        $insertWetoonStmt = $this->conn->prepare($insertWetoonSql);

        // check if webtoon present
        $getWebtoonIdStmt->bind_param("s", $title); // bind parameters
        $getWebtoonIdStmt->execute();
        $result = $getWebtoonIdStmt->get_result();

        // webtoon present
        if ($result->num_rows > 0) {
            return $result->fetch_column(0);
        }       
        
        // webtoon not present
        $insertWetoonStmt->bind_param("ss", $title, $url);    // bind parameters
        try {
            // execute sql
            $insertWetoonStmt->execute();
            // return webtoon id
            return $this->conn->insert_id;
        } catch (\mysqli_sql_exception $exception) {
            echo $exception->getMessage() . "\n";
        }

        return -1;
    }

    /**
     * Insert webtoon
     * @param $webtoons of webtoons
     */
    function insertManyWebtoon(array $webtoons): array
    {
        // define sql
        $getWebtoonIdSql = "SELECT webtoon_id FROM `webtoon` WHERE webtoon.title = ?;";
        $insertWetoonSql = "INSERT INTO webtoon (webtoon.title, webtoon.url)  VALUES (?, ?)";    // sql stmt	

        // prepare stmt
        $getWebtoonIdStmt = $this->conn->prepare($getWebtoonIdSql);
        $insertWetoonStmt = $this->conn->prepare($insertWetoonSql);

        foreach ($webtoons as $webtoon) {
            // check if webtoon present
            $getWebtoonIdStmt->bind_param("s", $webtoon->title); // bind parameters
            $getWebtoonIdStmt->execute();
            $result = $getWebtoonIdStmt->get_result();

            // webtoon present
            if ($result->num_rows > 0){
                $webtoon->id = $result->fetch_column(0);
                continue;
            }

            // webtoon not present: insert
            $insertWetoonStmt->bind_param("ss", $webtoon->title, $webtoon->url);    // bind parameters
            $insertWetoonStmt->execute();
            $webtoon->id =  $this->conn->insert_id;
        }

        return $webtoons;
    }


    /**
     * Update webtoon url
     * @param int $id webtoon id
     * @param string $url webtoon url
     * @return void
     */
    function updateWebtoonUrl(int $id, string $url): void
    {
        $sql_update = "UPDATE webtoon SET webtoon.url = ? WHERE webtoon_id = ?;";
        $stmt_update = $this->conn->prepare($sql_update);
        $stmt_update->bind_param("si", $url, $id); // bind parameters

        // update webtoon url
        $stmt_update->execute();   // execute query
    }

    /**
     * Get webtoon id
     * if not present returns -1
     * @return int webtoon id
     */
    function getWebtoonId(string $title): int
    {
        // define sql stmt
        $sql = "SELECT webtoon_id FROM `webtoon` WHERE webtoon.title = ?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $title); // bind parameters


        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_column(0);
        }
        // if not present
        return -1;
    }
}
