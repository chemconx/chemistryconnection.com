<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/27/19
 * Time: 11:07 AM
 */

require_once __DIR__ . "/../../data/auth.php";

$authresults = auth(false);

if (!$authresults['success']) {
	echo "You do not have access";
	exit();
}

$auth->deleteUser($_POST['uid']);

echo "User removed."