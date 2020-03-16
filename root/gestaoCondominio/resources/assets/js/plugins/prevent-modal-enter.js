$(document).ready(function(){
	$('form .modal input').keydown(function (e) { //Prevent 'Enter' key inside modal submit the form
		if (e.keyCode == 13) { //Enter key code
			e.preventDefault();
			return false;
		}
	});

});
