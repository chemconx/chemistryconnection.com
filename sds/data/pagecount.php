<?php

require_once (__DIR__ . "/DataSheet.php");
require_once (__DIR__ . "/Connection.php");
require_once (__DIR__ . "/auth.php");

$conn = new Connection();

if ($conn == null) {
	echo "0";
	exit();
}

$authResult = auth(false);
$perms = $authResult['perms'];

if (!$perms->userHasPermission("View File Directory")) {
	echo "0";
	exit();
}

$dataSheetType = -1;

if (isset($_GET['t']) && is_numeric($_GET['t'])) {
	$dataSheetType = intval($_GET['t']);
}



echo "".$conn->getNumPagesAllFiles(25, $dataSheetType);