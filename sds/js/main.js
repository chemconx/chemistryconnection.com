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

function initUpload() {
	$('#upload-file-input').on('change', function () {
		$('#upload-file-rename-input').val($(this).val().split("\\").pop());
	});

	$('#upload-file-submit').click(function (e) {
		e.preventDefault();

		// run upload crap
		let file = $('#upload-file-input').prop('files') [0];
		let upload = new Upload(file, $('#upload-file-rename-input').val());
		// execute upload
		upload.doUpload(function (data) {
			$('#progress-wrp').slideUp();
			$('#msg').html(data);
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
	$('.darkenscreen').show();

	$.get(url, function (data) {
		$(".modal").html(data).show();

		// Add event listeners to whatever gets loaded
		if (completion) {
			completion();
		}
	});
}

