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
	<td><a class="action threedots" data-uid="{UID}">&bull;&bull;&bull;</a></td>
	<td class="user-email-cell">{USER_EMAIL}</td>
	<td class="username-cell">{USER_NAME}</td>
</tr>
';

echo '<colgroup>
					<col width="10%">
					<col width="50%">
					<col width="40%">
				</colgroup>';

// foreach user in database, add: user email, button to
// change username, button to reset password, button to
// manage permissions, and button to delete

$users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);

foreach ($users as $user) {
	/** @var \Kreait\Firebase\Auth\UserRecord $user */

	$populatedTemplate = str_replace("{USER_EMAIL}", $user->email, $fileRowTeemplate);
	$populatedTemplate = str_replace("{USER_NAME}", $user->displayName, $populatedTemplate);
	$populatedTemplate = str_replace("{UID}", $user->uid, $populatedTemplate);

	echo $populatedTemplate;
}