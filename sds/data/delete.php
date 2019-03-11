<form class="modal-form" id="delete-form" style="min-width: 200px">
	<p style="margin: 0">

		<?php
		/**
		 * Created by PhpStorm.
		 * User: jasper
		 * Date: 3/9/19
		 * Time: 2:42 PM
		 */
		require_once __DIR__ . '/DataSheet.php';
		require_once __DIR__ . '/Connection.php';
		require_once __DIR__ . '/auth.php';

		function deleteFile($authresults) {

			if (!isset($_POST['id'])) {
				echo '<span class="error">Invalid POST data</span>';
				return;
			}

			if (!$authresults['success']) {
				echo '<span class="error">Not authorized.</span>';
				return;
			} else {
				// get original name
				$conn = new Connection();

				if ($conn == null) {
					echo "<span class='error'>Error connecting to database.</span>";
					return;
				}

				$sds = $conn->getFile($_POST["id"]);

				if ($sds == null) {
					echo "<span class='error'>Error finding file.</span>";
					return;
				}

				// delete file
				$filepath = $sds->filepath;
				if (file_exists($filepath)) {
					unlink($filepath);
				}

				// update database
				$conn->deleteFile($sds);

				echo "Success!";
			}
		}


		$authresults = auth(false);
		deleteFile($authresults);
		?>

	</p>

	<div class="container">
		<button class="modal-close" style="float: right">Ok</button>
	</div>
</form>
