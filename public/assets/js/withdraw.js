// AJAX Coin Withdrawal VALIDATION

$(document).ready(function(){

	// var baseurl = $("#baseurl").val();

	$("form[data-form-validate='true']").each(function() {
        $(this).validate({
            errorPlacement: function(error, element) {
                // to append radio group validation erro after radio group            
                if (element.is(":radio")) {
                    error.appendTo(element.parents('.form-group'));
                } else {
                    error.insertAfter(element);
                }
                console.log(error);
                console.log(element);
            }
        });
    })

	// $("#withdrow-btn").on('click', function(){
		
	// 	var coin = $("#coin_id").val();	
	// 	if (coin != '' ) {
	// 		toastr.error(coin);
	//  		return false;	
	// 	}

	// });

});