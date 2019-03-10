<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 2/24/19
 * Time: 9:09 PM
 */

class Connection {
	/** @var mysqli */
	var $conn;

	public function __construct() {
		$config = parse_ini_file(__DIR__ . '/private/db.ini');

		$servername = $config['servername'];
		$username = $config['username'];
		$password = $config['password'];
		$dbname = $config['dbname'];

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			$this->conn = null;
			$this->connect_error = $conn->connect_error;
		} else {
			$this->conn = $conn;
		}
	}

	function prepare(string $query) {
		if ($this->conn) {
			return $this->conn->prepare($query);
		} else {
			return false;
		}
	}

	// FILE READ

	/**
	 * @return SafetyDataSheet[]
	 * Null if database connection fails, array of SafetyDataSheets if successful
	 */
	function getAllFiles() {
		$stmt = $this->conn->prepare("SELECT * FROM `file` ORDER BY `name` ASC");
		$stmt->execute();

		$resut = $stmt->get_result();

		$files = array();

		while ($row = $resut->fetch_assoc()) {
			array_push($files, new SafetyDataSheet($row['name'], $row['filepath'], new DateTime($row['date_uploaded']), intval($row['id'])));
		}

		return $files;
	}

	/**
	 * Get five most recent files. Useful if you just uploaded a file and need to copy the link.
	 * @return SafetyDataSheet[]
	 * Null if database connection fails, array of SafetyDataSheets if successful.
	 */
	function getRecentFiles() {
		$stmt = $this->conn->prepare("SELECT * FROM `file` ORDER BY date_uploaded DESC LIMIT 0,5");
		$stmt->execute();

		$resut = $stmt->get_result();

		$files = array();

		while ($row = $resut->fetch_assoc()) {
			array_push($files, new SafetyDataSheet($row['name'], $row['filepath'], new DateTime($row['date_uploaded']), intval($row['id'])));
		}

		return $files;
	}

	function search(string $query) {
		$query = "%".$query."%";
		$stmt = $this->conn->prepare("SELECT * FROM `file` WHERE `name` LIKE ? OR `filepath` LIKE ?");
		$stmt->bind_param('ss', $query, $query);
		$stmt->execute();

		$resut = $stmt->get_result();

		$files = array();

		while ($row = $resut->fetch_assoc()) {
			array_push($files, new SafetyDataSheet($row['name'], $row['filepath'], new DateTime($row['date_uploaded']), intval($row['id'])));
		}

		return $files;
	}

	// FILE MANAGEMENT
	function getFile($id) {
		$stmt = $this->prepare("SELECT * FROM `file` WHERE `id` = ?");
		$stmt->bind_param('i', intval($id));
		$stmt->execute();

		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			return new SafetyDataSheet($row['name'], $row['filepath'], new DateTime($row['date_uploaded']), intval($row['id']));
		}

		return null;
	}

	/**
	 * Adds new file to database records
	 * @param $sds SafetyDataSheet
	 */
	function addNewFile($sds) {
		$stmt = $this->prepare("INSERT INTO `file` (type, name, filepath, date_uploaded) VALUES (1, ?, ?, NOW())");
		$stmt->bind_param("ss",$sds->name, $sds->filepath);
		$stmt->execute();
	}

	/**
	 * Deletes file from database records
	 * @param $sds SafetyDataSheet
	 */
	function deleteFile($sds) {
		$stmt = $this->prepare("DELETE FROM `file` WHERE id = ?");
		$stmt->bind_param("i", $sds->id);
		$stmt->execute();
	}

	/**
	 * Renames file in database records
	 * @param $sds SafetyDataSheet
	 */
	function renameFile($sds) {
		$stmt = $this->prepare("UPDATE `file` SET `name` = ?, `filepath` = ? WHERE id = ?");
		$stmt->bind_param("ssi", $sds->name, $sds->filepath, $sds->id);
		$stmt->execute();
	}
}