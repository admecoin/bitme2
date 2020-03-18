<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- SEO meta tags -->
		<meta name="description" content="@if(isset($title)) {{$title}} @else BitcoinNearMe @endif">
		<meta name="keywords" content="@if(isset($keyword)) {{$keyword}} @else BitcoinNearMe @endif">
		<meta name="author" content="">
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		<!-- <link rel="icon" href="{{ url('/') }}/images/favicon.ico"> -->
		<!-- Title -->
		<title>@if(isset($title)) {{$title}} @else {{"BitcoinNearMe"}} @endif</title>
		<!-- Stylesheets -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap-4.1.3.min.css">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/fontawesome-free-5.3.1.css">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/animate.css">
		<link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css">
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117547527-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-117547527-1');
        </script>
	</head>

	<body>
		<!-- Navigation -->
		<header id="myHeader">
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-dark navigationbar">
					<!-- <a href="{{ url('/') }}/home"><img src="{{ url('/') }}/assets/image/logo.png" class="img-fluid mobile-width" alt=""></a> -->
					<h1 class="m-0"><a href="{{ url('/') }}/home" class="text-white">BitcoinNearMe.com</a></h1>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link" href="#">
									<div class="np-link">
										<div>
											<!-- <i class="fa fa-box"></i> -->
										</div>
										<div><span class="np-link-text">Buy Bitcoins</span></div>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<div class="np-link">
										<div>
											<!-- <i class="fa fa-box"></i> -->
										</div>
										<div><span class="np-link-text">Sell Bitcoins</span></div>
									</div>
								</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/') }}/my-trades">
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-exchange-alt"></i></div> -->
										<div><span class="np-link-text">Post a Trade</span></div>
									</div>
								</a>
							</li>
							@if(Session::has('user_id')) 
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/') }}/my-offers">
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-bullhorn"></i></div> -->
										<div><span class="np-link-text">Offers</span></div>
									</div>
								</a>
							</li>
							<li class="nav-item">
									<a class="nav-link" href="{{ url('/') }}/wallet">
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-wallet"></i></div> -->
										<div><span class="np-link-text">Wallet</span></div>
									</div>
								</a>
							</li>
							@endif
							<li class="nav-item">
									<a class="nav-link" href="{{ url('/') }}/help">
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-question-circle"></i></div> -->
										<div><span class="np-link-text">Help</span></div>
									</div>
								</a>
							</li>
						</ul>

						<ul class="navbar-nav">
							@if(Session::has('user_id')) 
							<li class="nav-item">
									<a class="nav-link" href="{{ url('/') }}/my-account">
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-user"></i></div> -->
										<div><span class="np-link-text">{{Session::get('user_name')}}</span></div>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/') }}/logout">	
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-power-off"></i></div> -->
										<div><span class="np-link-text">Logout</span></div>
									</div>
								</a>
							</li>
							
							@else
							<li class="nav-item">
									<a class="nav-link" href="{{ url('/') }}/login">
									<div class="np-link">

										<div></div>
										<!-- <div><i class="fa fa-sign-in-alt"></i></div> -->
										<div><span class="np-link-text">Login</span></div>
									</div>
								</a>
							</li>
							<li class="nav-item">
									<a class="nav-link" href="{{ url('/') }}/register">
									<div class="np-link">
										<div></div>
										<!-- <div><i class="fa fa-sign-out-alt"></i></div> -->
										<div><span class="np-link-text">Register</span></div>
									</div>
								</a>
							</li>
							@endif
						</ul>

					</div>
				</nav>
			</div>
		</header>
		<main>
