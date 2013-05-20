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
					div.html(data);
				}
			},
		});
	});
	
	$("a").live("click", function() {
		var zone = $(this).attr("data-zone");
		var content = $(this).attr("data-content");
		var name = $(this).attr("data-name");
		$.ajax({
			url: "ajax.php?content="+content+"&name="+name,
			type: "get",
			dataType: "html",
			cache: false,
			success: function(data) {
				if (data != null) {
					$("div#" + zone).html(data);
				}
			},
		});
		return false;
	});
});
