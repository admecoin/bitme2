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
                                            <li class="breadcrumb-item active">All Users</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">CrypScrow Users</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Users</h4>
                                    <p class="sub-header mb-0">
                                        All users information here.
                                    </p>
                                    
                                    <table data-toggle="table"
                                           data-search="true"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" data-show-pagination-switch="true" class="table-bordered">
                                        <thead class="thead-light">
                                        <tr>
                                            <th data-field="srno" data-sortable="true" data-formatter># Sr. No.</th>
                                            <th data-field="username" data-sortable="true" data-formatter>Userame</th>
                                            <th data-field="email" data-sortable="true" data-formatter>Email</th>
                                            <th data-field="mobile" data-align="center" data-sortable="true" >Mobile</th>     
                                            <th data-field="address" data-align="center" data-sortable="true" >Address</th>
                                            <th data-field="pincode" data-align="center" data-sortable="true" >Pincode</th>
                                            <th data-field="login" data-align="center" data-sortable="true" >Last Login</th>
                                            <th data-field="logout" data-align="center" data-sortable="true" >Logout</th>
                                            <th data-field="ip_address" data-align="center" data-sortable="true" >IP Address</th>
                                            <th data-field="roel" data-align="center" data-sortable="true" >Role Type</th>
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
                                            <td>{{ $uinfo['street'] }},  {{ $uinfo['landmark'] }}, {{ $uinfo['city'] }} </td>
                                            <td>
                                                @if($uinfo['pincode'] != '')
                                                    {{ $uinfo['pincode'] }}
                                                @else
                                                    {{ '--' }}
                                                @endif
                                            </td>
                                            <td>{{ $uinfo['last_login'] }}</td>
                                            <td>{{$uinfo['logout']}}</td>
                                            <td>{{$uinfo['ip_address']}}</td>
                                            <td> 
                                                    @if($uinfo['user_type'] == 1)
                                                    <a href="{{ url('/') }}/admin/role-change/{{ $uinfo['user_id'] }}" class="btn btn-sm btn-primary" title="Click to Change Role"> ADMIN </a>
                                                    @elseif($uinfo['user_type'] == 2)
                                                    <a href="{{ url('/') }}/admin/role-change/{{ $uinfo['user_id'] }}" class="btn btn-sm btn-primary" title="Click to Change Role"> USER </a>    
                                                    @endif

                                            </td>
                                            <td>
												@if($uinfo['status'] == 0)
													<a href="{{ url('/') }}/admin/status-change/{{ $uinfo['user_id'] }}" title="Click to Verify"><div class="btn btn-sm btn-danger" > <i class="fe-user-x"></i> Unverified</div></a>
                                                @elseif($uinfo['status'] == 2)
                                                    <a href="{{ url('/') }}/admin/status-change/{{ $uinfo['user_id'] }}" title="Click to Active User"><div class="btn btn-sm btn-warning" > <i class="fe-user-x"></i>Inactive</div></a>
                                                @elseif($uinfo['status'] == 1)
                                                    <a href="{{ url('/') }}/admin/status-change/{{ $uinfo['user_id'] }}" title="Click to deactive User"><div class="btn btn-sm btn-success" >  <i class="fe-user-check"></i>Active</div></a>
                                                @endif

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
