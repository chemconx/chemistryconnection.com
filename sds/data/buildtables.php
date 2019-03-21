<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/8/19
 * Time: 11:44 PM
 */

require_once __DIR__ . '/auth.php';

function buildTables($sds) {
	$login = false;

	$fileRowTeemplate = '
<tr>
	<td>{FILENAME}</td>
	<td><a class="action" href="{LINK}" target="_blank">Open</a></td>
	<td><a class="action copy" data-clipboard-text="{FULL_LINK}" data-copy-link-file-type="{FILE_TYPE}">Copy Link</a></td>
</tr>
';

// check for session

	$authResult = auth(false);

	if ($authResult['success']) {
		$login = true;
		$fileRowTeemplate = '
<tr>
	<td>{FILENAME}</td>
	<td><a class="action" href="{LINK}" target="_blank">Open</a></td>
	<td><a class="action copy" data-clipboard-text="{FULL_LINK}" data-copy-link-file-type="{FILE_TYPE}">Copy Link</a></td>
	<td><a class="action" onclick="renameFile({ID})">Rename</a></td>
	<td><a class="action destructive" onclick="deleteFile({ID})">Delete</a></td>
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
		$populatedTemplate = str_replace("{LINK}", "data/pdf/".$file->name, $populatedTemplate);
		$populatedTemplate = str_replace("{FILE_TYPE}", $file->fileType, $populatedTemplate);
		$populatedTemplate = str_replace("{FULL_LINK}", "https://" . $_SERVER['HTTP_HOST'] ."/sds/data/pdf/".$file->name, $populatedTemplate);

		echo $populatedTemplate;
	}
}