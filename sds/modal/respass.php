<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 4/20/19
 * Time: 5:03 PM
 */

require_once __DIR__ . "/../data/auth.php";

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

if (!isset($_GET['uid'])) {
	echo "Invalid arguments";
	exit();
}


$user = $auth->getUser($_GET['uid']);
$email = $user->email;
//$auth->sendPasswordResetEmail($email);
?>

<div class="container header">
	<h3>Reset Password</h3>
</div>
<div class="container" id="respass-container">
	<form class="modal-form" id="respass-form">
		<p>Are you sure you want to rest the password for <?php echo $email; ?>? The user will receive an email to reset their password.</p>
		<input type="hidden" name="uid" id="respass-uid" value="<?php echo $user->uid; ?>">
		<div class="container modal-action-buttons">
			<button id="respass-accept" class="default-action" style="float: right">Yes</button>
			<button id="respass-decline" style="float: right">No</button>
		</div>
	</form>
</div>