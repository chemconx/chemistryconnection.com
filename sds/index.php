<?php
require_once("data/auth.php");

include __DIR__ . '/component/page-head.php';

include __DIR__ . '/data/usertoolbar.php';

include __DIR__ . '/component/navbar.php';

// check for session
if (isset($_GET['logout'])) {
	session_destroy();
	$authResults["success"] = false;
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


if ($authResults['success'] && $perms->userHasPermission("Upload File")) {

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
						<div class="page-numbers" id="all-files-page-numbers"></div>
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
						<div class="page-numbers" id="all-files-page-numbers"></div>
					</div>

					<!-- table data -->
				<table id="all-files-table">

				</table>
			</div>
				';
}

?>

	<!-- NAVBAR -->

	<div class="main content">
		<div class="tab-bar">
			<a class="tab-item tab-active" data-sheet-type="-1">All files</a>
			<a class="tab-item" data-sheet-type="1">Safety Data Sheets</a>
			<a class="tab-item" data-sheet-type="2">Certificates of Analysis</a>
			<a class="tab-item" data-sheet-type="3">Technical Data Sheets</a>
		</div>
		<div class="main-container">

			<?php if (!$perms->userHasPermission("View File Directory")) { ?>
				<div class="container newuserdefault">
					<div class="container header">
						<h3 class="header public">Login</h3>
					</div>

					<p>You must <a href="index.php?login">log in</a> to view files.</p>
				</div>
			<?php } else { ?>
				<div class="container search-container">
					<form id="search-form" action="" method="get">
						<input id="search-input" name="q" type="text" placeholder="SEARCH">
						<button id="search-submit" type="submit"> SEARCH</button>
					</form>
				</div>

				<?php
				if (isset($_GET['q']) && !empty($_GET['q'])) {
					echo $searchContainer;
				} else {
					echo $homeContainers;
				}
			}
			?>
		</div>
	</div>

<?php

if (isset($_GET['login']) && !$authResults['success']) {
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

if ($authResults['success']) {
	$scripts = [
		'<script src="js/main.js"></script>',
		'<script src="js/ui-dropdown/dropdown.min.js"></script>',
		'<script src="js/ui-transition/transition.min.js"></script>',
		'<script src="js/upload.js"></script>',
		'<script src="js/specialaccess.js"></script>'
	];
} else {
	$scripts = ['<script src="js/main.js"></script>'];
}

include __DIR__ . '/component/footer.php'; ?>