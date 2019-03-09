<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/9/19
 * Time: 1:54 PM
 */

require_once __DIR__ . '/../data/SafetyDataSheet.php';
require_once __DIR__ . '/../data/Connection.php';
require_once(__DIR__ . "/../data/auth.php");

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

?>

<div class="container header">
	<h3>Rename</h3>
</div>
<div class="container" id="rename-container">
	<form class="modal-form" id="login-form" method="post" action="./">
		<?php
			if (isset($_GET['id'])) {

				$conn = new Connection();

				if ($conn == null) {
					echo '<p>Unable to connect to database</p>';
				} else {

					$sds = $conn->getFile($_GET['id']);

					if ($sds == null) {
						echo '<p>File not found</p>';
					} else {

						echo '<input type="text" id="rename-file-name" name="rename" placeholder="New name" value="' . $sds->name . '" size="40">';

						echo '<input type="hidden" id="rename-file-id" name="id" value="' . $_GET['id'] . '">';
					}
				}
			}
		?>

		<div class="container">
			<button type="submit" id="rename-file-submit" style="float: right">Rename</button>
		</div>
	</form>
</div>
