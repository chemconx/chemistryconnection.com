<?php


class Connection {
	/** @var mysqli */
	var $conn;

	public function __construct() {
		$config = parse_ini_file(__DIR__ . '/db.ini');

		$servername = $config['servername'];
		$username = $config['username'];
		$password = $config['password'];
		$dbname = $config['dbname'];

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			echo "Connect error: " . $conn->connect_error;
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

	function search(string $query) {
		$mysqlquery = "SELECT * FROM `goatthroat`.`chemicals` WHERE `chemical` LIKE ?";

		$query = "%".$query."%";
		$stmt = $this->conn->prepare($mysqlquery);
		$stmt->bind_param('s', $query);
		$stmt->execute();

		$result = $stmt->get_result();

		$chemicals = array();

		while ($row = $result->fetch_assoc()) {
			array_push($chemicals, $this->chemicalFromRow($row));
		}

		return $chemicals;
	}

	function chemicalFromRow($row) {
		$chemical = [];
		$chemical['chemical'] = $row['chemical'];
		$chemical['gt100'] = $row['gt100'];
		$chemical['gt200'] = $row['gt200'];
		$chemical['gt300'] = $row['gt300'];
		$chemical['hose_rec_1'] = $row['hose_rec_1'];
		$chemical['hose_rec_2'] = $row['hose_rec_2'];
		$chemical['notes'] = $row['notes'];
		return $chemical;
	}
}