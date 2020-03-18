@include('Admin.header')
@include('Admin.sidebar')

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
             <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/contract-list">Contracts</a></li>
                                            <li class="breadcrumb-item active">Dispute contracts</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dispute Contract</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <div class="row">
                            <!-- CHAT -->
                            <div class="col-xl-4">
                                <div class="card-box">
                                    <h4 class="header-title ">Chat</h4>
                                    <div class="half-border"></div>
                                    <div class="chat-conversation">
                                        <ul class="conversation-list slimscroll" style="max-height: 350px;" id="chats">
                                            
                                        </ul>
                                        <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                                        <div class="row">
                                            <div class="col mb-2">
                                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                <input type="text" class="form-control chat-input" id="chat" placeholder="Enter your text">
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" id="chat-btn" class="btn btn-secondary btn-block waves-effect waves-light">Send</button>
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div> <!-- .chat-conversation -->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                            <div class="col-xl-8">
                                <div class="card-box">
                                	<h4 class="header-title text-dark">Dispute info</h4>
                                	<div class="half-border"></div>
                                    <div class="row">
                                    	<div class="col-md-12 col-sm-12">
	                                    	<h5>Title: {{$dispute->title}}</h5>                                    	
	                                    	<p class="font-14 text-left"><strong>Discription:</strong> {{$dispute->message}}</p>
	                                    	@if($dispute->file != '')
			                                <a href="{{url('/')}}/images/{{$dispute->file}}" class="btn btn-sm btn-secondary" target="_blank">
			                                <i class="fe-eye"></i> View file</a>
			                                @endif
		                            	</div>
                                    </div>
                                    <hr />
                                    <div class="row mt-3">
                                    	<div class="col-md-6 col-sm-6">
                                    		<h4 class="header-title text-dark">Contract info</h4>
	                                		<div class="half-border"></div>
	                                		<p class="font-14 text-left mb-0"><strong>Currency: </strong>{{substr($currency,3)}}</p>
	                                		<p class="font-14 text-left mb-0"><strong>Crypto value: </strong>{{ $contract->crypto_value}} {{ $coin_info->label }}</p>
	                                		<p class="font-14 text-left mb-0"><strong>Fees 1: </strong>{{ $contract->fees}} {{ $coin_info->label }}</p>
	                                		<p class="font-14 text-left mb-0"><strong>Fees 2: </strong>{{ $contract->fees2}} {{ $coin_info->label }}</p>
	                                		<p class="font-14 text-left mb-0"><strong>Created by: </strong>
	                                			@if($contract->from_user == $buyer_info->id)
		                                			{{$buyer_info->user_name}}
		                                		@else
		                                			{{$seller_info->user_name}}
		                                		@endif
	                                		</p>

                                    	</div>

                                    	<div class="col-md-6 col-sm-6">
                                    		<h4 class="header-title text-dark">Offer info</h4>
	                                		<div class="half-border"></div>
		                                	<p class="font-14 text-left mb-0">
		                                		<strong>Offer type: </strong> @if($offer->type_id == '14') Buy offer @else Sell offer @endif
		                                	</p>
		                                	<p class="font-14 text-left mb-0"><strong>Location: </strong> {{ $offer->location }}</p>
		                                	<p class="font-14 text-left mb-0"><strong>Coin: </strong> {{ $coin_info->name }} ({{ $coin_info->label }})</p>
		                                	<p class="font-14 text-left mb-0"><strong>Range: </strong> {{ $offer->min }} to {{ $offer->max }}</p>
		                                	<p class="font-14 text-left mb-0"><strong>Created by: </strong>
		                                		@if($offer->user_id == $buyer_info->id)
		                                			{{$buyer_info->user_name}}
		                                		@else
		                                			{{$seller_info->user_name}}
		                                		@endif
	                                		</p>
                                    	</div>
                                    </div>
                                   
                                    <hr />
                                    <div class="row mt-3">
                                    	<div class="col-md-12 col-sm-12">
                                            @if($contract->co_status == '17' || $contract->co_status == '16')
                                    		<h4 class="font-weight-normal text-dark">Approve/Reject contract</h4>
                                    		<form role="form" method="POST" action="{{route('contract-approve')}}" id="approval-form">
                                    			{{ csrf_field() }}
                                    			<div class="row">
                                    				<div class="col-md-8 col-sm-8">
                                    					<input type="hidden" name="contract_id" value="{{$contract->id}}">
                                    					<div class="form-group">
		                                    				<select  class="form-control" name="approval" id="appr">
		                                    					<option value="">-- Select any --</option>
		                                    					<option value="1"> Approve </option>
		                                    					<option value="2"> Reject </option>
		                                    				</select>
		                                    			</div>
                                    				</div>
                                    				<div class="col-md-4 col-sm-4">
                                    					<button type="submit" class="btn btn-secondary waves-effect waves-light">Submit</button>
                                    				</div>
                                    			</div>
                                    		</form>
                                            @elseif($contract->co_status == '18')
                                                <h4 class="font-weight-normal text-dark">Cancel trade</h4>
                                                <p class="font-14 text-left mb-0">This trade is cancelled. </p>
                                            @elseif($contract->co_status == '19')
                                                <h4 class="font-weight-normal text-dark">Execute trade</h4>
                                                <p class="font-14 text-left mb-0">This trade is executed. </p>
                                            @endif
                                    	</div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        	<div class="col-xl-6">
                                <div class="card-box">
                                	<h4 class="font-weight-normal text-dark">Buyer info</h4>
                                	<p class="font-14 text-left mb-0"><strong>Username: </strong> {{ $buyer_info->user_name }}</p>
                                	<p class="font-14 text-left mb-0"><strong>Email: </strong> {{ $buyer_info->email }}</p>
                                	<p class="font-14 text-left"><strong>Phone: </strong> {{ $buyer_info->mobile }}</p>
                                	<!-- <a href="javascript:void(0) {{$contract->id}}" class="btn btn-sm btn-secondary" >Send to buyer</a> -->
                            	</div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card-box">
                                	<h4 class="font-weight-normal text-dark">Seller info</h4>
                                	<p class="font-14 text-left mb-0"><strong>Username: </strong> {{ $seller_info->user_name }}</p>
                                	<p class="font-14 text-left mb-0"><strong>Email: </strong> {{ $seller_info->email }}</p>
                                	<p class="font-14 text-left"><strong>Phone: </strong> {{ $seller_info->mobile }}</p>
                                	<!-- <a href="javascript:void(0) {{$contract->id}}" class="btn btn-sm btn-secondary" >Send to seller</a> -->
                            	</div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div> <!-- container -->
                </div> <!-- content -->
                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                2019 &copy; CrypScrow All Right Reserved. 
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
<script type="text/javascript">
    var dispute_id = "{{$dispute->id}}";
    var contract_id = "{{$contract->id}}";
    var username = "{{ Session::get('user_name') }}";
</script>

@include('Admin.footer')

<style type="text/css">
.fixed-table-loading {
    display: none;
}
</style>
<!-- Bootstrap Tables js -->
<script src="{{url('/')}}/admin_assets/assets/libs/bootstrap-table/bootstrap-table.min.js"></script>

<!-- Init js -->
<script src="{{url('/')}}/admin_assets/assets/js/pages/bootstrap-tables.init.js"></script> 

