// manage.js
// define variables and functions for manage.php

$(document).ready((e) => {
	$.get("data/usermgmt/buildtable.php", function (data) {
		$('#user-table').html(data);
		$('.threedots').click((e) =>{

			var $dropdown = $('#threedotsdropdown').clone();
			$dropdown.addClass('threedotsdropdown');
			var dropdownQuery = $('<div class="threedotsdropdown">' + $dropdown.html() + '</div>').hide();
			$(e.target).parent().append(dropdownQuery);
			dropdownQuery.slideDown(100);
		});
	});

	$(document).mouseup(() =>{
		var dropdown = $('.threedotsdropdown');

		if (dropdown.length > 0 && !dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
			dropdown.slideUp(100, ()=>{dropdown.remove();});
		}
	});
});

function manageUser(uid) {

}