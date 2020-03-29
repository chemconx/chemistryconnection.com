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
					<div id="search-results-table">
	
					</div>
				</div>';


if ($authResults['success'] && $perms->userHasPermission("Upload File")) {

	$homeContainers = '
				<div class="container recent">
			 		<div class="container header">
						<h3 class="header recent">Recently Uploaded</h3>
						<button id="upload-button">UPLOAD</button>
					</div>

					<!-- table data -->
					<div class="file-table" id="recent-files-table">
	
					</div>
				</div>

				<div class="container all">
					<div class="container header">
						<h3 class="header all">All Safety Data Sheets</h3>
					</div>

				<div class="page-numbers top" style="display: none"></div>
					<!-- table data -->
				<div class="file-table" id="all-files-table">

				</div>
				<div class="page-numbers bottom" style="display: none"></div>
			</div>
				';

} else {
	$homeContainers = '
				<div class="container recent">
			 		<div class="container header">
						<h3 class="header recent">Recently Uploaded</h3>
					</div>

					<!-- table data -->
					<div class="file-table" id="recent-files-table">
	
					</div>
				</div>

				<div class="container all">
					<div class="container header">
						<h3 class="header all">All Safety Data Sheets</h3>
					</div>
				
				<div class="page-numbers top" style="display: none"></div>
					<!-- table data -->
				<div class="file-table" id="all-files-table">

				</div>
				<div class="page-numbers bottom" style="display: none"></div>
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

			<div class="mobile-tab-dropdown"><span class="text">All files</span> <i id="tabs-dropdown-button" class="fas fa-chevron-down"></i></div>
			<div class="mobile-tab-list">
				<a class="mobile-tab-item tab-active" data-sheet-type="-1">All files</a>
				<a class="mobile-tab-item" data-sheet-type="1">Safety Data Sheets</a>
				<a class="mobile-tab-item" data-sheet-type="2">Certificates of Analysis</a>
				<a class="mobile-tab-item" data-sheet-type="3">Technical Data Sheets</a>
			</div>
			<div class="occlusion-panel"></div>
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
						<button id="search-submit" type="submit"><i class="fas fa-search"></i></button>
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

$scripts = ['<script type="module" src="js/main.js"></script>'];

if (isset($_GET['login']) && !$authResults['success']) {
	array_push($scripts, '<script type="module" src="js/login.js"></script>');
}

if ($authResults['success']) {
	array_push($scripts,
		'<script src="js/ui-dropdown/dropdown.min.js"></script>',
		'<script src="js/ui-transition/transition.min.js"></script>');
}

include __DIR__ . '/component/footer.php'; ?>