<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/29/19
 * Time: 3:47 PM
 */

require_once(__DIR__ . "/../../data/auth.php");

$authresults = auth(false, "Change Email Address");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

// data validation
if (!isset($_POST['uid']) || !isset($_POST['email'])) {
	echo "<p style='margin: 0;' class='error'>Invalid data.</p>";
}

if (empty($_POST['email']) || strlen($_POST['email']) < 1) {
	echo "<p style='margin: 0;' class='error'>Email must have at least 1 character</p>";
	exit();
}

$properties = [
	'email' => $_POST['email']
];

$updatedUser = $auth->updateUser($_POST['uid'], $properties);

if ($updatedUser->uid == $_SESSION['user']->uid) {
	$_SESSION['user'] = $updatedUser;
}

?>

<p style="margin: 0;">Email changed successfully</p>

<div class="container">
	<button class="modal-close" style="float: right">Ok</button>
</div>