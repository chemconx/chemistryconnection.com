$(document).ready(()=>{
	initModals();
});

function initModals() {
	$('.darkenscreen').click(function () {
		closeModal();
	});

	$('.modal-close').click(function () {
		$('.darkenscreen').hide();
		$('.modal').hide();
	});

	$('.bottommsg').click(function () {
		hideBottomMsg();
	})
}

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}

function cleanURL() {
	let uri = window.location.toString();
	if (uri.indexOf("?") > 0) {
		let clean_uri = uri.substring(0, uri.indexOf("?"));
		window.history.replaceState({}, document.title, clean_uri);
	}
}

function showModal(url, completion = null) {
	$('.darkenscreen').fadeIn(100);
	$('.modal').fadeIn(100);

	$.get(url, function (data) {
		$(".modal").html(data).show();

		// Add event listeners to whatever gets loaded
		if (completion) {
			completion();
		}
	});
}

function closeModal() {
	$('.darkenscreen').fadeOut(100);
	$('.modal').fadeOut(100);
	cleanURL();
}

function showBottomMSG(msg){
	let bottomMSG = $('.bottommsg');
	bottomMSG.html("<p>" + msg + "</p>");
	bottomMSG.show();

	bottomMSG.animate({bottom:'0px'},300);

	setTimeout(function () {
		hideBottomMsg();
	}, 3000);

}

function hideBottomMsg() {
	$('.bottommsg').animate({bottom:'-100px'},300, "swing", function() {
		$(this).hide();
	});
}

