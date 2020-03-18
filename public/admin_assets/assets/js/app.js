/* Custom js */


$('#approval-form').on('submit',function(){
	var appr = $('#appr').val();
	if (appr == '') {
		toastr.error('Please select any.');
		$('#appr').focus();
		return false;
	} else {
		if (appr == '1') {
			appr = 'execute';
		} else {
			appr = 'cancel';
		}
		if (confirm('Are you sure you want to '+ appr +' this trade?')) {
			return true;
		} else{
			return false;
		}
	}
	

});

function autoRefresh_div() {
	$.ajax({
		type: "GET",
		url:  baseurl+"/admin/getdisputchat",
		data:{dispute_id:dispute_id},
		success: function(data) {
			$('#chats').html(data);
			$(".slimscroll").animate({ scrollTop:$('.slimscroll').prop("scrollHeight")}, "0");
		}
	});
 } setInterval('autoRefresh_div()', 3000);


$('#chat-btn').click(function() {
	var message = $('#chat').val();
	// var media_file = $('#media_file').val();

	if (message == '') {
		toastr.error('Please enter message.');
		$('#chat').focus();
		return false;
	} else {		
		$.ajax({
			type:'GET',
			url: baseurl+'/admin/dispute-chat',
			data:{'dispute_id':dispute_id, 'message':message, '_token': $('#token').val()},
			success: function(data){
				var obj = JSON.parse(data);
				if (obj.status == '2') {
					toastr.error(obj.message);
				} else {
					$('#chat').val('');
					$(".chat-conversation").animate({ scrollTop:$('.chat-conversation').prop("scrollHeight")}, "0");
				}
			}
		});
	}
});

/* Get chat */

