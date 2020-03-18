@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="breadcrumbs">
							    <a class="_2iET cW_J gray" href="{{ url('/') }}/offers">Offers</a>
							    <span>{{ $offer['type_name'] }} {{ $offer['coin'] }} from <b>{{ $offer['user_name'] }}</b> via {{ $offer['mode'] }}</span>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-6 col-md-6 border-right">
							<h3>Trade amount</h3>
							<p>Limits: {{ $offer['currency'] }} {{ $offer['min'] }} - {{ $offer['currency'] }} {{ $offer['max'] }}</p>
							<form method="post" action="{{ url('/') }}/createcontract">
								{{ csrf_field() }}
								<input type="hidden" id="cur" name='cur' value="{{ $offer['currency'] }}">
								<input type="hidden" id="cry" name='cry' value="{{ $offer['cname'] }}">
								<input type="hidden" id="min_val" name='min' value="{{ $offer['min'] }}">
								<input type="hidden" id="max_val" name='max' value="{{ $offer['max'] }}">	
								
								<div class="input-group mb-3">
                                    <input type="text" class="form-control" autocomplete="new-currency" aria-label="{{ $offer['currency'] }}" name="currency" aria-describedby="basic-addon1" id="currency">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon1">{{ $offer['currency'] }}</span>
                                    </div>
                                </div>
                                <span id="min_error" style="color:red;display:none;">you can to {{ $offer['type_name'] }} less than minimum limit of trade</span>
                                <span id="max_error" style="color:red;display:none;">you can to {{ $offer['type_name'] }} less than maximum limit of trade</span>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" autocomplete="new-crypto" aria-label="{{ $offer['cname'] }}" name="crypto" aria-describedby="basic-addon2" id="crypto" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{ $offer['cname'] }}</span>
                                    </div>
                                </div>
								<div class="form-group">
									<button type="submit" id="trbtn" class="browse-btn">Open Trade</button>
								</div>
							</form>
							<p>You'll be able to discuss the payment details with the seller using end-to-end encryption.</p>
							<hr>
							<h2><i class="fa fa-lock"></i>&nbsp;Encrypted chat</h2>
							<p>Once you open a trade, messages are end-to-end encrypted so your privacy is protected. The only case where we can read your messages is if either party initiates a dispute.</p>
						</div>
						<div class="col-sm-6 col-md-6">
						    <div class="text-center">
						        <h2>You are the {{ $offer['trader'] }}.</h2>
						    </div>
							<hr>
							<div class="text-center">
							    <p>1 {{ $offer['cname'] }} = <strong>{{ $offer['currency'] }} <span >{{ $offer['main_total'] }}</span></strong></p>
							    <input type="hidden" name="coinPrc" autocomplete="new-coinPrc" id="coinPrc" value="{{ $offer['main_total'] }}">
							    <p>The {{ $offer['trader1'] }} chose this price — only continue if you’re comfortable with it. This rate includes crypscrow	's 0.75% fee.</p>
							</div>
							<hr>
							<div>
							    <h2>Terms of trade with {{ $offer['user_name'] }}</h2>
							    <p class="_6Am7">{{ $offer['description'] }}</p>
							</div>
							<hr>
							<div class="_2iIj">
							    <table>
									<tbody>
										<tr>
											<th>Username</th>
											<td><span><a class="_2iET WWog" href="{{ url('/') }}/#" lang="en">{{ $offer['user_name'] }}</a></span></td>
										</tr>
										<tr>
											<th>Registered</th>
											<td>{{ $offer['registered'] }}</td>
										</tr>
										<tr>
											<th>Trades</th>
											<td>{{ $offer['success_trade'] }}</td>
										</tr>
										<!--<tr>
											<th>Volume</th>
											<td>~150 ETH</td>
										</tr> -->
										<tr>
											<th>Good feedback</th>
											<td>{{ round($offer['good_feedback'],2) }}%</td> 
										</tr>
										<tr>
											<th>Email verified</th>
											<td>Yes</td>
										</tr>
										<tr>
											<th>Phone verified</th>
											<td>Yes</td>
										</tr>
									</tbody>
								</table>
							</div>
							<hr>
							<div class="">
								<h2>Rating and Reviews</h2>
								<section class='rating-widget'>
								  <!-- Rating Stars Box -->
								  <div class='rating-stars'>
									<ul id='stars'>
									  <li class='star' title='Poor' data-value='1'>
										<i class='fa fa-star fa-fw'></i>
									  </li>
									  <li class='star' title='Fair' data-value='2'>
										<i class='fa fa-star fa-fw'></i>
									  </li>
									  <li class='star' title='Good' data-value='3'>
										<i class='fa fa-star fa-fw'></i>
									  </li>
									  <li class='star' title='Excellent' data-value='4'>
										<i class='fa fa-star fa-fw'></i>
									  </li>
									  <li class='star' title='WOW!!!' data-value='5'>
										<i class='fa fa-star fa-fw'></i>
									  </li>
									</ul>
								  </div>
								  <div id='reviews'>
									<p class="_6Am7"> Reviews </p>
									<textarea id='review' name='review' class='form-control' placeholder='Your feedback about offers'></textarea>
								  </div>
								  <div id='rate-btn'>
									<br> 
									<button id="btn-review" class="btn btn-sm browse-btn"> submit</button>
										<div class='success-box'>
											<div class='clearfix'></div>
											<!-- <img alt='tick image' width='15' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/> -->
											<div class='text-message'></div>
											<div class='clearfix'></div>									
										  </div>
								  </div>
								  <input type='hidden' name='offer_id' id='offer_id' value="{{$offer['offer_id']}}">
								  <hr />
								@foreach($rating as $rt)
									<div class="">									
										<p><span><strong>{{$rt['username']}}</strong></span> 
										<span class="float-right"><strong>Rate: 
											@for($i=1; $i<= $rt['rating']; $i++) 
											<i class='fa fa-star fa-fw' style="color: #ff912c;"></i>
											@endfor
										</strong></span></p>
										<p>Reviews: {{$rt['review']}}</p>
									</div>
								@endforeach
								</section>
							</div>						
						</div>
					</div>
				</div>
			</section>
			@include('footer')