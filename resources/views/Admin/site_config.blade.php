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
                                            <li class="breadcrumb-item active">Site Config</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">CrypScrow Site Config</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Site Config</h4>
                                    <p class="sub-header mb-0">
                                        Site Config.
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
	                                            <th data-field="label" data-sortable="true" data-formatter>label</th>
	                                            <th data-field="value" data-sortable="true" data-formatter>value</th>
	                                            <th data-field="remarks" data-sortable="true" data-formatter>remarks</th>
                                                <th data-field="Action" data-align="center" data-sortable="true" >Action</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                           <?php $i=1; ?>
                                            @foreach($site_config as $sc)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$sc->label}}</td>
                                                <td>{{$sc->value}}</td>
                                                <td>{{$sc->remarks}}</td>
                                                <td>
													<?php if($sc->id!="7") { ?>
														<a href="{{url('/')}}/admin/edit-siteconfig/{{$sc->id}}" class="btn btn-warning btn-xs waves-effect waves-light" title="Click to edit">
															<i class="fe-edit"></i>
														</a>
													<?php } else { ?>
															<?php if($sc->status=="1") { ?>
                                                                <!-- Active KYC -->
                                                                <a href="{{ url('/') }}/admin/kycoption/7/2" class="btn btn-success" title="Click to deactive KYC option"><i class="fe-check-circle"></i> ON</a>
															<?php } else {  ?>
                                                                <!-- Deactive KYC -->
                                                                <a href="{{ url('/') }}/admin/kycoption/7/1" class="btn btn-danger" title="Click to active KYC option"><i class="fe-power"></i> OFF</a>
															<?php } ?>
													<?php } ?>
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