$(document).ready(function(){
	var x = window.scrollX, y = window.scrollY;
	$(this).find("input:text:enabled:visible:first, textarea:enabled:visible:first").focus();
	window.scrollTo(x, y);
})
