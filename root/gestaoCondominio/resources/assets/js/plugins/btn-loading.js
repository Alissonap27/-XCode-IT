$(document).ready(function(){
	// Disable button until finish the request and go to another page
	$('.btn-loading').click(function(event){ //Loading button class
		if($(this).hasClass("disabled")) return false;

		$(this).find('.fa').removeClass('fa-search').addClass('fa-spinner fa-spin'); //Removes all existin icons
		$(this).addClass("disabled");

		return true;
	});
});
