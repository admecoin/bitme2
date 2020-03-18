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
                                            <li class="breadcrumb-item active">KYC List</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">KYC List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Document List</h4>
                                    <p class="sub-header mb-0">
                                        All document information here.
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
                                            <th data-field="username" data-sortable="true" data-formatter>Userame</th>
                                            <th data-field="email" data-sortable="true" data-formatter>Identity Proof</th>
                                            <th data-field="rprofof" data-sortable="true" data-formatter>Residential Proof</th>
                                            <th data-field="mobile" data-align="center" data-sortable="true" >Status</th>     
                                            <th data-field="address" data-align="center" data-sortable="true" >Created At</th>
                                            <th data-field="action" data-align="center" data-sortable="true" >Action</th>
                                            
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($user_info as $uinfo)
                                        
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $uinfo['user_name'] }}</td>
                                            <td><a target="_blank" href="{{url('/')}}/images/{{ $uinfo['Identity_proof'] }}"><img src="{{url('/')}}/images/{{ $uinfo['Identity_proof'] }}" width="70" height="70"></a></td>
                                            <td><a target="_blank" href="{{url('/')}}/images/{{ $uinfo['residential_proof'] }}"><img src="{{url('/')}}/images/{{ $uinfo['residential_proof'] }}" width="70" height="70"></a></td>
											<td>{{ $uinfo['status'] }}</td>
											<td>{{ $uinfo['created_at'] }}</td>
                                            <td>
												<select class="form-control"  onchange="location = this.value;">
													<option selected value="">-- Select Action --</option>
													<option value="{{ url('') }}/admin/actionkyc/{{$uinfo['id']}}/0">Pending</option>
													<option value="{{ url('') }}/admin/actionkyc/{{$uinfo['id']}}/1">Approve</option>
													<option value="{{ url('') }}/admin/actionkyc/{{$uinfo['id']}}/2">Reject</option>
													
												</select>	
											</td>
                                        </tr>
                                        <?php $i++; ?>
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
 