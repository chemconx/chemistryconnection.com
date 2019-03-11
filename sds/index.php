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

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
		  integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<link rel="stylesheet" href="js/ui-transition/transition.min.css">
	<link rel="stylesheet" href="js/ui-dropdown/dropdown.min.css">

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
						<p>Welcome, Admin<br><a href="index.php?logout">Log out</a></p>
					</div>
				';
		}
		?>
	</div>
</div>

<div class="main content">
	<div class="tab-bar">
		<a class="tab-item tab-active" data-sheet-type="-1">All files</a>
		<a class="tab-item" data-sheet-type="1">Safety Data Sheets</a>
		<a class="tab-item" data-sheet-type="2">Certificates of Analysis</a>
	</div>
	<div class="main-container">
		<div class="container search-container">
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

<div class="bottommsg" style="display: none;">

</div>

<!--<div class="modal login-panel" style="display: none">-->
<!---->
<!--</div>-->


<script src="../js/vendor/modernizr-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../js/vendor/jquery-3.3.1.min.js"><\/script>');</script>
<script src="../js/vendor/clipboard.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="js/main.js"></script>
<?php
if ($authresults['success']) {
	echo '<script src="js/ui-dropdown/dropdown.min.js"></script>';
	echo '<script src="js/ui-transition/transition.min.js"></script>';
	echo '<script src="js/upload.js"></script>';
	echo '<script src="js/specialaccess.js"></script>';

}
?>


<?php

if (isset($_GET['login']) && !$authresults['success']) {
	echo '<script>
		(function() {
			jQuery(document).ready(function (){
				showModal("modal/login.html", initLogin);
			});
		}());
		
		function initLogin() {
			jQuery("#login-form-submit").click(function (e) {
				var that = jQuery(this);
				that.prop("disabled", true);
				 e.preventDefault();

				let email = jQuery("#login-form-email").val();
				let pass = jQuery("#login-form-pass").val();

				var formData = new FormData();

				// add assoc key values, this will be posts values
				formData.append("email", email);
				formData.append("pass", pass);
				
				jQuery.ajax({
					type: "POST",
					url: "data/login.php",
					async: true,
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 60000
				}).done(function (data) {
					if (data === "Success") {
						window.location = window.location.pathname;
					} else {
						jQuery("#login-message").html(data).slideDown(100);
						console.log(data);
						that.prop("disabled", false);
					}
				});
			});
		}
		 
	</script>';
}

?>

</html>