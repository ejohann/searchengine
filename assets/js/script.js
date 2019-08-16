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
});

function increaseLinkClicks(linkID, url){
	$.post("ajax/updateLinkCount.php", {linkID: linkID});
}