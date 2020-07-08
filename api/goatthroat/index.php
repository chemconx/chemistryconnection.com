<?php

require_once __DIR__ . '/private/Connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://192.168.103.64:3000'); // todo: MUST CHANGE TO https://makeyourown.buzz FOR PRODUCTION
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: stencil-config,stencil-options,x-xsrf-token');

$conn = new Connection();

$result = [];

if ($conn == null) {
	$result['error'] = "Unable to establish a connection with the database";
	echo json_encode($result);
	exit();
}

if (isset($_GET['q']) && !empty($_GET['q'])) {
	$query = $_GET['q'];
	$chemicals = $conn->search($query);
	$result['chemicals'] = $chemicals;
	$result['count'] = sizeof($chemicals);
	echo json_encode($result);
}else {
	$result['error'] = "Please provide a search query";
	echo json_encode($result);
}