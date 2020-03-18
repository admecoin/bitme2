@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-2 col-md-2">
							{{ csrf_field() }}
							<div class="form-group">
								<select class="form-control" name="coin" id="coin">
									<option value="">Select Coin</option>
									@foreach($coins as $c)
									<option value="{{$c->id}}">{{$c->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<select class="form-control" name="offerType" id="offerType">
									<option value="">Select Offer</option>
									@foreach($offertype as $o)
									<option value="{{$o->id}}">{{substr($o->name,0,4)}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-3 col-md-3">
							<div class="form-group">
								<select class="form-control" id="pay_method" name="pay_method">
									<option value="">Any payment method</option>
									@foreach($payment_method as $p)
									<option value="{{$p->id}}">{{$p->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-3 col-md-3">
							<div class="form-group">
								<input type="search" id="address" name="location" class="form-control" placeholder="Choose City" />
							</div>
						</div>
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<button id="apply-filter" class="btn btn-sm browse-btn"> Apply Filter</button>
							</div>
						</div>
					</div>
					<hr>
				</div>
			</section>
			<section class="sellers">
				<div id="all_data" class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h2>Sell to these buyers:</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										@foreach($buy as $b)
											@if($b['result']=="OK")
												<tr>
													<td>
														@if($b['open'] != '' && $b['close'] != '')
															<i class="fa fa-paper-plane"></i>
														@endif
													</td>
													<td>
														<div><a href="#">{{ $b['user_name'] }}</a></div>
													</td>
													
													<td>
														<div><a href="#">{{ $b['coin'] }}</a></div>
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
														<div class="font-bold">Range</div>
														<div>{{ $b['min'] }} to {{ $b['max'] }}</div>
													</td>
													<td>
														<a class="price" href="{{ url('/') }}/offer/{{ $b['offer_id'] }}">
															<div class="font-10">Sell @</div>
															<div>{{ $b['currency'] }} {{ $b['max'] }}</div>
														</a>
													</td>
												</tr>
											@endif
										@endforeach										
									</tbody>
								</table>
							</div>
							<a class="browse-btn" href="{{url('/all-buy-offers')}}"><span class="_2JVa"></span>Browse all sellers</a>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h2>Buy from these sellers:</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										@foreach($sell as $s)
											@if($s['result']=="OK")
												<tr>
													<td>
														@if($s['open'] != '' && $s['close'] != '')
															<i class="fa fa-paper-plane"></i>
														@endif
													</td>
													<td>
														<div><a href="#">{{ $s['user_name'] }}</a></div>
													</td>
													
													<td>
														<div><a href="#">{{ $s['coin'] }}</a></div>
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
														<div class="font-bold">Range</div>
														<div>{{ $s['min'] }} to {{ $s['max'] }}</div>
													</td>
													<td>
														<a class="price" href="{{ url('/') }}/offer/{{ $s['offer_id'] }}">
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
							<a class="browse-btn" href="{{url('/all-sell-offers')}}"><span class="_2JVa"></span>Browse all buyers</a>
						</div>
					</div>
				</div>
			</section>
			
			@include('footer')