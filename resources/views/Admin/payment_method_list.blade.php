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
                                            <li class="breadcrumb-item active">Payment Method</li>
                                        </ol>
                                    </div>

                                    <h4 class="page-title">Payment Method</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <div class="row mb-3">
                                      <div class="col-6">
                                        <h4 class="header-title">Payment Method List</h4>
                                      </div>
                                      <div class="col-6 text-right">
                                        <a href="{{url('admin/add-payment')}}" class="btn btn-primary btn-sm"><i class="fe-plus-square"></i> Add new</a> 
                                      </div>
                                    </div>

                                    
                                    
                                     <table data-toggle="table"
                                           data-search="true"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" class="table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th data-field="srno" data-sortable="true"># Sr. No.</th>
                                                <th data-field="name" data-sortable="true">Name</th>
                                                <th data-field="description" data-sortable="true">Description</th>
                                                <th data-field="remarks" data-sortable="true">Remarks</th>
                                                <th data-field="status" data-align="center" data-sortable="true">Status</th>
                                                <th data-field="action" data-align="center" data-sortable="true">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; ?>

                                            @foreach($payment_methods as $pm)
                                            <tr>
                                                <td> {{ $i++ }} </td>
                                                <td>{{$pm->name}}</td>
                                                <td>{{$pm->description}}</td>
                                                <td>{{$pm->remarks}}</td>
                                                <td>
                                                    @if($pm->status == 1)
                                                    <span class="badge badge-success"><i class="fe-check"></i> Active</span>
                                                    @elseif($pm->status == 2)
                                                    <span class="badge badge-warning"><i class="fe-alert-triangle"></i> Inactive</span>
                                                    @elseif($pm->status == 3)
                                                    <span class="badge badge-danger"><i class="fe-x"></i> Deleted</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{url('admin/edit-payment')}}/{{$pm->id}}" class="text-primary font-20"><i class="fe-edit"></i></a>
                                                    <a href="{{url('admin/delete-payment')}}/{{$pm->id}}" class="text-danger font-20"><i class="fe-trash-2"></i></a>
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