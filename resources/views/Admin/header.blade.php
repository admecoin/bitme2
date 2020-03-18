<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>BitcoinNearMe | Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Erience Solutions" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="images/favicon.ico">	
		
        <link href="{{ url('/')}}/admin_assets/assets/libs/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />

        <link href="{{ url('/')}}/admin_assets/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

        <link href="{{ url('/')}}/admin_assets/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/')}}/admin_assets/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/')}}/admin_assets/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/')}}/admin_assets/assets/css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    </head>

    <body>
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ url('/')}}/admin_assets/assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                            	@if(Session::get('user_name') != '')
                                {{ Session::get('user_name') }}
                                @else 
                                {{ 'Admin' }}
                                @endif
                                 <i class="mdi mdi-chevron-down"></i> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                           <!--  <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome Admin !</h6>
                            </div> -->

                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>My Account</span>
                            </a> -->

							<!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-book"></i>
                                <span>Login History</span>
                            </a> -->
							
                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock"></i>
                                <span>Security</span>
                            </a> -->

                            <!-- <div class="dropdown-divider"></div> -->

                            <!-- item-->
                            <a href="{{ url('/')}}/logout" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>
                </ul>
                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{ url('/')}}/admin/dashboard" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{ url('/')}}/assets/image/logo.png" alt="" height="22">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">U</span> -->
                            <img src="{{ url('/')}}/admin_assets/assets/images/logo-sm.png" alt="" height="30">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>
				</ul>
            </div>
            <!-- end Topbar -->


