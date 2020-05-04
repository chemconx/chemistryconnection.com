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

?>

	<div class="main content">
		<div class="main-container">

<?php

// main content here
if (!$authResults['success'] || !$perms || !$perms->userHasPermissionsFromUserGroup("1 Admin")){
	echo '<div class="container header">
				<h3 class="header recent">Manage Accounts</h3>
			</div>';


	echo "<p>You do not have permission</p>";
} else {
	?>

	<div class="container userlist">
		<div class="container header">
			<h3 class="header userlist">Manage Accounts</h3>

			<?php if ($perms->userHasPermission('Create User')) { ?>
				<button id="add-user-button">ADD USER</button>
			<?php } ?>
		</div>

		<!-- table data -->
		<table id="user-table">

		</table>
	</div>

	<?php if ($perms->userHasPermission('Manage Permissions')) { ?>

		<div class="container public">
			<div class="container header">
				<h3 class="header public">Manage Public Permissions</h3>
				<button id="public-permissions">PUBLIC PERMISSIONS</button>
			</div>

			<p>Manage permissions for unsigned users</p>
		</div>

		<div class="container newuserdefault">
			<div class="container header">
				<h3 class="header public">Manage Default Permissions for New Users</h3>
				<button id="default-permissions">DEFAULT PERMISSIONS</button>
			</div>

			<p>Manage default permissions for new users.</p>
		</div>

		<?php

	}
}

?>
		</div>
	</div>

<div style="display: none" id="threedotsdropdown">
	<?php if ($perms->userHasPermission('Change Display Name')) { ?>
	<a class="threedotsaction" id="chusername-threedotsaction">Change Username</a>
	<?php }

	if ($perms->userHasPermission('Change Email Address')) { ?>
	<a class="threedotsaction" id="chemail-threedotsaction">Change Email</a>
	<?php }

	if ($perms->userHasPermission('Reset Password')) { ?>
	<a class="threedotsaction" id="respass-threedotsaction">Reset Password</a>
	<?php }

	if ($perms->userHasPermission("Manage Permissions")){?>
	<a class="threedotsaction" id="perms-threedotsaction">Permissions</a>
	<?php }

	if ($perms->userHasPermission("Delete User")){?>
	<a class="threedotsaction destructive" id="del-threedotsaction">Delete</a>
	<?php } ?>
</div>

<?php

if ($authResults['success']) {
	$scripts = [
		'<script src="js/ui-dropdown/dropdown.min.js"></script>',
		'<script src="js/ui-transition/transition.min.js"></script>',
		'<script type="module" src="js/manage.js"></script>'
	];
}

include __DIR__ . '/component/footer.php';