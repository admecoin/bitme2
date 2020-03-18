@include('header')
			<section class="sellers mt-28"">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h2>Buy from these sellers:</h2>
							<hr>
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
														<div><a href="#">{{ $s['coin_name'] }}</a></div>
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
														<a class="browse-btn price" href="{{ url('/') }}/offer/{{ $s['offer_id'] }}"> Buy Bitcoins
														</a>
													</td>
												</tr>
											@endif
										@endforeach	
									</tbody>
								</table>
							</div>
							<!-- <a class="browse-btn" href="{{url('/all-sell-offers')}}"><span class="_2JVa"></span>Browse all buyers</a> -->
						</div>
					</div>
				</div>
			</section>
			
			@include('footer')