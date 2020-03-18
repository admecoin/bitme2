 <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="{{ url('/') }}/admin/dashboard">
                                    <i class="fe-airplay"></i>
                                    <span> Dashboard</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
							
							<li>
                                <a href="{{ url('/') }}/admin/users">
                                    <i class="fe-user"></i>
                                    <span>Users</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}/admin/wallet">
                                    <i class=" fas fa-wallet"></i>
                                    <span>Wallet</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}/admin/pages">
                                    <i class="fe-user"></i>
                                    <span>Pages</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-gift"></i>
                                    <span> Offers </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{ url('/') }}/admin/buy-offers-list">Buy Offers</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/') }}/admin/sell-offers-list">Sell Offers</a>
                                    </li>
                                    
                                </ul>
                            </li>

                            <li>
                                <a href="{{ url('/') }}/admin/contract-list">
                                    <i class="far fa-file-alt"></i>
                                    <span>Contract</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ url('/') }}/admin/coin-list">
                                    <i class=" fab fa-bitcoin"></i>
                                    <span>Crypto Coins</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}/admin/payment-method">
                                    <i class="far fa-money-bill-alt"></i>
                                    <span>Payment Method</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li> 

                            <li>
                                <a href="{{ url('/') }}/admin/currency-list">
                                    <i class="far fa-money-bill-alt"></i>
                                    <span>Fiat Currency</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li> 
                            
                            <li>
                                <a href="{{ url('/') }}/admin/withdraw-list">
                                    <i class="far fa-money-bill-alt"></i>
                                    <span>Withdraw</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
							
							<li>
                                <a href="{{ url('/') }}/admin/report-user-list">
                                    <i class="far fa-user"></i>
                                    <span>Report users</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}/admin/afilliate-list">
                                    <i class="mdi mdi-account-group"></i>
                                    <span>Afilliate List</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
							<li>
                                <a href="{{ route('adminkyc') }}">
                                    <i class="fe-user"></i>
                                    <span>KYC List</span>
                                    
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/') }}/admin/site-config">
                                    <i class="fe-settings"></i>
                                    <span>Site Config</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->