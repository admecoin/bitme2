@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<label for="want">I want to...</label>
								<select class="form-control" id="want">
									<option>Buy or sell ETH</option>
									<option>Sell ETH</option>
									<option>Buy ETH</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4 col-md-4">
							<div class="form-group">
								<label for="pay">Payment method</label>
								<select class="form-control" id="pay">
									<option>Any payment method</option>
									<option>International wire</option>
									<option>Alipay</option>
									<option>Other</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4 col-md-4">
							<div class="form-group">
								<label for="location">Location</label>
								<select class="form-control" id="location">
									<option>India</option>
									<option>USA</option>
									<option>UAE</option>
									<option>Other</option>
								</select>
							</div>
						</div>
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<label for="sort">Sort by</label>
								<select class="form-control" id="sort">
									<option>Price</option>
									<option>Popularity</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
				</div>
			</section>
			<section class="sellers">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h2>Buy ETH from these sellers:</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										@foreach($buy as $b)
											@if($b['result']=="OK")
												<tr>
													<td><i class="fas fa-bolt"></i></td>
													<td>
														<div><a href="#">{{ $b['user_name'] }}</a></div>
														<div>1940+ trades</div>
													</td>
													<td>
														<div class="font-bold">{{ $b['mode'] }}</div>
														<div>{{ $b['heading'] }}</div>
													</td>
													<td>
														<div class="font-bold">{{ $b['city'] }}</div>
														<div>{{ $b['state'] }}</div>
													</td>
													<td>
														<div>{{ $b['min'] }} to {{ $b['max'] }}</div>
													</td>
													<td>
														<a class="price" href="{{ url('/') }}/offer/{{ $b['offer_id'] }}">
															<div class="font-10">Buy @</div>
															<div>{{ $b['currency'] }} {{ $b['max'] }}</div>
														</a>
													</td>
												</tr>
											@endif
										@endforeach										
									</tbody>
								</table>
							</div>
							<a class="browse-btn" href="#"><span class="_2JVa"></span>Browse all sellers</a>
						</div>
					</div>
					<hr>
					<div class="col-sm-12 col-md-12">
							<h2>Sell ETH to these buyers:</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										@foreach($sell as $s)
											@if($s['result']=="OK")
												<tr>
													<td><i class="fas fa-bolt"></i></td>
													<td>
														<div><a href="#">{{ $s['user_name'] }}</a></div>
														<div>1940+ trades</div>
													</td>
													<td>
														<div class="font-bold">{{ $s['mode'] }}</div>
														<div>{{ $s['heading'] }}</div>
													</td>
													<td>
														<div class="font-bold">{{ $s['city'] }}</div>
														<div>{{ $s['state'] }}</div>
													</td>
													<td>
														<div>{{ $s['min'] }} to {{ $s['max'] }}</div>
													</td>
													<td>
														<a class="price" href="{{ url('/') }}/offer/{{ $b['offer_id'] }}">
															<div class="font-10">Buy @</div>
															<div>{{ $s['currency'] }} {{ $s['max'] }}</div>
														</a>
													</td>
												</tr>
											@endif
										@endforeach	
									</tbody>
								</table>
							</div>
							<a class="browse-btn" href="#"><span class="_2JVa"></span>Browse all buyers</a>
						</div>
				</div>
			</section>
			
			@include('footer')