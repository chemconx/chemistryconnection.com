<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/6/19
 * Time: 6:05 PM
 */

require_once(__DIR__ . "/../data/auth.php");

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

?>

<div class="container header">
	<h3>Upload File</h3>
</div>
<div class="container" id="upload-container">
	<form class="login-form" id="upload-form">
		<input class="upload-input" type="file" id="upload-file-input" name="file" accept=".pdf">
		<label for="upload-file-input"><i class="fas fa-file-upload"></i> Choose...</label>
		<input type="text" name="filename" id="upload-file-rename-input" placeholder="Rename" size="35">
		<p id="upload-msg">You can optionally provide an alternate name</p>

		<div id="progress-wrp" style="display: none;">
			<div class="progress-bar"></div>
<!--			<div class="status">0%</div>-->
		</div>

		<div class="container">
			<button id="upload-file-submit" style="float: right">Upload</button>
		</div>
	</form>
</div>
