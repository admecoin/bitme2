			<footer class="footer">
				<div class="container border-top">
					<div class="row">
						<div class="col-sm-3 col-md-3 col-lg-3">
							<div class="footer-title">
								Social
							</div>
							<ul class="social">
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-telegram"></i></a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-twitter"></i></a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-instagram"></i></a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-tumblr"></i></a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-pinterest"></i></a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank"><i class="fab fa-youtube"></i></a>
								</li>
							</ul>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<div class="footer-title">
								Trade
							</div>
							<ul>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/how-to-buy">How to Buy</a>
								</li>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/all-buy-offers">Buy Crypto</a>
								</li>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/all-sell-offers">Sell Crypto</a>
								</li>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/exchange">Convert</a>
								</li>
							</ul>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<div class="footer-title">
								More About Crypto
							</div>
							<ul>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/faq">FAQ's</a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank">Forum</a>
								</li>
								<li>
									<a class="wallet-img" href="#" target="_blank">Blog</a>
								</li>
								<li>
									<a class="wallet-img" href="#">News</a>
								</li>
							</ul>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<div class="footer-title">
								Terms & Privacy
							</div>
							<ul>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/terms-&-condition">Terms & Condition</a>
								</li>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/privacy-policy">Privacy Policy</a>
								</li>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/contact">Contact us</a>
								</li>
								<li>
									<a class="wallet-img" href="{{ url('/') }}/affiliate">Affiliate</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
			<input type="hidden" name="baseurl" value="{{ url('/') }}" id="baseurl">
		</main>
		
		<!-- Javascriprt -->
		<script src="{{ url('/') }}/assets/js/jquery.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="{{ url('/') }}/assets/js/popper.min.js"></script>
		<script src="{{ url('/') }}/assets/js/bootstrap-4.1.3.min.js"></script>
		<!--<script src="{{ url('/') }}/assets/js/smooth-scroll.js"></script>-->
		<script src="{{ url('/') }}/assets/js/wow.min.js"></script>
		<script src="{{ url('/') }}/assets/js/custom.js"></script>
		<script src="{{ url('/') }}/assets/js/filter.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
		<script src="{{ url('/') }}/assets/js/withdraw.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<script src="{{ url('/') }}/assets/js/app.js"></script>
		<style type="text/css">
			.error{color: red;}
		</style>        
        <script>
          @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
          	@endif
        </script>
        
         <script>
         	
	         	function btc_copy(text){
				    var dummy = document.createElement("input");
				    document.body.appendChild(dummy);
				    dummy.setAttribute('value', text);
				    dummy.select();
				    document.execCommand("copy");
				    document.body.removeChild(dummy);
				    toastr.success("BTC Address copied !! ");
				    
				}

				function eth_copy(text){
				    var dummy = document.createElement("input");
				    document.body.appendChild(dummy);
				    dummy.setAttribute('value', text);
				    dummy.select();
				    document.execCommand("copy");
				    document.body.removeChild(dummy);
				    toastr.success("ETH Address copied !! ");
				    
				}

				function ltc_copy(text){
				    var dummy = document.createElement("input");
				    document.body.appendChild(dummy);
				    dummy.setAttribute('value', text);
				    dummy.select();
				    document.execCommand("copy");
				    document.body.removeChild(dummy);
				    toastr.success("LTC Address copied !! ");
				    
				}
				
				function depoAddress_copy(){
					var text =  $("#dep_address").val();
				    var dummy = document.createElement("input");
				    document.body.appendChild(dummy);
				    dummy.setAttribute('value', text);
				    dummy.select();
				    document.execCommand("copy");
				    document.body.removeChild(dummy);
				    toastr.success("Deposit Address copied !! ");
				    
				}
			
         </script>
    	<script>

         function autoRefresh_div() {
		        var scrolled=0;
		    	$.ajax({
					type: "GET",
					url: "{{ url('') }}/getchat",
					success: function(data) {
	    			 	$('#msgs').animate({ scrollTop: $('#msgs').get(0).scrollHeight+500}, 2000);
	    			    $('#msgs').html(data);	        		
					}
				});

				$.ajax({
					type: "GET",
					url: "{{ url('') }}/getdisputchat",
					data:{dispute_id:dispute_id},
					success: function(data) {
	    			 	$('#dispute_msg').animate({ scrollTop: $('#dispute_msg').get(0).scrollHeight+500}, 2000);
	    			    $('#dispute_msg').html(data);	        		
					}
				});
		    }
		    setInterval('autoRefresh_div()', 3000);

         $(document).ready(function() {
         	if(!!window.performance && window.performance.navigation.type === 2) {
			    window.location.reload();
			}
         	var scrolled=0;
            scrolled=scrolled+50000;
            $("#msgs").animate({
             scrollTop:  scrolled
            });
            $("#dispute_msg").animate({
             scrollTop:  scrolled
            });

            $('#trbtn').on('click', function(){
            	var amount = $("#currency").val();
            	var min = $("#min_val").val();
         		var max = $("#max_val").val();
				
				if(amount == ''){
            		toastr.error('Currency Ammount required');
            		$("#currency").focus();
            		return false;
            	} else {
            		return true;
					
            	}            	
            });

         	$("#currency").on('keyup', function(){

         		var cur = $("#cur").val();
         		var cry = $("#cry").val();
         		var amount =  Number($("#currency").val());
         		var min = Number($("#min_val").val());
         		var max = Number($("#max_val").val()); 
         		var crypto = $("#crypto").val();
				
				
				if( amount < min || amount > max) {
					$("#min_error").css("display","block").html("You can Buy Minimum or maximum limits of trade amount");
         			$("#max_error").css("display","none");
         			$("#trbtn").attr("disabled",true);
					$('#crypto').val('');
         			return false;
					
				}
				else {
					
					if(amount<min){
         			$("#min_error").css("display","block");
         			$("#max_error").css("display","none");
         			$("#trbtn").attr("disabled",true);
					$('#crypto').val('');
         			return false;
					
					} else if(amount>max){ 
						$("#max_error").css("display","block");
						$("#min_error").css("display","none");
						$("#trbtn").attr("disabled",true);
						return false;
					} else {
						$("#trbtn").attr("disabled",false);
						$("#max_error").css("display","none");
						$("#min_error").css("display","none");
						var prc = $("#coinPrc").val();
						var cryp = amount/prc;
						$("#crypto").val(cryp);
					}
					
         		}

         	});

         	$("#next1").click(function(){

         		var offer = $('input[name="type"]:checked').val();

         		if(offer=="14"){
         			var ot = "Buy Offer";
         		} else if(offer=="15"){
         			var ot = "Sell Offer";
         		}

         		var pm = $('input[name="payment_method"]:checked').val();
         		var location = $('input[name="location2"]').val();
         		var currency = $('select[name="trade_cur2"]').val();

         		if(offer==undefined || offer==""){
         			toastr.error("Select offer type to create offer");
         		} else if(location==undefined || location==""){
         			toastr.error("Enter offer Location");
         		}  else if(pm==undefined || pm==""){
         			toastr.error("Select any payment method to create offer");
         		} else if(currency==undefined || currency==""){
         			toastr.error("Select  offer currency");
         		} else {

         			$("#menu1").css("display","none");
	         		$("#menu2").css("display","block");  
	         		$("#s1").removeClass("active");
	         		$("#s2").addClass("active");  
         		}
         		
			});



			$("#prev1").click(function(){
				
				$("#menu1").css("display","block");
         		$("#menu2").css("display","none");
				$("#s2").removeClass("active");
         		$("#s1").addClass("active"); 
         		
			});

			$('#confprice').on('click',function(){

				var cur = $("input[name='trade_cur']").val();
				var cur2 = $("select[name='trade_cur2']").val();
				
				if(cur2=="" || cur2==undefined){
					var currency = cur;	
				} else {
					var currency = cur2;
				}

				var per = $("#per").val();
				var con = $('input[name="ab_bl"]:checked').val();
				var coin = $('select[name="coins"]').val();
				var offer = $('input[name="type"]:checked').val();

				if(per==undefined || per==""){
         			toastr.error("Enter percentage for confirm price");
         		} else if(con==undefined || con==""){
         			toastr.error("Select above or below for confirm price");
         		}  else if(coin==undefined || coin==""){
         			toastr.error("Select any coin for confirm price");
         		}  else {
				
					$.ajax({

						'method' : "GET",
						'url' : "{{ url('/') }}/checkprice",
						'data' : {currency:currency,per:per,con:con,coin:coin,offer:offer},
						'success': function(data){

							$("#next2").attr('disabled',false);
							$("#confdata").html(data);
							
						}

					});

				}

			});


			$("#next2").click(function(){

         		var percentage = $('input[name="per"]').val();
         		var coin = $('select[name="coins"]').val();
         		var ab_bl = $('input[name="ab_bl"]:checked').val();
         		var max_range = Number($('input[name="max_range"]').val());
         		var min_range = Number($('input[name="min_range"]').val());
         		var balance = parseFloat($('input[name="balance"]').val());
         		var main_price = $('input[name="main_price"]').val();				
         		var coinValue = max_range/main_price;
         		var offer = $('input[name="type"]:checked').val();
         		var wanttobuy = parseFloat($('input[name="wanttobuy"]').val());

         		if(min_range==undefined || min_range==""){
         			toastr.error("Minimum range required!");
                    return false;
         		} else if(max_range==undefined || max_range==""){
         			toastr.error("Maximum range required!");
                    return false;
         		} else if(min_range >= max_range) {
	                toastr.error("Minimum range can not be greater than or equal to maximum range");
                    return false;
                } else if(offer=="15"){
					var current_rate = $('input[name="user_price"]').val();
					var max_val = current_rate*wanttobuy;
                	
					if(max_range > max_val){
						$('input[name="max_range"]').val(Math.floor(max_val));
						$('#err_maxRange').attr('style','color:red');
						$('#err_maxRange').html("Maximum range limit is "+ Math.floor(max_val) + " !");
						return false;
					}
					else if(wanttobuy > balance){

                		toastr.error("Insufficient Balance!");
	                    return false;
	                } else {
                		$("#menu2").css("display","none");
		         		$("#menu3").css("display","block");
						$("#s2").removeClass("active");
		         		$("#s3").addClass("active"); 
                	}
                } else {

	         		$("#menu2").css("display","none");
	         		$("#menu3").css("display","block");
					$("#s2").removeClass("active");
	         		$("#s3").addClass("active"); 
	    		}
			});

			$("#prev2").click(function(){

         		$("#menu2").css("display","block");
         		$("#menu3").css("display","none");
         		$("#s3").removeClass("active");
         		$("#s2").addClass("active"); 
				
			});
			
		});	 
    </script>

         <script src="https://cdn.jsdelivr.net/npm/places.js@1.16.1"></script>
          <script>
		(function() {
		  var placesAutocomplete = places({
		    appId: 'plXO40H2I739',
		    apiKey: '5a09e5e8b421fdc07e2bc085b6eeb0cf',
		    container: document.querySelector('#address')
		  });

		  var $address = document.querySelector('#address-value')
		  placesAutocomplete.on('change', function(e) {
		    $address.textContent = e.suggestion.value
		  });

		  placesAutocomplete.on('clear', function() {
		    $address.textContent = 'none';
		  });

		})();
		 </script>

		<link rel="manifest" href="/manifest.json" />

		<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
		<script>
		  var OneSignal = window.OneSignal || [];
		  OneSignal.push(function() {
		    OneSignal.init({
		      appId: "56e62dbe-0b92-45fd-adec-12f1b7e6b5af",
		    });
		  });
		</script>

		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117547527-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-117547527-1');
		</script>

		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/5b2e46eceba8cd3125e31c05/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
			})();
		</script>
		<!--End of Tawk.to Script-->
		
		<!-- Star Rating Script -->
		<script>
			$(document).ready(function(){
  
			  /* 1. Visualizing things on Hover - See next part for action on click */
			  $('#stars li').on('mouseover', function(){
				var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
			   
				// Now highlight all the stars that's not after the current hovered star
				$(this).parent().children('li.star').each(function(e){
				  if (e < onStar) {
					$(this).addClass('hover');
				  }
				  else {
					$(this).removeClass('hover');
				  }
				});
			  }).on('mouseout', function(){
				$(this).parent().children('li.star').each(function(e){
				  $(this).removeClass('hover');
				});
			  });
			  
			  /* 2. Action to perform on click */
			  $('#stars li').on('click', function(){
				var onStar = parseInt($(this).data('value'), 10); // The star currently selected
				var stars = $(this).parent().children('li.star');
				
				for (i = 0; i < stars.length; i++) {
				  $(stars[i]).removeClass('selected');
				}
				
				for (i = 0; i < onStar; i++) {
				  $(stars[i]).addClass('selected');
				}
				
				// JUST RESPONSE (Not needed)
				var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
				var msg = "";
				
				if (ratingValue > 0) {
					if (ratingValue > 1) {
						msg = "<img alt='tick image' width='15' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/> Thanks! You rated this " + ratingValue + " stars.";
					}
					else {
						msg = "<img alt='tick image' width='15' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/> We will improve ourselves. You rated this " + ratingValue + " stars.";
					}
					
				}
				else {
					msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
				}
				responseMessage(msg);
				
			  });
			});
			
			$('#btn-review').on('click',function(){
				
				var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
				
				var offer_id = $('#offer_id').val();
				var review = $('#review').val();
				var baseurl = $('input[name="baseurl"]').val();
				
				if(review == ''){
					alert('Please Gives Review of this offer!');
					return false;
				} 
				else {
					$.ajax({
						type:'POST',
						url: baseurl + "/rating",
						data:{ratingValue:ratingValue, offer_id:offer_id, review:review},
						headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
						success:function(data){
							if(data.success == false){
								toastr.error(data.message);
							}
							else{
								toastr.success(data.message);
							}							
						},
						error:function(response){
							console.log(response);
						}
					});
				}
			});

			function responseMessage(msg) {
			  $('.success-box').fadeIn(200);  
			  $('.success-box div.text-message').html("<span>" + msg + "</span>");
			}
		</script>
		<!-- End Rating Script -->
		
		
		<!-- Claim -->
		<script>
			$(document).ready(function(){
				$('.claims').on('click',function(){
					var baseurl = $('input[name="baseurl"]').val();
					var claim = $(this).attr('data-value');
					
					$.ajax({
						type:'POST',
						url: baseurl + "/claim",
						data:{claim:claim},
						headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
						success:function(data){
							if(data.success == false){
								toastr.error(data.message);
							}
							else{
								toastr.success(data.message);
								window.setTimeout(function(){location.reload()},1000);
							}
						},
						error:function(response){
							console.log(response);
						}
					});
				});
			});
		</script>

		<!-- Exchange Coin -->
		<script>
			$(document).ready(function(){			
				var baseurl = $('input[name="baseurl"]').val();
				$('#form_coin').on('change',function(){
					var form_coin = $('#form_coin').val();
					var to_coin = $('#to_coin').val();
					
					if (form_coin == to_coin) {
						toastr.error('Change coin pair!');
						$('#exc_ammount').attr('disabled','true');
						return false;
					} else {
						$('#exc_ammount').removeAttr('disabled');

						$.ajax({
							type:'POST',
							url: baseurl + "/getmiamount",
							data:{form_coin:form_coin, to_coin:to_coin},
							headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
							success:function(data){
								var obj = $.parseJSON(data);
								$('#min_ammount').val(obj.result);
								$('#minAmount').html('<p>* Minimum '+obj.result+' balance required for exchange.</p>');
							},
							error:function(response){
								console.log(response);
							}
						});
					}
				});

				$('#to_coin').on('change',function(){
					var form_coin = $('#form_coin').val();
					var to_coin = $('#to_coin').val();
					var baseurl = $('input[name="baseurl"]').val();
					
					if (form_coin == to_coin) {
						toastr.error('Change coin pair!');
						$('#exc_ammount').attr('disabled','true');
						return false;
					} else {
						$('#exc_ammount').removeAttr('disabled');
						$.ajax({
							type:'POST',
							url: baseurl + "/getmiamount",
							data:{form_coin:form_coin, to_coin:to_coin},
							headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
							success:function(data){
								var obj = $.parseJSON(data);
								$('#min_ammount').val(obj.result);
								$('#minAmount').html('<p>* Minimum '+obj.result+' balance required for exchange.</p>');
							},
							error:function(response){
								console.log(response);
							}
						});
					}
				}); 

				$('#exc_ammount').on('keyup',function(){ 
					var form_coin = $('#form_coin').val();
					var to_coin = $('#to_coin').val();
					var exc_ammount = $('#exc_ammount').val();
					var baseurl = $('input[name="baseurl"]').val();

					if (form_coin == to_coin) {
						toastr.error('Change coin pair!');
						return false;
					} else {
						$('#exc_ammount').removeAttr('disabled');
						$.ajax({
							type:'POST',
							url: baseurl + "/estimate-amt",
							data:{form_coin:form_coin, to_coin:to_coin,exc_ammount:exc_ammount},
							headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
							success:function(data){
								var obj = $.parseJSON(data);
								$('#rec_ammount').val(obj.result);
								console.log(data);
							},
							error:function(response){
								console.log(response);
							}
						});
					} 
				});

				$('#user_address').on('keyup',function(){ 
					var form_coin = $('#form_coin').val();
					var to_coin = $('#to_coin').val();
					var address = $('#user_address').val();
					var baseurl = $('input[name="baseurl"]').val();

					if (form_coin == to_coin) {
						toastr.error('Change coin pair!');
						return false;
					} else {
						$('#exc_ammount').removeAttr('disabled');
						$.ajax({
							type:'POST',
							url: baseurl + "/generateAddress",
							data:{form_coin:form_coin,to_coin:to_coin,address:address},
							headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
							success:function(data){
								var obj = $.parseJSON(data);

								if (obj.result == false) {
									$('input[name=exc_submit]').attr('disabled','true');
								}
								else {
									$('#dep_address').val(obj.result.address);
								}
								//console.log(data);
							},
							error:function(response){
								console.log(response);
							}
						});
					} 
				});

				$('input[name=exc_submit]').on('click',function(){
					
					var form_coin = $('#form_coin').val();
					var to_coin = $('#to_coin').val();
					var exc_ammount = parseFloat($('#exc_ammount').val());
					var min_ammount = parseFloat($('#min_ammount').val());
					
					var user_address = $('#user_address').val();
					var dep_address = $('#dep_address').val();

					if (form_coin == to_coin) {
						toastr.error('Change coin pair!' );
						return false;
					} else if(user_address == ''){
						toastr.error('User Address Required !');
						return false;
					} else if(dep_address == ''){
						toastr.error('Deposit Address Required!' );
						return false;
					} else if(exc_ammount < min_ammount){
						toastr.error('Minimum '+min_ammount+ ' value required');
						return false;
					} else{ 
						toastr.success('done!');
						return true;
					}

				});
			});
		</script>
		
	</body>
</html>