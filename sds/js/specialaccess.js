// specialaccess.js: download this script only if user is logged in
// keeps download size small and improves security maybe
//
// although this file will still be accessible if people know where
// to look.


function initUpload() {
	$('#upload-file-input').on('change', function () {
		$('#upload-file-rename-input').val($(this).val().split("\\").pop());
	});

	$('#upload-file-submit').click(function (e) {
		e.preventDefault();

		// run upload crap
		let file = $('#upload-file-input').prop('files') [0];
		let upload = new Upload(file, $('#upload-file-rename-input').val());

		if (upload.getSize() > 10000000) {
			$('#upload-msg').addClass('error').html('File too big (Max 10mb).');
			return;
		}

		$('#progress-wrp').slideDown(100, function () {
			// execute upload
			upload.doUpload(function (data) {
				$('.login-form').slideUp(100, function () {
					let message = $(data).hide();

					$('#upload-container').append(message);
					message.slideDown(100);

					// add event to modal-close
					$('.modal-close').click(function (e) {
						e.preventDefault();
						$('.darkenscreen').hide();
						$('.modal').hide();

						// reload homepage
						initTables();
					});
				});
			});
		});
	});
}

function renameFile(id) {
	// TODO Rename file

}

function deleteFile(id) {
	// TODO delete file
	console.log("DELETE FILE");
}