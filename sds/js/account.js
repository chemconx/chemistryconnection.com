// account.js
// Handle user events and front-end data validation here

$(document).ready(e => {
	$('.chpassfield').keyup(handlePassFieldChange);
});

function handlePassFieldChange() {
	const oldPass = $('#new-pass-form-old');
	const newPass = $('#new-pass-form-new');
	const confPass = $('#new-pass-form-confirm');

	const oldVal = oldPass.val();
	const newVal = newPass.val();
	const confVal = confPass.val();

	var enabled = true;

	if (oldVal.length === 0) {
		$('#new-pass-form-old-msg').html('Password is required.');
		$('#new-pass-form-old-msg-container').slideDown(100);
		oldPass.addClass('error');
		enabled = false;
	} else {
		$('#new-pass-form-old-msg-container').slideUp(100);
		oldPass.removeClass('error');
	}

	if (newVal.length < 6) {
		$('#new-pass-form-new-msg').html('Password must have at least 6 characters.');
		$('#new-pass-form-new-msg-container').slideDown(100);
		newPass.addClass('error');
		enabled = false;
	} else {
		$('#new-pass-form-new-msg-container').slideUp(100);
		newPass.removeClass('error');
	}

	if (newVal != confVal) {
		$('#new-pass-form-confirm-msg').html('Passwords do not match.');
		$('#new-pass-form-confirm-msg-container').slideDown(100);
		confPass.addClass('error');
		enabled = false;
	} else {
		$('#new-pass-form-confirm-msg-container').slideUp(100);
		confPass.removeClass('error');
	}

	if (enabled) {
		enableSubmit();
	} else {
		disableSubmit();
	}
}

function enableSubmit() {
	$('#new-pass-form-submit').attr('disabled', false).removeClass('disabled');
}

function disableSubmit() {
	$('#new-pass-form-submit').attr('disabled', true).addClass('disabled');

}