<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/10/19
 * Time: 3:29 PM
 */

include __DIR__ . '/component/page-head.php';

include __DIR__ . '/component/navbar.php';

?>

	<div class="main content">
		<div class="main-container">
			<div class="container">
				<div class="container header">
					<h3 class="header recent">Reset Password</h3>
				</div>

				<p>Please Wait...</p>

			</div>
		</div>
	</div>

	<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-auth.js"></script>
	<script type="module" src="js/emailaction.js"></script>

<?php

include __DIR__ . '/component/footer.php';

?>