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
                                            <li class="breadcrumb-item active">Report list</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">CrypScrow Report user</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Reports list</h4>
                                   <table data-toggle="table"
                                           data-search="true"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" data-show-pagination-switch="true" class="table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th data-field="srno" data-align="left" data-sortable="true"># Sr. No.</th>
                                                <th data-field="username" data-align="left" data-sortable="true">Username</th>
                                                <th data-field="email" data-align="left" data-sortable="true">Email</th>
                                                <th data-field="mobile" data-align="left" data-sortable="true">Mobile</th>
                                                <th data-field="total" data-align="left" data-sortable="true">Total report</th>
                                            </tr>                                    
                                        </thead>
                                        <tbody>
                                        @if(count($reports) > 0)
                                            @foreach($reports as $r)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $r['username'] }}</td>
                                                <td>{{ $r['email'] }}</td>
                                                <td>{{ $r['mobile'] }}</td>
                                                <td>{{ $r['total'] }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
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