<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/27/19
 * Time: 12:25 PM
 */

require_once __DIR__ . '/../Connection.php';
require_once __DIR__ . '/../UserPermissions.php';
require_once __DIR__ . "/../auth.php";

$authresults = auth(false, "Create User");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

$userProperties = [
	'email' => $_POST['email'],
	'emailVerified' => false,
	'displayName' => $_POST['display_name'],
];

try {
	$createdUser = $auth->createUser($userProperties);

	$conn = new Connection();
	$userPerms = new UserPermissions($createdUser->uid, $conn);

	$perms = $conn->listDefaultPermissions();
	foreach ($perms as $perm) {
		$userPerms->updateUserPermission($perm->id,true);
	}

	echo "User created successfully.";
} catch (Kreait\Firebase\Exception\Auth\EmailExists $e) {
	echo "Cannot create user: Email exists.";
}