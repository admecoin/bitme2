$(document).ready(function() {
	$('#sendmsg').on('click', function() {
		var file = $('#file-upload').val();
		var msg = $('#message').val();
		if (msg == '' && file == '') {
			toastr.error('Message Or File is Required!');
			$('#message').focus();
			return false;
		} else {
			return true;
		}
	});

	$('#dispute_chat').on('submit', function() {
		
		var msg = $('#message').val();
		var file = $('#file-upload').val();

		if (msg == '' && file == '') {
			toastr.error('Message Or File is Required!');
			$('#message').focus();
			return false;
		} else {
			return true;
		}
	});	
});