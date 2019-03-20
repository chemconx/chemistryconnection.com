<div class="darkenscreen" style="display: none">
</div>

<div class="modal" style="display: none">

</div>

<div class="bottommsg" style="display: none;">

</div>

<!--<div class="modal login-panel" style="display: none">-->
<!---->
<!--</div>-->


<script src="../js/vendor/modernizr-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../js/vendor/jquery-3.3.1.min.js"><\/script>');</script>
<script src="../js/vendor/clipboard.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="js/main.js"></script>
<?php
if ($authresults['success']) {
	echo '<script src="js/ui-dropdown/dropdown.min.js"></script>';
	echo '<script src="js/ui-transition/transition.min.js"></script>';
	echo '<script src="js/upload.js"></script>';
	echo '<script src="js/specialaccess.js"></script>';

}
?>


<?php

if (isset($_GET['login']) && !$authresults['success']) {
	echo '<script>
		(function() {
			jQuery(document).ready(function (){
				showModal("modal/login.html", initLogin);
			});
		}());
		
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
		 
	</script>';
}

?>

</html>