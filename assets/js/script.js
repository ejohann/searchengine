var timer;

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
	grid.on("layoutComplete", function(){
		$(".grid-item img").css("visibility", "visible");
			});

	grid.masonry({
		itemSelector: ".grid-item",
		columnWidth: 200,
		gutter: 5,
		transitionDuration: 0,
		isInitLayout: false	
	});

	$("[data-fancybox]").fancybox();

});

function loadImage(src, className){
	var image = $("<img>");
	image.on("load", function(){
		$("." + className + " a").append(image);
		clearTimeout(timer);
		timer = setTimeout(function(){
			$(".image-results").masonry();
		}, 500);
	});

	image.on("error", function(){
		//broken image
		$("." + className).remove();
		$.post("ajax/setBroken.php", {src: src});

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