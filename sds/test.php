<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/6/19
 * Time: 11:13 PM
 */

require_once (__DIR__ . "/data/auth.php");

include __DIR__ . "/data/UserPermissions.php";

$userPerms = new UserPermissions();

$authresults = auth(false);

echo $userPerms->userHasPermission($authresults['user']->uid, 'Manage Permissions');