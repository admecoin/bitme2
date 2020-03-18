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
                                            <li class="breadcrumb-item active">Contracts</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">CrypScrow Contract</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Contract List</h4>
                                    <p class="sub-header mb-0">
                                        All users contract list here.
                                    </p>

                                    <table data-toggle="table"
                                           data-search="true"
                                           data-show-refresh="true"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" data-show-pagination-switch="true" class="table-bordered">
                                        <thead class="thead-light">
	                                        <tr>
	                                            <th data-field="srno" data-sortable="true" data-formatter># Sr. No.</th>
	                                            <th data-field="Create" data-sortable="true" data-formatter>Create By</th>
	                                            <th data-field="Purchased" data-sortable="true" data-formatter>Purchased By</th>
	                                            <th data-field="offerType" data-sortable="true" data-formatter>Offer Type</th>
	                                            <th data-field="coin" data-align="center" data-sortable="true" >Coin</th>
	                                            <th data-field="Currency" data-align="center" data-sortable="true" >Currency & Rate</th>
	                                            <th data-field="cryptoValue" data-align="center" data-sortable="true" >Crypto Value</th>
	                                            <th data-field="fiatValue" data-align="center" data-sortable="true">Fiat Value</th>
	                                            <th data-field="fees1" data-align="center" data-sortable="true">Offer creation fees</th>
                                                <th data-field="fees2" data-align="center" data-sortable="true">Offer acceptance fees</th>
                                                <th data-field="dispute" data-align="center" data-sortable="true">Dispute</th>
												<th data-field="status" data-align="center" data-sortable="true">Status</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                        	<?php $i=1; ?>

                                        	@foreach($contractList as $cl)
                                        	<tr>
                                        		<td> {{ $i++ }} </td>
                                        		<td>{{ $cl['create_offer'] }}</td>
                                        		<td>{{ $cl['buy_offer'] }}</td>
                                        		<td>{{ $cl['offer_type'] }}</td>
                                        		<td>{{ $cl['coin_label'] }}</td>
                                        		<td>{{ $cl['currency'] }}</td>
                                        		<td>{{ $cl['crypto_value'] }}</td>
                                        		<td>{{ $cl['fiat_value'] }}</td>
                                        		<td>{{ $cl['fees1'] }}</td>
                                                <td>{{ $cl['fees2'] }}</td>
                                                <td>
                                                    @if($cl['despute'] == '1')
                                                    <a href="javascript:void(0);">NO</a>
                                                    @elseif($cl['despute'] == '2')
                                                    <a href="{{ route('dispute-info', ['contract_id' => $cl['contract_id']]) }}">YES</a>
                                                    @endif
                                                </td>
												<td>{{ $cl['contract_status'] }}</td>
                                        	</tr>
                                        	@endforeach
                                        </tbody>
									</table>
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
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
<script type="text/javascript">

    $(document).ready(function(){
        $('#data-id').on('click',function(){

        })
    });

</script>