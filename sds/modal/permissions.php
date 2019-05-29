<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/25/19
 * Time: 9:16 AM
 */
require_once __DIR__ . '/../data/Connection.php';
require_once __DIR__ . '/../data/UserPermissions.php';
require_once(__DIR__ . "/../data/auth.php");

$authresults = auth(false, "Manage Permissions");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

$conn = new Connection();

if ($conn == null) {
	echo "<span class='error'>Error connecting to database.</span>";
	exit();
}

?>

<form class="modal-form" id="permissions-form" style="min-width: 200px">

	<div class="container header">
		<h3 class="header recent">Assign Permissions</h3>
	</div>

	<input id="assign-perms-uid" type="hidden" value="<?php echo $_GET['uid'] ?>" />

	<fieldset class="multi-checkbox">

		<?php


			$perms = $conn->listPermissions($_GET['uid'] == 'public');
			$userperms = new UserPermissions($_GET['uid'], $conn);

			foreach ($perms as $perm) {
				echo "<div class=\"checkboxrow\">
						<input class=\"checkbox\" data-perm-id='" . $perm->id . "' type=\"checkbox\" name=\"checkbox".$perm->id."\" id=\"checkbox".$perm->id."\" ";

				if ($userperms->userHasPermissionID($perm->id)) {
					echo "checked='true'";
				}

				echo ">
						<div class='checkbox-label'>
							<label for=\"checkbox".$perm->id."\">" . $perm->title . "</label>
							<p class='perm-desc'>". $perm->description . "</p>
						</div>
					</div>";
			}

		?>


	</fieldset>

	<div class="container modal-action-buttons">
		<button class="left-most-button" id="assign-perms-select-all">Select All</button>
		<button class="" id="assign-perms-select-none">Select None</button>
		<button class="modal-close default-action" id="assign-perms-save" style="float: right">Save</button>
	</div>

	<?php
	/**
	 * Created by PhpStorm.
	 * User: jasper
	 * Date: 5/20/19
	 * Time: 10:27 PM
	 */

	?>

</form>
