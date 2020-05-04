// filemanagement.js
// Functions and code needed only if a user is logged in.

import * as main from './main.js';
import * as util from './util.js';
import {Upload} from "./upload.js";

$(document).ready(function () {
	$('#upload-button').click(function () {
		util.showModal("modal/upload.php", initUpload);
	});
});

function initUpload() {
	$('#upload-file-filetype').dropdown();

	$('#upload-file-input').on('change', function () {
		$('#upload-file-rename-input').val($(this).val().split("\\").pop()).focus().select();
	});

	$('#upload-file-submit').click(function (e) {
		e.preventDefault();

		// run upload crap
		let file = $('#upload-file-input').prop('files') [0];
		let fileType = $('#upload-file-filetype').dropdown('get value');
		let upload = new Upload(file, $('#upload-file-rename-input').val(), fileType);

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
					main.initTables();

					// add event to modal-close
					$('.modal-close').click(function (e) {
						e.preventDefault();
						util.closeModal();
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
				main.initTables();

				// add event to modal-close
				$('.modal-close').click(function (e) {
					e.preventDefault();
					util.closeModal();
				});
			});
		});
	});
}

function initDelete(){
	$('#delete-file-decline').click(function (e) {
		e.preventDefault();
		util.closeModal();
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
				main.initTables();

				// add event to modal-close
				$('.modal-close').click(function (e) {
					e.preventDefault();
					util.closeModal();
				});
			});
		});
	});
}

export function renameFile(id) {
	util.showModal("modal/rename.php?id=" + id, initRename);
};

export function deleteFile(id) {
	util.showModal("modal/delete.php?id=" + id, initDelete);
}