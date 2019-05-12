<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/19/19
 * Time: 11:29 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/component/page-head.php';

require_once(__DIR__ . "/data/auth.php");

$authresults = auth(false);
$displayName;

function changePassword($uid) {
	global $auth;
	$result = ['error' => false, 'msg' => array()];

	$old = "";
	$new = "";
	$confirm = "";

	if ((isset($_POST['oldpass']) && !empty($_POST['oldpass']))
		|| (isset($_POST['newpass']) && !empty($_POST['newpass']))
		|| (isset($_POST['confirm']) && !empty($_POST['confirm']))) {

		if (!isset($_POST['oldpass']) || empty($_POST['oldpass'])) {
			$result['error'] = true;
			array_push($result['msg'], 'Password is required.');
		} else {
			$old = $_POST['oldpass'];
		}

		if (!isset($_POST['newpass']) || empty($_POST['newpass'])) {
			$result['error'] = true;
			array_push($result['msg'], 'New password is required.');
		} else {
			$new = $_POST['newpass'];
		}

		if (!isset($_POST['confirm']) || empty($_POST['confirm'])) {
			$result['error'] = true;
			array_push($result['msg'], 'Confirm password is required.');
		} else {
			$confirm = $_POST['confirm'];
		}

		if ($result['error']) {
			return $result;
		}

		if (strlen($old) < 6) {
			$result['error'] = true;
			array_push($result['msg'], 'Password is incorrect.');
		}

		if (strlen($new) < 6){
			$result['error'] = true;
			array_push($result['msg'], 'New password must be six or more characters long.');
		}

		if (strlen($confirm) < 6){
			$result['error'] = true;
			array_push($result['msg'], 'Confirm password must be six or more characters long.');
		}

		if ($result['error']) {
			return $result;
		}

		if ($new != $confirm) {
			$result['error'] = true;
			array_push($result['msg'], 'Passwords do not match.');
			return $result;
		}

		$updatedUser = $auth->changeUserPassword($uid, $new);

		$result['user'] = $updatedUser;
		$result['success'] = true;

		return $result;
	}
}

if ($authresults['success']) {
	$uid = $authresults['user']->uid;
	$properties = array();
	$updateUser = false;

	// check post data
	if (isset($_POST['email']) && !empty($_POST['email']) && $_POST['email'] != $authresults['user']->email) {
		// we won't update email if it's empty
		$properties['email'] = $_POST['email'];
		$updateUser = true;
	}

	if (isset($_POST['display']) && !empty($_POST['display']) && $_POST['display'] != $authresults['user']->displayName) {
		// we won't update email if it's empty
		$properties['displayName'] = $_POST['display'];
		$updateUser = true;
	}


	if ($updateUser) {
		$updatedUser = $auth->updateUser($uid, $properties);
		$_SESSION['user'] = $updatedUser;
		$authresults['user'] = $updatedUser;
	}

	$passRes = changePassword($uid);

	if ($authresults['user']->displayName) {
		$displayName = $authresults['user']->displayName;
	} else {
		$displayName = "";
	}

	$email = $authresults['user']->email;

	include __DIR__ . '/data/usertoolbar.php';

	include __DIR__ . '/component/navbar.php';

// crap goes here

	?>

	<div class="main content">
		<form class="content-form main-container" method="post">
			<div class="container header">
				<h3 class="header recent">Account</h3>
			</div>

			<?php if ($updateUser) { ?>

				<p class="success hide-eventually">Successfully updated user.</p>

			<?php } ?>

			<div class="form-element">
				<label for="account-form-email">Email:</label>
				<input type="text" id="account-form-email" name="email" placeholder="Email" size="40"
					   value="<?php echo $email; ?>">
			</div>

			<div class="form-element">
				<label for="account-form-display">Name:</label>
				<input type="text" id="account-form-display" name="display" placeholder="Display Name"
					   size="40" value="<?php echo $displayName; ?>">
			</div>

			<div class="form-element submit-element">
				<button type="submit" id="account-form-submit">Update</button>
			</div>
			<div class="container header">
				<h3 class="header recent">Change Password</h3>
			</div>

			<?php

			if ($passRes['error']) {
				foreach ($passRes['msg'] as $msg) {
					echo "<p class=\"error\">$msg</p>";
				}
			} else if($passRes['success']) {
				echo '<p class="success hide-eventually">Password updated successfully.</p>';
			}


			?>

			<div class="form-element">
				<label for="new-pass-form-old">Old Password:</label>
				<input type="password" autocomplete="current-password" id="new-pass-form-old" name="oldpass"
					   placeholder="Old Password" size="40" class="chpassfield">
			</div>

			<div class="form-element" id="new-pass-form-old-msg-container" style="display: none">
				<label></label>
				<p class="small error" id="new-pass-form-old-msg"></p>
			</div>

			<div class="form-element">
				<label for="new-pass-form-new">New Password:</label>
				<input type="password" autocomplete="new-password" id="new-pass-form-new" name="newpass"
					   placeholder="New Password" size="40" class="chpassfield">
			</div>

			<div class="form-element" id="new-pass-form-new-msg-container" style="display: none">
				<label></label>
				<p class="small error" id="new-pass-form-new-msg"></p>
			</div>

			<div class="form-element">
				<label for="new-pass-form-confirm">Confirm:</label>
				<input type="password" autocomplete="confirm-password" id="new-pass-form-confirm" name="confirm"
					   placeholder="Confirm" size="40" class="chpassfield">
			</div>

			<div class="form-element" id="new-pass-form-confirm-msg-container" style="display: none">
				<label></label>
				<p class="small error" id="new-pass-form-confirm-msg"></p>
			</div>

			<div class="form-element submit-element">
				<button type="submit" id="new-pass-form-submit">Update</button>
			</div>
		</form>
	</div>

	<?php

} else {

	include __DIR__ . '/component/navbar.php';

	?>

	<div class="main content">
		<div class="main-container">
			<div class="container">
				<div class="container header">
					<h3 class="header recent">Not Authorized</h3>
				</div>

				<p>Please sign in</p>

			</div>
		</div>
	</div>

	<?php
}

$scripts = ['<script src="js/account.js"></script>'];
include __DIR__ . '/component/footer.php';