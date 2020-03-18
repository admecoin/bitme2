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
                                            <li class="breadcrumb-item active">User Log</li>
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
                                    <h4 class="header-title">User Logs List</h4>
                                    <p class="sub-header mb-0">
                                        All users User Logs list here.
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
	                                            <th data-field="Session" data-sortable="true" data-formatter>Session Code</th>
	                                            <th data-field="OS" data-sortable="true" data-formatter>OS</th>
	                                            <th data-field="Browser" data-align="center" data-sortable="true" >Browser</th>
	                                            <th data-field="InTime" data-align="center" data-sortable="true" >In Time</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                        	<?php $i=1; ?>

                                        	@foreach($userlog_history as $ulh)
                                        	<tr>
                                        		<td> {{ $i++ }} </td>
                                        		<td>{{ $ulh['username'] }}</td>
                                        		<td>{{ $ulh['session_code'] }}</td>
                                        		<td>{{ $ulh['os'] }}</td>
                                        		<td>{{ $ulh['user_agent'] }}</td>
                                        		<td>{{ $ulh['in_time'] }}</td>
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