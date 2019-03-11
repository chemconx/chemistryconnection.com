<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/10/19
 * Time: 3:46 PM
 */

require_once __DIR__ . '/auth.php';

$authResults = auth(false);
if ($authResults['success']) {
	echo "Success";
} else {
	// figure out why login failed
	echo $authResults['message'];
//	var_dump($authResults);
}

?>