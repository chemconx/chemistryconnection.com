// upload.js
// Define Upload prototype.

export var Upload = function (file, filename, fileType) {
	this.file = file;
	this.filename = filename;
	this.dsType = fileType;
};

Upload.prototype.getType = function() {
	return this.file.type;
};
Upload.prototype.getSize = function() {
	return this.file.size;
};
Upload.prototype.getName = function() {
	return this.file.name;
};

Upload.prototype.getFilename = function() {
	return this.filename;
};

Upload.prototype.getDSType = function() {
	return this.dsType;
};

Upload.prototype.doUpload = function (completion = null) {
	var that = this;
	var formData = new FormData();

	// add assoc key values, this will be posts values
	formData.append("file", this.file, this.getName());
	formData.append("filename", this.getFilename());
	formData.append("dstype", this.getDSType());
	formData.append("upload_file", true);

	$.ajax({
		type: "POST",
		url: "data/upload.php",
		xhr: function () {
			var myXhr = $.ajaxSettings.xhr();
			if (myXhr.upload) {
				myXhr.upload.addEventListener('progress', that.progressHandling, false);
			}
			return myXhr;
		},
		success: function (data) {
			// your callback here
		},
		error: function (error) {
			// handle error
		},
		async: true,
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		timeout: 60000
	}).done(function (data) {completion(data)});
};

Upload.prototype.progressHandling = function (event) {
	var percent = 0;
	var position = event.loaded || event.position;
	var total = event.total;
	var progress_bar_id = "#progress-wrp";
	if (event.lengthComputable) {
		percent = Math.ceil(position / total * 100);
	}
	// update progressbars classes so it fits your code
	$(progress_bar_id + " .progress-bar").css("width", +percent + "%");
	// $(progress_bar_id + " .status").text(percent + "%");
};