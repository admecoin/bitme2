@include('header')
<section class="sellers mt-28">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2>Dispute trades:</h2>
				<hr>
				<div class="table-responsive">
					<table class="table">
						<tbody>
							@foreach($dispute as $d)
								<tr>
									<td>
										<div class="font-bold"><i class="fa fa-paper-plane" style="width: 25px;height: 25px;"></i> {{ $d->title }}</div>
									</td>
									<td>
										<div class="font-bold">Dispute By</div>
										<div>{{ $d->user_name }}</div>
									</td>
									<td>
										<div class="font-bold">Dispute date</div>
										<div>{{ date('d M, Y', strtotime($d->created_date)) }}</div>
									</td>
									<td>
										<a class="price" href="{{ url('/') }}/trade/dispute-info/{{ $d->id }}">
											<div class="font-bold"> <i class="fa fa-question-circle"></i> More </div>
										</a>
									</td>
								</tr>
							@endforeach										
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@include('footer')