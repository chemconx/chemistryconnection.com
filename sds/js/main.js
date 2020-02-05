// main.js
// define global variables and main functions
import * as pagination from './filespagination.js';

var tabSelected = -1;

$(document).ready(function () {
	initTabs();

	initTables();

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

export function initTables() {
	var getArgs = "?t="+tabSelected+"&p="+pagination.pagenumber;
	var type = "?t=" + tabSelected;

	if (tabSelected === -1) {
		getArgs = "?p="+pagination.pagenumber;
		type = "";
	}

	$.get("data/recentfiles.php" + type, function (data) {
		$('#recent-files-table').html(data);

		initTableButtons();
	});

	$.get("data/allfiles.php" + getArgs, function (data) {
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

	// TODO send datasheet type
	$.get("data/pagecount.php", data => {
		const pages = parseInt(data, 0);
		$("#all-files-page-numbers").html(pagination.buildHTML(pages));
	});
}

function onCopy(e) {
	let link = $(e.target).attr("data-clipboard-text");
	let fileType = $(e.target).attr("data-copy-link-file-type");
	showModal('modal/copy.php', () => {
		let imageLink = "https://chemistryconnection.com/sds/img/datasheettype" + fileType + ".jpg";
		let iconCode = '<a target="_blank" href="' + link + '"><img src="' + imageLink + '" style="height: 6rem; width: auto"></a>';

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

