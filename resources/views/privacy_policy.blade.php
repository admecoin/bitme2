@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<h1>{{$title}}</h1>
							<hr>
							{!! $body !!}
						</div>
					</div>

				</div>
			</section>

			@include('footer')