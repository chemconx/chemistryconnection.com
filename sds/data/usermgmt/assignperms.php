<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/25/19
 * Time: 4:08 PM
 */

require_once __DIR__ . '/../Connection.php';
require_once __DIR__ . '/../UserPermissions.php';
require_once(__DIR__ . "/../auth.php");

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have permission";
	exit();
}

$conn = new Connection();

if ($conn == null) {
	echo "Error connecting to database.";
	exit();
}

$userPerms = new UserPermissions($_POST['uid'], $conn);

$perms = json_decode($_POST['perms'], true);

foreach ($perms as $perm => $enabled) {
	$userPerms->updateUserPermission($perm, $enabled);
}

echo "Updated permissions successfully!";