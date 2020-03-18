@include('header')
			<section class="mt-28">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<h1>My account</h1>
							<hr>
							<h2>Profile</h2>
							<div class="WgPh">
							    <div>Username</div>
							    <div>{{ $user_name }}</div>
							</div>
							<div class="WgPh">
							    <div>Bio</div>
                  @if($biodata=="") 
							     <div><em>(none set)</em></div>
                  @else
                   <div><em>{{ $biodata }}</em></div>
                  @endif
							    <div>
							        <button class="browse-btn btn-edit" data-toggle="modal" data-target="#editblurb"><span class="_2JVa"></span>Edit</button>
							    </div>
							</div>
							<!-- <a class="browse-btn" href="{{ url('/') }}/profile">View my profile</a> -->
						</div>
					
						<div class="col-sm-6 col-md-6">
              <h1>&nbsp;</h1>
						    <hr>
							<h2>Contact</h2>
							<div class="WgPh">
							    <div>E-mail</div>
							    <div>{{ $email }}</div>
							   <!--  <div>
							        <button class="browse-btn btn-edit" data-toggle="modal" data-target="#editemail"><span class="_2JVa"></span>Edit</button>
							    </div> -->
							</div>
							<div class="WgPh">
							    <div>Phone number</div>
							    @if($phone=="") 
                   <div><em>(none set)</em></div>
                  @else
                   <div><em>+{{$country_code}} {{ $phone }}</em></div>
                  @endif
							    <div>
							        <button class="browse-btn btn-edit" data-toggle="modal" data-target="#editphone"><span class="_2JVa"></span>Edit</button>
							    </div>
							</div>
						</div>
					</div>
          <div class="row">
						<div class="col-sm-6 col-md-6">
						    <hr>
							<h2>Security</h2>
							<p>Two-factor authentication is mandatory on CrypScrow. You can either use a link sent to your e-mail address, or an OTP app (e.g. Google Authenticator).</p>
							<div class="WgPh">
							    <div>Password</div>
							    <div>**********</div>
							    <div>
							        <button class="browse-btn btn-edit" data-toggle="modal" data-target="#editpass"><span class="_2JVa"></span>Edit</button>
							    </div>
							</div>
							<div class="WgPh">
							    <div>Two-factor</div>
							    <div><em>
                    @if($auth_type == 1)
                     E-mail magic link
                     @elseif($auth_type == 2)
                     OTP
                     @endif
                  </em></div>
							    <div>
							        <button class="browse-btn btn-edit" data-toggle="modal" data-target="#edit2fa"><span class="_2JVa"></span>Edit</button>
							    </div>
							</div>
					    </div>
					
						<div class="col-sm-6 col-md-6">
						    <hr>
							<h2>Invite your friends</h2>
							<p>Invite your friends to buy and sell ether on CrypScrow. When somebody signs up using your unique link, you will earn 20% of fees incurred by their trades throughout the lifetime of their account. Affiliate payments are made at the end of the month.</p>
							
              <!-- <a class="browse-btn" href="#">Apply for referral program</a> -->
              <?php 
                $ref_code = strtoupper(Session::get('user_name'));
                  $referral_msg = "CrypScrow referral Code is :'".$ref_code."'
                  ".url('register'); 
              ?>
              <!-- Refferal Sahring Buttons -->

             <!-- Sharingbutton WhatsApp -->
              <a class="resp-sharing-button__link desk-none browse-btn" href="https://api.whatsapp.com://send?text={{$referral_msg}}" target="_blank" rel="noopener" aria-label="WhatsApp">
                <div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle">
                  <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24"><path d="m12 0c-6.6 0-12 5.4-12 12s5.4 12 12 12 12-5.4 12-12-5.4-12-12-12zm0 3.8c2.2 0 4.2 0.9 5.7 2.4 1.6 1.5 2.4 3.6 2.5 5.7 0 4.5-3.6 8.1-8.1 8.1-1.4 0-2.7-0.4-3.9-1l-4.4 1.1 1.2-4.2c-0.8-1.2-1.1-2.6-1.1-4 0-4.5 3.6-8.1 8.1-8.1zm0.1 1.5c-3.7 0-6.7 3-6.7 6.7 0 1.3 0.3 2.5 1 3.6l0.1 0.3-0.7 2.4 2.5-0.7 0.3 0.099c1 0.7 2.2 1 3.4 1 3.7 0 6.8-3 6.9-6.6 0-1.8-0.7-3.5-2-4.8s-3-2-4.8-2zm-3 2.9h0.4c0.2 0 0.4-0.099 0.5 0.3s0.5 1.5 0.6 1.7 0.1 0.2 0 0.3-0.1 0.2-0.2 0.3l-0.3 0.3c-0.1 0.1-0.2 0.2-0.1 0.4 0.2 0.2 0.6 0.9 1.2 1.4 0.7 0.7 1.4 0.9 1.6 1 0.2 0 0.3 0.001 0.4-0.099s0.5-0.6 0.6-0.8c0.2-0.2 0.3-0.2 0.5-0.1l1.4 0.7c0.2 0.1 0.3 0.2 0.5 0.3 0 0.1 0.1 0.5-0.099 1s-1 0.9-1.4 1c-0.3 0-0.8 0.001-1.3-0.099-0.3-0.1-0.7-0.2-1.2-0.4-2.1-0.9-3.4-3-3.5-3.1s-0.8-1.1-0.8-2.1c0-1 0.5-1.5 0.7-1.7s0.4-0.3 0.5-0.3z"/></svg> Apply for referral program </div></div>
              </a>


              <a class="resp-sharing-button__link mob-none browse-btn" href="whatsapp://send?text={{$referral_msg}}" target="_blank" rel="noopener" aria-label="WhatsApp">
                <div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle">
                  <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24"><path d="m12 0c-6.6 0-12 5.4-12 12s5.4 12 12 12 12-5.4 12-12-5.4-12-12-12zm0 3.8c2.2 0 4.2 0.9 5.7 2.4 1.6 1.5 2.4 3.6 2.5 5.7 0 4.5-3.6 8.1-8.1 8.1-1.4 0-2.7-0.4-3.9-1l-4.4 1.1 1.2-4.2c-0.8-1.2-1.1-2.6-1.1-4 0-4.5 3.6-8.1 8.1-8.1zm0.1 1.5c-3.7 0-6.7 3-6.7 6.7 0 1.3 0.3 2.5 1 3.6l0.1 0.3-0.7 2.4 2.5-0.7 0.3 0.099c1 0.7 2.2 1 3.4 1 3.7 0 6.8-3 6.9-6.6 0-1.8-0.7-3.5-2-4.8s-3-2-4.8-2zm-3 2.9h0.4c0.2 0 0.4-0.099 0.5 0.3s0.5 1.5 0.6 1.7 0.1 0.2 0 0.3-0.1 0.2-0.2 0.3l-0.3 0.3c-0.1 0.1-0.2 0.2-0.1 0.4 0.2 0.2 0.6 0.9 1.2 1.4 0.7 0.7 1.4 0.9 1.6 1 0.2 0 0.3 0.001 0.4-0.099s0.5-0.6 0.6-0.8c0.2-0.2 0.3-0.2 0.5-0.1l1.4 0.7c0.2 0.1 0.3 0.2 0.5 0.3 0 0.1 0.1 0.5-0.099 1s-1 0.9-1.4 1c-0.3 0-0.8 0.001-1.3-0.099-0.3-0.1-0.7-0.2-1.2-0.4-2.1-0.9-3.4-3-3.5-3.1s-0.8-1.1-0.8-2.1c0-1 0.5-1.5 0.7-1.7s0.4-0.3 0.5-0.3z"/></svg> Apply for referral program </div></div>
              </a>

              <!-- <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                  <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                  <a class="a2a_button_facebook"></a>
                  <a class="a2a_button_twitter"></a>
                  <a class="a2a_button_whatsapp"></a>
                  <a class="a2a_button_linkedin"></a>
              </div> -->
			  <hr />
				<div class="table-responsive">
				<h2>Invite Users</h2>
				
					<table class="table">
					@foreach($affiliate_list as $af)
						<tr>
							<td>{{ $af['user_name'] }}</td>
							<td>{{ $af['email'] }}</td> 
							<td>
								@if($af['claim']=="2")
								<button id='claim' class='btn btn-edit browse-btn claims' data-value="{{ $af['af_id'] }}">Claim</button>
								@else
									Claimed
								@endif
							</td>
							
						</tr>
					@endforeach	
					</table>
				</div>
              <!-- END Refferal Sahring Buttons -->

						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-md-6">
						    <hr>
							<h2>Logout</h2>
							<p>When using a shared device, you should always log out before leaving.</p>
							<a class="browse-btn" href="{{ url('/') }}/logout">Logout</a>
						</div>
						<?php if($kyc_op=="1") { ?>
						<div class="col-sm-6 col-md-6">
						    <hr>
							<h2>KYC Documents</h2>
							<!-- <p>When using a shared device, you should always log out before leaving.</p> -->
							<button class="browse-btn btn-edit" data-toggle="modal" data-target="#kycmodal"><span class="_2JVa"></span>Add Documents</button>
							<hr />
							<div class="table-responsive">
							<h2>Document List</h2>
							
								<table class="table">
								@foreach($user_kyc as $uk)
								
									<tr>
										<td><img src="{{ url('/') }}/images/{{ $uk->Identity_proof }}" width="100" height="100"></td>
										<td><img src="{{ url('/') }}/images/{{ $uk->residential_proof }}" width="100" height="100"></td>
										<td>
											@if($uk->status=="0")
											Pending
											@elseif($uk->status=="1")
											Approve
											@elseif($uk->status=="2")
											Reject
											@endif
										</td>
										
									</tr>
								@endforeach	
								</table>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</section>
			
			<!-- Modal Blurb-->
            <div class="modal fade" id="kycmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add KYC Documents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="{{ route('addkyc',$user_id) }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                        <!-- <p>Your email address is never shown to anyone. To change it, we'll send you a confirmation link</p> -->
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Identity Proof</label>
                                <input type="file" name="pictures" class="form-control" required/>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <label>Residential Proof </label>
                            <div class="form-group">
                                <input type="file" name="pictures2" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="button-cta btn-font-size" >Add Document</button>
                    </form>
                  </div>
                
                </div>
              </div>
            </div>
			
			<!-- Modal Blurb-->
            <div class="modal fade" id="editblurb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change your bio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="{{url('/')}}/biodata">
                      {{ csrf_field() }}
                        <p>Your email address is never shown to anyone. To change it, we'll send you a confirmation link</p>
                        <div class="form-group">
                            <textarea class="form-control" name="biodata" rows="3" >{{ $biodata }}</textarea>
                        </div>
                        <button type="submit" class="button-cta btn-font-size" >Change bio</button>
                    </form>
                  </div>
                
                </div>
              </div>
            </div>
            
            <!-- Modal email-->
            <div class="modal fade" id="editemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change your email address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="{{url('/')}}/changeemail">
                      {{ csrf_field() }}
                        <p>Your email address is never shown to anyone. To change it, we'll send you a confirmation link</p>
                        <div class="form-group">
                            <input type="text" autocomplete="new-email" class="form-control" name="email" placeholder="name@example.com" value="{{ $email }}">
                        </div>
                        <button type="submit" class="button-cta btn-font-size" >Change email</button>
                    </form>
                  </div>
                
                </div>
              </div>
            </div>
            
            <!-- Phone Number Modal-->
            <div class="modal fade" id="editphone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Set your phone number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    
                    <!-- <form method="post" action="{{url('/')}}/changephone"> -->
                       {{ csrf_field() }}
                        <p>Enter your phone number, including your country calling code and plus sign.</p>
                        <div id="sms" style="display: block;">
                          <div class="form-group">
                              <input type="text" autocomplete="new-phone" class="form-control" readonly id="phone_num" name="phone" placeholder="e.g. +1 5417543010" value="{{ $phone }}">
                              <br>
                              <button type="submit" id="change_number" style="display: block;" class="button-cta btn-font-size">Send OTP</button>
                          </div>
                        </div>

                    <!-- </form> -->
                      
                      <div id="sms2" style="display: none;">
                        <div class="form-group">
                          <form method="post" action="{{url('/')}}/changephone">
                            {{ csrf_field() }}
                              <input type="hidden"  name="phone2" id="phone2" class="form-control" value="" readonly />
                              <label>Enter Otp</label><br>
                              <input type="hidden"  name="phone2" id="phone2" class="form-control" value="" readonly />
                              <input type="text" autocomplete="new-verifyotp" name="verify_otp" id="otp" class="form-control" value="" />
                                
                              <label>Select Country Code*</label><br>
                              <select name="country_code" class="form-control" id="country_code" required>
                                <option value="">Select Country Code</option>
                                <option value="93">93 (Afghanistan)</option>
                                <option value="355">355 (Albania)</option>
                                <option value="213">213 (Algeria)</option>
                                <option value="1684">1684 (American Samoa)</option>
                                <option value="376">376 (Andorra)</option>
                                <option value="244">244 (Angola)</option>
                                <option value="1264">1264 (Anguilla)</option>
                                <option value="672">672 (Antarctica)</option>
                                <option value="1268">1268 (Antigua and Barbuda)</option>
                                <option value="54">54 (Argentina)</option>
                                <option value="374">374 (Armenia)</option>
                                <option value="297">297 (Aruba)</option>
                                <option value="61">61 (Australia)</option>
                                <option value="43">43 (Austria)</option>
                                <option value="994">994 (Azerbaijan)</option>
                                <option value="1242">1242 (Bahamas)</option>
                                <option value="973">973 (Bahrain)</option>
                                <option value="880">880 (Bangladesh)</option>
                                <option value="1246">1246 (Barbados)</option>
                                <option value="375">375 (Belarus)</option>
                                <option value="32">32 (Belgium)</option>
                                <option value="501">501 (Belize)</option>
                                <option value="229">229 (Benin)</option>
                                <option value="1441">1441 (Bermuda)</option>
                                <option value="975">975 (Bhutan)</option>
                                <option value="591">591 (Bolivia)</option>
                                <option value="387">387 (Bosnia and Herzegovina)</option>
                                <option value="267">267 (Botswana)</option>
                                <option value="55">55 (Brazil)</option>
                                <option value="246">246 (British Indian Ocean Territory)</option>
                                <option value="1284">1284 (British Virgin Islands)</option>
                                <option value="673">673 (Brunei)</option>
                                <option value="359">359 (Bulgaria)</option>
                                <option value="226">226 (Burkina Faso)</option>
                                <option value="257">257 (Burundi)</option>
                                <option value="855">855 (Cambodia)</option>
                                <option value="237">237 (Cameroon)</option>
                                <option value="1">1 (Canada)</option>
                                <option value="238">238 (Cape Verde)</option>
                                <option value="1345">1345 (Cayman Islands)</option>
                                <option value="236">236 (Central African Republic)</option>
                                <option value="235">235 (Chad)</option>
                                <option value="56">56 (Chile)</option>
                                <option value="86">86 (China)</option>
                                <option value="61">61 (Christmas Island)</option>
                                <option value="61">61 (Cocos Islands)</option>
                                <option value="57">57 (Colombia)</option>
                                <option value="269">269 (Comoros)</option>
                                <option value="682">682 (Cook Islands)</option>
                                <option value="506">506 (Costa Rica)</option>
                                <option value="385">385 (Croatia)</option>
                                <option value="53">53 (Cuba)</option>
                                <option value="599">599 (Curacao)</option>
                                <option value="357">357 (Cyprus)</option>
                                <option value="420">420 (Czech Republic)</option>
                                <option value="243">243 (Democratic Republic of the Congo)</option>
                                <option value="45">45 (Denmark)</option>
                                <option value="253">253 (Djibouti)</option>
                                <option value="1767">1767 (Dominica)</option>
                                <option value="1809, 1829, 1849">1809, 1829, 1849 (Dominican Republic)</option>
                                <option value="670">670 (East Timor)</option>
                                <option value="593">593 (Ecuador)</option>
                                <option value="20">20 (Egypt)</option>
                                <option value="503">503 (El Salvador)</option>
                                <option value="240">240 (Equatorial Guinea)</option>
                                <option value="291">291 (Eritrea)</option>
                                <option value="372">372 (Estonia)</option>
                                <option value="251">251 (Ethiopia)</option>
                                <option value="500">500 (Falkland Islands)</option>
                                <option value="298">298 (Faroe Islands)</option>
                                <option value="679">679 (Fiji)</option>
                                <option value="358">358 (Finland)</option>
                                <option value="33">33 (France)</option>
                                <option value="689">689 (French Polynesia)</option>
                                <option value="241">241 (Gabon)</option>
                                <option value="220">220 (Gambia)</option>
                                <option value="995">995 (Georgia)</option>
                                <option value="49">49 (Germany)</option>
                                <option value="233">233 (Ghana)</option>
                                <option value="350">350 (Gibraltar)</option>
                                <option value="30">30 (Greece)</option>
                                <option value="299">299 (Greenland)</option>
                                <option value="1473">1473 (Grenada)</option>
                                <option value="1671">1671 (Guam)</option>
                                <option value="502">502 (Guatemala)</option>
                                <option value="441481">441481 (Guernsey)</option>
                                <option value="224">224 (Guinea)</option>
                                <option value="245">245 (Guinea-Bissau)</option>
                                <option value="592">592 (Guyana)</option>
                                <option value="509">509 (Haiti)</option>
                                <option value="504">504 (Honduras)</option>
                                <option value="852">852 (Hong Kong)</option>
                                <option value="36">36 (Hungary)</option>
                                <option value="354">354 (Iceland)</option>
                                <option value="91">91 (India)</option>
                                <option value="62">62 (Indonesia)</option>
                                <option value="98">98 (Iran)</option>
                                <option value="964">964 (Iraq)</option>
                                <option value="353">353 (Ireland)</option>
                                <option value="441624">441624 (Isle of Man)</option>
                                <option value="972">972 (Israel)</option>
                                <option value="39">39 (Italy)</option>
                                <option value="225">225 (Ivory Coast)</option>
                                <option value="1876">1876 (Jamaica)</option>
                                <option value="81">81 (Japan)</option>
                                <option value="441534">441534 (Jersey)</option>
                                <option value="962">962 (Jordan)</option>
                                <option value="7">7 (Kazakhstan)</option>
                                <option value="254">254 (Kenya)</option>
                                <option value="686">686 (Kiribati)</option>
                                <option value="383">383 (Kosovo)</option>
                                <option value="965">965 (Kuwait)</option>
                                <option value="996">996 (Kyrgyzstan)</option>
                                <option value="856">856 (Laos)</option>
                                <option value="371">371 (Latvia)</option>
                                <option value="961">961 (Lebanon)</option>
                                <option value="266">266 (Lesotho)</option>
                                <option value="231">231 (Liberia)</option>
                                <option value="218">218 (Libya)</option>
                                <option value="423">423 (Liechtenstein)</option>
                                <option value="370">370 (Lithuania)</option>
                                <option value="352">352 (Luxembourg)</option>
                                <option value="853">853 (Macau)</option>
                                <option value="389">389 (Macedonia)</option>
                                <option value="261">261 (Madagascar)</option>
                                <option value="265">265 (Malawi)</option>
                                <option value="60">60 (Malaysia)</option>
                                <option value="960">960 (Maldives)</option>
                                <option value="223">223 (Mali)</option>
                                <option value="356">356 (Malta)</option>
                                <option value="692">692 (Marshall Islands)</option>
                                <option value="222">222 (Mauritania)</option>
                                <option value="230">230 (Mauritius)</option>
                                <option value="262">262 (Mayotte)</option>
                                <option value="52">52 (Mexico)</option>
                                <option value="691">691 (Micronesia)</option>
                                <option value="373">373 (Moldova)</option>
                                <option value="377">377 (Monaco)</option>
                                <option value="976">976 (Mongolia)</option>
                                <option value="382">382 (Montenegro)</option>
                                <option value="1664">1664 (Montserrat)</option>
                                <option value="212">212 (Morocco)</option>
                                <option value="258">258 (Mozambique)</option>
                                <option value="95">95 (Myanmar)</option>
                                <option value="264">264 (Namibia)</option>
                                <option value="674">674 (Nauru)</option>
                                <option value="977">977 (Nepal)</option>
                                <option value="31">31 (Netherlands)</option>
                                <option value="599">599 (Netherlands Antilles)</option>
                                <option value="687">687 (New Caledonia)</option>
                                <option value="64">64 (New Zealand)</option>
                                <option value="505">505 (Nicaragua)</option>
                                <option value="227">227 (Niger)</option>
                                <option value="234">234 (Nigeria)</option>
                                <option value="683">683 (Niue)</option>
                                <option value="850">850 (North Korea)</option>
                                <option value="1670">1670 (Northern Mariana Islands)</option>
                                <option value="47">47 (Norway)</option>
                                <option value="968">968 (Oman)</option>
                                <option value="92">92 (Pakistan)</option>
                                <option value="680">680 (Palau)</option>
                                <option value="970">970 (Palestine)</option>
                                <option value="507">507 (Panama)</option>
                                <option value="675">675 (Papua New Guinea)</option>
                                <option value="595">595 (Paraguay)</option>
                                <option value="51">51 (Peru)</option>
                                <option value="63">63 (Philippines)</option>
                                <option value="64">64 (Pitcairn)</option>
                                <option value="48">48 (Poland)</option>
                                <option value="351">351 (Portugal)</option>
                                <option value="1787, 1939">1787, 1939 (Puerto Rico)</option>
                                <option value="974">974 (Qatar)</option>
                                <option value="242">242 (Republic of the Congo)</option>
                                <option value="262">262 (Reunion)</option>
                                <option value="40">40 (Romania)</option>
                                <option value="7">7 (Russia)</option>
                                <option value="250">250 (Rwanda)</option>
                                <option value="590">590 (Saint Barthelemy)</option>
                                <option value="290">290 (Saint Helena)</option>
                                <option value="1869">1869 (Saint Kitts and Nevis)</option>
                                <option value="1758">1758 (Saint Lucia)</option>
                                <option value="590">590 (Saint Martin)</option>
                                <option value="508">508 (Saint Pierre and Miquelon)</option>
                                <option value="1784">1784 (Saint Vincent and the Grenadines)</option>
                                <option value="685">685 (Samoa)</option>
                                <option value="378">378 (San Marino)</option>
                                <option value="239">239 (Sao Tome and Principe)</option>
                                <option value="966">966 (Saudi Arabia)</option>
                                <option value="221">221 (Senegal)</option>
                                <option value="381">381 (Serbia)</option>
                                <option value="248">248 (Seychelles)</option>
                                <option value="232">232 (Sierra Leone)</option>
                                <option value="65">65 (Singapore)</option>
                                <option value="1721">1721 (Sint Maarten)</option>
                                <option value="421">421 (Slovakia)</option>
                                <option value="386">386 (Slovenia)</option>
                                <option value="677">677 (Solomon Islands)</option>
                                <option value="252">252 (Somalia)</option>
                                <option value="27">27 (South Africa)</option>
                                <option value="82">82 (South Korea)</option>
                                <option value="211">211 (South Sudan)</option>
                                <option value="34">34 (Spain)</option>
                                <option value="94">94 (Sri Lanka)</option>
                                <option value="249">249 (Sudan)</option>
                                <option value="597">597 (Suriname)</option>
                                <option value="47">47 (Svalbard and Jan Mayen)</option>
                                <option value="268">268 (Swaziland)</option>
                                <option value="46">46 (Sweden)</option>
                                <option value="41">41 (Switzerland)</option>
                                <option value="963">963 (Syria)</option>
                                <option value="886">886 (Taiwan)</option>
                                <option value="992">992 (Tajikistan)</option>
                                <option value="255">255 (Tanzania)</option>
                                <option value="66">66 (Thailand)</option>
                                <option value="228">228 (Togo)</option>
                                <option value="690">690 (Tokelau)</option>
                                <option value="676">676 (Tonga)</option>
                                <option value="1868">1868 (Trinidad and Tobago)</option>
                                <option value="216">216 (Tunisia)</option>
                                <option value="90">90 (Turkey)</option>
                                <option value="993">993 (Turkmenistan)</option>
                                <option value="1649">1649 (Turks and Caicos Islands)</option>
                                <option value="688">688 (Tuvalu)</option>
                                <option value="1340">1340 (U.S. Virgin Islands)</option>
                                <option value="256">256 (Uganda)</option>
                                <option value="380">380 (Ukraine)</option>
                                <option value="971">971 (United Arab Emirates)</option>
                                <option value="44">44 (United Kingdom)</option>
                                <option value="1">1 (United States)</option>
                                <option value="598">598 (Uruguay)</option>
                                <option value="998">998 (Uzbekistan)</option>
                                <option value="678">678 (Vanuatu)</option>
                                <option value="379">379 (Vatican)</option>
                                <option value="58">58 (Venezuela)</option>
                                <option value="84">84 (Vietnam)</option>
                                <option value="681">681 (Wallis and Futuna)</option>
                                <option value="212">212 (Western Sahara)</option>
                                <option value="967">967 (Yemen)</option>
                                <option value="260">260 (Zambia)</option>
                                <option value="263">263 (Zimbabwe)</option>
                              </select>

                              <label>Enter New Mobile Number</label><br>
                              <input type="text" autocomplete="new-newnumber" name="new_number" id="new_number" class="form-control" value="" readonly/>
                              <br>
                              <button type="submit" name="submit" class="button-cta btn-font-size" id="sms_btn2">Change Number</button>
                          </form>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
            
            <!-- Password Modal-->
            <div class="modal fade" id="editpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="{{url('/')}}/changepassword">
                      {{ csrf_field() }}
                        <p>Changing your CrypScrow password involves your web browser re-encrypting your private key using AES256-CBC to a PBKDF2-stretched version of your new password.</p>
                        <div class="form-group">
                            <input type="password" autocomplete="new-password" class="form-control" id="pass" name="password" placeholder="enter new password">
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="new-cpassword" class="form-control" id="cpass" name="cpassword" placeholder="Confirm new password">
                        </div>
                        <button type="submit" id="cng-password" class="button-cta btn-font-size">Change password</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- 2fa Modal-->
            <div class="modal fade" id="edit2fa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change two factor login method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <form method="post" action="{{url('/')}}/changeauth">
                      {{ csrf_field() }}
                        <p>Enter your phone number, including your country calling code and plus sign.</p>
                        <div class="form-group">
                            <label for="2fa">Two factor log in method</label>
                            <select class="form-control" name='otp_login' id="2fa">
                              <option value='1' @if($auth_type == 1) selected @endif >Email magic link</option>
                              <option value='2' @if($auth_type == 2) selected @endif >OTP</option>
                            </select>
                        </div>
                        <button type="submit" class="button-cta btn-font-size">Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
     <script async src="https://static.addtoany.com/menu/page.js"></script>
			@include('footer')

<script type="text/javascript">
  $(document).ready(function(){
    
    $('#cng-password').click(function(){
      var pass =$("#pass").val();
      var cpass =$("#cpass").val();
      var paswd=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{4,15}$/;

      if(pass == "" && cpass == "") { 
        toastr.error('Both Fields are Required');
        return false;
      } else if(pass == ""){
        toastr.error('Password is Required');
        return false;
      } else if(cpass == ""){
        toastr.error('Confirm Password is Required');
        return false;
      } else if(pass.length < 5){
        toastr.error('Password should contain minimum 6 letter');
        return false;
      } else if(pass.length > 15){
        toastr.error('Password should contain Maximum 14 letter');
        return false;
      } else if(pass != cpass){
        toastr.error('Password and Confirm Password is Not Matched');
        return false;
      } else if(!(paswd.test(pass))) { 
        toastr.error("Password should contain atleast one number, one alphabetic and one special character!");
        return false;
      } else {
           return true;
      }
    });
    
    $('#change_number').click(function(){

          var phone = $('#phone_num').val();
          // var filter = /^(\+[1-9]{1,10})$/;
          var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;

          if(phone == ''){
              $('#phone_num').focus();
              toastr.error("Mobile Number Required!");
              return false;
          } 
       /*   else if (phone.length != 10) {
              toastr.error("Mobile Number should contain 10 digit number!");
              return false;
          } */
           else {           
            var baseurl = $('input[name="baseurl"]').val();
            var user_id = "{{Session::get('user_id')}}";

            $.ajax({
                type: "POST",
                url: baseurl + "/sendotp",
                cache: false,
                data: {phone:phone,user_id:user_id},
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                success:function(data){

                    $("#sms").css("display", "none");
                    $("#sms2").css("display", "block");
                    $('#phone2').val(data.phone);
                    // console.log("succes");
                    toastr.success("OTP Send on you entered number!");
                },
                error:function(response){
                  // console.log(response);
                }
              });
          }        
    });

    $('#sms_btn2').click(function(){
      
      if ($('#otp').val() == '') {
        toastr.error("Enter Otp!");
        $('#otp').focus();
        return false;  
      } else if ($('#country_code').val() == '') {
        toastr.error("Select Country Code!");
        $('select[name=country_code]').focus();
        return false;  
      } else if ($('#new_number').val() == '') {
        toastr.error("Enter your new mobile number!");
        $('input[name=new_number]').focus();
        return false;  
      }
      else {
        return true;
      }
      
    });

    $("#otp").on('keyup', function(){
      var str = $("#otp").val();
      if(str.length=="6"){
      $("#new_number").attr("readonly",false);
    } else {
      $("#new_number").attr("readonly",true);
    }

    });




    
  });
</script>