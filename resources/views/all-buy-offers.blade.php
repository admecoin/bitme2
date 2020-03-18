@include('header')
			<section class="sellers mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h2>Sell to these buyers:</h2>
							<hr>
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
														<div><a href="#">{{ $b['coin_name'] }}</a></div>
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
														<a class="browse-btn price" href="{{ url('/') }}/offer/{{ $b['offer_id'] }}">
															Sell Bitcoins
														</a>
													</td>
												</tr>
											@endif
										@endforeach										
									</tbody>
								</table>
							</div>
							<!-- <a class="browse-btn" href="{{url('/all-buy-offers')}}"><span class="_2JVa"></span>Browse all sellers</a> -->
						</div>
					</div>
				</div>
			</section>
			
			@include('footer')