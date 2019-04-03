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
<script src="../js/vendor/clipboard.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="js/main.js"></script>

<?php

if (isset($scripts)) {
		foreach ($scripts as $script) {
			echo $script;
		}
	}

?>

</html>