<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 4/12/19
 * Time: 7:58 PM
 */

include __DIR__ . "/../auth.php";

$fileRowTeemplate = '
<tr>
	<td>{USER_EMAIL}</td>
	<td><a class="action" onclick="changeDispName({UID})">Change Display Name</a></td>
	<td><a class="action" onclick="resetUserPassword({UID})">Reset Password</a></td>
	<td><a class="action" onclick="managePermissions({UID})">Permissions</a></td>
	<td><a class="action destructive" onclick="deleteUser({UID})">Delete</a></td>
</tr>
';

echo '<colgroup>
					<col width="100%">
					<col width="0%">
					<col width="0%">
					<col width="0%">
					<col width="0%">
				</colgroup>';

// foreach user in database, add: user email, button to
// change username, button to reset password, button to
// manage permissions, and button to delete

$users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);

foreach ($users as $user) {
	/** @var \Kreait\Firebase\Auth\UserRecord $user */

	$populatedTemplate = str_replace("{USER_EMAIL}", $user->email, $fileRowTeemplate);
	$populatedTemplate = str_replace("{UID}", $user->uii, $populatedTemplate);

	echo $populatedTemplate;
}

echo "Here's your damn table.";