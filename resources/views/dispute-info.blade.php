@include('header')
<section class="mt-28">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="breadcrumbs">
					<a class="_2iET cW_J gray" href="{{ url('/') }}/my-trades">My Trades</a>
					<a class="_2iET cW_J gray" href="{{ url('/') }}/trade/{{$contract_id}}">Trade</a>
					<span><b>Dispute trade</b></span>
				</div>
			</div>
		</div>

		<hr>
		<div class="row">
			<div class="col-sm-6 col-md-6 border-right">
				<h2><i class="fas fa-comments"></i> Dispute chat</h2>
				
				<div class="_3Vfz khro" id="dispute_msg" style="height:400px;overflow-y:auto;padding: 8px 8px;">
					@foreach($messages as $msg)
						@if($msg->user_id==$from_user || $msg->user_id==$to_user)
							@if($msg->user_id==$uid)
								<p  style="padding:10px;">
									<span class="text-right"  style="float:right;width:90%;background-color: #d9d7ec;border-radius:10px 10px 10px 0px;margin-top:10px;padding: 8px;">
									@if($msg->message!="")
										{{ $msg->message }}<br>
									@endif
									@if($msg->file!="")
										<a href="{{ url('/') }}/images/{{ $msg->file }}" target="_blank">{{ url('/') }}/images/{{ $msg->file }}</a>
									@endif
									</span>
								</p>
							@else 
								<p  style="padding:10px;">
									<span class="text-left" style="float:left;width:90%;background-color: #ede0ac;border-radius:10px 10px 0px 10px;margin-top:10px;padding: 8px;">
									@if($msg->message!="")
										{{ $msg->message }}<br>
									@endif
									@if($msg->file!="")
										<a href="{{ url('/') }}/images/{{ $msg->file }}" target="_blank">{{ url('/') }}/images/{{ $msg->file }}</a>
									@endif
									</span>
								</p>
							@endif
						@else 
							<p  style="padding:10px;">
								<span class="text-left" style="float:left;width:90%;background-color: #ede0ac;border-radius:10px 10px 0px 10px;margin-top:10px;padding: 8px;">
								@if($msg->message!="")
									{{ $msg->message }}<br>
								@endif
								@if($msg->file!="")
									<a href="{{ url('/') }}/images/{{ $msg->file }}" target="_blank">{{ url('/') }}/images/{{ $msg->file }}</a>
								@endif
								</span>
							</p>
						@endif
					@endforeach
				</div>

				<form enctype="multipart/form-data" method="POST" id="dispute_chat" action='{{ url("/") }}/dispute-chat'>
					{{ csrf_field() }}
					<input type="hidden" name="dispute_id" value="{{ $dispute_info->id }}">
					<div class="row">
						<div class="col-sm-10">
							<textarea type="text" name="message" id="message" class="form-control" rows="4"></textarea>
						</div>
						<div class="col-sm-2">
							<input id="file-upload" type="file" name="image" style="display:none"/>
							<label  for="file-upload" class="browse-btn"><i class="fa fa-file"></i></label>
							<button type="submit" class="browse-btn" id="send_sms" style="margin-top:10px;"><i class="fas fa-paper-plane"></i></button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-sm-6 col-md-6">
				<div class="row">
					<div class="col-sm-12">
						<h2>{{ $dispute_info->title}}</h2>
						<div class="">
							<p>{{ $dispute_info->message}}</p>
						</div>
						@if($dispute_info->file !='') 
						<div class="disp_img mb-3" >
							<a href="{{ url('/') }}/images/{{$dispute_info->file}}" target="_blank" class="browse-btn"> <i class="fa fa-file"></i> View file </a>
						</div>
						@endif
						
					</div>
				</div>
				<div class="_3Vfz khro">
					<div class="_3JQV">
						<div class="_1PWp G7hA"></div>
				
						<div>
							@if($co_status == 17)
								<div class="_1pzq">Trade under dispute by {{ $dispute_by->user_name }}.</div>
								<p class="_30Dp">
									 Your wallet balance will reflect post decision of the admin. 
								</p>
							@elseif($co_status == 18)
								<div class="_1pzq">Trade Rejected</div>
								<p class="_30Dp">
									The trade has been Cancelled by admin and funds have been transferred to Seller
								</p>
							@elseif($co_status == 19)
								<div class="_1pzq">Trade Executed</div>
								<p class="_30Dp">
									 The trade has been successfully executed by admin. and funds have been transferred to Buyer.
								</p>
							@else 
								<div class="_1pzq">Waiting for the {{ $type2 }}.</div>
								<p class="_30Dp">
									Don't release the {{ $coin_name }} until you can confirm the amount credited in your account.
								</p>
							@endif
						</div>
							
					</div>
					@if($to_user == $ses_id)
					<div class="_2O8a">
						<div class="_3QVC _2iuH">Buyer pays seller directly</div>
						<div class="_3QVC @if($tr_status != NULL) _2iuH @endif ">CrypScrow released to buyer</div>
					</div>
					@else
						<div class="_2O8a">
							<div class="_3QVC _2iuH">Buyer pays the seller</div>
							<div class="_3QVC @if($tr_status != NULL) _2iuH @endif">Waiting for seller to confirm</div>
						</div>
					@endif
					
				</div>
				<hr>
				<div class="">
					<div class="_3nRb">
						<div> {{ $type }} <strong>{{ $crypto }} {{ $coin_name }}</strong> for <strong>{{ $currency }} {{ $fiat }}</strong></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var dispute_id = "{{ $dispute_info->id }}";
	var contract_id = "{{ $contract_id }}";
</script>
@include('footer')