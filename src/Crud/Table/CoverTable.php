<?php

namespace Anmol\Webtoon\Crud\Table;
use Anmol\Webtoon\Crud\Table;

class CoverTable extends  Table
{
	/**
	 * Insert Cover
	 * @param int $w_id
	 * @param string $url
	 */
	function insert_cover(int $w_id, string $url): void
	{
		// define sql stmt
		$sql = "INSERT INTO covers (w_id, url)  VALUES (?, ?) ON DUPLICATE KEY UPDATE url = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("iss", $w_id, $url, $url); // bind parameters

		if ($w_id and $url) {
			try {
				$stmt->execute();   // execute query
			} catch (\mysqli_sql_exception $th) {
				echo $th->getMessage() . "\n";
			}
		}
	}

	/**
	 * Update Cover URL
	 * @param int $w_id
	 * @param string $url
	 */
	function update_cover(int $w_id, string $url): void
	{
		// define sql stmt
		$sql = "UPDATE covers SET url = ? WHERE w_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $url, $w_id); // bind parameters

		if ($w_id and $url) {
			try {
				$stmt->execute();   // execute query
			} catch (\mysqli_sql_exception $th) {
				echo $th->getMessage() . "\n";
			}
		}
	}

	/**
	 * Get all Covers
	 * @return array
	 */
	function get_all_covers():array
	{
		// define sql stmt
		$sql = "SELECT * FROM covers";

		// execute query
		$result = mysqli_query($this->conn, $sql);

		// fetch result
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

		// returns an array of objects
		return $rows;
	}
}