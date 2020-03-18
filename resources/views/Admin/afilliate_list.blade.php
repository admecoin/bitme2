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
                                            <li class="breadcrumb-item active">Afilliate List</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">CrypScrow Afilliate List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Afilliate List</h4>
                                    <p class="sub-header mb-0">
                                        Afilliate List.
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
	                                            <th data-field="Username" data-sortable="true" data-formatter>Username</th>
	                                            <th data-field="Referral" data-sortable="true" data-formatter>Referral By</th>
	                                            <th data-field="transaction" data-sortable="true" data-formatter>Transaction Date</th>
                                                <th data-field="Claim" data-sortable="true" data-sortable="true" >Claim</th>
												<th data-field="Value" data-sortable="true" data-sortable="true" >Value</th>
                                                <th data-field="Payment" data-sortable="true" data-sortable="true" >Payment</th>
	                                            <th data-field="Hash" data-sortable="true" data-sortable="true" >Hash</th>
                                                <th data-field="Action" data-align="center" data-sortable="true" data-sortable="true" >Action</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                           <?php $i=1; ?>
                                            @foreach($affiliate as $af)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$af['username']}}</td>
                                                <td>{{$af['ref_username']}}</td>
                                                <td>{{$af['transaction']}}</td>
                                                <td>
													@if($af['claim'] == 1)
														<button type='button' class="btn btn-success btn-xs waves-effect waves-light">
															<i class="fe-check"></i>
														</button>
													@else
														<button type='button' class="btn btn-danger btn-xs waves-effect waves-light">
															<i class="fe-x"></i>
														</button>
													@endif
												</td>
												<td>{{$af['value']}}</td>
                                                <td>

                                                    @if($af['payment'] == 1)
                                                    <span class="badge bg-soft-success text-success"><i class="fe-check"></i> Done</span>
                                                    @else
                                                    <span class="badge bg-soft-danger text-danger"><i class="fe-x"></i>Pending</span>
                                                    @endif

                                                </td>
                                                <td>{{$af['hash']}}</td>
                                                <td>
                                                    @if($af['payment'] != 1)
                                                    <a href="{{url('/')}}/admin/approve-affiliate/{{$af['id']}}" class="btn btn-success btn-xs waves-effect waves-light" title="Click to Approve" onclick="return confirm('Are you sure? Approve this claim !');">
                                                        <i class="fe-check"></i> Approve
                                                    </a>
                                                    @else 
                                                        Approved
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