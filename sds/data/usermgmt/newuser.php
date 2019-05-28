<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/27/19
 * Time: 12:25 PM
 */

require_once __DIR__ . "/../../data/auth.php";

$authresults = auth(false);

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
	echo "User created successfully.";
} catch (Kreait\Firebase\Exception\Auth\EmailExists $e) {
	echo "Cannot create user: Email exists.";
}
