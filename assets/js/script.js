$(document).ready(function(){
	$(".result").on("click", function(){
		var url = $(this).attr("href");
		var id = $(this).attr("data-linkID");

		if(!id){ 
			// do something here
		  }

		increaseLinkClicks(id, url);
		return false;
	});

	var grid = $(".image-results");
	grid.masonry({
		itemSelector: ".grid-item",
		columnWidth: 200,
		gutter: 5,
		transitionDuration: 0,
		isInitLayout: false	
	});
});

function loadImage(src, className){
	var image = $("<img>");
	image.on("load", function(){
		$("." + className + " a").append(image);
	});

	image.on("error", function(){
		//broken image
	});

	image.attr("src", src);
}

function increaseLinkClicks(linkID, url){
	$.post("ajax/updateLinkCount.php", {linkID: linkID})
	 	.done(function(result){
	 		if(result != ""){
	 			// do something here
	 			return;
	 		  }

	 		window.location.href = url;
	 	});
}