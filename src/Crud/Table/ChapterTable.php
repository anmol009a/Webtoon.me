<?php

namespace Anmol\Webtoon\Crud\Table;

use Anmol\Webtoon\Crud\Table;

class ChapterTable extends Table
{

	/**
	 * Insert Chapter
	 * @return int if chapter inserted or not
	 */
	function insertOneChapter(int $w_id, int $number, string $url): int
	{
		// define sql stmt
		$getChapterByNumberSql = "SELECT chapter_id FROM webtoon_chapter WHERE webtoon_chapter.number = ? and webtoon_id = ?;";
		$insertChapterSql = "INSERT INTO webtoon_chapter (webtoon_id, webtoon_chapter.number, webtoon_chapter.url)  VALUES (?, ?, ?)";

		$getChapterByNumberStmt = $this->conn->prepare($getChapterByNumberSql);
		$insertChapterStmt = $this->conn->prepare($insertChapterSql);

		// check if chapter present; checking only one as in dec. order
		$getChapterByNumberStmt->bind_param("di", $number, $w_id); // bind parameters
		$getChapterByNumberStmt->execute();
		$result = $getChapterByNumberStmt->get_result();

		// chapter present
		if ($result->num_rows > 0)  return $result->fetch_column(0);;
			// insert chapter
			$insertChapterStmt->bind_param("ids", $w_id, $number, $url); // bind parameters
			
			try {
				$insertChapterStmt->execute();
				return $this->conn->insert_id;
		} catch (\mysqli_sql_exception $th) {
			echo $th->getMessage() . "\n";
		}
		return -1;
	}

	/**
	 * Insert Many Chapters
	 * @param $chapters array of chapter objects
	 */
	function insertManyChapter(array $chapters)
	{
		// define sql stmt
		$getChapterByNumberSql = "SELECT chapter_id FROM webtoon_chapter WHERE webtoon_chapter.number = ? and webtoon_id = ?;";
		$insertChapterSql = "INSERT INTO webtoon_chapter (webtoon_id, webtoon_chapter.number, webtoon_chapter.url)  VALUES (?, ?, ?)";

		// prepare stmt
		$getChapterByNumberStmt = $this->conn->prepare($getChapterByNumberSql);
		$insertChapterStmt = $this->conn->prepare($insertChapterSql);

		// for each chapter
		foreach ($chapters as $chapter) {
			// check if chapter present
			$getChapterByNumberStmt->bind_param("di", $chapter->number, $chapter->webtoon_id); // bind parameters
			$getChapterByNumberStmt->execute();	// execute query
			$result = $getChapterByNumberStmt->get_result(); // get result

			// chapter present
			if ($result->num_rows > 0) continue;

			// chapter not present: insert
			// bind parameters
			$insertChapterStmt->bind_param("ids",  $chapter->webtoon_id, $chapter->number, $chapter->url); 
			$insertChapterStmt->execute();
		}
		return true;
	}


	/**
	 * Get Webtoon Chapters (default 2)
	 * @param int $w_id webtoon id
	 * @param int $limit no of chapters
	 * @return array of objects
	 */
	function getChapters(int $w_id, int $limit = 2): array
	{
		// define sql stmt
		$sql = "SELECT * FROM webtoon_chapter WHERE webtoon_id = ? ORDER BY webtoon_chapter.number DESC LIMIT $limit";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $w_id); // bind parameters


		$stmt->execute();
		$result = $stmt->get_result();

		// fetch result
		$rows =  $result->fetch_array(MYSQLI_NUM);

		// returns an array of objects
		return $rows;
	}
	function getChapterByNumber(int $number, $w_id): int
	{
		// define sql stmt
		$getChapterByNumberSql = "SELECT chapter_id FROM webtoon_chapter WHERE webtoon_chapter.number = ? and webtoon_id = ?;";
		$getChapterByNumberStmt = $this->conn->prepare($getChapterByNumberSql);

		// check if chapter present
		$getChapterByNumberStmt->bind_param("di", $number, $w_id); // bind parameters
		$getChapterByNumberStmt->execute();
		$result = $getChapterByNumberStmt->get_result();

		if ($result->num_rows) {
			return $result->fetch_column(0);
		}
		// if not present
		return -1;
	}
}
