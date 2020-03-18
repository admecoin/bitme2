<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- SEO meta tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="{{ url('/') }}/images/favicon.ico">
		<!-- Title -->
		<title>BitcoinNearMe</title>
		<!-- Stylesheets -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap-4.1.3.min.css">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/fontawesome-free-5.3.1.css">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/animate.css">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
		<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117547527-1"></script>

        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-117547527-1');
        </script>
	</head>
	<body class="body-back">
		<header id="myHeader">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-dark navigationbar">
                    <!-- <a href="{{ url('/') }}/home"><img src="{{ url('/') }}/assets/image/logo.png" class="img-fluid mobile-width" alt=""></a> -->
                    <h1 class="m-0"><a href="{{ url('/') }}/home" class="text-white">BitcoinNearMe</a></h1>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/') }}/login">
                                    <div class="np-link">
                                        <div>
                                            <i class="fa fa-sign-in-alt"></i>
                                        </div>
                                        <div>
                                            <span class="np-link-text">Login</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/') }}/register">
                                    <div class="np-link">
                                        <div>
                                            <i class="fa fa-sign-out-alt"></i>
                                        </div>
                                        <div>
                                            <span class="np-link-text">Register</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

		<div class="auth px-4">
	        <div class="auth-inner">
	            <div class="box">
	                <div class="d-flex justify-content-center align-items-center">
    	                <a href="{{ url('/') }}">
    	                <img src="assets/image/logo.png" class="img-fluid mobile-width" alt="">
                        </a>
    	            </div>
    	            <form method="post" action="{{url('/')}}/change-password" onsubmit='return get_action();'>
			         {{ csrf_field() }}
	                    <div class="row">
	                        <div class="col-12">
	                            <div class="form-group">
	                                <label class="control-label">New Password</label>
                                    <input type="hidden" class="form-control" name="token" placeholder="token" value="{{ $AuthToken }}">
                                    <input type="hidden" class="form-control" name="id" placeholder="token" value="{{ $user_id }}">
	                                <input type="hidden" class="form-control" name="value" placeholder="token" value="{{ $value }}">
                                    <input type="password" id="newpass" class="form-control" name="newPass" placeholder="New Password">
	                            </div>
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" id="cpass" class="form-control" name="cPass" placeholder="Confirm Password">
                                </div>
	                        </div>
	                        <div class="col-12">
	                            <div class="form-group">
	                                <div class="g-recaptcha" data-sitekey="6LevWAUTAAAAAHQj5sFEaU_Xj7G0jt3HeTuJwsbv" data-theme="light" data-type="image" data-size="normal" ></div>
	                            </div>
	                        </div>
	                        <div class="col-12 mt-3">

	                            <button type="submit" class="button-cta font-14 btn-block">Submit</button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	            
	        </div>
	    </div>
	    
	    <footer class="footer">
            <div class="container border-top">
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="footer-title">
                            Social
                        </div>
                        <ul class="social">
                            <li>
                                <a class="wallet-img" href="https://www.facebook.com/CrypScrow/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a class="wallet-img" href="https://t.me/joinchat/H1UYZkqjw7sx2ixZLMEqRw/" target="_blank"><i class="fab fa-telegram"></i></a>
                            </li>
                            <li>
                                <a class="wallet-img" href="https://twitter.com/CrypScrow/" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a class="wallet-img" href="https://www.instagram.com/crypscrow/" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li>
                                <a class="wallet-img" href="https://crypscrow.tumblr.com/" target="_blank"><i class="fab fa-tumblr"></i></a>
                            </li>
                            <li>
                                <a class="wallet-img" href="https://www.pinterest.com/crypscrow/" target="_blank"><i class="fab fa-pinterest"></i></a>
                            </li>
                            <li>
                                <a class="wallet-img" href="https://www.youtube.com/channel/UComYU3C6wcHeCR9YwiqZpxw/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="footer-title">
                            Trade
                        </div>
                        <ul>
                            <li>
                                <a class="wallet-img" href="offers-buy">Buy ETH</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="offers-sell">Sell ETH</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="footer-title">
                            Learn
                        </div>
                        <ul>
                            <li>
                                <a class="wallet-img" href="#">How to buy</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="#">White paper</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="#">Affiliates</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="faq">FAQ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="footer-title">
                            Company
                        </div>
                        <ul>
                            <li>
                                <a class="wallet-img" href="https://blog.crypscrow.com/" target="_blank">Blog</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="contact">Contact us</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="{{ url('/') }}/terms-&-condition">Terms & Condition</a>
                            </li>
                            <li>
                                <a class="wallet-img" href="{{ url('/') }}/privacy-policy">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
				
		<!-- Javascriprt -->
		<script src="{{ url('/') }}/assets/js/jquery.js"></script>
		<script src="{{ url('/') }}/assets/js/popper.min.js"></script>
		<script src="{{ url('/') }}/assets/js/bootstrap-4.1.3.min.js"></script>
		<script src="{{ url('/') }}/assets/js/smooth-scroll.js"></script>
		<script src="{{ url('/') }}/assets/js/wow.min.js"></script>
		<script src="{{ url('/') }}/assets/js/custom.js"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
		    $('document').ready(function(){
			var width = $('.g-recaptcha').parent().width();
			
            if (width < 302) {
				var scale = width / 302;
				$('.g-recaptcha').css('transform', 'scale(' + scale + ')');
				$('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
				$('.g-recaptcha').css('transform-origin', '0 0');
				$('.g-recaptcha').css('-webkit-transform-origin', '0 0');
			}

		});
		</script>
        <script>
        function get_action(){
            var v = grecaptcha.getResponse();
            var pass = $('#newpass').val();
            var cpass = $('#cpass').val();
            var paswd=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{4,15}$/;

                if (pass == ''){
                    toastr.error("New Password Required!");
                    return false;
                }
                else if (cpass == ''){
                    toastr.error("Confirm Password Required!");
                    return false;
                }
                else if (pass != cpass){
                    toastr.error("New Password & Confirm Password not Match!");
                    return false;
                }
                 else if(pass.length < 5){
                    toastr.error('Password should contain minimum 6 letter');
                    return false;
                } else if(pass.length > 15){
                    toastr.error('Password should contain Maximum 14 letter');
                    return false;
                }
                else if(!(paswd.test(pass))) { 
                    toastr.error("Password should contain atleast one number, one alphabetic and one special character!");
                    return false;
                  }
                else if(v.length == 0 || v== "" ||v == 'undefined')
                {
                    toastr.error("You can't leave Captcha Code empty!");
                    return false;
                }
                else {
                   return true; 
                } 
        }
        </script>

	</body>
</html>