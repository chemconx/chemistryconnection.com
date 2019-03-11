<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 2/28/19
 * Time: 6:17 PM
 */

require __DIR__ . '/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

session_start();

function auth($echoJSON = true) {
	$result = array();

	if (isset($_SESSION['user'])) {
		$result['success'] = true;
		$result['user'] = $_SESSION['user'];
	} else {
		if (!isset($_POST['email']) || empty($_POST['email'])) {
			$result['success'] = false;
			$result['message'] = "Invalid email";
		} else if (!isset($_POST['pass']) || empty($_POST['pass'])) {
			$result['success'] = false;
			$result['message'] = "Invalid password";
		} else {

			$email = $_POST['email'];
			$password = $_POST['pass'];

			if (strlen($password) < 6) {
				$result['success'] = false;
				$result['message'] = "Invalid username or password";
			} else {

				$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/private/myopdffilebrowser-b92e95396fa0.json');

				$firebase = (new Factory)
					->withServiceAccount($serviceAccount)
					->create();

				$auth = $firebase->getAuth();

				try {
					$user = $auth->verifyPassword($email, $password);
					$result['success'] = true;
					$result['user'] = $user;
					$_SESSION['user'] = $user;
				} catch (Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
					$result['success'] = false;
					$result['message'] = $e->getMessage();
				}
			}
		}
	}

	if ($echoJSON) {
		header("Content-Type: application/json");

		echo json_encode($result);
	}

	return $result;
}