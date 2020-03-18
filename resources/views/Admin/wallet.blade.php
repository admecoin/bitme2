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
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li> -->
                                <li class="breadcrumb-item active">Wallet</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Wallet</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title -->
            <div class="row">
	            <div class="col-xl-12">
	                <div class="card-box">
	                    <h4 class="header-title mb-4">Wallet</h4>

	                    <table data-toggle="table"
                               data-search="true"
                               data-sort-name="id"
                               data-page-list="[5, 10, 20]"
                               data-page-size="10"
                               data-pagination="true" data-show-pagination-switch="true" class="table-bordered">
                            <thead class="thead-light">
	                            <tr>
	                                <th data-field="srno" data-sortable="true" data-formatter>#SrNo.</th>
	                                <th data-field="coin" data-sortable="true" data-formatter>Coin</th>
	                                <th data-field="type" data-sortable="true" data-formatter>Type</th>
	                                <th data-field="Address" data-align="center" data-sortable="true" >Address</th>
	                                <th data-field="Lock" data-align="center" data-sortable="true" >Lock</th>
	                                <th data-field="Live" data-align="center" data-sortable="true" >Live</th>
	                                <th data-field="Withdrawed" data-align="center" data-sortable="true" >Withdrawed</th></th>
	                                <th data-field="Withdrawable" data-align="center" data-sortable="true" >Withdrawable</th></th>
	                                <th data-field="Update" data-align="center" data-sortable="true" >Update</th></th>
	                            </tr>
                            </thead>
                            <tbody>
                            	@if(count($wallet)>0)
                            	@foreach($wallet as $row)
                            	<tr>
                            		<td> {{ $i++ }} </td>
                            		<td> {{ $row['coin_label'] }} ( {{ $row['coin_name'] }} ) </td>
                            		<td> {{ $row['type'] }} </td>                            		
                            		<td> {{ $row['address'] }} </td>                            		
                            		<td> {{ $row['lock_balance'] }} </td>                            		
                            		<td> {{ $row['live_balance'] }} </td>                            		
                            		<td> {{ $row['withdraw_balance'] }} </td>                            		
                            		<td> {{ $row['avalable_balance'] }} </td>                            		
                            		<td> <a href="{{ url('/') }}{{ $row['update'] }}" class="btn btn-secondary  mt-3">
	                           				<i class="fe-refresh-cw"></i> Update
	                           			</a> 
	                           		</td>                            		
                            	</tr>
                            	@endforeach
                            	@endif
                            </tbody>
	                    
	                </div> <!-- end card-box-->
	            </div> <!-- end col -->
	        </div>
	        <!-- end row -->
        </div>
    </div>
</div>
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
