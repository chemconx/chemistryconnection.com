var oldWidth = 0;

export function init() {
	oldWidth = $(window).width;

	// run update methods when window is resize
	$(window).resize(update);

	$('#mobile-bars').click((e) => {
		const mobileBars = $('#mobile-bars');
		mobileBars.toggleClass('active');
		const usertoolbarLinks = $('.usertoolbar-links');

		if (usertoolbarLinks.is(':hidden')) {
			usertoolbarLinks.slideDown(200);
		} else {
			usertoolbarLinks.slideUp(200);
		}
	});

	$('.mobile-tab-dropdown').click((e) => {
		if ($('#tabs-dropdown-button').hasClass('active')) {
			hideTabsDropdown();
		} else {
			showTabsDropdown();
		}
	});
}

export function update() {
	$('.usertoolbar-links').attr('style', '');
	$('#mobile-bars').removeClass('active');
	hideTabsDropdown();

	const newWidth = $(window).width;
	if (new newWidth != oldWidth) {
		dropTableRowUp();
	}
}

export function hideTabsDropdown() {
	$('#tabs-dropdown-button').removeClass('active');
	$('.mobile-tab-list').slideUp(200);
	$('.occlusion-panel').fadeOut(200);
}

export function showTabsDropdown() {
	$('#tabs-dropdown-button').addClass('active');
	$('.mobile-tab-list').slideDown(200);
	$('.occlusion-panel').fadeIn(200);
}

export function initTable() {
	const fileRow = $('.filename-cell');
	fileRow.off('click.dropdown_table'); // prevent duplicate click events
	fileRow.on('click.dropdown_table', (e) => {
		// find what was clicked.
		var clicked = null;
		if ($(e.target).hasClass('.file-row')) {
			clicked = $(e.target);
		} else {
			clicked = $(e.target).closest('.file-row');
		}

		if (clicked.hasClass('active')) {
			dropTableRowUp();
		} else {
			dropTableRowUp();
			dropTableRowDown(clicked);
		}


	});
}

export function dropTableRowDown(clicked) {
	// mark this row as the active row
	clicked.addClass('active');

	// set the chevron to its rotated state (css manages this animation)
	clicked.find('.dropdown-cell').addClass('active');

	// get all action cells inside and slide them down
	const actionCells = clicked.find('.action-cell');
	actionCells.slideDown(200);
}

export function dropTableRowUp() {
	const row = $('.file-row.active');
	row.removeClass('active');
	row.find('.dropdown-cell').removeClass('active');
	const actionCells = row.find('.action-cell');
	actionCells.slideUp(200, () => {
		actionCells.removeAttr('style');
	});
}