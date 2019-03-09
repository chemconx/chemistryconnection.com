<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/8/19
 * Time: 11:44 PM
 */

function buildTables($sds) {
	$login = false;

	$fileRowTeemplate = '
<tr>
	<td><a href="">{FILENAME}</a></td>
	<td><button onclick="downloadFile({ID})">Download</button></td>
	<td><button onclick="copyLink({ID})">Copy Link</button></td>
</tr>
';

// check for session

	$authResult = auth(false);

	if ($authResult['success']) {
		$login = true;
		$fileRowTeemplate = '
<tr>
	<td><a href="">{FILENAME}</a></td>
	<td><button onclick="downloadFile({ID})">Download</button></td>
	<td><button onclick="renameFile({ID})">Rename</button></td>
	<td><button onclick="copyLink({ID})">Copy Link</button></td>
	<td><button class="destructive" onclick="deleteFile({ID})">Delete</button></td>
</tr>
';
	}

// load files
	echo '<colgroup>
					<col width="100%">
					<col width="0%">
					<col width="0%">
					<col width="0%">
					<col width="0%">
				</colgroup>';

	foreach ($sds as $file) {
		$populatedTemplate = str_replace("{FILENAME}", $file->name, $fileRowTeemplate);
		$populatedTemplate = str_replace("{ID}", $file->id, $populatedTemplate);

		echo $populatedTemplate;
	}
}