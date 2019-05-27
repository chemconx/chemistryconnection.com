<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/27/19
 * Time: 10:01 AM
 */

require_once __DIR__ . '/../data/Connection.php';
require_once(__DIR__ . "/../data/auth.php");

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have permission";
	exit();
}

if (!isset($_GET['uid'])) {
	echo "Invalid arguments";
	exit();
}


$uid = $_GET['uid'];

if ($uid == $authresults['user']->uid) {
	echo "You cannot delete your own user account.";
	exit();
}

$user = $auth->getUser($_GET['uid']);
$email = $user->email;

?>

<div class="container header">
	<h3>Delete User</h3>
</div>
<div class="container" id="delete-container">
	<form class="modal-form" id="delete-form">
		<p>Are you sure you want to delete the user <?php echo $email ?>? This cannot be undone.</p>
		<input type="hidden" name="uid" id="delete-user-uid" value="<?php echo $uid ?>">
		<div class="container modal-action-buttons">
			<button id="delete-user-accept" class="default-action" style="float: right">Yes</button>
			<button id="delete-user-decline" style="float: right">No</button>
		</div>
	</form>
</div>
