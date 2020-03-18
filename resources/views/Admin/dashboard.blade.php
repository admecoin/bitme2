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
                                    <h4 class="page-title">Dashboard </h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						<!--
                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="fe-grid font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $totalUser }}</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Users</p>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 

                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                                <i class="fe-briefcase font-22 avatar-title text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">200</span></h3>
                                                <p class="text-muted mb-1 text-truncate">School Admin</p>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 

                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                                <i class="fe-sidebar font-22 avatar-title text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">500</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Teacher</p>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 
							
							<div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                <i class="fe-sidebar font-22 avatar-title text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">2</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Admin</p>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 
                        </div> -->

                        <div class="row">
                           
                            <div class="col-xl-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Latest Users</h4>
                                    <hr>
                                    <div class="table-responsive">
                                        <table data-toggle="table"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" data-show-pagination-switch="false" class="table-bordered">
                                        <thead class="thead-light">
                                        <tr>
                                            <th data-field="srno" data-sortable="true" data-formatter># Sr. No.</th>
                                            <th data-field="username" data-sortable="true" data-formatter>Userame</th>
                                            <th data-field="email" data-sortable="true" data-formatter>Email</th>
                                            <th data-field="mobile" data-align="center" data-sortable="true" >Mobile</th>     
                                            <th data-field="address" data-align="center" data-sortable="true" >Address</th>
                                            <th data-field="pincode" data-align="center" data-sortable="true" >Pincode</th>
                                            <th data-field="status" data-align="center" data-sortable="true" data-formatter="statusFormatter">Status</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($user_info as $uinfo)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $uinfo['user_name'] }}</td>
                                            <td>{{ $uinfo['email'] }}</td>
                                            <td>
                                                @if($uinfo['mobile'] != '')
                                                    {{ $uinfo['mobile'] }}
                                                @else
                                                    {{ '--' }}
                                                @endif
                                            </td>
                                            <td>

                                                {{ $uinfo['street'] }},  {{ $uinfo['landmark'] }}, {{ $uinfo['city'] }}

                                            </td>
                                            <td>
                                                @if($uinfo['pincode'] != '')
                                                    {{ $uinfo['pincode'] }}
                                                @else
                                                    {{ '--' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($uinfo['status'] != 1)
                                                    <a href="{{ url('/') }}/admin/status-change/{{ $uinfo['user_id'] }}" title="Click to Active"><div class="btn btn-sm btn-warning" > <i class="fe-user-x"></i> Inactive</div></a>
                                                @else
                                                    <a href="{{ url('/') }}/admin/status-change/{{ $uinfo['user_id'] }}" title="Click to Inactive"><div class="btn btn-sm btn-success" >  <i class="fe-user-check"></i> Active</div></a>
                                                @endif

                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                2019 &copy; All rights reserved <a href="https://erience.co">Erience Solutions.</a> 
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