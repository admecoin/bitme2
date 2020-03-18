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
                                            <li class="breadcrumb-item active">Withdraw</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Withdraw</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Withdraw List</h4>
                                    <p class="sub-header mb-0">
                                        All Withdraw list below here.
                                    </p>

                                    <table data-toggle="table"
                                           data-search="true"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" data-show-pagination-switch="true" class="table-bordered">
                                        <thead class="thead-light">
	                                        <tr>
	                                            <th data-field="srno" data-sortable="true" data-formatter>#</th>
                                                <th data-field="Username" data-sortable="true" >Username</th>
                                                <th data-field="From" data-sortable="true" >From</th>
                                                <th data-field="To"  data-sortable="true" >To</th>
                                                <th data-field="Coin" data-sortable="true" >Coin</th>
                                                <th data-field="Amount" data-sortable="true" >Amount</th>
                                                <th data-field="Date" data-sortable="true" >Date</th>
	                                            <th data-field="Action" data-sortable="true" >Action</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                        	<?php $i=1; ?>

                                        	@foreach($request as $req)
                                        	<tr>
                                                <td> {{ $i++ }} </td>
                                                <td> {{ $req['user_name'] }} </td>
                                                <td> {{ $req['from'] }} </td>
                                                <td> {{ $req['to'] }} </td>
                                                <td> {{ $req['coin_label'] }}</td>
                                                <td> {{ $req['amount'] }} </td>
                                                <td>{{ date("M-d-Y",mktime(0,0,0,substr($req['date'],5,2),substr($req['date'],8,2),substr($req['date'],0,4))) }}
                                                </td>
												<td>
                                                    @if($req['status'] == '1')
                                                    <a href="{{ url('/') }}/admin/accept-withdraw/{{$req['withdraw_id']}}" class='btn btn-success btn-sm' title='Accept'>Accept</a>
                                                    @endif
                                                    @if($req['status'] == '4')
                                                    Accepted
                                                    @endif
                                                </td>
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
                                2019 &copy; CrypScrow All Right Reserved. <!-- <a href="#"></a>  -->
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div> -->
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