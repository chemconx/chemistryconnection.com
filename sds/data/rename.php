<form class="modal-form" id="upload-form" style="min-width: 200px">
	<p style="margin: 0">

		<?php
		/**
		 * Created by PhpStorm.
		 * User: jasper
		 * Date: 3/9/19
		 * Time: 2:42 PM
		 */
		require_once __DIR__ . '/SafetyDataSheet.php';
		require_once __DIR__ . '/Connection.php';
		require_once __DIR__ . '/auth.php';

		function renameFile($authresults) {

			if (!isset($_POST['id']) || !isset($_POST['rename'])) {
				echo '<span class="error">Invalid POST data</span>';
				return;
			}

			if (!$authresults['success']) {
				echo '<span class="error">Not authorized.</span>';
				return;
			} else {
				// handle duplicates
				$targetDir = __DIR__ . "/pdf/";
				$desiredName = pathinfo($_POST['rename'], PATHINFO_FILENAME);
				$desiredName = str_replace(" ", "_", $desiredName);
				$replacementSTR = "";
				$tries = 0;
				$fileType = "pdf";

				do {
					$targetFile = $targetDir . $desiredName . $replacementSTR . "." . $fileType;
					$tries++;
					$replacementSTR = "_" . $tries;
				} while (file_exists($targetFile));

				// get original name
				$conn = new Connection();

				if ($conn == null) {
					echo "<span class='error'>Error connecting to database.</span>";
					return;
				}

				$sds = $conn->getFile($_POST["id"]);

				if ($sds == null) {
					echo "<span class='error'>Finding file.</span>";
					return;
				}

				// rename file
				$oldFile = $sds->filepath;
				rename($oldFile, $targetFile);

				// update database
				$sds->name = pathinfo($targetFile, PATHINFO_FILENAME) . ".pdf";
				$sds->filepath = $targetFile;
				$conn->renameFile($sds);

				echo "Success!";
			}
		}


		$authresults = auth(false);
		renameFile($authresults);
		?>

	</p>

	<div class="container">
		<button class="modal-close" style="float: right">Ok</button>
	</div>
</form>
