import * as util from "./util.js";

$(document).ready(() => {
	util.showModal("modal/login.html", initLogin);
});

function initLogin() {
	jQuery("#login-form-submit").click(function (e) {
		var that = jQuery(this);
		that.prop("disabled", true);
		e.preventDefault();

		let email = jQuery("#login-form-email").val();
		let pass = jQuery("#login-form-pass").val();

		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("email", email);
		formData.append("pass", pass);

		jQuery.ajax({
			type: "POST",
			url: "data/login.php",
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		}).done(function (data) {
			if (data === "Success") {
				window.location = window.location.pathname;
			} else {
				jQuery("#login-message").html(data).slideDown(100);
				console.log(data);
				that.prop("disabled", false);
			}
		});
	});
}