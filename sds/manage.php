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

$perms = new UserPermissions($authResults['user']->uid);

?>

	<div class="main content">
		<div class="main-container">
			<div class="container header">
				<h3 class="header recent">Manage Accounts</h3>
			</div>
<?php

// main content here
if (!$perms->userHasPermissionsFromUserGroup("Admin")){
	echo "<p>You do not have permission</p>";
}

?>
		</div>
	</div>


<?php


include __DIR__ . '/component/footer.php';