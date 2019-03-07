<?php
require_once("data/auth.php");

// check for session
if (isset($_GET['logout'])) {
	session_destroy();
	$authresults["success"] = false;
} else {
	$authresults = auth(false);
}
$searchContainer = '<div class="container search">
			 		<div class="container header">
						<h3 class="header recent">Search Results</h3>
						<form action=""><button type="submit" id="clear-button">CLEAR</button></form>
					</div>

					<!-- table data -->
					<table id="search-results-table">
	
					</table>
				</div>';


if ($authresults['success']) {

	$homeContainers = '
				<div class="container recent">
			 		<div class="container header">
						<h3 class="header recent">Recently Uploaded</h3>
						<button id="upload-button">UPLOAD</button>
					</div>

					<!-- table data -->
					<table id="recent-files-table">
	
					</table>
				</div>

				<div class="container all">
					<div class="container header">
						<h3 class="header all">All Safety Data Sheets</h3>
					</div>

					<!-- table data -->
				<table id="all-files-table">

				</table>
			</div>
				';

} else {
	$homeContainers = '
				<div class="container recent">
			 		<div class="container header">
						<h3 class="header recent">Recently Uploaded</h3>
					</div>

					<!-- table data -->
					<table id="recent-files-table">
	
					</table>
				</div>

				<div class="container all">
					<div class="container header">
						<h3 class="header all">All Safety Data Sheets</h3>
					</div>

					<!-- table data -->
				<table id="all-files-table">

				</table>
			</div>
				';
}


?>

<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<title>Chemistry Connection -- Safety Data Sheets</title>
	<meta name="description" content="Chemistry Connection -- Safety Data Sheets">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="manifest" href="../site.webmanifest">
	<link rel="apple-touch-icon" href="../icon.png">
	<!-- Place favicon.ico in the root directory -->

	<link rel="stylesheet" href="../css/normalize.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="css/sds.css">
	<link rel="stylesheet" href="css/modal.css">
	<link rel="stylesheet" href="css/form.css">

	<meta name="theme-color" content="#fafafa">
</head>

<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
	your browser</a> to improve your experience and security.</p>
<![endif]-->

<!-- Add your site or application content here -->
<div class="navbar">
	<div class="main main-header">
		<img class="header-image" src="../img/chemconx.png">
		<h1>Safety Data Sheets</h1>


		<?php
		if ($authresults['success']) {
			echo '
					<div>
						<p>Welcome, Jasper<br><a href="index.php?logout">Log out</a></p>
					</div>
				';
		}
		?>
	</div>
</div>

<div class="main content">
	<div class="main-container">
		<div class="search-container">
			<form id="search-form" action="" method="get">
				<input id="search-input" name="q" type="text" placeholder="SEARCH">
				<button id="search-submit" type="submit">SEARCH</button>
			</form>
		</div>

		<?php
		if (isset($_GET['q']) && !empty($_GET['q'])) {
			echo $searchContainer;
		} else {
			echo $homeContainers;
		}
		?>
	</div>
</div>

<div class="darkenscreen" style="display: none">
</div>

<div class="modal" style="display: none">

</div>

<!--<div class="modal login-panel" style="display: none">-->
<!---->
<!--</div>-->

<script src="../js/vendor/modernizr-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../js/vendor/jquery-3.3.1.min.js"><\/script>');</script>
<script src="../js/plugins.js"></script>
<script src="js/main.js"></script>
<script src="js/upload.js"></script>

<?php

if (isset($_GET['login']) && !$authresults['success']) {
	echo '<script>
		(function() {
			jQuery(document).ready(function (){
//				jQuery(\'.darkenscreen\').show();
//				jQuery(\'.login-panel\').show();
				showModal("modal/login.html");
			});
		}());
	</script>';
}

?>

</html>