<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/4/19
 * Time: 1:57 PM
 */

require_once (__DIR__ . "/SafetyDataSheet.php");
require_once (__DIR__ . "/Connection.php");
require_once (__DIR__ . "/auth.php");

$login = false;

$fileRowTeemplate = '
<tr>
	<td><a href="">{FILENAME}</a></td>
	<td><button>Download</button></td>
	<td><button>Copy Link</button></td>
</tr>
';

// check for session

$authResult = auth(false);

if ($authResult['success']) {
	$login = true;
	$fileRowTeemplate = '
<tr>
	<td><a href="">{FILENAME}</a></td>
	<td><button>Download</button></td>
	<td><button>Rename</button></td>
	<td><button>Copy Link</button></td>
	<td><button class="destructive">Delete</button></td>
</tr>
';
}

// initialize connection to database
$conn = new Connection();

if ($conn == null) {
	echo "Error connecting to database. ";
	echo '<pre>' . var_export($conn->connect_error, true) . '</pre>';
	exit();
}

// load files
$recentsdsheets = $conn->getAllFiles();

echo '<colgroup>
					<col width="100%">
					<col width="0%">
					<col width="0%">
					<col width="0%">
					<col width="0%">
				</colgroup>';

foreach ($recentsdsheets as $file) {
	$populatedTemplate = str_replace("{FILENAME}", $file->name, $fileRowTeemplate);
	echo $populatedTemplate;
}