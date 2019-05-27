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
	var $uid;

	public function __construct($uid, $conn = null) {
		if ($conn == null) {
			$this->conn = new Connection();
		} else {
			$this->conn = $conn;

		}

		$this->uid = $uid;
	}

	public function userHasPermission($perm) {
		// get permission ID from name of permission
		$stmt = $this->conn->prepare("SELECT id FROM perms where title = ?");
		$stmt->bind_param('s', $perm);
		$stmt->execute();
		$result_row = $stmt->get_result()->fetch_row();

		if ($result_row != null && count($result_row) == 1) {
			return $this->userHasPermissionID($result_row[0]);
		} else {
			return false;
		}

		// check if user has ID
	}

	public function userHasPermissionID($permid) {
		$stmt = $this->conn->prepare("SELECT * FROM userperms where uid = ? AND permid = ?");
		$stmt->bind_param('si', $this->uid, intval($permid));
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->num_rows == 1;
	}

	public function updateUserPermission($permid, $value = true) {
		$stmt = null;
		if ($value) {
			$stmt = $this->conn->prepare("INSERT INTO `userperms` (uid, permid) VALUES (?, ?) ");
		} else {
			$stmt = $this->conn->prepare("DELETE FROM `userperms` WHERE `uid` = ? AND `permid` = ? ");
		}

		$stmt->bind_param('si', $this->uid, $permid);
		$stmt->execute();
	}

	public function userHasPermissionsFromUserGroup($group) {
		$stmt = $this->conn->prepare("SELECT * FROM perms WHERE usergroup = ?");
		$stmt->bind_param('s', $group);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0) {
			return false;
		}

		$newStmt = "SELECT permid FROM userperms WHERE uid = ? AND (";

		$index = 0;
		while ($row = $result->fetch_assoc()) {
			if ($index == 0) {
				$newStmt = $newStmt . "permid = " . $row['id'] . " ";
			} else {
				$newStmt = $newStmt . "OR permid = " . $row['id'] . " ";
			}

			$index++;
		}

		$newStmt = $newStmt . ");";
		$stmt = $this->conn->prepare($newStmt);
		$stmt->bind_param("s", $this->uid);
		$stmt->execute();

		return $stmt->get_result()->num_rows >= 1;
	}
}