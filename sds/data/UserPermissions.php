<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 4/6/19
 * Time: 2:25 PM
 */

require_once __DIR__ . '/Connection.php';


class UserPermissions {
	/** @var Connection */
	var $conn;

	public function __construct() {
		$this->conn = new Connection();
	}

	public function userHasPermission($uid, $perm) {
		// get permission ID from name of permission
		$stmt = $this->conn->prepare("SELECT id FROM perms where title = ?");
		$stmt->bind_param('s', $perm);
		$stmt->execute();
		$result_row = $stmt->get_result()->fetch_row();

		if ($result_row != null && count($result_row) == 1) {
			return $this->userHasPermissionID($uid, $result_row[0]);
		} else {
			return false;
		}

		// check if user has ID
	}

	public function userHasPermissionID($uid, $permid) {
		$stmt = $this->conn->prepare("SELECT * FROM userperms where uid = ? AND permid = ?");
		$stmt->bind_param('si', $uid, intval($permid));
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->num_rows == 1;
	}
}