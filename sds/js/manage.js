// manage.js
// define variables and functions for manage.php

$(document).ready((e) => {
	$.get("data/usermgmt/buildtable.php", function (data) {
		$('#user-table').html(data);
	});
});