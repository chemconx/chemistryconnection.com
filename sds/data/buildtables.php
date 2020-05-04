<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/8/19
 * Time: 11:44 PM
 */

require_once __DIR__ . '/auth.php';

function buildTables($sds) {
	// check for session
	$authResult = auth(false);
	$perms = $authResult['perms'];

	if (!$perms->userHasPermission("View File Directory")) {
		echo "You do not have access";
		exit();
	}

	$fileRowTeemplate = '
<div class="file-row">
	<div class="file-cell filename-cell">{FILENAME} <div class="file-cell dropdown-cell"><i class="fas fa-chevron-right"></i></div></div>
	<div class="file-cell action-cell"><a class="action" href="{LINK}" target="_blank">Open</a></div>';


	if ($perms->userHasPermission("Copy Link") || $perms->userHasPermission("Copy HTML")) {
		$fileRowTeemplate .= '<div class="file-cell action-cell"><a class="action copy" data-clipboard-text="{FULL_LINK}" data-copy-link-file-type="{FILE_TYPE}">Copy Link</a></div>';
	}

	if ($perms->userHasPermission("Rename File")) {
		$fileRowTeemplate .= '<div class="file-cell action-cell"><a class="action rename" data-file-id="{ID}">Rename</a></div>';
	}

	if ($perms->userHasPermission("Delete File")) {
		$fileRowTeemplate .= '<div class="file-cell action-cell"><a class="action destructive delete" data-file-id="{ID}">Delete</a></div>';
	}

	$fileRowTeemplate .= '</div>';

	foreach ($sds as $file) {
		$populatedTemplate = str_replace("{FILENAME}", $file->name, $fileRowTeemplate);
		$populatedTemplate = str_replace("{ID}", $file->id, $populatedTemplate);
		$populatedTemplate = str_replace("{LINK}", "data/pdf/".$file->name, $populatedTemplate);
		$populatedTemplate = str_replace("{FILE_TYPE}", $file->fileType, $populatedTemplate);
		$populatedTemplate = str_replace("{FULL_LINK}", "https://" . $_SERVER['HTTP_HOST'] ."/sds/data/pdf/".$file->name, $populatedTemplate);

		echo $populatedTemplate;
	}
}