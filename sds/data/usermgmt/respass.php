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

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

$email = $auth->getUser($_POST['uid'])->email;
$auth->sendPasswordResetEmail( $email);

echo "An email has been sent.";
?>

	</p>

	<div class="container">
		<button class="modal-close" style="float: right">Ok</button>
	</div>
</form>