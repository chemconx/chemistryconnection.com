<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/4/19
 * Time: 1:57 PM
 */

require_once (__DIR__ . "/DataSheet.php");
require_once (__DIR__ . "/Connection.php");
require_once (__DIR__ . "/auth.php");
require_once (__DIR__ . "/buildtables.php");

// initialize connection to database
$conn = new Connection();

if ($conn == null) {
	echo "Error connecting to database. ";
	echo '<pre>' . var_export($conn->connect_error, true) . '</pre>';
	exit();
}

$fileType = -1;

if (!empty($_GET['t']) && is_numeric($_GET['t'])) {
	$fileType = intval($_GET['t']);
}

$sds = $conn->getAllFiles($fileType);

buildTables($sds);