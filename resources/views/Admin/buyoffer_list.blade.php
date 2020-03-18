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
                                            <li class="breadcrumb-item active">Buy offers</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">CrypScrow Offers</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Buy Offers</h4>
                                    <p class="sub-header mb-0">
                                        Buy offers list display below.
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
                                            <th data-field="srno" data-align="left" data-sortable="true"># Sr. No.</th>
                                            <th data-field="Username" data-align="left" data-sortable="true">Username</th>
                                            <th data-field="offertype" data-align="left" data-sortable="true">Offer Type</th>
                                            <th data-field="cointype" data-align="left" data-sortable="true">Coin Type</th>
                                            <th data-field="FiatType" data-align="left" data-sortable="true">Fiat Type</th>     
                                            <th data-field="Range" data-align="left" data-sortable="true">Range</th>
                                            <th data-field="PaymentMethod" data-align="left" data-sortable="true">Payment Method</th>
                                            <th data-field="Remarks" data-align="left" data-sortable="true">Remarks</th>
                                            <!-- <th data-field="status" data-align="center" data-sortable="true" data-formatter="statusFormatter">Status</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =1; ?>
                                            @foreach($buyoffer as $offer)
                                        	<tr>
                                                <td>{{$i}}</td>
                                        		<td>{{ $offer['username'] }}</td>
                                        		<td>{{ $offer['offer_type'] }}</td>
                                        		<td>{{ $offer['coin_type'] }}</td>
                                        		<td>{{ substr($offer['fiat_type'], 0, -3)  }} - {{ substr($offer['fiat_type'],3)  }}</td>
                                        		<td>{{ $offer['min'] }} - {{ $offer['max'] }}</td>
                                        		<td>{{ $offer['mode'] }}</td>
                                        		<td>{{ $offer['remark'] }}</td>
                                        		<!-- <td>
                                                    @if($offer['status'] != 1)
                                                        <a href="{{ url('/') }}/admin/status-change/{{ $offer['offer_id'] }}" title="Click to Active"><div class="btn btn-sm btn-warning" > <i class="fe-x"></i> Inactive</div></a>
                                                    @else
                                                        <a href="{{ url('/') }}/admin/status-change/{{ $offer['offer_id'] }}" title="Click to Inactive"><div class="btn btn-sm btn-success" >  <i class="fe-gift"></i> Active</div></a>
                                                    @endif
                                                </td> -->
                                        	</tr>
                                            <?php $i++; ?>
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