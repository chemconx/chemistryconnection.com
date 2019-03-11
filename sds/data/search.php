<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 2/28/19
 * Time: 6:14 PM
 */

require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/buildtables.php';

if (!isset($_GET['q']) || empty($_GET['q'])) {
	exit();
}

// initialize connection to database
$conn = new Connection();

if ($conn == null) {
	echo "Error connecting to database. ";
	echo '<pre>' . var_export($conn->connect_error, true) . '</pre>';
	exit();
}

$fileType = -1;

if(isset($_GET['t']) && ($_GET['t'] == 1 || $_GET['t'] == 2)) {
	$fileType = $_GET['t'];
}

// load files
$recentsdsheets = $conn->search($_GET['q'], $fileType);

buildTables($recentsdsheets);