<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 4/20/19
 * Time: 4:05 PM
 */
require_once(__DIR__ . "/../../data/auth.php");

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

// data validation
if (!isset($_POST['uid']) || !isset($_POST['username'])) {
	echo "<p style='margin: 0;' class='error'>Invalid data.</p>";
}

if (empty($_POST['username']) || strlen($_POST['username']) < 1) {
	echo "<p style='margin: 0;' class='error'>Username must have at least 1 character</p>";
	exit();
}

$properties = [
	'displayName' => $_POST['username']
];

$updatedUser = $auth->updateUser($_POST['uid'], $properties);


?>

<p style="margin: 0;">Username changed successfully</p>

<div class="container">
	<button class="modal-close" style="float: right">Ok</button>
</div>