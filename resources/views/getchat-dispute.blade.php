@foreach($messages as $msg) 
	@if($msg->user_id==$from_user || $msg->user_id==$to_user)
		@if($msg->user_id==$uid)
			<p  style="padding:10px;">
				<span class="text-right"  style="float:right;background-color: #d9d7ec;border-radius:10px 10px 10px 0px;margin-top:10px;padding: 8px;">
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
				<span class="text-left" style="float:left;background-color: #ede0ac;border-radius:10px 10px 0px 10px;margin-top:10px;padding: 8px;">
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

			<span class="text-left" style="float:left;background-color: #ede0ac;border-radius:10px 10px 0px 10px;margin-top:10px;padding: 8px;">
				<span>Admin:</span>
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