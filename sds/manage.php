<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 4/9/19
 * Time: 6:48 PM
 *
 *
 * This is where administrators can create a new account, reset passwords and display names, and control user permissions
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . "/data/auth.php");
require_once(__DIR__ . "/data/UserPermissions.php");

include __DIR__ . '/component/page-head.php';

include __DIR__ . '/data/usertoolbar.php';

include __DIR__ . '/component/navbar.php';

$perms = null;

if ($authResults['success']) {
	$perms = new UserPermissions($authResults['user']->uid);
}

?>

	<div class="main content">
		<div class="main-container">

<?php

// main content here
if (!$perms || !$perms->userHasPermissionsFromUserGroup("Admin")){
	echo '<div class="container header">
				<h3 class="header recent">Manage Accounts</h3>
			</div>';


	echo "<p>You do not have permission</p>";
} else {
	?>

	<div class="container userlist">
		<div class="container header">
			<h3 class="header userlist">Manage Accounts</h3>
			<button id="add-user-button">ADD USER</button>
		</div>

		<!-- table data -->
		<table id="user-table">

		</table>
	</div>

	<?php
}

?>
		</div>
	</div>

<div style="display: none" id="threedotsdropdown">
	<a class="threedotsaction" id="chusername-threedotsaction">Change Username</a>
	<a class="threedotsaction" id="respass-threedotsaction">Reset Password</a>
	<a class="threedotsaction" id="perms-threedotsaction">Permissions</a>
	<a class="threedotsaction destructive" id="del-threedotsaction">Delete</a>
</div>

<?php

if ($authResults['success']) {
	$scripts = [
		'<script src="js/ui-dropdown/dropdown.min.js"></script>',
		'<script src="js/ui-transition/transition.min.js"></script>',
		'<script src="js/manage.js"></script>'
	];
}

include __DIR__ . '/component/footer.php';