<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/6/19
 * Time: 8:37 PM
 */

require_once (__DIR__ . '/auth.php');

// Check auth
$authresults = auth(false);

if (!$authresults['success']) {
	echo '<p class="upload-fail">Not authorized.</p>';
	exit();
} else {
	// HANDLE DUPLICATE FILES
	$targetDir = __DIR__ . "/pdf/";
	$basename = basename($_FILES['file']['name']);
	$targetFile = $targetDir . $basename;
	$filename = pathinfo($targetFile, PATHINFO_FILENAME);
	$fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

	$desiredName = pathinfo($_POST['filename'], PATHINFO_FILENAME);

	$replacementSTR = "";
	$tries = 0;

	do {
		$targetFile = $targetDir . $desiredName . $replacementSTR . "." . $fileType;
		$tries++;
		$replacementSTR = " " . $tries;
	} while (file_exists($targetFile));


	// HANDLE FILE SIZE
	if ($_FILES['file']['size'] > 10000000) {
		echo "<p class=\"upload-fail\">File too large (max 10mb).</p>";
		exit();
	}

	// HANDLE FILE TYPE
	if ($fileType != "pdf") {
		echo "<p class=\"upload-fail\">Invalid file type (only PDF is allowed).</p>";
		exit();
	}

	if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

		// TODO: Do fancy MySQL stuff

		echo "Upload successful";
	} else {
		echo "<p class=\"upload-fail\">Unknown error processing file.</p>";
	}
}
