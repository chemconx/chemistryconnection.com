// manage.js
// define variables and functions for manage.php

$(document).ready((e) => {
	initTable();

	$(document).mouseup((e) =>{
		if (e.which == 1) {
			var dropdown = $('.threedotsdropdown');

			if (dropdown.length > 0 && !dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
				closeDropdown(dropdown);
			}
		}
	});
});

function initTable() {
	$.get("data/usermgmt/buildtable.php", function (data) {
		$('#user-table').html(data);
		$('.threedots').click((e) =>{
			var uid = $(e.target).attr("data-uid");
			console.log(uid);
			var $dropdown = $('#threedotsdropdown').clone();
			$dropdown.addClass('threedotsdropdown');
			var dropdownQuery = $('<div class="threedotsdropdown">' + $dropdown.html() + '</div>').hide();
			$(e.target).parent().append(dropdownQuery);
			dropdownQuery.slideDown(100);

			$('#chusername-threedotsaction').click(() => {
				closeDropdown($('.threedotsdropdown'));
				showModal("modal/chusername.php?uid=" + uid, initChUsername);

			});

			$('#respass-threedotsaction').click(() => {
				closeDropdown($('.threedotsdropdown'));
				showModal("modal/respass.php?uid=" + uid, initResPass);

			});
		});
	});
}

function closeDropdown(dropdown) {
	dropdown.slideUp(100, () => {
		dropdown.remove();
	});
}

function initChUsername() {
	$('#chusername-username').focus().select();

	$('#chusername-submit').click(function (e) {
		e.preventDefault();

		var that = jQuery(this);
		that.prop("disabled", true);

		let id = $("#chusername-uid").val();
		let username = $('#chusername-username').val();

		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("username", username);
		formData.append("uid", id);

		$.ajax({
			type: "POST",
			url: "data/usermgmt/chusername.php",
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (data) {
			$('.modal-form').slideUp(100, function () {
				let message = $(data).hide();

				that.prop("disabled", false);

				$('#chusername-container').append(message);
				message.slideDown(100);

				// reload homepage
				initTable();

				// add event to modal-close
				$('.modal-close').click(function (e) {
					e.preventDefault();
					closeModal();
				});
			});
		});
	});
}

function initResPass(){
	$('#respass-decline').click(function (e) {
		e.preventDefault();
		closeModal();
	});

	$('#respass-accept').click(function (e) {
		e.preventDefault();

		let id = $("#respass-uid").val();

		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("uid", id);

		$.ajax({
			type: "POST",
			url: "data/usermgmt/respass.php",
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (data) {
			$('.modal-form').slideUp(100, function () {
				let message = $(data).hide();

				$('#respass-container').append(message);
				message.slideDown(100);

				// add event to modal-close
				$('.modal-close').click(function (e) {
					e.preventDefault();
					closeModal();
				});
			});
		});
	});
}