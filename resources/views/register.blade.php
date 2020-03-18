<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- SEO meta tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="images/favicon.ico">
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
                                        <!-- <div>
                                            <i class="fa fa-sign-in-alt"></i>
                                        </div> -->
                                        <div></div>
                                        <div>
                                            <span class="np-link-text">Login</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/') }}/register">
                                    <div class="np-link">
                                        <!-- <div>
                                            <i class="fa fa-sign-out-alt"></i>
                                        </div> -->
                                        <div></div>
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
    	            <form  class="mt-3 mt-sm-5" method="post" action="insertuser">
                         {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">User Name*</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Email*</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Password*</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password*</label>
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LcCPGAUAAAAAPp4saz9KO7EeR5ZGP342f14zoOb" data-theme="light" data-type="image" data-size="normal" ></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-white">Already have an account ?<a href="login" class="text-white"> Sign In</a></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="button-cta btn-block font-14">Sign Up</button>
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
		<!-- Javascriprt -->
		<script src="{{ url('/') }}/assets/js/jquery.js"></script>
		<script src="{{ url('/') }}/assets/js/popper.min.js"></script>
		<script src="{{ url('/') }}/assets/js/bootstrap-4.1.3.min.js"></script>
		<script src="{{ url('/') }}/assets/js/smooth-scroll.js"></script>
		<script src="{{ url('/') }}/assets/js/wow.min.js"></script>
		<script src="{{ url('/') }}/assets/js/custom.js"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script>
		    $('document').ready(function(){
                alert('');
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
	</body>
</html>