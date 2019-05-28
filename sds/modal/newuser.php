<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/27/19
 * Time: 11:53 AM
 */

?>

<div class="container header">
	<h3>New User</h3>
</div>
<div class="container" id="new-user-container">
	<form class="modal-form" id="new-user-form">
<!--		<input type="email" id="add-user-email" name="email">-->
<!--		<input type="text" id="add-user-name" name="name">-->

		<div class="form-element">
			<label for="new-user-display-name">Display Name:</label>
			<input type="text" id="new-user-display-name" name="displayName" placeholder="Display Name"
				   size="40">
		</div>

		<div class="form-element">
			<label for="new-user-email">Email:</label>
			<input type="email" id="new-user-email" name="email" placeholder="Email"
				   size="40">
		</div>

		<div class="form-element" style="display: none;" id="new-user-email-err">
			<label></label>
			<p class="small error">Email is required.</p>
		</div>

		<div class="form-element">
			<label for="new-user-password">Password</label>
			<input type="password" id="new-user-password" name="password" placeholder="Password"
				   size="40">
		</div>

		<div class="form-element" style="display: none;" id="new-user-pass-err">
			<label></label>
			<p class="small error">Passwords do not match.</p>
		</div>

		<div class="form-element">
			<label for="new-user-confpass">Confirm:</label>
			<input type="password" id="new-user-confpass" name="confpass" placeholder="Confirm"
				   size="40">
		</div>

		<div class="container">
			<button type="submit" id="new-user-submit" style="float: right">Save</button>
		</div>
	</form>
</div>