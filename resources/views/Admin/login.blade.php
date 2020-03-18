<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Erience Solutions</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Erience Solutions" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App css -->
        <link href="{{ url('/') }}/admin_assets/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/') }}/admin_assets/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/') }}/admin_assets/assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">


    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <a href="index.html">
                                        <span><img src="{{ url('/') }}/assets/image/logo.png" alt="" height="22"></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access Admin panel.</p>
                                </div>

                                <form method="post" action="{{ url('/') }}/admin/logincheck" data-parsley-validate="" novalidate="">

                                {{ csrf_field() }}

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" type="email" id="emailaddress" name="user_name" required="" placeholder="Enter your email address">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" required="" name="password" id="password" placeholder="Enter your password">
                                    </div>
									
									<!-- <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin">I agree to the terms of use.</label>
                                        </div>
                                    </div> -->

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> Submit </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="#" class="text-white-50 ml-1">Forget your password?</a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            2019 &copy; All Rights Reserved <a href="https://erience.co" class="text-white-50">Crypscrow.</a> 
        </footer>

        <!-- Vendor js -->
        <script src="{{ url('/') }}/admin_assets/assets/js/vendor.min.js"></script>
		<!-- Plugin js-->
        <script src="{{ url('/') }}/admin_assets/assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="{{ url('/') }}/admin_assets/assets/js/pages/form-validation.init.js"></script>
        <!-- App js -->
        <script src="{{ url('/') }}/admin_assets/assets/js/app.min.js"></script>
        <!--End of Tawk.to Script-->
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
         <script>
          @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
          @endif
         </script>
    </body>
</html>