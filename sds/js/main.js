$(document).ready(function () {
	initTables();

	initModals();

	initSearch();
}());


function initTables() {
	$.get("data/recentfiles.php", function (data) {
		$('#recent-files-table').html(data);
	});

	$.get("data/allfiles.php", function (data) {
		$('#all-files-table').html(data);
	});

	if ($('.container.search').length) {
		let urlvars = getUrlVars();
		let url = 'data/search.php?q=' + urlvars['q'];

		$("#search-input").val(urlvars['q'].replace(/\+/g, ' '));

		$.get(url, function (data) {
			$("#search-results-table").html(data);
		});
	}

	let clipboard = new ClipboardJS('.action.copy');


	clipboard.on('success', function(e) {
		showBottomMSG("Link copied!");
	});

	clipboard.on('error', function(e) {
		showBottomMSG("We were unable to copy the link.");
	});
}

function initModals() {
	$('.darkenscreen').click(function () {
		$(this).hide();
		$('.modal').hide();

		cleanURL();
	});

	$('#upload-button').click(function () {
		showModal("modal/upload.php", initUpload);
	});

	$('.modal-close').click(function () {
		$('.darkenscreen').hide();
		$('.modal').hide();
	});

	$('.bottommsg').click(function () {
		hideBottomMsg();
	})
}

function initSearch() {
	let searchInput = $('#search-input');

	searchInput.click(function () {
		$(this).val('');
	});

	searchInput.on('keyup paste', function () {

		if ($(this).val().length > 2) {

			let q = $(this).val().replace(/ /g, '+');
			let url = 'data/search.php?q=' + q;

			$.get(url, function (data) {
				$("#search-results-table").html(data);
			});
		}
	});
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
	$('.darkenscreen').show();

	$.get(url, function (data) {
		$(".modal").html(data).show();

		// Add event listeners to whatever gets loaded
		if (completion) {
			completion();
		}
	});
}

function showBottomMSG(msg){
	let bottomMSG = $('.bottommsg');
	bottomMSG.html("<p>" + msg + "</p>");
	bottomMSG.show();

	bottomMSG.animate({bottom:'0px'},500);

	setTimeout(function () {
		hideBottomMsg();
	}, 3000);

}

function hideBottomMsg() {
	$('.bottommsg').animate({bottom:'-100px'},500, "swing", function() {
		$(this).hide();
	})
}