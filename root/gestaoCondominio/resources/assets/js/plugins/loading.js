$(document).ajaxStart(function () {
	$('body').append("<div class='loading' id='loading'><div class='loader' id='loader'></div></div>");
	$('body').css('overflow-y', 'hidden');
});
$(document).ajaxStop(function () {
    $('#loading').remove();
    $('body').css('overflow-y', 'auto');
});
$(document).ajaxError(function( event, request, settings ) {
	if(request.status == 401) //Unauthorized
	{
		$.notify({
			message: "Ocorreu um erro, favor logar novamente."
		}, { type: 'danger' } );
	}
	if(request.status == 500) //Fatal error
	{
		$.notify({
			message: "Ocorreu um erro, favor tentar novamente.",
		}, { type: 'danger' } );
	}
});
