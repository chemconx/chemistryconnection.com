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
}

export function update() {

}