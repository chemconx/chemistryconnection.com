<form class="modal-form" id="upload-form" style="min-width: 200px">
	<p style="margin: 0">
		<?php
		/**
		 * Created by PhpStorm.
		 * User: jasper
		 * Date: 3/6/19
		 * Time: 8:37 PM
		 */

		require_once __DIR__ . '/DataSheet.php';
		require_once __DIR__ . '/Connection.php';
		require_once __DIR__ . '/auth.php';

		function upload($authresults) {
			if (!$authresults['success']) {
				echo '<span class="error">Not authorized.</span>';
				return;
			} else {
				// DO DSTYPE INJECTION CHECK, DEFAULT TO 1
				$dsType = 1;
				if (isset($_POST['dstype'])){
					$dsType = intval($_POST['dstype']);
					if ($dsType != 1 && $dsType != 2) {
						$dsType = 1;
					}
				}

				$targetDir = __DIR__ . "/pdf/";
				$targetFile = $_FILES['file']['name'];
				$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

				$desiredName = pathinfo($_POST['filename'], PATHINFO_FILENAME);

				$desiredName = str_replace(" ", "_", $desiredName);

				$replacementSTR = "";
				$tries = 0;


				// HANDLE FILE SIZE
				if ($_FILES['file']['size'] > 10000000) {
					echo "<span class=\"error\">File too large (max 10mb).</span>";
					return;
				}


				// HANDLE FILE TYPE
				if ($fileType != "pdf") {
					echo "<span class=\"error\">Invalid file type (only PDF is allowed).</span>";
					return;
				}

				// HANDLE DUPLICATES
				do {
					$targetFile = $targetDir . $desiredName . $replacementSTR . "." . $fileType;
					$tries++;
					$replacementSTR = "_" . $tries;
				} while (file_exists($targetFile));

				$finalName = pathinfo($targetFile, PATHINFO_BASENAME);


				// FINALLY
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
					$conn = new Connection();

					if ($conn == null) {
						echo "<span class='error'>Error connecting to database.</span>";
						return;
					}

					$sds = new DataSheet($finalName, $targetFile, new DateTime(), -1, $dsType);

					$conn->addNewFile($sds);

					echo "Upload successful";
				} else {
					echo "<span class=\"error\">Unknown error processing file.</span>";
				}
			}
		}

		// Check auth
		$authresults = auth(false, "Upload File");
		upload($authresults);
		?>
	</p>

	<div class="container">
		<button class="modal-close" style="float: right">Ok</button>
	</div>
</form>