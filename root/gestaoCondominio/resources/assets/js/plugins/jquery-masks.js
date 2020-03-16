$(document).ready(function(){
	$('.cpf').mask('000.000.000-00', {reverse: true});
	$(".date").mask("99/99/9999");
	$(".phone").mask("(99)9999-9999");
	$(".cell-phone").mask("(99)99999-9999");
	$(".cep").mask("99.999-999");
	$(".time").mask("99:99");
    $('.number').mask('0#');
    $('.registration').mask('0#');
});
