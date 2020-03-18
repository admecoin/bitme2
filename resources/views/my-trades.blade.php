@include('header')
			<section class="mt-28">
				<div class="container" id="scroll-container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h1>Active trades</h1>
							
							<div class="table-responsive">
								<table class="table">
									<tbody>
										@foreach($active_contract as $c)
											@if($c['co_status']=="16" || $c['co_status']=="17")
											<tr>
												<td><i class="fas fa-paper-plane"></i></td>
												<td>
												@if($c['to_user']==$c['sid'])
													<div><a href="#">{{ $c['user_name'] }}</a></div>
												@else
													<div><a href="#">{{ $c['to_usename'] }}</a></div>
												@endif
												</td>
												<td><div><a href="#">{{ $c['coin_name'] }}</a></div></td>
												<td>
													<div class="font-bold">{{ $c['mode'] }}</div>
													<div>{{ $c['heading'] }}</div>
												</td>
												<td>
													<div class="font-bold">{{ $c['city'] }}</div>
													<div>{{ $c['state'] }}</div>
												</td>
												<td>
													<div class="font-bold">Range</div>
													<div>{{ $c['min'] }} to {{ $c['max'] }}</div>
												</td>
												<td>
													@if($c['to_user']==$c['sid'])

														@if($c['co_status']=="16")
															<div>
																<a class="browse-btn" href="{{ url('/') }}/acceptoffer/{{ $c['id'] }}">Accept</a> &nbsp;&nbsp; 
																<a class="browse-btn" href="{{ url('/') }}/rejectoffer/{{ $c['id'] }}">Reject</a>
															</div>
														@elseif($c['co_status']=="17")
															<div>
																<a class="price browse-btn" href="{{ url('/') }}/trade/{{ $c['id'] }}">
																	Active Trade
																</a>
															</div>
														@endif
													
													@elseif($c['from_user']==$c['sid'])
														@if($c['co_status']=="16")
															<div>
																<span class="browse-btn">Pending</span>
															</div>
														@elseif($c['co_status']=="17")
															<div>
																<a class="price browse-btn" href="{{ url('/') }}/trade/{{ $c['id'] }}">
																	Active Trade
																</a>
															</div>
														@endif
													@endif
												</td>
											</tr>
											@endif
										@endforeach										
									</tbody>
								</table>
							</div>

							<a class="browse-btn" href="{{ url('/') }}/offers-buy">Find an offer</a>&nbsp;or &nbsp;
							<a class="browse-btn" href="{{ url('/') }}/offers">Create a new offer</a>
							
						</div>
					</div>
					<hr>
				</div>
			</section>
			<section class="sellers">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h1>Past trades</h1>
							<div class="table-responsive">
								<table class="table table-striped table-condensed table-bitcoins ">
									<tbody>

										@foreach($active_contract as $pc)
											@if($pc['co_status']=="18" || $pc['co_status']=="19")
											<tr>
												<td><i class="fas fa-bolt"></i></td>
												<td>
													<div><a href="{{ url('/') }}/trade/{{ $c['id'] }}">{{ $pc['user_name'] }}</a></div>
													
												</td>
												<td><div><a href="#">{{ $pc['coin_name'] }}</a></div></td>
												<td>
													<div class="font-bold">{{ $pc['mode'] }}</div>
													<div>{{ $pc['heading'] }}</div>
												</td>
												<td>
													<div class="font-bold">{{ $pc['city'] }}</div>
													<div>{{ $pc['state'] }}</div>
												</td>
												<td>
													<div class="font-bold">Range</div>
													<div>{{ $pc['min'] }} to {{ $pc['max'] }}</div>
												</td>
												<td>
													
													@if($pc['co_status']=="18")
														<div>
															<span class="browse-btn">Cancelled</span>
														</div>
													@elseif($pc['co_status']=="19")
														<div>
															<a href="{{ url('/') }}/trade/{{ $pc['id'] }}">
																<span class="browse-btn">Executed</span>
															</a>
														</div>
													@endif									
												</td>
											</tr>
											@endif
										@endforeach										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
				</div>
			</section>
		@include('footer')