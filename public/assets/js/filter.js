
$(document).ready(function(){

	var baseurl = $('input[name="baseurl"]').val();
	var csrf = $('input[name="_token"]').val();
	
	$('#apply-filter').on('click', function(e){
		
		e.preventDefault();
		var coinid = $('#coin').val();
		var offertype = $('#offerType').val();
		var location = $('#address').val();
		var paymethod = $('#pay_method').val();

		var send_data = {};

		if(coinid =='' && offertype=='' && location=='' && paymethod==''){
			toastr.error("Any One Field Required!");
			$('#coin').focus()
			return false;
		}

		// if((coinid==undefined || coinid=="" ) && (offertype==undefined || offertype=="") && (location==undefined || location=="") && (paymethod==undefined || paymethod=="") ){

		// 	$("#search_data").hide();
		// 	$("#all_data").removeAttr("style");
         	
  //        	//toastr.error("Any One Field Required!");
 	// 		// windows.localtion.reload(baseurl + "/offers-buy");
  //           //return false;
  //       }

		if (coinid!=undefined || coinid!="") {
        	send_data['coinid'] = coinid;
        }

        
        if (offertype!=undefined || offertype!="") {
        	send_data['offertype'] = offertype;
        }

        if (location!=undefined || location!="") {
        	send_data['location'] = location;
        }

        
        if (paymethod!=undefined || paymethod!="") {
        	send_data['paymethod'] = paymethod;
        }
				// console.log(send_data);
		$.ajax({
			type: "POST",
			url: baseurl + "/applyfilter",
			cache: false,
			data: {send_data},
			headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
			success:function(data){
				
				$("#all_data").attr("style", "display:none");
				$(".sellers").html(data);

			},
			error:function(response){
				console.log(response);
			}
		});

	});	

});
