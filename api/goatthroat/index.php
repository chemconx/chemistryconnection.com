<?php

require_once __DIR__ . '/private/Connection.php';

header('Content-Type: application/json');

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