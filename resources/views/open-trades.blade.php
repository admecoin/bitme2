@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="breadcrumbs">
								<a class="_2iET cW_J gray" href="{{ url('/') }}/my-trades">My Trades</a>
								<span>{{ $contract['type'] }} {{ $contract['cname'] }} {{ $contract['dir'] }} <b>{{ $contract['user_name'] }}</b></span>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 text-right">
							@if($contract['despute']=="1")
								@if($contract['co_status']=="16")
								<span class="browse-btn">Pending</span>
								@elseif($contract['co_status']=="17")
									<span class="browse-btn">Active</span>
								@elseif($contract['co_status']=="18")
								<span class="browse-btn">Cancelled</span>
								@elseif($contract['co_status']=="19")
								<span class="browse-btn">Executed</span>
								@endif
							@elseif($contract['despute']=="2")
								<a href="{{ url('/') }}/trade/dispute-info/{{$contract['id']}}" class="browse-btn">
									Disputed
								</a>
							@elseif($contract['despute']=="3")
								<span class="browse-btn">Executed</span>
							@endif
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-6 col-md-6 border-right">
							<h2><i class="fas fa-comments"></i> Chat With {{ $contract['user_name'] }}</h2>
							@if($contract['co_status']=="17")
							<div class="_3Vfz khro" id="msgs" style="height:400px;overflow-y:auto;padding: 8px 8px;">

								@foreach($contract['messages'] as $msg) 
									@if($msg->user_id==$contract['from_user'] || $msg->user_id==$contract['to_user'] && $contract['id']==$msg->contract_id)
										@if($msg->user_id==$contract['uid'])
												<p  style="padding:10px;">
													<span class="text-right"  style="float:right;width:90%;background-color: #ede0ac;border-radius:10px 10px 10px 0px;margin-top:10px;padding: 8px;">
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
								
							</div>
							@endif
							
							<form enctype="multipart/form-data" method="POST" id="form-edit-post" action='{{ url("/") }}/sendmessage'>
								@if($contract['co_status']=="17")
								{{ csrf_field() }}
								<input type="hidden" name="cid" value="{{$contract['id']}}">
								<div class="row">
									<div class="col-sm-10">
										<textarea type="text" name="message" id="message" class="form-control" rows="4"></textarea>
									</div>
									<div class="col-sm-2">
										<input id="file-upload" type="file" name="image" style="display:none"/>
										<label  for="file-upload" class="browse-btn"><i class="fa fa-file"></i></label>
										<button type="submit" class="browse-btn" id="sendmsg" style="margin-top:10px;"><i class="fas fa-paper-plane"></i></button>
									</div>
								</div>
								@endif
								<hr>
								<div class="_37la _3G74 _1kmU"><span>The key to this chat will be destroyed in <strong><span>7 days</span></strong>.</span></div>
								<div class="_3dFa">
									<div>Say hello and exchange payment details with the other user.</div>
									<small>Remember:</small>
									<ul>
										<li>Always use BitcoinNearMe. It's there for your safety.</li>
										<li>Open a payment dispute if you run into trouble.</li>
									</ul>
								</div>
							</form>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="_3Vfz khro">
								<div class="_3JQV">
									@if($contract['co_status'] != 19)
									<div class="_1PWp G7hA"></div>
									@else
									<div class="_1PWp G7hA2"></div>
									@endif

									@if($contract['scrp']=="1")
									<!-- Sell offer --> 
										@if($contract['to_user'] == $contract['ses_id'])
											<div>
												@if($contract['co_status'] != 19)
													@if($contract['tr_status'] == 2) 
														<div class="_1pzq">Please release {{ $contract['cname'] }}.</div>
													@else 
														<div class="_1pzq">Waiting for the {{ $contract['type2'] }}.</div>
													@endif
													<p class="_30Dp">
														Don't release the {{ $contract['cname'] }} until you can confirm the amount credited in your account.
													</p>
												@else
													<div class="_1pzq">Trade Executed.</div>
													<p class="_30Dp">
														Funds would be debited from your account and would be credited into <strong>{{ $contract['user_name'] }}</strong> account.
													</p>
												@endif
											</div>
										@else
											<div>

												@if($contract['co_status'] != 19)
													@if($contract['tr_status'] == 2)
														<div class="_1pzq">Waiting for the {{ $contract['type2'] }}.</div>
													@else
														<div class="_1pzq">Please complete the payment.</div>
													@endif
													<p class="_30Dp">
														Please pay the {{ $contract['type2'] }} the amount mentioned in the contract. Please verify the account number before transferring the amount.
													</p>
												@else
													<div class="_1pzq">Trade Executed.</div>
													<p class="_30Dp">
														Funds would shortly be credited into your account.
													</p>
												@endif
											</div>
										@endif
									@elseif($contract['scrp']=="2")
									<!-- Buy offer --> 
										@if($contract['to_user'] == $contract['ses_id'])
											<div>
												@if($contract['co_status'] != 19)
													@if($contract['tr_status'] == 2) 
														<div class="_1pzq">Waiting for the {{ $contract['type2'] }}.</div>
													@else 
														<div class="_1pzq">Please complete the payment.</div>						
													@endif
													<p class="_30Dp">														
														Please pay the seller the amount mentioned in the contract. Please verify the account number before transferring the amount.
													</p>
												@else
													<div class="_1pzq">Trade Executed.</div>
													<p class="_30Dp">
														Funds would shortly be credited into your account.
													</p>
												@endif
											</div>
										@else
											<div>
												@if($contract['co_status'] != 19)
													@if($contract['tr_status'] == 2)
														<div class="_1pzq">Please release {{ $contract['cname'] }}.</div>
													@else
														<div class="_1pzq">Waiting for the {{ $contract['type2'] }}.</div>
													@endif
													<p class="_30Dp">
														Don't release the {{ $contract['cname'] }} until you can confirm the amount credited in your account.
													</p>
												@else
													<div class="_1pzq">Trade Executed.</div>
													<p class="_30Dp">
														Funds would be debited from your account and would be credited into <strong>{{ $contract['user_name'] }}</strong> account.
													</p>
												@endif
											</div>
										@endif
									@endif
								</div>
								@if($contract['to_user'] == $contract['ses_id'])
								<div class="_2O8a">
									<div class="_3QVC _2iuH">Buyer pays seller directly</div>
									<div class="_3QVC @if($contract['tr_status'] != NULL) _2iuH @endif ">BitcoinNearMe released to buyer</div>
								</div>
								@else
									<div class="_2O8a">
										<div class="_3QVC _2iuH">Buyer pays the seller</div>
										<div class="_3QVC @if($contract['tr_status'] != NULL) _2iuH @endif">Waiting for seller to confirm</div>
									</div>
								@endif
								
							</div>
							<hr>
							<div class="">
								<div class="_3nRb">
									<div> {{ $contract['type'] }} <strong>{{ $contract['crypto'] }} {{ $contract['cname'] }}</strong> for <strong>{{ $contract['currency'] }} {{ $contract['fiat'] }}</strong></div>
								</div>
							</div>
							<hr />
							<!--Despute Condition-->
							@if(isset($contract['despute']) && $contract['despute'] == '1')
								@if($contract['scrp']=="1")
								<!-- Sell offer --> 
									@if($contract['from_user'] == $contract['ses_id'])
									<!-- Buyer Show buttons -->
										<div>
											<div class="_3nRb">
											@if($contract['tr_status'] == NULL) 
												<a href="{{ url('/') }}/paymentdone/{{ $contract['id'] }}" class="browse-btn"><span class="_2JVa"></span>Payment Done</a>
											@endif
											@if($contract['co_status'] != 19 && $contract['co_status'] != 18)
												<a class="browse-btn" data-toggle="modal" data-target="#dispute"><span class="_2JVa"></span>Dispute trade</a>
											@endif
												<a class="browse-btn" data-toggle="modal" data-target="#report"><span class="_2JVa"></span>Report {{ $contract['user_name'] }}</a>
											</div>
										</div>
									@elseif($contract['to_user'] == $contract['ses_id'])
									<!-- Seller Show buttons -->
										<div>
											<div class="_3nRb">
												@if($contract['tr_status'] == 2)
													<a href="{{ url('/') }}/release-crypto/{{ $contract['id'] }}/1" class="browse-btn"><span class="_2JVa"></span>Release Crypto</a>
												@endif
												@if($contract['co_status'] != 19 && $contract['co_status'] != 18)
													<a class="browse-btn" data-toggle="modal" data-target="#dispute"><span class="_2JVa"></span>Dispute trade</a>
												@endif
													<a class="browse-btn" data-toggle="modal" data-target="#report"><span class="_2JVa"></span>Report {{ $contract['user_name'] }}</a>
											</div>
										</div>
									@endif
								@elseif($contract['scrp']=="2")
								<!-- Buy offer -->
									@if($contract['to_user'] == $contract['ses_id'])
									<!-- Buyer Show buttons -->
										<div>
											<div class="_3nRb">
											@if($contract['tr_status'] == NULL) 
												<a href="{{ url('/') }}/paymentdone/{{ $contract['id'] }}" class="browse-btn"><span class="_2JVa"></span>Payment Done</a>
											@endif
											@if($contract['co_status'] != 19 && $contract['co_status'] != 18)
												<a class="browse-btn" data-toggle="modal" data-target="#dispute"><span class="_2JVa"></span>Dispute trade</a>
											@endif
												<a class="browse-btn" data-toggle="modal" data-target="#report"><span class="_2JVa"></span>Report {{ $contract['user_name'] }}</a>
											</div>
										</div>
									@elseif($contract['from_user'] == $contract['ses_id'])
									<!-- Seller Show buttons -->
										<div>
											<div class="_3nRb">
												@if($contract['tr_status'] == 2)
													<a href="{{ url('/') }}/release-crypto/{{ $contract['id'] }}/2" class="browse-btn"><span class="_2JVa"></span>Release Crypto</a>
												@endif

												@if($contract['co_status'] != 19 && $contract['co_status'] != 18)
													<a class="browse-btn" data-toggle="modal" data-target="#dispute"><span class="_2JVa"></span>Dispute trade</a>
												@endif
													<a class="browse-btn" data-toggle="modal" data-target="#report"><span class="_2JVa"></span>Report {{ $contract['user_name'] }}</a>
											</div>
										</div>
									@endif
								@endif
							@endif
							<!--End Despute Condition-->
							<hr>
							<div class="_3Uan">
								<div>
									<h2>{{ $contract['type2'] }}</h2>
									<div class="_2eUT"><a class="_2iET WWog" href="#" lang="en">{{ $contract['user_name'] }}</a></div>
								</div>
								<div>
									<h2>Offer</h2>
									<div class="_3MtX">
									     {{ $contract['mod'] }} 
									</div>
									<p class="_2uYC">
									    <span>{{ $contract['des'] }}<br></span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!--Report modal start-->
            <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to report this {{ $contract['user_name'] }}?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>If you believe this user should be suspended, you can report them. This will automatically volunteer a copy of the conversation for BitcoinNearMe to review.</p>

                    @if($contract['ses_id'] == $contract['to_user'])
                    	<?php  $report_to = $contract['from_user']; ?>
                    @else
                    	<?php  $report_to = $contract['to_user']; ?>
                    @endif

                    <form enctype="multipart/form-data" method="POST" id="report-user" action='{{ url("/") }}/report-user'>
					{{ csrf_field() }}
						<!-- <input type="hidden" name="contract_id" value="{{$contract['id']}}"> -->

						<input type="hidden" name="report_to" value="{{ $report_to }}">
						<!-- <div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<input type="text" name="title" id="title" class="form-control" placeholder="Enter title" />
								</div>
								<div class="form-group">
									<textarea type="text" name="comment" id="message" class="form-control" rows="3" placeholder="Comment"></textarea>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<input id="file-upload" type="file" name="image" class="form-control"/>
								</div>
							</div>
						</div> -->
	                    <div class="_3fLD">
	                        <div>
	                            <button type="submit" class="action-button btn-font-size">Yes, report <span>{{ $contract['user_name'] }}</span></button>
	                        </div>
	                        <div>
	                            <button class="button-cta btn-font-size" data-dismiss="modal">No, don't report</button>
	                        </div>
	                    </div>
	                </form>
                  </div>
                </div>
              </div>
            </div>
			<!--End report modal-->

			<!--Dispute modal start-->
            <div class="modal fade" id="dispute" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dispute Trade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                   	<form enctype="multipart/form-data" method="POST" id="form-edit-post" action='{{ url("/") }}/trade/dispute'>
					{{ csrf_field() }}

						<input type="hidden" name="contract_id" value="{{$contract['id']}}">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<input type="text" name="title" id="title" class="form-control" placeholder="Enter title" />
								</div>
								<div class="form-group">
									<textarea type="text" name="comment" id="message" class="form-control" rows="3" placeholder="Comment"></textarea>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<input id="file-upload" type="file" name="image" class="form-control"/>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<button type="submit" class="browse-btn" id="sent_dispute" style="margin-top:10px;">Submit</button> 
								</div>
							</div>
						</div>
					</form>
                  </div>
                </div>
              </div>
            </div>
			<!--End Dispute modal-->

		@include('footer')