<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/19/19
 * Time: 11:29 PM
 */

include __DIR__ . '/component/page-head.php';

include __DIR__ . '/data/usertoolbar.php';

include __DIR__ . '/component/navbar.php';

require_once("data/auth.php");

$authresults = auth(false);
$displayName;

if ($authresults['success']) {
	if ($authresults['user']->displayName) {
		$displayName = $authresults['user']->displayName;
	} else {
		$displayName = "";
	}

	$email = $authresults['user']->email;

// crap goes here

	?>

	<div class="main content">
		<div class="main-container">
			<div class="container">
				<div class="container header">
					<h3 class="header recent">Account</h3>
				</div>

				<form class="content-form" method="post">

					<div class="form-element">
						<label for="account-form-email">Email:</label>
						<input type="text" id="account-form-email" name="email" placeholder="Email" size="40" value="<?php echo $email; ?>">
					</div>

					<div class="form-element">
						<label for="account-form-display">Display Name:</label>
						<input type="text" id="account-form-display" name="display" placeholder="Display Name"
							   size="40" value="<?php echo $displayName; ?>">
					</div>


					<div class="form-element submit-element">
						<button type="submit" id="account-form-submit">Update</button>
					</div>
				</form>

			</div>

			<div class="container">
				<div class="container header">
					<h3 class="header recent">Change Password</h3>
				</div>
				<form class="content-form" method="post">

					<div class="form-element">
						<label for="account-form-email">Old Password:</label>
						<input type="password" autocomplete="current-password" id="new-pass-form-old" name="oldpass"
							   placeholder="Old Password" size="40">
					</div>

					<div class="form-element">
						<label for="account-form-display">New Password:</label>
						<input type="password" autocomplete="new-password" id="new-pass-form-new" name="newpass"
							   placeholder="New Password" size="40">
					</div>

					<div class="form-element">
						<label for="account-form-display">Confirm:</label>
						<input type="password" autocomplete="confirm-password" id="new-pass-form-confirm" name="confirm"
							   placeholder="Confirm" size="40">
					</div>

					<div class="form-element submit-element">
						<button type="submit" id="new-pass-form-submit">Update</button>
					</div>
				</form>
			</div>

			<div class="container">
			</div>
		</div>
	</div>

	<?php

} else {
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
include __DIR__ . '/component/footer.php';