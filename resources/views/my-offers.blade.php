@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h1>My Offers</h1>
						</div>
						
						<div class="col-sm-12 col-md-12">
							<p>
								<span>Creating an offer will allow you to set your own rate and terms, and enjoy a 0.25% fee. People that <em>respond</em> to offers pay a 0.75% fee.</span>
								<strong> You don’t have any offers yet.</strong>
							</p>
						</div>
					</div>
					<div class="row" style="margin-top:20px;">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Offer Type</th>
											<th>Coin Type</th>
											<th>Fiat Type</th>
											<th>Range</th>
											<th>Payment Method</th>											
											<th>Remarks</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($offers as $offer)
											<tr>
												<td>{{ $offer['type'] }}</td>
												<td>{{ $offer['coin'] }}</td>
												<td>{{ $offer['currency'] }}</td>
												<td>{{ $offer['min'] }} - {{ $offer['max'] }}</td>
												<td>{{ $offer['mode'] }}</td>
												<td>{{ $offer['offer'] }}</td>
												<td>
													<a href="{{url('/')}}/edit-offer/{{$offer['offer_id']}}" title="Click to edit"><i class="fa fa-edit"></i></a> &nbsp;
													<a href="{{url('/')}}/delet-offer/{{$offer['offer_id']}}" title="Click to delete"><i class="fa fa-trash"></i></a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table> 
							</div>
						</div>
					</div> 
					<div class="row">
						<div class="col-sm-6">
							<a class="browse-btn btn-block" href="offers">Create a new offer</a>
						</div>
					</div>
				</div>

			</section>

			
			@include('footer')