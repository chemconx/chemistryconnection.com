<form class="login-form" id="upload-form" style="min-width: 200px">
	<p style="margin: 0">
		<?php
		/**
		 * Created by PhpStorm.
		 * User: jasper
		 * Date: 3/6/19
		 * Time: 8:37 PM
		 */

		require_once __DIR__ . '/Connection.php';
		require_once __DIR__ . '/auth.php';

		function upload($authresults) {
			if (!$authresults['success']) {
				echo '<span class="error">Not authorized.</span>';
				return;
			} else {
				// HANDLE DUPLICATE FILES
				$targetDir = __DIR__ . "/pdf/";
				$basename = basename($_FILES['file']['name']);
				$targetFile = $targetDir . $basename;
				$filename = pathinfo($targetFile, PATHINFO_FILENAME);
				$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

				$desiredName = pathinfo($_POST['filename'], PATHINFO_FILENAME);

				$replacementSTR = "";
				$tries = 0;

				do {
					$targetFile = $targetDir . $desiredName . $replacementSTR . "." . $fileType;
					$tries++;
					$replacementSTR = " " . $tries;
				} while (file_exists($targetFile));


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

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

					// TODO: Do fancy MySQL stuff


					echo "Upload successful";
				} else {
					echo "<span class=\"error\">Unknown error processing file.</span>";
				}
			}
		}

		// Check auth
		$authresults = auth(false);
		upload($authresults);
		?>
	</p>

	<div class="container">
		<button class="modal-close" style="float: right">Ok</button>
	</div>
</form>