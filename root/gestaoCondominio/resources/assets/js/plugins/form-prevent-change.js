// Function to ask the user if he really wants to exit the page after editing the form
$(".form-prevent-change textarea,.form-prevent-change :input").on('click change keypress', function(){
	$(window).bind('beforeunload', function(data){
		return 'Deseja descartar as modificações?';
	});
});
$(".form-prevent-change").on("submit", function(event) {
	$(window).unbind('beforeunload');
});

//You can make a button that doesn't show the alert with this class (unbind)
$('.btn-unbind-change').click(function() {
	$(window).unbind('beforeunload');
});
