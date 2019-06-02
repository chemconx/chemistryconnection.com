<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/30/19
 * Time: 1:21 PM
 */
require_once __DIR__ . "/../data/auth.php";

$authresults = auth(false);

$copyLink = $authresults['perms']->userHasPermission("Copy Link");
$copyHTML = $authresults['perms']->userHasPermission("Copy HTML");

if (!$copyLink && !$copyHTML) {
	echo "You do not have access.";
	exit();
}


?>

<div class="container header">
	<h3>Copy</h3>
</div>
<div class="container">
<?php if ($copyLink) { ?>
	<button id="copy-form-link">Copy Link</button>
<?php }

if ($copyHTML) { ?>
	<button id="copy-form-icon-code">Copy Icon HTML Code</button>
<?php } ?>
</div>
