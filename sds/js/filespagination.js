export var pagenumber = 0;

export function buildHTML(pages) {
	let html = "";
	if (pagenumber > 0 ) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber - 1) +'>&lt; Prev</a> ';
	}

	// We only want the first page, previous two pages, current page, next two pages, and last page
	// ex: 1 ... 4 5 6 7 8 ... 12   cur = 6 - 1
	// ex: 1 2 3 ... 12             cur = 1 - 1
	// ex: 1 2 3 4 5 6 ... 12       cur = 3 - 1
	// ex: 1 ... 9 10 11 12         cur = 10 - 1
	// `first` ... `prev2` `prev` `cur` `next` `next2` ... `last`

	// logic behind this:
	// step 1
	// if the previous second page is the first page, don't output `prev2` or ...
	//        (current - 2 <= 0)
	// if the previous page is the first page, don't output `prev2`, `prev`, or ...
	//        (current - 1 <= 0)
	// if the current page is the first page, don't output `prev2`, `prev`, `cur`, or ...
	//        (current == 0)
	// step 2
	// if the current page is the last page, don't output `next2`, `next`, `cur`, or ...
	//        (current == pages - 1)
	// if the next page is the last page, don't output	`next2`, `next`, or ...
	//        (current + 1 >= pages - 1)
	// if the next second page is the last page, don't put `next2` or ...
	//        (current + 2 >= pages - 1)

	/*
		Another way of thinking through this: procedurally.
		Do we output < prev?		(current > 0)

		0. Do we output ...? 		(current - 3 > 0)
		1. Do we output prev2? 		(current - 2 > 0)
		2. Do we output prev?		(current - 1 > 0)
		3. Do we output cur? 		(current > 0 && current < pages - 1)
		4. Do we output next?		(current + 1 < pages - 1)
		5. Do we output next2?		(current + 2 < pages - 1)
		6. Do we output ...?		(current + 3 < pages - 1)


	 */

	// print first page always
	html += '<a class="page-number-link" data-page-number=' + (0) + '>' + (1) + '</a> ';

	// Do we output ... ?
	if (pagenumber - 3 > 0) {
		html += '... ';
	}

	// Do we output prev2 ?
	if (pagenumber - 2 > 0) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber - 2) + '>' + (pagenumber - 1) + '</a> ';
	}

	// Do we output prev ?
	if (pagenumber - 1 > 0) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber - 1) + '>' + pagenumber + '</a> ';
	}

	// Do we output cur ?
	if (pagenumber > 0 && pagenumber < pages - 1) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber) + '>' + (pagenumber + 1) + '</a> ';
	}

	// Do we output next ?
	if (pagenumber + 1 < pages - 1) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber + 1) + '>' + (pagenumber + 2) + '</a> ';
	}

	// Do we output next2 ?
	if (pagenumber + 2 < pages - 1) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber + 2) + '>' + (pagenumber + 3) + '</a> ';
	}

	// Do we output ... ?
	if (pagenumber + 3 < pages - 1) {
		html += '... ';
	}

	// print last page always
	html += '<a class="page-number-link" data-page-number=' + (pages - 1) + '>' + (pages) + '</a> ';

	if (pagenumber < (pages - 1)) {
		html += '<a class="page-number-link" data-page-number=' + (pagenumber + 1) + '> Next &gt;</a>';
	}

	$("#all-files-page-numbers").html(html);

	initPageLinks();
}

function initPageLinks() {
	// TODO: click events
}