<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 3/19/19
 * Time: 3:24 PM
 */

require_once (__DIR__ . "/auth.php");

$auth = auth(false);

if ($auth['success'] && !isset($_GET['logout'])) {?>

	<link rel="stylesheet" href="css/usertoolbar.css">

	<div class="usertoolbar">
		<ul class="usertoolbar-links">
			<li class="usertoolbar-link"><a href="">Welcome, <?php echo $auth['user']->displayName; ?></a></li>
			<li class="usertoolbar-link"><a href="">Manage Users</a></li>
			<li class="usertoolbar-link"><a href="index.php?logout">Sign out</a></li>
		</ul>
	</div>


<?php
}
?>