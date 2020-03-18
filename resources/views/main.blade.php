<!DOCTYPE html>
<html lang="en">
<?php
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
    
        return $ipaddress;
    }
    function get_country($json)
    {
        return $country  = $json['country'];
    }
    function get_region($json)
    {
        return $region = $json['region'];
    }
    function get_city($json) 
    {
        return $city = $json['city'];
    }
    
    function generate_string($json)
    {
        return $address = get_country($json).' '.get_region($json).' '.get_city($json);
    }
    
    
    

    function getDistance($addressTo, $addressFrom,$unit=' '){
        $apiKey='AIzaSyCS1FhFE2oniXdaWBCrZI9SVGcltT7B5uY';  //Сюда вставить ключ

        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);  
   
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
    
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        $outputTo = json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }
    
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
    
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = rad2deg(acos(sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta))));
        $miles    = $dist * 60 * 1.1515;
    
        $unit = strtoupper($unit);
        if($unit == "K"){
            return round($miles * 1.609344, 2).' km';
        }else{
            return round($miles, 2).' miles';
        }   
}
    $ip = get_client_ip();
    $json     = file_get_contents("http://ipinfo.io/$ip/geo");
    $json     = json_decode($json, true);
    $destination=' Queens, NY, USA';
    $from=generate_string($json);
    $distance=getDistance($destination, $from,"K");

