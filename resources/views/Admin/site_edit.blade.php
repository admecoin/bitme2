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
                                            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/site-config">Site Config</a></li>
                                            <li class="breadcrumb-item active">Edit Site Config</li>
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
                                    <h4 class="header-title">Edit Site Config</h4>
                                   
                                <div class="card-box">
                                    @foreach($site_config as $sc)
                                        <form role="form" method="POST" action="{{url('/')}}/admin/editsiteconfig">
                                            <div class="form-group row">
                                                <label for="Lable" class="col-2 col-form-label">Lable<span class="text-danger">*</span></label>
                                                <div class="col-8">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" required class="form-control" name="cid" id="label" value="{{$sc->id}}" placeholder="Lable">
                                                    <input type="text" required class="form-control" name="label" id="label" value="{{$sc->label}}" placeholder="Lable">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Value" class="col-2 col-form-label">Value<span class="text-danger">*</span></label>
                                                <div class="col-8">
                                                    <input id="value" type="text" name='vaule' placeholder="Value" value='{{$sc->value}}' required class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Remarks" class="col-2 col-form-label">Remarks<span class="text-danger">*</span></label>
                                                <div class="col-8">
                                                    <input type="text" required="" class="form-control" id="remarks" name="remarks" value="{{$sc->remarks}}" placeholder="Remarks">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4 offset-2">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                         @endforeach
                                    </div> <!-- end card-box -->   
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