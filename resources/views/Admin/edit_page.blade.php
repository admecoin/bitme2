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
                                            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/pages">Pages</a></li>
                                            <li class="breadcrumb-item active">Edit Page</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Page</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Edit Page</h4>
                                
                                <div class="card-box">
                                    @foreach($page as $p)
                                        <form role="form" method="POST" action="{{url('/')}}/admin/page-edit">
                                            <div class="form-group row">
                                                <label for="payment" class="col-2 col-form-label">Name<span class="text-danger">*</span></label>
                                                <div class="col-10">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" required class="form-control" name="page_id" id="page_id" value="{{$p->id}}">
                                                    <input type="text" required class="form-control" name="name" id="name" value="{{$p->name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="payment" class="col-2 col-form-label">Title<span class="text-danger">*</span></label>
                                                <div class="col-10">
                                                    <input type="text" required class="form-control" name="title" id="title" value="{{$p->title}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="payment" class="col-2 col-form-label">Keywords<span class="text-danger">*</span></label>
                                                <div class="col-10">
                                                    <input type="text" required class="form-control" name="keyword" id="keyword" value="{{$p->keyword}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="payment" class="col-2 col-form-label">Body<span class="text-danger">*</span></label>
                                                <div class="col-10">
                                                    <textarea type="text" required class="form-control" name="body" id="body" rows="50">{{$p->body}}</textarea>
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