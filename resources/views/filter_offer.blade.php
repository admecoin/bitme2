			
				<div id="search_data" class="container" >
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h2>Search Result:</h2>
							<div class="table-responsive">
								<table class="table table-striped table-condensed table-bitcoins ">
									<tbody>
										<tr>
											<th>Seller</th>
											<th title="Payment method">Payment method</th>
											<th title="Payment method">Location</th>
											<th class="header-price" title="Current price of this ad">Price / BTC</th>
											<th class="header-limit" title="Trade amount in fiat currency">Limits</th>
											<th></th>
										</tr>

										@if(!empty($search_Data) || count($search_Data)>0)
											@foreach($search_Data as $of)												
													<tr class="clickable">
														<td class="column-user">
															<a href="#">{{ $of['user_name'] }}</a>
															<span title="" class="online-status online-status-online">
															<i class="fa fa-circle"></i>
															</span>
														</td>
														<td>
															{{ $of['mode'] }}
														</td>
														<td> {{ $of['location'] }} </td>
														<td class="column-price"> 
															1 {{ $of['coin_name'] }} = {{$of['coin_price']}} USD
														</td>
														<td class="column-limit">
															{{ number_format($of['min']) }} - {{ number_format($of['max']) }}
															{{ substr($of['currency'],3) }}
														</td>
														<td>
															<a class="browse-btn price" href="{{ url('/') }}/offer/{{ $of['offer_id'] }}"> 
																{{$of['type']}} Bitcoins
															</a>
														</td>
													</tr>
												
											@endforeach
										@else
											<tr>
												<td><i class="fas fa-bolt"></i></td>
												<td>No Result Found</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
							<!-- <a class="browse-btn" href="{{url('/all-buy-offers')}}"><span class="_2JVa"></span>Browse all sellers</a> -->
						</div>
					</div>
				</div>