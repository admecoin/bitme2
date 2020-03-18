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
                                    <h4 class="header-title mb-3">Update Payment Method</h4>

                                    <form action="{{url('admin/save-payment')}}" method="post">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name">Payment Name</label>
                                            <input type="hidden" id="id" name="id" value="{{$payment_method->id}}" class="form-control">
                                            <input type="text" id="name" name="name" value="{{$payment_method->name}}" class="form-control"  placeholder="Payment Method Name">
                                        </div>
                                         <div class="form-group">
                                            <label for="description">Payment Local</label>
                                            <input type="text" id="local" name="local" value="{{$payment_method->local}}" class="form-control" placeholder="eg. 0 or 1">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Payment Description</label>
                                            <textarea id="description" name="description" class="form-control" placeholder="Payment Method Description">{{$payment_method->description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="remarks">Payment Remarks</label>
                                            <textarea id="remarks" name="remarks" class="form-control" placeholder="Payment Method Remarks"> {{$payment_method->remarks}}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                    </form>
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