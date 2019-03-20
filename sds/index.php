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

<!-- PAGE HEAD -->
<?php include __DIR__ . '/component/page-head.php';

include __DIR__ . '/data/usertoolbar.php';

include __DIR__ . '/component/navbar.php';
?>

<!-- NAVBAR -->

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

<?include __DIR__ . '/component/footer.php'; ?>