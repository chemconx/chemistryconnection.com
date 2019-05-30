<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/6/19
 * Time: 6:05 PM
 */

require_once __DIR__ . '/../data/DataSheet.php';
require_once __DIR__ . '/../data/Connection.php';
require_once __DIR__ . "/../data/auth.php";

$authresults = auth(false, "Delete File");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

if (!isset($_GET['id'])) {
	echo "Invalid arguments";
	exit();
}


$conn = new Connection();
$sds;

if ($conn == null) {
	echo 'Unable to connect to database';
	exit();
}

$sds = $conn->getFile($_GET['id']);

if ($sds == null) {
	echo '<p>File not found</p>';
	exit();
}


?>

<div class="container header">
	<h3>Delete File</h3>
</div>
<div class="container" id="delete-container">
	<form class="modal-form" id="delete-form">
		<p>Are you sure you want to delete <?php echo $sds->name ?>? This cannot be undone.</p>
		<input type="hidden" name="id" id="delete-file-id" value="<?php echo $sds->id ?>">
		<div class="container modal-action-buttons">
			<button id="delete-file-accept" class="default-action" style="float: right">Yes</button>
			<button id="delete-file-decline" style="float: right">No</button>
		</div>
	</form>
</div>
