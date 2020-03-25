export function init() {
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
	})
}

export function update() {
	$('.usertoolbar-links').attr('style', '');
	$('#mobile-bars').removeClass('active');
	hideTabsDropdown();
}

function hideTabsDropdown() {
	$('#tabs-dropdown-button').removeClass('active');
	$('.mobile-tab-list').slideUp(200);
	$('.occlusion-panel').fadeOut(200);
}

function showTabsDropdown() {
	$('#tabs-dropdown-button').addClass('active');
	$('.mobile-tab-list').slideDown(200);
	$('.occlusion-panel').fadeIn(200);
}