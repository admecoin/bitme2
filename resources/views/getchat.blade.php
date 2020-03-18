@foreach($messages as $msg) 

	@if($msg->user_id==$from_user || $msg->user_id==$to_user && $id==$msg->contract_id)

		@if($msg->user_id==$uid)
			
				<p  style="padding:10px;">
					<span class="text-right"  style="float:right;width:90%;background-color: #d9d7ec;border-radius:10px 10px 10px 0px;margin-top:10px;padding: 8px;">
					@if($msg->text!="")
						{{ $msg->text }}
					@endif
					@if($msg->media!="")
						<br><a href="{{ url('/') }}/images/{{ $msg->media }}" target="_blank"><img src="{{ url('/') }}/images/{{ $msg->media }}" style="width:50px;height:50px;" > </a>
					@endif
					</span>
				</p>
			
		@else 
			
				<p  style="padding:10px;">
					<span class="text-left" style="float:left;width:90%;background-color: #ede0ac;border-radius:10px 10px 0px 10px;margin-top:10px;padding: 8px;">
					@if($msg->text!="")
						{{ $msg->text }}
					@endif
					@if($msg->media!="")
						<br><a href="{{ url('/') }}/images/{{ $msg->media }}" target="_blank"><img src="{{ url('/') }}/images/{{ $msg->media }}" style="width:50px;height:50px;" > </a>
					@endif
					</span>
				</p>

		@endif

	@endif

@endforeach