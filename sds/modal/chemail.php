<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/29/19
 * Time: 3:33 PM
 */

require_once(__DIR__ . "/../data/auth.php");

$authresults = auth(false, "Change Email Address");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

?>

<div class="container header">
	<h3>Change Email</h3>
</div>
<div class="container" id="chemail-container">
	<form class="modal-form" id="chemail-form" method="post" action="./">
		<?php
		if (isset($_GET['uid'])) {

			$user = $auth->getUser($_GET['uid']);
			$email = $user->email;

			echo '<input type="text" id="chemail-email" name="email" placeholder="New Email" value="' . $email . '" size="40">';

			echo '<input type="hidden" id="chemail-uid" name="id" value="' . $_GET['uid'] . '">';
		}
		?>

		<div class="container">
			<button type="submit" id="chemail-submit" style="float: right">Change Email</button>
		</div>
	</form>
</div>
