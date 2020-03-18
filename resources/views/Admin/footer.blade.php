       </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script type="text/javascript">
            var baseurl = "{{ url('/')}}";
        </script>
        
        <script src="{{ url('/')}}/admin_assets/assets/js/vendor.min.js"></script>
        <!-- Plugins js-->
        <script src="{{ url('/')}}/admin_assets/assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="{{ url('/')}}/admin_assets/assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="{{ url('/')}}/admin_assets/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Dashboar 1 init js-->
        <script src="{{ url('/')}}/admin_assets/assets/js/pages/dashboard-1.init.js"></script>
        <!-- App js-->
        <script src="{{ url('/')}}/admin_assets/assets/js/app.min.js"></script
>      
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
        
        function btc_copy(text){
            var dummy = document.createElement("input");
            document.body.appendChild(dummy);
            dummy.setAttribute('value', text);
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            toastr.success("BTC Address copied !! ");
        }

        function eth_copy(text){
            var dummy = document.createElement("input");
            document.body.appendChild(dummy);
            dummy.setAttribute('value', text);
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            toastr.success("ETH Address copied !! ");
        }

        function ltc_copy(text){
            var dummy = document.createElement("input");
            document.body.appendChild(dummy);
            dummy.setAttribute('value', text);
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            toastr.success("LTC Address copied !! "); 
        }
    </script>  
    <script src="{{ url('/')}}/admin_assets/assets/js/app.js"></script>
    </body>
</html>