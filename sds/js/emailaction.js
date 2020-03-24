import * as util from './util.js';

$(document).ready( () => {

	var urlVars = util.getUrlVars();
	var mode = urlVars['mode'];

	if (mode === 'resetPassword') {

		var config = {
			'apiKey': 'AIzaSyDKyAfHEhK8ATWY-_z-M1cIz9MvxC4LrZA'
		};

		var app = firebase.initializeApp(config);
		var auth = app.auth();

		var actionCode = urlVars['oobCode'];
		var accountEmail;

		// Verify the password reset code is valid.

		auth.verifyPasswordResetCode(actionCode).then(function(email) {
			accountEmail = email;

			// TODO: Show the reset screen with the user's email and ask the user for
			// the new password.

			$.get('data/usermgmt/resetpass.html', (data)=>{
				$('.main.content').slideUp(100, ()=>{
					var dataDOM = $(data);
					dataDOM.find('.header.recent').html('Reset Password for ' + accountEmail);
					dataDOM.find('#reset-pass-form-email').val(accountEmail);
					$('.main.content').html(dataDOM).slideDown(100);
					// TODO assign event listeners to buttons
					initResPassButton(auth, actionCode);
				});
			});
		}).catch(function(error) {
			// Invalid or expired action code. Ask user to try to reset the password
			// again.
		});

	}
}, false);

var currentlyProcessing = false;

function initResPassButton(auth, actionCode) {
	$('#reset-pass-form').submit((e) =>{
		e.preventDefault();

		if (!currentlyProcessing) { // check against user clicking twice
			var newpass = $('#reset-pass-form-new').val();
			var confpass = $('#reset-pass-form-confirm').val();

			if (newpass !== confpass) {
				$('#new-pass-form-new-msg').html('Passwords do not match');
				$('#new-pass-form-new-msg-container').slideDown(100);
				that.prop('disabled', false);
			} else {
				$('.form-element').slideUp(100);

				// Save the new password.
				auth.confirmPasswordReset(actionCode, newpass).then(function (resp) {
					// Password reset has been confirmed and new password updated.

					var confirm = $('<div class="container"><p>Your password has been changed. Continue to <a href="index.php?login">login</a></p>');

					$('#reset-pass-form').append(confirm);
				}).catch(function (error) {
					// Error occurred during confirmation. The code might have expired or the
					// password is too weak.

					console.log(error);
				});
			}
		}
	});
}

