$(document).ready(function(){
	$(".result").on("click", function(){
		var url = $(this).attr("href");
		var id = $(this).attr("data-linkID");

		console.log("URL: " + url + " ID: " + id);
		return false;
	});
});

function increaseLinkClicks(linkID, url){

}