?>

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- SEO meta tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<!-- <link rel="icon" href="images/favicon.ico"> -->
		
		<!-- Title -->
		<title>BitcoinNearMe</title>
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
		<main class="main">
			<section>
				<div class="container">
							@if(Session::has('user_id')) 
							@else
					<div class="banner">
						<h1 class="title">Buy and sell bitcoins near you</h1>
						<h2 class="tagline">Instant. Secure. Private.</h2>
						<p>Trade bitcoins in <span class="tagline">7909 cities</span> and <span class="tagline">248 countries</span> including <span class="tagline">India</span></p>
						<a href="#" title="" class="browse-btn"><i class="fas fa-user-plus"></i> Sign up free</a>
					</div>
					@endif
				</div>
			</section>
			<!-- Buy bitcoins section -->
			<section class="feature">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h3>Buy bitcoins with cash near Los Angeles, CA, USA</h3>
							
							<div class="table-responsive">
								<table class="table table-striped table-condensed table-bitcoins ">
									<tbody>
										<tr>
											<!-- <th>Buyer</th> -->
											<th>Seller</th>
											<!-- <th title="Payment Method">Payment Method</th> -->
											<!-- <th title="Location">Location</th> -->
											<th title="Distance">Distance</th>
											<th title="Location">Location</th>
											<th class="header-price" title="Current price of this ad">Price / BTC</th>
											<th class="header-limit" title="Trade amount in fiat currency">Limits</th>
											<th></th>
										</tr>
										@foreach($sell_offer as $srow)
										<tr class="clickable">
											<td class="column-user">
												<a href="#">{{$srow->user_name}} </a>
												<span title="" class="online-status online-status-online">
												<i class="fa fa-circle"></i>
												</span>
											</td>
											<!-- <td>{{ $srow->payment_mode }}</td> -->
                                            <td><?php $dist= GetDistance($srow->location,$from,'');
                                                echo $dist;?></td>
											<td >{{ $srow->location }}</td>
											<td class="column-price">
												1 {{ $srow->label }} = {{$srow->coinprice}} USD
											</td>
											<td class="column-limit">
												{{number_format($srow->min)}} - {{number_format($srow->max)}} {{ substr($srow->short,3) }}
											</td>
											<td class="column-button">
												<a class="browse-btn" href="{{url('offer')}}/{{$srow->offer_id}}">Buy</a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="dropdown float-right">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Show More...
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<a class="dropdown-item" href="#">Something else here</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Sell bitcoins section -->
			<section class="feature mt-5">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h3>Buy bitcoins online in the United States</h3>
							<div class="table-responsive">
								<table class="table table-striped table-condensed table-bitcoins ">
									<tbody>
										<tr>
											<!-- <th>Seller</th> -->
											<th>Seller</th>
											<!-- <th>Payment Method</th> -->
											<th title="payment_method">Payment Method</th>
											<th class="header-price" title="Current price of this ad">Price / BTC</th>
											<th class="header-limit" title="Trade amount in fiat currency">Limits</th>
											<th></th>
										</tr>
										@foreach($buy_offer as $brow)
										<tr class="clickable">
											<td class="column-user">
												<a href="#">{{$brow->user_name}} </a>
												<span title="" class="online-status online-status-online">
												<i class="fa fa-circle"></i>
												</span>
											</td>
											 <td>{{ $brow->payment_mode }}</td> 
											<!-- <td>99.3 miles</td>-->
											<!--<td >{{$brow->location}}</td>-->
											<td class="column-price">
												1 {{ $brow->label }} = {{$brow->coinprice}} USD
											</td>
											<td class="column-limit">
												{{number_format($brow->min)}} - {{number_format($brow->max)}} {{ substr($brow->short,3) }}
											</td>
											<td class="column-button">
												<a class="browse-btn" href="{{url('offer')}}/{{$brow->offer_id}}">Buy</a>
											</td>
										</tr>
										@endforeach
										
									</tbody>
								</table>
							</div>
							<div class="dropdown float-right">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Show More...
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<a class="dropdown-item" href="#">Something else here</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- <section class="feature">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h3>Buy bitcoins with cash near, {{$live['city']}}, {{$live['state']}}, {{$live['country']}}</h3>
							<div class="table-responsive">
								<table class="table table-striped table-condensed table-bitcoins ">
									<tbody>
										<tr>
											<th>Seller</th>
											<th title="Distance">Distance</th>
											<th title="Location">Location</th>
											<th class="header-price" title="Current price of this ad">Price / BTC</th>
											<th class="header-limit" title="Trade amount in fiat currency">Limits</th>
											<th></th>
										</tr>
										@foreach($location_sell_offer as $lsrow)
										<tr class="clickable">
											<td class="column-user">
												<a href="#">{{$lsrow->user_name}}</a>
												<span title="" class="online-status online-status-online">
												<i class="fa fa-circle"></i>
												</span>
											</td>
											<td>99.3 miles</td>
											<td>{{$lsrow->location}}</td>
											<td class="column-price">
												1 {{ $lsrow->label }} = {{$lsrow->coinprice}} USD
											</td>
											<td class="column-limit">
												{{number_format($lsrow->min)}} - {{number_format($lsrow->max)}} {{ substr($lsrow->short,3) }}
											</td>
											<td class="column-button">
												<a class="browse-btn" href="{{url('offer')}}/{{$lsrow->offer_id}}">
												Buy </a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="dropdown float-right">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Show More...
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<a class="dropdown-item" href="#">Something else here</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="feature mt-5">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h3>Sell bitcoins with cash near, {{$live['city']}}, {{$live['state']}}, {{$live['country']}}</h3>
							<div class="table-responsive">
								<table class="table table-striped table-condensed table-bitcoins ">
									<tbody>
										<tr>
											<th>Seller</th>
											<th title="Distance">Distance</th>
											<th title="Location">Location</th>
											<th class="header-price" title="Current price of this ad">Price / BTC</th>
											<th class="header-limit" title="Trade amount in fiat currency">Limits</th>
											<th></th>
										</tr>
										@foreach($location_buy_offer as $lbrow)
										<tr class="clickable">
											<td class="column-user">
												<a href="#">{{$lbrow->user_name}}</a>
												<span title="" class="online-status online-status-online">
												<i class="fa fa-circle"></i>
												</span>
											</td>
											<td>99.3 miles</td>
											<td>
												{{$lbrow->location}}
											</td>
											<td class="column-price">
												1 {{ $lbrow->label }} = {{$lbrow->coinprice}} USD
											</td>
											<td class="column-limit">
												{{number_format($lbrow->min)}} - {{number_format($lbrow->max)}} {{ substr($lbrow->short,3) }}
											</td>
											<td class="column-button">
												<a class="browse-btn" href="{{url('offer')}}/{{$lbrow->offer_id}}">
												Sell</a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="dropdown float-right">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Show More...
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<a class="dropdown-item" href="#">Something else here</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section> -->

			<section id="as-seen-on-container">
				<div class="container">
					<hr id="as-seen-on-top">
					<div class="row" id="as-seen-on">
						<div class="col-md-12" id="as-seen-on-logo-container">
							<span id="as-seen-on-label">As seen on</span>
							<div id="as-seen-on-logos">
								<img alt="BusinessWeek" src="{{ url('/') }}/assets/image/businessweek.png">
								<img alt="Forbes" src="{{ url('/') }}/assets/image/forbes.png">
								<img alt="Financial Times" src="{{ url('/') }}/assets/image/financial-times.png">
							</div>
						</div>
					</div>				

				</div>
			</section>
			
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
		</main>
		<!-- Javascriprt -->
		<script src="{{ url('/') }}/assets/js/jquery.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="{{ url('/') }}/assets/js/popper.min.js"></script>
		<script src="{{ url('/') }}/assets/js/bootstrap-4.1.3.min.js"></script>
		<script src="{{ url('/') }}/assets/js/smooth-scroll.js"></script>
		<script src="{{ url('/') }}/assets/js/wow.min.js"></script>
		<script src="{{ url('/') }}/assets/js/custom.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<link rel="manifest" href="/manifest.json" />
		<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>


		<!-- <script>
			var OneSignal = window.OneSignal || [];
			OneSignal.push(function() {
			  OneSignal.init({
			    appId: "56e62dbe-0b92-45fd-adec-12f1b7e6b5af",
			  });
			});
		</script> -->




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
				// alert(text);
			var dummy = document.createElement("input");
			document.body.appendChild(dummy);
			dummy.setAttribute('value', text);
			dummy.select();
			document.execCommand("copy");
			document.body.removeChild(dummy);
			toastr.success("BTC Address copied !! ");
			
			}
			
			function eth_copy(text){
				// alert(text);
			var dummy = document.createElement("input");
			document.body.appendChild(dummy);
			dummy.setAttribute('value', text);
			dummy.select();
			document.execCommand("copy");
			document.body.removeChild(dummy);
			toastr.success("ETH Address copied !! ");
			
			}
			
			function ltc_copy(text){
				// alert(text);
			var dummy = document.createElement("input");
			document.body.appendChild(dummy);
			dummy.setAttribute('value', text);
			dummy.select();
			document.execCommand("copy");
			document.body.removeChild(dummy);
			toastr.success("LTC Address copied !! ");
			
			}
			
		</script>
		<script>
			$(document).ready(function(){
			
			
			
				$("#next1").click(function(){
			
					var coin = $('input[name="coins"]:checked').val();
			
					if(coin=="3"){
						var name = "BTC";
					} else if(coin=="4"){
						var name = "ETH";
					} else if(coin=="5"){
						var name = "LTC";
					}
			
					var offer = $('input[name="type"]:checked').val();
			
					if(offer=="14"){
						var ot = "Buy Offer";
					} else if(offer=="15"){
						var ot = "Sell Offer";
					}
			
					var price = $('input[name="price"]').val();
					var max_range = $('input[name="max_range"]').val();
					var min_range = $('input[name="min_range"]').val();
			
					if(offer==undefined || offer==""){
						toastr.error("Select offer type to create offer");
					} else if(coin==undefined || coin==""){
						toastr.error("Select any coin to create offer");
					} else if(price==undefined || price==""){
						toastr.error("please enter price to create offer");
					} else if(isNaN(price)) {
			        toastr.error("please enter only integer value for price");
			           return false;
			       } else if(max_range==undefined || max_range==""){
						toastr.error("please set maximum range to create offer");
					} else if(isNaN(max_range)) {
			        toastr.error("please enter only integer value for maximum range");
			           return false;
			       } else if(min_range==undefined || min_range==""){
						toastr.error("please set minimum range to create offer");
					} else if(isNaN(min_range)) {
			        toastr.error("please enter only integer value for minimum range");
			           return false;
			       } else if(max_range>price) {
			        toastr.error("maximum range can not be greater than price");
			           return false;
			       } else if(min_range>max_range) {
			        toastr.error("minimum range can not be greater than maximum range");
			           return false;
			       } else {
			
						var range = min_range+"-"+max_range;
			
						$('input[name="range"]').val(range);
						$("#dot").text(ot);
						$("#dcoin").text(name);
						$("#dprice").text(price);
						$("#dminr").text(min_range);
						$("#dmaxr").text(max_range);
			
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
			
			$("#next2").click(function(){
			
			var payment_method = $('select[name="payment_method"]').val();
					var payment_window = $('input[name="payment_window"]').val();
					var range = $('input[name="range"]').val();
					var remarks = $('textarea[name="remarks"]').val();
			
					if(payment_method=="10") {
						var pname = "Paypal";
					} else if(payment_method=="11") {
						var pname = "PayUmoney";
					} else if(payment_method=="12") {
						var pname = "UPI";
					} else if(payment_method=="12") {
						var pname = "PayTm";
					}
			
					if(payment_method==undefined || payment_method==""){
						toastr.error("Select any payment method to create offer");
					} else if(payment_window==undefined || payment_window==""){
						toastr.error("please set payment window to create offer");
					} else if(range==undefined || range==""){
						toastr.error("please set range to create offer");
					} else if(remarks==undefined || remarks==""){
						toastr.error("please enter remarks to create offer");
					} else if(isNaN(payment_window)) {
			        toastr.error("please enter only integer value for payment window");
			           return false;
			       } else {
		
						$("#dpm").text(pname);
						$("#dpw").text(payment_window + " Minutes ");
						$("#dr").text(remarks);
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
		
		<script>
			function makeListingRowsClickable() {
			       $("tr.clickable").click(function(e) {
			
			           // Only do the magic on left mouse button
			           if (e.which !== 1) {
			               return;
			           }
			
			           var href = $(this).find('.megabutton, .primary-link').attr("href");
			
			           if (href) {
			               window.location = href;
			           }
			       });
			   }
		</script>
	</body>
</html>