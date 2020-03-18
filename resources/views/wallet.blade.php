@include('header')
<section class="mt-28">
	<div class="container">
		<div class="row">
			
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h1>wallet</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<ul class="nav nav-tabs" >

				  <li class="nav-item dropdown" style="margin-bottom:10px;">
				    <a class="nav-link dropdown-toggle btn active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Select Coin &nbsp;&nbsp;</a>
				    <div class="dropdown-menu">
				    	
				    	@foreach($coins as $c)
				    		<a class="dropdown-item " data-toggle="tab" href="#{{ strtolower($c->label) }}">{{ $c->name }} ( {{$c->label}} )</a>
						@endforeach
				    </div>
				  </li>
				</ul>
				<div class="tab-content">
				
				@foreach($wallet_history as $wh)
				  <div class="tab-pane container fade @if($wh['label']=='BTC') active show @endif" id="{{strtolower($wh['label'])}}">
			  		<div class="row" style="margin-top:10px;">
						<div class="col-sm-6 col-md-6 border-right">
							<div class="row">
								<div class="col-sm-6">
									<div>Total balance</div>
								</div>
								<div class="col-sm-6 text-right">
									<p class="mb-0"><b>
										{{ number_format($wh['total_balance'], 8, '.', '') }}
									<!-- {{  number_format($wh['balance'], 8, '.', '') +  number_format($wh['locked'], 8, '.', '') }} -->
									<!--{{ $wh['balance'] }} --> {{ $wh['label'] }}</b> <br/>($ {{ $wh['total_balance']*$wh['usd'] }})</p>
									@if(!empty($wh['balance_update']))
										<span><a href="{{ url('/') }}/{{ $wh['balance_update'] }}" ><i class="fa fa-refresh"></i> Update balance</a></span>
									@endif											
								</div>
								<div class="col-sm-12">
									<strong>*To recheck your balance please wait for 5 minutes for it to fetch from the Network.</strong>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-sm-6">
									<div>Available Balance:</div>
									<p class="mb-0"><b>{{ number_format($wh['avail_bal'], 8, '.', '') }} {{ $wh['label'] }}</b></p>
								</div>
								<div class="col-sm-6 text-right">
									<div>Locked Balance:</div>
									<p class="mb-0"><b>{{ number_format($wh['locked'], 8, '.', '') }} {{ $wh['label'] }}</b></p>
								</div>
							</div>
							<hr>
							
							<h3>Withdraw {{ $wh['name'] }} ({{ $wh['label'] }})</h3>
							<form data-form-validate='true' method="POST" action="{{ url('/')}}/withdrow" novalidate="novalidate">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="to">To address</label>
									<input type="text" data-rule-required="true" required data-msg-required="Please enter your Address." autocomplete="new-to" class="form-control" id="to_address" name="to" required>
									<input type="hidden" class="form-control" id="from_address" required name="from" value="{{ $wh['address'] }}">
								</div>
								<div class="form-group">
									<label for="amount">Amount ({{ $wh['label'] }})</label>
									<input type="hidden" class="form-control" id="coin_id" required name="coin_id" value="{{ $wh['coin_id'] }}">
									<input type="number" step="any" min='0.00' autocomplete="new-amount"  data-rule-required="true" required data-msg-required="Please enter your Amount."  class="form-control" id="amount" name="amount" required>
								</div>
								<div class="form-group">
									<input type="submit" id="withdrow-btn" class="browse-btn btn-block" name="submit" value="Withdraw">
								</div>
							</form>

						</div>
						<div class="col-sm-6 col-md-6">
							<div class="wallet-key">
								<div>
									<img src="{{ url('/') }}/assets/image/download.png" class="img" />
								</div>
								<div>
    								<div class="_1V29">
    									<p>
	    									<span>{{ $wh['address'] }} </span>
	    									<span >
	    										<a data-toggle="tooltip" title="Copy to Clipboard" class="white-tooltip" class="btn btn-secondary">
	    											<i class="fas fa-copy" onClick="btc_copy('{{ $wh['address'] }}')"></i>
	    										</a>
	    									</span>
    									</p>
    								</div>
								</div>

							</div>
							<div class="text-center">
								<img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{ $wh['address'] }}"/>
							</div>
						</div>
					</div>
				  </div>
					@endforeach
				</div>
			</div>
		</div>
		
	</div>
</section>
@include('footer')