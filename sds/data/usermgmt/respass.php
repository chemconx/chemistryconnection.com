<form class="modal-form" id="respass-form" style="min-width: 200px">
	<p style="margin: 0">

<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/2/19
 * Time: 4:01 PM
 */
require_once __DIR__ . "/../../data/auth.php";

use Kreait\Firebase;

$authresults = auth(false, "Reset Password");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

try {
	$email = $auth->getUser($_POST['uid'])->email;
//	$auth->sendPasswordResetEmail( $email);
	$auth->sendPasswordResetLink($email);
	echo "An email has been sent.";
} catch (\Exception $e) {
	echo 'Failed to send password: '.$e->getMessage();
}

?>

	</p>

	<div class="container">
		<button class="modal-close" style="float: right">Ok</button>
	</div>
</form>