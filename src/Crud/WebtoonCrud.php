<?php
namespace Anmol\Webtoon\Crud;

use Anmol\Webtoon\Crud\DatabaseHandler;

class WebtoonCrud extends DatabaseHandler
{
	private $webtoon_table;
	private $cover_table;
	private $chapter_table;

	/**
	 * Insert Webtoons with chapters and covers
	 * @param array $webtoons
	 * @todo update webtoon url only when a new chapter is inserted
	 * @todo update cover url
	 */
	function insertAllWebtoonData(array $webtoons): void
	{
		// define sql
		$getWebtoonIdSql = "SELECT webtoon_id FROM `webtoon` WHERE webtoon.title = ?;";	// get webtoon sql
		$insertWetoonSql = "INSERT INTO webtoon (webtoon.title, webtoon.url, webtoon.cover_url)  VALUES (?, ?,?)";

		$updateWebtoonUrlSql = "UPDATE webtoon SET webtoon.url = ? WHERE webtoon_id = ?;";

		$getChapterByNumberSql = "SELECT chapter_id FROM webtoon_chapter WHERE webtoon_chapter.number = ? and webtoon_id = ?;";
		$insertChapterSql = "INSERT INTO webtoon_chapter (webtoon_id, webtoon_chapter.number, webtoon_chapter.url)  VALUES (?, ?, ?)";

		// define stmt
		$getWebtoonIdStmt = $this->conn->prepare($getWebtoonIdSql);
		$insertWetoonStmt = $this->conn->prepare($insertWetoonSql);
		$updateWebtoonUrlStmt = $this->conn->prepare($updateWebtoonUrlSql);
		$insertChapterStmt = $this->conn->prepare($insertChapterSql);
		$getChapterByNumberStmt = $this->conn->prepare($getChapterByNumberSql);


		// for each webtoon
		foreach ($webtoons as $webtoon) {
			// check if webtoon present
			$getWebtoonIdStmt->bind_param("s", $webtoon->title); // bind parameters
			$getWebtoonIdStmt->execute();
			$result = $getWebtoonIdStmt->get_result();

			// webtoon present
			if ($result->num_rows) {
				$webtoonId = $result->fetch_column(0);
			}
			// webtoon not present
			else {
				$insertWetoonStmt->bind_param("sss", $webtoon->title, $webtoon->url, $webtoon->cover_url);    // bind parameters
				$insertWetoonStmt->execute();
				$webtoonId = $this->conn->insert_id;
			}

			// check if chapters present
			if (!isset($webtoon->chapters))
				continue;


			// for each chapter
			foreach ($webtoon->chapters as $chapter) {
				// check if chapter present
				$getChapterByNumberStmt->bind_param("di", $chapter->number, $webtoonId); // bind parameters
				$getChapterByNumberStmt->execute();
				$result = $getChapterByNumberStmt->get_result();

				// chapter present
				if ($result->num_rows)
					continue;

				// chapter not present
				// insert chapter
				$insertChapterStmt->bind_param("ids", $webtoonId, $chapter->number, $chapter->url); // bind parameters
				$insertChapterStmt->execute();
			}
		}
	}

	/**
	 * Search for a webtoon
	 * @param int $limit no of webtoons
	 * @return array of objects
	 */
	function searchWebtoon(string $query, int $limit = 18): array
	{
		// define sql stmt
		$search_webtoon_sql = "SELECT * FROM `webtoon` WHERE `webtoon`.`title` LIKE '%$query%' ORDER BY `webtoon`.`updated_at` DESC Limit $limit;";
		$get_chapters_sql = "SELECT * FROM webtoon_chapter WHERE webtoon_id = ? ORDER BY webtoon_chapter.number DESC LIMIT 3;";

		// prepare stmt
		$get_chapters_stmt = $this->conn->prepare($get_chapters_sql);

		// execute query
		$result = mysqli_query($this->conn, $search_webtoon_sql);

		// fetch result
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($rows as $key => $row) {

			$get_chapters_stmt->bind_param("i", $row['webtoon_id']); // bind parameters
			$get_chapters_stmt->execute();	// execute query
			$result = $get_chapters_stmt->get_result(); // get result

			// fetch result
			$chapters = $result->fetch_all(MYSQLI_ASSOC);
			
			$rows[$key]['chapters'] = $chapters;	// insert result into webtoon array
		}

		// returns an array of objects
		return $rows;
	}

	/**
	 * Get Webtoons
	 * @param int $limit no of webtoons
	 * @return array  Associative array of webtoons
	 */
	function getWebtoons(int $limit = 30, int $offset = 0): array
	{
		// define sql stmt
		$get_webtoon_sql = "SELECT * FROM webtoon ORDER BY webtoon.updated_at desc;";
		$get_chapters_sql = "SELECT * FROM webtoon_chapter WHERE webtoon_id = ? ORDER BY webtoon_chapter.number DESC LIMIT 3;";

		// prepare stmt
		$get_chapters_stmt = $this->conn->prepare($get_chapters_sql);

		// execute query
		$result = mysqli_query($this->conn, $get_webtoon_sql);

		// fetch result
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($rows as $key => $row) {

			$get_chapters_stmt->bind_param("i", $row['webtoon_id']); // bind parameters
			$get_chapters_stmt->execute();	// execute query
			$result = $get_chapters_stmt->get_result(); // get result

			// fetch result
			$chapters = $result->fetch_all(MYSQLI_ASSOC);
			
			$rows[$key]['chapters'] = $chapters;	// insert result into webtoon array
		}

		// returns an array of objects
		return $rows;
	}
}
