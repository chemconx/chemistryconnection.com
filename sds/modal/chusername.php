<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 4/19/19
 * Time: 7:06 PM
 */

require_once(__DIR__ . "/../data/auth.php");

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

?>

<div class="container header">
	<h3>Change Username</h3>
</div>
<div class="container" id="chusername-container">
	<form class="modal-form" id="chusername-form" method="post" action="./">
		<?php
		if (isset($_GET['uid'])) {

			$user = $auth->getUser($_GET['uid']);
			$username = $user->displayName;

			echo '<input type="text" id="chusername-username" name="username" placeholder="New Username" value="' . $username . '" size="40">';

			echo '<input type="hidden" id="chusername-uid" name="id" value="' . $_GET['uid'] . '">';
		}
		?>

		<div class="container">
			<button type="submit" id="chusername-submit" style="float: right">Change Username</button>
		</div>
	</form>
</div>
