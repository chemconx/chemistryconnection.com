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

// TODO set up datasheet type param

echo "".$conn->getNumPagesAllFiles();