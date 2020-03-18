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
                                            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/afilliate-list">Afilliate List</a></li>
                                            <li class="breadcrumb-item active">Edit Site Config</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Afilliate</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Edit Afilliate</h4>
                                
                                <div class="card-box">
                                    @foreach($affiliate as $af)
                                        <form role="form" method="POST" action="{{url('/')}}/admin/editaffiliate">
                                            <div class="form-group row">
                                                <label for="payment" class="col-2 col-form-label">Payment<span class="text-danger">*</span></label>
                                                <div class="col-6">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" required class="form-control" name="af_id" id="af_id" value="{{$af->id}}">
                                                        
                                                    <select required class="form-control" name="payment" id="payment">
                                                        <option value="" @if($af->payment == '') {{"Selected"}} @endif >Select</option>
                                                        <option value="1" @if($af->payment == 1) {{"Selected"}} @endif >YES</option>
                                                        <option value="2" @if($af->payment == 2) {{"Selected"}} @endif>NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Hah" class="col-2 col-form-label">Hash<span class="text-danger">*</span></label>
                                                <div class="col-6">
                                                    <input id="hash" type="text" name='hash' placeholder="Hash" value='{{$af->hash}}' required class="form-control">
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