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
                                            <li class="breadcrumb-item active">Crypto coin</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Crypto Currency</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="header-title">Crypto Currency List</h4>
                                    <!--<p class="sub-header mb-0">
                                        All Crypto Currency list below here.
                                    </p> -->
					               
                                    <div id="addcoin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add New ERC20 Tokens</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <form method="post" action="{{url('/')}}/admin/add-new-coin">
                                                     {{ csrf_field() }}
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="coin_name" class="control-label">Name *</label>
                                                                <input type="text" class="form-control" id="coin_name" name="coin_name" placeholder="Binance" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="coin_label" class="control-label">Label *</label>
                                                                <input type="text" class="form-control" id="coin_label" name="coin_label" placeholder="BNB" required>
                                                            </div>
                                                        </div>
                                                     <!--   <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="fees" class="control-label">Fees *</label>
                                                                <input type="number" class="form-control" id="fees" name="fees" placeholder="0.000001" required>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="contract_address" class="control-label">Contract Address *</label>
                                                                <input type="text" class="form-control" id="contract_address" name="contract_address" placeholder="0xd26114cd6EE289AccF82350c8d8487fedB8A0C07" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group no-margin">
                                                                <label for="desc" class="control-label">Description</label>
                                                                <textarea class="form-control" id="desc" name="description" placeholder="ERC20 Token Description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="Submit" id="addNewCoin" class="btn btn-primary waves-effect waves-light">Submit</button>
                                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->
                                    <!-- Responsive modal -->
                                    <button type="button" id="addnewcoin" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addcoin">
                                        <i class="fe-plus"></i> Add Token
                                    </button>


                                    <table data-toggle="table"
                                           data-search="true"
                                           data-show-refresh="true"
                                           data-sort-name="id"
                                           data-page-list="[5, 10, 20]"
                                           data-page-size="10"
                                           data-pagination="true" data-show-pagination-switch="true" class="table-bordered">
                                        <thead class="thead-light">
	                                        <tr>
	                                            <th data-field="srno" data-sortable="true" data-formatter># Sr. No.</th>
                                                <th data-field="Currency" data-align="left" data-sortable="true" >Label</th>
	                                            <th data-field="Short" data-align="left" data-sortable="true" >Coin name</th>
                                                <th data-field="Rate" data-align="left" data-sortable="true" >Rate</th>
	                                            <th data-field="Fees" data-align="left" data-sortable="true" >Fees</th>
	                                            <th data-field="Created" data-align="left" data-sortable="true" >Created On</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                        	<?php $i=1; ?>

                                        	@foreach($crypto as $cryp)
                                        	<tr>
                                        		<td> {{ $i++ }} </td>
                                                <td>{{ $cryp->label }}</td>
                                        		<td>{{ $cryp->name }}</td>
                                                <td>{{ $cryp->price}}</td>
                                                <td>{{ $cryp->fees}}</td>
                                                <td>
                                                {{ 
                                                date("M-d-Y",mktime(0,0,0,substr($cryp->created_date,5,2),substr($cryp->created_date,8,2),substr($cryp->created_date,0,4)))
                                                }}

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
        $('#addNewCoin').on('click',function(){

            var coin_name = $('#coin_name').val();
            var coin_label = $('#coin_label').val();
            var fees = $('#fees').val();
            var contract_address = $('#contract_address').val();
            
             if (coin_name =='' coin_label =='' fees =='' contract_address =='') {
				alert("All Fields Required");
				return false;    
            }
            
           
        })
    });
</script>

