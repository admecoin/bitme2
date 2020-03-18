@include('header')
			<section class="mt-28">
				<div class="container">
					
					<div class="row">
					<iframe src="https://old.changelly.com/widget/v1?auth=email&#038;from=BTC&#038;to=ETH&#038;merchant_id=cd01fb6682fe&#038;address=&#038;amount=1&#038;ref_id=cd01fb6682fe&#038;color=4a4a4a" width="600" height="500" class="changelly" scrolling="no" style="overflow-y: hidden; border: none;margin:auto;" ></iframe>
					<!--	<div class="col-sm-8 col-md-8">
							<form method="post" action="{{ url('/') }}/createTransaction">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
											<label>From Coin</label>
											<select class="form-control" name="form_coin" id="form_coin">
												@foreach($coins as $c)
												<option value="{{ $c }}">{{ strtoupper($c) }}</option>	
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
											<label>To Coin</label>
											<select class="form-control" id="to_coin" name="to_coin">
												@foreach($coins as $c)
												<option value="{{ $c }}">{{ strtoupper($c) }}</option>	
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<div id="minAmount"></div>
										<input type="hidden" id="min_ammount" name="min_ammount" class="form-control" value="" placeholder="0.1234546">
										<br>
									</div>

									<div class="col-sm-5">
										<div class="form-group">
											<label>Exchange Coin</label>
											<input type="text" id="exc_ammount" name="exc_ammount" class="form-control" placeholder="0.1234546">
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
											<label>Recieve Coin </label>
											<input type="text" id="rec_ammount" name="rec_ammount" class="form-control" placeholder="0.1234546" readonly>
										</div>
									</div>
									
									<div class="col-sm-10">
										<div class="form-group">
											<label>User Address</label>
											<input type="text" id="user_address" name="user_address" class="form-control" placeholder="0x32Be343B94f860124dC4fEe278FDCBD38C102D88 ">
										</div>
									</div>
									<div class="col-sm-10">
										<div class="form-group">
											<label>Deposit Address</label>  <a data-toggle="tooltip" title="Copy to Clipboard below address" class="white-tooltip"><i class="fas fa-copy" onClick="depoAddress_copy()"></i></a>
											<input type="text" id="dep_address" name="dep_address" class="form-control" placeholder=" send money to this above address " readonly>
											
											<p>Please use your wallet or exchange to send money to the above address.</p>
										</div>
									</div>
								</div>
								<input type="submit" name="exc_submit" value="Submit" class="btn btn-sm browse-btn" >
							</form>
							<p>NOTE: You have 24 hours to send funds otherwise the transaction will be canceled automatically </p>
						</div>
					-->
					</div>
				</div>
			</section>
@include('footer')