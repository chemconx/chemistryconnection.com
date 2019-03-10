// specialaccess.js: download this script only if user is logged in
//
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
				$('.modal-form').slideUp(100, function () {
					let message = $(data).hide();

					$('#upload-container').append(message);
					message.slideDown(100);

					// reload homepage
					initTables();

					// add event to modal-close
					$('.modal-close').click(function (e) {
						e.preventDefault();
						$('.darkenscreen').fadeOut(100);
						$('.modal').fadeOut(100);
					});
				});
			});
		});
	});
}

function initRename() {
	$('#rename-file-name').focus().select();


	$('#rename-file-submit').click(function (e) {
		e.preventDefault();

		let id = $("#rename-file-id").val();
		let rename = $('#rename-file-name').val();

		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("rename", rename);
		formData.append("id", id);

		$.ajax({
			type: "POST",
			url: "data/rename.php",
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (data) {
			$('.modal-form').slideUp(100, function () {
				let message = $(data).hide();

				$('#rename-container').append(message);
				message.slideDown(100);

				// reload homepage
				initTables();

				// add event to modal-close
				$('.modal-close').click(function (e) {
					e.preventDefault();
					$('.darkenscreen').fadeOut(100);
					$('.modal').fadeOut(100);
				});
			});
		});
	});
}

function initDelete(){
	$('#delete-file-decline').click(function (e) {
		e.preventDefault();
		$('.darkenscreen').fadeOut(100);
		$('.modal').fadeOut(100);
	});

	$('#delete-file-accept').click(function (e) {
		e.preventDefault();

		let id = $("#delete-file-id").val();

		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("id", id);

		$.ajax({
			type: "POST",
			url: "data/delete.php",
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (data) {
			$('.modal-form').slideUp(100, function () {
				let message = $(data).hide();

				$('#delete-container').append(message);
				message.slideDown(100);

				// reload homepage
				initTables();

				// add event to modal-close
				$('.modal-close').click(function (e) {
					e.preventDefault();
					$('.darkenscreen').fadeOut(100);
					$('.modal').fadeOut(100);
				});
			});
		});
	});
}

function renameFile(id) {
	// TODO Rename file
	showModal("modal/rename.php?id=" + id, initRename);
}

function deleteFile(id) {
	// TODO delete file
	showModal("modal/delete.php?id=" + id, initDelete);
}