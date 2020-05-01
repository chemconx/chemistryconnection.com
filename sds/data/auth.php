<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 2/28/19
 * Time: 6:17 PM
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/UserPermissions.php";


use Kreait\Firebase\Factory;

session_start();

$auth = (new Factory)
	->withServiceAccount(__DIR__ . '/private/myopdffilebrowser-b92e95396fa0.json')
	->createAuth();

function auth($echoJSON = true, $perm = null) {
	global $auth;
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
				try {
					$signInResult = $auth->signInWithEmailAndPassword($email, $password);
//					var_dump($signInResult);
					$user = $auth->getUser($signInResult->data()['localId']);
					$result['success'] = true;
					$result['user'] = $user;
					$_SESSION['user'] = $user;
				} catch (Kreait\Firebase\Auth\SignIn\FailedToSignIn $e) {
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

	$perms = null;

	if ($result['success']) {
		$perms = new UserPermissions($result['user']->uid);
	} else {
		$perms = new UserPermissions("public");
	}

	if ($perm != null) {
		if (!$perms->userHasPermission($perm)) {
			$result['success'] = false;
		}
	}

	$result['perms'] = $perms;

	return $result;
}