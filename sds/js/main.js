// main.js
// define global variables and main functions

var tabSelected = -1;

$(document).ready(function () {
	initTabs();

	initTables();

	initModals();

	initSearch();

	setTimeout(function () {
		$('.hide-eventually').slideUp(300);
	}, 3000);
}());

function initTabs() {
	$('.tab-item').click(function (e) {
		$('.tab-active').removeClass('tab-active');
		$(this).addClass('tab-active');

		tabSelected = parseInt($(this).attr("data-sheet-type"));

		initTables();
	})
}

function initTables() {
	var type = "?t="+tabSelected;

	if (tabSelected === -1) {
		type = ""
	}

	$.get("data/recentfiles.php" + type, function (data) {
		$('#recent-files-table').html(data);

		initTableButtons();
	});

	$.get("data/allfiles.php" + type, function (data) {
		$('#all-files-table').html(data);

		initTableButtons();
	});

	if ($('.container.search').length) {
		let urlvars = getUrlVars();

		var url = '';

		if (tabSelected === -1) {
			url = 'data/search.php?q=' + urlvars['q'];
		} else {
			url = 'data/search.php' + type + '&q=' + urlvars['q']
		}



		$("#search-input").val(urlvars['q'].replace(/\+/g, ' '));

		$.get(url, function (data) {
			$("#search-results-table").html(data);

			initTableButtons();
		});
	}

	// let clipboard = new ClipboardJS('.action.copy');
	//
	// clipboard.on('success', function(e) {
	// 	showBottomMSG("Link copied!");
	// });
	//
	// clipboard.on('error', function(e) {
	// 	showBottomMSG("We were unable to copy the link.");
	// });
}

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

function initSearch() {
	let searchInput = $('#search-input');

	searchInput.click(function () {
		$(this).select();
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

function initTableButtons() {
	$('.action.copy').click(e => {
		onCopy(e);
	});
}

function onCopy(e) {
	let link = $(e.target).attr("data-clipboard-text");
	let fileType = $(e.target).attr("data-copy-link-file-type");
	showModal('modal/copy.html', () => {
		var imageLink = "https://chemistryconnection.com/sds/img/datasheettype" + fileType + ".jpg";
		var iconCode = '<a target="_blank" href="' + link + '"><img src="' + imageLink + '" style="height: 6rem; width: auto"></a>';

		$('#copy-form-link').attr("data-clipboard-text", link);
		$('#copy-form-icon-code').attr("data-clipboard-text", iconCode);

		let clipboardLink = new ClipboardJS('#copy-form-link');
		let clipboardCode = new ClipboardJS('#copy-form-icon-code');

		clipboardLink.on('success', () => {
			closeModal();
			showBottomMSG("Link copied!");
		});

		clipboardLink.on('error', () => {
			showBottomMSG("We were unable to copy the link.");
		});

		clipboardCode.on('success', () => {
			closeModal();
			showBottomMSG("HTML code copied!");
		});

		clipboardCode.on('error', () => {
			showBottomMSG("We were unable to copy the code.");
		});
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
	})
}

