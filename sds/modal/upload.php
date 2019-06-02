<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/6/19
 * Time: 6:05 PM
 */

require_once(__DIR__ . "/../data/auth.php");
require_once __DIR__ . '/../data/Connection.php';

$authresults = auth(false, "Upload File");

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

$conn = new Connection();

if ($conn == null) {
	echo "<p>Unable to connect to database</p>";
}

?>

<div class="container header">
	<h3>Upload File</h3>
</div>
<div class="container" id="upload-container">
	<form class="modal-form" id="upload-form">
		<input class="upload-input" type="file" id="upload-file-input" name="file" accept=".pdf">
		<label for="upload-file-input"><i class="fas fa-file-upload"></i> Choose...</label>
		<div>
			<select class="ui dropdown" id="upload-file-filetype">
				<?php

				foreach ($conn->getDataSheetTypes() as $type){
					echo "<option value='" . $type['id'] . "'>" . $type['display_name'] . "</option>";
				}

				?>
			</select>
		</div>

		<input type="text" name="filename" id="upload-file-rename-input" placeholder="Rename" size="45">
		<p id="upload-msg" class="small">You can optionally provide an alternate name</p>

		<div id="progress-wrp" style="display: none;">
			<div class="progress-bar"></div>
			<!--			<div class="status">0%</div>-->
		</div>

		<div class="container">
			<button id="upload-file-submit" style="float: right">Upload</button>
		</div>
	</form>
</div>
