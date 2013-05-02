$(document).ready(function() {
	$("div#menu").each(function() {
		var div = $(this);
		$.ajax({
			url: "ajax.php?content=menu",
			type: "get",
			dataType: "html",
			cache: false,
			success: function(data) {
				if (data != null) {
					div.replaceContent(data);
				}
			},
		});
	})
});
