@foreach($dispute_info as $disp)
<li class="clearfix @if(Session::get('user_id') == $disp->user_id) odd @endif">
    <div class="conversation-text">
        <div class="ctext-wrap">
            <i>
            @if($buyer_info->id == $disp->user_id)
               {{ $buyer_info->user_name }}
            @elseif($seller_info->id == $disp->user_id)
                {{ $seller_info->user_name }}
            @elseif(Session::get('user_id') == $disp->user_id)
                {{ Session::get('user_name') }}
            @endif</i>
            <p>{{$disp->message}}</p>
        </div>
    </div>
</li>
@endforeach