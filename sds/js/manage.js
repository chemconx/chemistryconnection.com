// manage.js
// define variables and functions for manage.php

import * as util from './util.js';

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

	$('#add-user-button').click((e)=>{
		e.preventDefault();

		util.showModal("modal/newuser.php", initNewUserModal);
	});

	$('#public-permissions').click(()=> {
		util.showModal('modal/permissions.php?uid=public', initMngPerms);
	});

	$('#default-permissions').click(()=> {
		util.showModal('modal/permissions.php?uid=default', initMngPerms);
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
				util.showModal("modal/chusername.php?uid=" + uid, initChUsername);

			});

			$('#chemail-threedotsaction').click(() => {
				closeDropdown($('.threedotsdropdown'));
				util.showModal("modal/chemail.php?uid=" + uid, initChEmail);

			});

			$('#respass-threedotsaction').click(() => {
				closeDropdown($('.threedotsdropdown'));
				util.showModal("modal/respass.php?uid=" + uid, initResPass);

			});

			$('#perms-threedotsaction').click(()=> {
				closeDropdown($('.threedotsdropdown'));
				util.showModal('modal/permissions.php?uid=' + uid, initMngPerms);
			});

			$('#del-threedotsaction').click(()=> {
				closeDropdown($('.threedotsdropdown'));
				util.showModal('modal/deluser.php?uid=' + uid, initDelUser);
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
					util.closeModal();
				});
			});
		});
	});
}

function initChEmail() {
	$('#chemail-email').focus().select();

	$('#chemail-submit').click(function (e) {
		e.preventDefault();

		var that = jQuery(this);
		that.prop("disabled", true);

		let id = $("#chemail-uid").val();
		let email = $('#chemail-email').val();

		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("email", email);
		formData.append("uid", id);

		$.ajax({
			type: "POST",
			url: "data/usermgmt/chemail.php",
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

				$('#chemail-container').append(message);
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
		util.closeModal();
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
					util.closeModal();
				});
			});
		});
	});
}

function initMngPerms() {
	$('.checkboxrow').click((e) => {
		var checkbox = jQuery(e.target).find(':checkbox');
		checkbox.prop('checked', !checkbox[0].checked);
	});

	$('.checkbox-label').click((e) => {
		var checkbox = $(e.target).parents('.checkboxrow').find(':checkbox');
		checkbox.prop('checked', !checkbox[0].checked);
	});

	$('.checkbox-label label').click((e) => {
		e.preventDefault();
	});

	$('#assign-perms-select-all').click((e) => {
		e.preventDefault();

		$('.checkbox').each((i,e) => {
			$(e).prop('checked', true);
		});
	});

	$('#assign-perms-select-none').click((e) => {
		e.preventDefault();

		$('.checkbox').each((i,e) => {
			$(e).prop('checked', false);
		});
	});

	$('#assign-perms-save').click((e) => {
		e.preventDefault();

		var permMap = {};

		$('.checkbox').each((i,e) => {
			var permid = $(e).attr("data-perm-id");
			permMap[permid] = $(e).prop('checked');
			// permMap.set(permid, $(e).prop('checked'));
		});

		var stringify = JSON.stringify(permMap);

		var data = new FormData();
		data.append('perms',stringify);
		data.append('uid', $('#assign-perms-uid').val());

		$.ajax({
			type: "POST",
			url: "data/usermgmt/assignperms.php",
			async: true,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (result) {
			util.closeModal();
			util.showBottomMSG(result);
		});
	});
}

function initDelUser(){
	$('#delete-user-accept').click((e)=>{
		e.preventDefault();

		var data = new FormData();
		data.append('uid', $('#delete-user-uid').val());

		$.ajax({
			type: "POST",
			url: "data/usermgmt/deluser.php",
			async: true,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (result) {
			util.closeModal();
			initTable();
			util.showBottomMSG(result);
		});
	});

	$('#delete-user-decline').click((e)=>{
		e.preventDefault();
		util.closeModal();
	});
}

function initNewUserModal(){
	$('#new-user-form').submit((e)=>{
		e.preventDefault();


		var email = $('#new-user-email').val();
		var displayName = $('#new-user-display-name').val();
		var pass = $('#new-user-password').val();
		var confpass = $('#new-user-confpass').val();

		if (email.length == 0) {
			$('#new-user-email-err').slideDown(100);
			return;
		} else {
			$('#new-user-email-err').slideUp(100);
		}

		if (pass != confpass) {
			$('#new-user-pass-err p').html('Passwords do not match.');
			$('#new-user-pass-err').slideDown(100);
			return;
		} else {
			$('#new-user-pass-err').slideUp(100);
		}

		if (pass.length < 6) {
			$('#new-user-pass-err p').html('Password must have at least 6 characters.');
			$('#new-user-pass-err').slideDown(100);
			return;
		} else {
			$('#new-user-pass-err').slideUp(100);
		}

		$('#new-user-submit').attr("disabled", true);

		var data = new FormData();
		data.append('email', email);
		data.append('display_name', displayName);
		data.append('password', pass);
		data.append('confpass', confpass);


		$.ajax({
			type: "POST",
			url: "data/usermgmt/newuser.php",
			async: true,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (result) {
			util.closeModal();
			initTable();
			util.showBottomMSG(result);
		});	});
}