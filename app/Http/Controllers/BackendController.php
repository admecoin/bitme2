<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use Input;
use DB;
use Redirect;
use Alert;
use Mail;
use Location;
use Session;
use Cookie;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
// use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Routing\UrlGenerator;
use Exception;
use Torann\GeoIP\Support\HttpClient;
use Torann\GeoIP\Services\AbstractService;


class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {

     $u_id = Session::get('user_id');
     $u_type = Session::get('user_type');
     
        if ($u_id !='' && $u_type == 1) {

            $data = array();

            $users = DB::table('a_users')->where('user_type',2)->get();

            $data['totalUser'] = count($users);

            if(count($users)>0) {

	            foreach ($users as $u_info) {

	                $uinfo = DB::table('a_users_info')->where('user_id', $u_info->id)->get();
	                
	                if ($uinfo != '') {

	                    foreach ($uinfo as $info) { }
	                    
	                        $array[] = array(
	                            'user_id' => $u_info->id,
	                            'user_name' => $u_info->user_name,
	                            'first_name' => $u_info->first_name,
	                            'last_name' => $u_info->last_name,
	                            'email' => $u_info->email,
	                            'mobile' => $u_info->mobile,
	                            'street' => $info->street,
	                            'landmark' => $info->landmark,
	                            'city' => $info->city,
	                            'state' => $info->state,
	                            'country' => $info->country,
	                            'pincode' => $info->pincode,
	                            'bio_data' => $info->bio_data,
	                            'status' => $u_info->status,
	                        );
	                }
	            }
        	} else {
        		$array = array();
        	}

           

            $data['user_info'] = $array;

            return View::make('Admin.dashboard')->with($data);
            
        } elseif($u_type == 2) {

            $notification = array(
                        'message' => 'Oops! Something wrong.', 
                        'alert-type' => 'warning'
                    );
                    
            return Redirect::to('home')->with($notification);

        } else {

            $notification = array(
                        'message' => 'Please Login First!', 
                        'alert-type' => 'error'
                    );
                    
            return Redirect::to('login')->with($notification);

        }
    }

    /*
    *
    * Users List
    */

    public function users_list() {   
    
    $u_id = Session::get('user_id');
    $u_type = Session::get('user_type');
    
    if ($u_id !='' && $u_type == 1) {
        
        $data = array();

        // $user = DB::table('a_users')->where('user_type', 2)->orderby('id','DESC')->get();
        $user = DB::table('a_users')->orderby('id','DESC')->get();

        foreach ($user as $u_info) {
            $uinfo = DB::table('a_users_info')->where('user_id', $u_info->id)->orderby('id','DESC')->get();
            $ulog = DB::table('a_users_log')->where('user_id', $u_info->id)->orderby('id','DESC')->limit(1)->get();
			
			//print_r($uinfo); exit;
			
            if ($uinfo != '') {
                foreach ($uinfo as $info) { }

				if (count($ulog)> 0) {
					foreach ($ulog as $ul) { }
					
						$login = date('Y-m-d', strtotime($ul->in_time));//date("M-d-Y",mktime(0,0,0, substr($ul->in_time,5,2), substr($ul->in_time,8,2), substr($ul->in_time,0,4) ));
						
						$logout = date('Y-m-d', strtotime($ul->out_time)); //date("M-d-Y",mktime(0,0,0, substr($ul->out_time,5,2), substr($ul->out_time,8,2), substr($ul->out_time,0,4) )); //$ul->out_time;

						$ip_address  = $ul->created_ip;
				} else {
					$login = '';
					$logout = '';
					$ip_address = '';
				}
				
				$array[] = array(
					'user_id' => $u_info->id,
					'user_type' => $u_info->user_type,
					'user_name' => $u_info->user_name,
					'first_name' => $u_info->first_name,
					'last_name' => $u_info->last_name,
					'email' => $u_info->email,
					'mobile' => $u_info->mobile,
					'street' => $info->street,
					'landmark' => $info->landmark,
					'city' => $info->city,
					'state' => $info->state,
					'country' => $info->country,
					'pincode' => $info->pincode,
					'bio_data' => $info->bio_data,
					'last_login' => $login,
					'logout' => $logout,
					'ip_address' => $ip_address,
					'status' => $u_info->status,
				);
            }
        }
        $data['user_info'] = $array;
        return View::make('Admin.users_list')->with($data);
    } else {

        $notification = array(
            'message' => 'Error occured, Please try again', 
            'alert-type' => 'warning'
        );
        return Redirect::to('home')->with($notification);
        }
    }
	
	/* Start Kyc Section */
	
	public function kyclist() {   
    
    $u_id = Session::get('user_id');
    $u_type = Session::get('user_type');
    
    if ($u_id !='' && $u_type == 1) {
        
        $data = array();

        $user = DB::table('a_kyc_list')->orderby('id','DESC')->get();
        if(count($user)>0) { 
        foreach ($user as $u_info) {
            $uinfo = DB::table('a_users')->where('id', $u_info->user_id)->get();
           	foreach ($uinfo as $info) { }
			
			if($u_info->status=="0") { 
				$st = "Pending";
			} else if($u_info->status=="1") { 
				$st = "Approve";
			} else if($u_info->status=="2") {
				$st = "Reject";
			}

				$array[] = array(
					'id' => $u_info->id,
					'user_name' => $info->user_name,
					'Identity_proof' => $u_info->Identity_proof,
                    'residential_proof' => $u_info->residential_proof,
					'status' => $st,
					'created_at' => $u_info->created_date
				);
            
        }
    } else {
    	$array =array();
    }
        $data['user_info'] = $array;
        return View::make('Admin.kyc_list')->with($data);
    } else {

        $notification = array(
            'message' => 'Error occured, Please try again', 
            'alert-type' => 'warning'
        );
        return Redirect::to('home')->with($notification);
        }
    }
	
	public function actionkyc($id,$status){
		
		$update = DB::table('a_kyc_list')->where('id', $id)->update(['status' => $status]);
		$notification = array(
				'message' => 'Status Updated Successfully!', 
				'alert-type' => 'success'
			);
				
		return Redirect::to('admin/kyclist')->with($notification);
	}
	
	public function kycoption($id,$status) {
		
		$update = DB::table('a_site_config')->where('id', $id)->update(['status' => $status]);
		$notification = array(
				'message' => 'Status Updated Successfully!', 
				'alert-type' => 'success'
			);
				
		return Redirect::to('admin/site-config')->with($notification);
	}
	/* End Kyc section */
    /*
    * Update user Status
    */
    public function userstatus(Request $req){
    
    $u_id = Session::get('user_id');
    $u_type = Session::get('user_type');
    
    if ($u_id !='' && $u_type == 1) {
            
        $user = DB::table('a_users')->select('status')->where('id', $req->userid)->get();
        
            if ($user != '') {

                if ($user[0]->status == 1) {
                    
                    DB::table('a_users')->where('id', $req->userid)->update(['status' => 2]);
                    
                    $notification = array(
                            'message' => 'Status Updated Successfully!', 
                            'alert-type' => 'success'
                        );
                        
                    return Redirect::to('admin/users')->with($notification);

                } else {

                    DB::table('a_users')->where('id', $req->userid)->update(['status' => 1]);
                    $notification = array(
                            'message' => 'Status Updated Successfully!', 
                            'alert-type' => 'success'
                        );
                        
                    return Redirect::to('admin/users')->with($notification);

                }
            }

        } else {

            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);

        } 
    }

  /*
    * Update User Role
    */
    public function userrole(Request $req){
    
    $u_id = Session::get('user_id');
    $u_type = Session::get('user_type');
    
    if ($u_id !='' && $u_type == 1) {
            
        $user = DB::table('a_users')->select('user_type')->where('id', $req->userid)->get();
        
            if ($user != '') {

                if ($user[0]->user_type == 1) {
                    
                    DB::table('a_users')->where('id', $req->userid)->update(['user_type' => 2]);
                    
                    $notification = array(
                            'message' => 'Role Updated Successfully!', 
                            'alert-type' => 'success'
                        );
                        
                    return Redirect::to('admin/users')->with($notification);

                } else {

                    DB::table('a_users')->where('id', $req->userid)->update(['user_type' => 1]);
                    $notification = array(
                            'message' => 'Role Updated Successfully!', 
                            'alert-type' => 'success'
                        );
                        
                    return Redirect::to('admin/users')->with($notification);

                }
            }

        } else {

            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);

        } 
    }
    /*
    * All Offer List
    */

    public function buyOfferList() {

        $u_id = Session::get('user_id');
        $u_type = Session::get('user_type');
        
        $data = array();
        $array = array();

        if ($u_id !='' && $u_type == 1) {

            $select = DB::table('a_offers')->where('type_id',14)->orderBy('id', 'DESC')->get();
            
            foreach ($select as $row) {
                
                $user = DB::table('a_users')->select('user_name')->where('id',$row->user_id)->get();
                $coin = DB::table('a_coin_info')->where('id',$row->coin_id)->get();
                $offer_type = DB::table('a_master_values')->where('id',$row->type_id)->get();
                $currency = DB::table('a_currency_list')->where('id',$row->currency_id)->get();
                $mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
                
                foreach($mode as $m){}  
                foreach ($user as $u) { }
                foreach ($coin as $c) { }
                foreach ($offer_type as $tp) { }
                foreach ($currency as $cur) { }

                $array[] = array(
                    'offer_id' => $row->id,
                    'username' => $u->user_name,
                    'user_id' => $row->user_id,
                    'offer_type' => $tp->name,
                    'coin_type' => $c->name,
                    'fiat_type' => $cur->short,
                    'mode' =>  $m->name,
                    'min' => $row->min,
                    'max' => $row->max,
                    'remark' => $row->offer,
                    'open' => $row->open,
                    'close' =>  $row->close,
                    'status' => $row->status,
                );
            }

            $data = array(
                'buyoffer' => $array
            );
            

            return View::make('Admin.buyoffer_list')->with($data);

        } else {

            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);

        }

    }
    public function sellOfferList() {


        $u_id = Session::get('user_id');
        $u_type = Session::get('user_type');
        
        $data = array();
        $array = array();

        if ($u_id !='' && $u_type == 1) {

            $select = DB::table('a_offers')->where('type_id',15)->orderBy('id', 'DESC')->get();
            
            foreach ($select as $row) {
                
                $user = DB::table('a_users')->select('user_name')->where('id',$row->user_id)->get();
                $coin = DB::table('a_coin_info')->where('id',$row->coin_id)->get();
                $offer_type = DB::table('a_master_values')->where('id',$row->type_id)->get();
                $currency = DB::table('a_currency_list')->where('id',$row->currency_id)->get();
                $mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
                
                foreach($mode as $m){}  
                foreach ($user as $u) { }
                foreach ($coin as $c) { }
                foreach ($offer_type as $tp) { }
                foreach ($currency as $cur) { }

                $array[] = array(
                    'offer_id' => $row->id,
                    'username' => $u->user_name,
                    'user_id' => $row->user_id,
                    'offer_type' => $tp->name,
                    'coin_type' => $c->name,
                    'fiat_type' => $cur->short,
                    'mode' =>  $m->name,
                    'min' => $row->min,
                    'max' => $row->max,
                    'remark' => $row->offer,
                    'open' => $row->open,
                    'close' =>  $row->close,
                    'status' => $row->status,
                );
            }

            $data = array(
                'buyoffer' => $array
            );
            

            return View::make('Admin.selloffer_list')->with($data);

        } else {

            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);

        }

    }


    /*
    * Login Check Function for Check Admin Login Credentials
    */

    public function loginchk() {
        
        $u_id = Session::get('user_id');
        $u_type = Session::get('user_type');

         if ($u_id !='' && $u_type == 1) {
           return "true";
        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }
    }

    /**
     * Show the Contract List.
     *
     * @return \Illuminate\Http\Response
     */

    public function contractList() {

        $data = array();
        $u_id = Session::get('user_id');
        $u_type = Session::get('user_type');
        $array = array();

        if ($u_id !='' && $u_type == 1) {
            $contract = DB::table('a_contract')->where('status','1')->orderBy('id', 'DESC')->get();
            if ($contract > 0 ) {
                foreach ($contract as $row ) {
                    $user_create = DB::table('a_users')->select('user_name')->where('id',$row->to_user)->get();
                    foreach($user_create as $uc) { }
                    $user_buy = DB::table('a_users')->select('user_name')->where('id',$row->from_user)->get();
                    foreach ($user_buy as $ub) { }
                    $offer = DB::table('a_offers')->select('type_id','coin_id','id')->where('id',$row->offer_id)->get();
                    foreach ($offer as $ofr) { }
                    $currency = DB::table('a_currency_list')->where('id',$row->currency_id)->get();
                    foreach ($currency as $cur) { }
                    $offer_type = DB::table('a_master_values')->select('name')->where('id',$ofr->type_id)->get();
                    foreach ($offer_type as $ot) { }
                    $coins = DB::table('a_coin_info')->select('name','label')->where('id',$ofr->coin_id)->get();
                    foreach ($coins as $coin) { }
                    $status = DB::table('a_master_values')->select('name')->where('id',$row->co_status)->get();
                    foreach ($status as $st) { }
                    $array[] = array(
                        'contract_id' => $row->id,
                        'crypto_value' => $row->crypto_value,
                        'fiat_value'=> $row->fiat_value,
                        'fees1' => $row->fees,
                        'fees2' => $row->fees2,
                        'co_status' => $row->co_status,
                        'create_offer' => $uc->user_name,
                        'buy_offer' => $ub->user_name,
                        'offer_type' => $ot->name,
                        'coin_label' => $coin->label,
                        'coin_name' => $coin->name,
                        'despute' => $row->despute,
                        'currency' => $cur->short,
                        'currency_rate' =>  $cur->rate,
						'contract_status' => $st->name,
                    );
                }     
                $data = array("contractList" => $array);
                // print_r($array); exit;
                return View::make('Admin.contract_list')->with($data);
            }
        } else {
            $notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'warning');
            return Redirect::to('home')->with($notification);
        }
    }


    /**
    *
    * Show Currency List
    *
    */
	
	public function users_log(){
		
		$data = array();

        $u_id = Session::get('user_id');
        $u_type = Session::get('user_type');
        
        $array = array();

        if ($u_id !='' && $u_type == 1) {
			$userlog = DB::table('a_users_log')->get();
			
			foreach($userlog as $row){
				$users = DB::table('a_users')->select('user_name')->where('id',$row->user_id)->where('user_type', "2")->get();
				
				foreach($users as $u)
				
				$array[] = array(
					"username"=>$u->user_name,
					"session_code"=> $row->session_code,
					"in_time"=> $row->in_time,
					"os"=> $row->os,
					"user_agent"=> $row->user_agent,
					"out_time"=> $row->out_time,
				);
			}
			
			$data = array("userlog_history" => $array);
			 return View::make('Admin.user_log')->with($data);
		
		} else {
			$notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
		}
	}
	
    public function currencyList() {

        $login=$this->loginchk();
        
        if ($login == 'true') {
            $data = array();
            $currency = DB::table('a_currency_list')->get();
            // echo "<pre>"; print_r($currency);

            $data['currency'] = $currency;

            return View::make('Admin.currency_list')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }       

    }

     /**
    *
    * Show Withdraw List
    *
    */

     public function withdrawList(){
        $login=$this->loginchk();
        
        if ($login == 'true') {
            $data = array();
            $array = array();
            $array2 = array();
            
            // $withdraw = DB::table('a_withdraw_list')->where('status','1')->get();
            $withdraw = DB::table('a_withdraw_list')->get();
            // $withdraw2 = DB::table('a_withdraw_list')->where('status','4')->get();
            
            if (count($withdraw)>0) {
                foreach ($withdraw as $row) {
                    $user = DB::table('a_users')->where('id',$row->user_id)->get();
                    $coin = DB::table('a_coin_info')->where('id',$row->coin_id)->get();
                    foreach ($user as $u) { }
                    foreach ($coin as $c) { }

                    $array[] = array(
                        'withdraw_id' => $row->id,
                        'user_name' => $u->user_name,
                        'email' => $u->email,
                        'mobile' => $u->mobile,
                        'from' => $row->from_address,
                        'to' => $row->to_address,
                        'amount' => $row->amount,
                        'coin_label' => $c->label,
                        'coin_name' => $c->name,
                        'date' => $row->created_date,
                        'status' => $row->status,
                    );
                }                
            }

            // if (count($withdraw2)>0) {
            //     foreach ($withdraw2 as $row2) {
            //         $user2 = DB::table('a_users')->where('id',$row2->user_id)->get();
            //         $coin2 = DB::table('a_coin_info')->where('id',$row2->coin_id)->get();
            //         foreach ($user2 as $u2) { }
            //         foreach ($coin2 as $c2) { }

            //         $array[] = array(
            //             'withdraw_id' => $row2->id,
            //             'user_name' => $u2->user_name,
            //             'email' => $u2->email,
            //             'mobile' => $u2->mobile,
            //             'from' => $row2->from_address,
            //             'to' => $row2->to_address,
            //             'amount' => $row2->amount,
            //             'coin_label' => $c2->label,
            //             'coin_name' => $c2->name,
            //             'date' => $row2->created_date,
            //         );
            //     }
            // }

            $data['request'] = $array;
            // $data['accepted'] = $array2;

            
            return View::make('Admin.withdraw_list')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }
     }

      /**
    *
    * Show Crypto Coin List
    *
    */

     public function coinList(){

        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = array();
            $crypto = DB::table('a_coin_info')->get();

            $data['crypto'] = $crypto;
            return View::make('Admin.crypto_list')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

     }
    /**
     * Store a newly created Crypto Coin in Database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addNewCoin(Request $request)
    {   

        $uid = Session::get('user_id');

        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = $request->all();
            $c_name = $data['coin_name'];
            $c_label = $data['coin_label'];
          //  $fees = $data['fees'];
            $cont_address = $data['contract_address'];
            $desc = $data['description'];

            $array = array(
                'logo' => strtoupper($c_label).'.png',
                'label' => strtoupper($c_label),
                'name' => ucfirst($c_name),
                'description' => $desc,
                'contract_address' => $cont_address,
                'type' => 'coin',
             //   'fees' => $fees,
                'status' => '1',
                'created_by' => $uid,
                'created_date' => date('Y-m-d H:i:s'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $Check = DB::table('a_coin_info')->insertGetId($array);
            
            if ($Check) {

                $notification = array(
                            'message' => 'Coin Successfully Added!',
                            'alert-type' => 'success'
                    );
                return Redirect::back()->with($notification);
            }
            
            return $array;
        } 
        else {

            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);

        }
    }


    
    /**
     * Site Config 
     *
     * @param
     * @return \Illuminate\Http\Response
     */

    public function site_config(){
       
        $data = array();
        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = array();
            $select = DB::table('a_site_config')->get();
            $data['site_config'] = $select;

            return View::make('Admin.site_config')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

    }

    public function siteconfig_edit($id=''){
        $data = array();
        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = array();
            $select = DB::table('a_site_config')->where('id', $id)->get();
            $data['site_config'] = $select;
            
            return View::make('Admin.site_edit')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }
    }

    public function editsiteconfig(){
        $data = Input::all();
        $login=$this->loginchk();
        
        if ($login == 'true') {

            if ($data['_token'] != '') {
                
                $array = array(
                    'label' => $data['label'],
                    'value' => $data['vaule'],
                    'remarks' => $data['remarks'],
                );

                $select = DB::table('a_site_config')->where('id', $data['cid'])->update($array);
                
                if ($select) {
                    $notification = array(
                            'message' => 'Successfully updated!', 
                            'alert-type' => 'success'
                        );
                    return Redirect::back()->with($notification);
                }
                else {
                    $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                    return Redirect::back()->with($notification);
                }

            } 
            else {
                $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                return Redirect::back()->with($notification);
            }
        }
        else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

        
    }

    /**
     * Affiliate List
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function afilliate_list(){
        
        $data = array();
        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = array();
            
            $select = DB::table('a_affiliate_list')->get();
            if(count($select)>0) {
	            foreach ($select as $row) {

	                $u_id = $row->user_id;
	                $ref_user = $row->source;

	                $user1 = DB::table('a_users')->where('id', $u_id)->get();
	                $user2 = DB::table('a_users')->where('id', $ref_user)->get();
	                
	                foreach ($user1 as $u1) { }
	                foreach ($user2 as $u2) { }
	                
	                $array[] = array(
	                    'id' => $row->id,
	                    'username' => $u1->user_name,
	                    'ref_username' => $u2->user_name,
	                    'transaction' => $row->transaction,
						'claim' => $row->claim,
	                    'value' => $row->value,
	                    'payment' => $row->payment,
	                    'hash' => $row->hash,
	                );
	            }
	        } else {
	        	$array = array();
	        }
            $data['affiliate'] = $array;
            
            return View::make('Admin.afilliate_list')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }


    }   

    public function approve_affiliate($id=''){
        
        $login=$this->loginchk();
        if ($login == 'true') {                

                $select = DB::table('a_affiliate_list')->where('id', $id)->get();
                 $user_id = $select[0]->user_id;
                 $claim_val = $select[0]->value;

                 // echo $user_id; exit;
// USD to BTC Convert               
				$url1 = 'https://free.currencyconverterapi.com/api/v6/convert?q=USD_BTC&compact=ultra&apiKey=7ffdebad767d5d7ac75f';
				$ch1 = curl_init();
				curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch1, CURLOPT_URL,$url1);
				$result1 = curl_exec($ch1);
				curl_close($ch1);
				$live1 = json_decode($result1, true);
				
				if (empty($live1['USD_BTC']) && !isset($live1['USD_BTC'])) {
					$btc_val = 0.00011;
				} else {
					$btc_val = $live1['USD_BTC'];
				}

				$claim_bal = $claim_val*$btc_val;
// BTC Value
				// Get User BTC Balance from Wallet
				$wallet = DB::table('a_coin_wallet')->select('*')->where('coin_id','1')->where('user_id',$user_id)->get();

				if ($wallet[0]->balance == '') {
					$balance = 0 + $claim_bal;
				} else {
					$balance = $wallet[0]->balance + $claim_bal;
				}

				$array = array('balance' => $balance);
				
                if (count($wallet)>0) {
 					
 					$update = DB::table('a_coin_wallet')->select('*')->where('coin_id','1')->where('user_id',$user_id)->update($array);

                    if ($update) {

						$array2 = array(
							'payment' => '1',
						);

						DB::table('a_affiliate_list')->where('id', $id)->update($array2);

						$user = DB::table('a_users')->where('id',$user_id)->get();

						$to = $user[0]->email;
						$uname = $user[0]->user_name;


						$select = DB::table('a_site_config')->where('id',2)->get();
    					$authkey = $select[0]->value;

    					$from = "no-reply@crypscrow.com";
						$subject = "Approve your claim request";
						$body = "<body><h2>Hello ".$uname.",</h2><p> <br><b><u> Your claim request has been approved.</u></b> <br /> ".$claim_bal. " BTC credited in your crypscrow wallet. <br /></p><p><b>Thank you,</b></p><p><b>Crypscrow</b></p></body>";
						
						$url = "http://control.msg91.com/api/sendmail.php?authkey=".$authkey."&from=".$from."&to=".$to."&subject=".$subject."&body=".$body;

						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => $url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "POST",
						  CURLOPT_POSTFIELDS => "",
						  CURLOPT_SSL_VERIFYHOST => 0,
						  CURLOPT_SSL_VERIFYPEER => 0,
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
						  echo "cURL Error #:" . $err;
						} else {
						  echo $response;
						}

						$res = json_decode($response,true);



                    	$notification = array(
                            'message' => 'Claim Approved Successfully!', 
                            'alert-type' => 'success'
                        );
                    	return Redirect::to('admin/afilliate-list')->with($notification);
                    } else {
                    	$notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                    	return Redirect::to('admin/afilliate-list')->with($notification);
                    }                    
                } else {
                    $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                    return Redirect::to('admin/afilliate-list')->with($notification);
                }

        } else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

    }


    /**
     * Accept User Withdrawal Request
     *
     * @param
     * @return \Illuminate\Http\Response
     */

    public function acceptwithdraw($id='') {
        
        $data = array();
        $login = $this->loginchk();
        
        $select = DB::table('a_withdraw_list')->where('id', $id)->get();
        
        if (count($select)>0) {
            foreach ($select as $wdr) {
                $to_address = $wdr->to_address;
                $amount = $wdr->amount;
                $coin_id = $wdr->coin_id;
                $user_id = $wdr->user_id;
            }
            $coin = DB::table('a_coin_info')->where('id',$coin_id)->get();
            $address = DB::table('a_address')->where('user_id',$user_id)->where('coin_id', $coin_id)->first();
            
            foreach ($coin as $c) {}
            $cointype = $c->label;
            
            if ($cointype == 'BTC') {

            $url = "http://159.89.44.224:3000/sendbtc/".$address->address.'/'.$address->private_key.'/'.$to_address."/".$amount;
            }
            else if ($cointype == 'ETH') {
                $url = "http://159.89.44.224:3000/sendeth/".$address->address.'/'.$address->private_key.'/'.$to_address."/".$amount;
            } 
            
            // print_r($address); exit;

            if (!empty($url)) {
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL,$url);
                $result = json_decode(curl_exec($ch), true);
                curl_close($ch);
                
                if ($result != NULL || $result != '') {

                   $updateArr = array(
                        'tx_hash' => $result,
                        'status' => '4',
                        'modified_by' => '1',
                        'modified_date' => date("Y-m-d H:i:s"),
                        'modified_ip' => $_SERVER['REMOTE_ADDR'],
                    );
                   $check = DB::table('a_withdraw_list')->where('id',$id)->update($updateArr);
                  
                    $notification = ['message' => 'Successfully withdrawn.',
                        'alert-type' => 'success'];
                    return Redirect::back()->with($notification);              
                }
                else {
                    $notification = ['message' => 'Sorry! Request Failed.',
                            'alert-type' => 'error'];
                    return Redirect::back()->with($notification);
                }
            } 
            else {
                $notification = array(
                        'message' => 'Sorry! Request Failed.',
                        'alert-type' => 'error'
                    );
                return Redirect::back()->with($notification);
            }
        }
        else {
            $notification = array('message' => 'Oops! Request Not Found.', 'alert-type' => 'error');
            return Redirect::to('home')->with($notification);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function affiliate_edit($id=''){
        
        $data = array();
        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = array();
            $select = DB::table('a_affiliate_list')->where('id', $id)->get();
            $data['affiliate'] = $select;
            
            // print_r($data);

            return View::make('Admin.affiliate_edit')->with($data);

        } else {
           $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

    }


    public function editaffiliate(){
        
        $data = Input::all();
        $login=$this->loginchk();
        
        if ($login == 'true') {

            if ($data['_token'] != '') {
                
                $array = array(
                    'payment' => $data['payment'],
                    'hash' => $data['hash'],
                );

                $select = DB::table('a_affiliate_list')->where('id', $data['af_id'])->update($array);
                
                if ($select) {

                    $notification = array(
                            'message' => 'Successfully updated!', 
                            'alert-type' => 'success'
                        );
                    return Redirect::to('admin/afilliate-list')->with($notification);
                }
                else {
                    $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                    return Redirect::to('admin/afilliate-list')->with($notification);
                }

            } 
            else {
                $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                return Redirect::back('admin/afilliate-list')->with($notification);
            }
        }
        else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

    }

    public function pages(){

        $data = Input::all();
        $login=$this->loginchk();
        
        if ($login == 'true') {
            $data = array();
            $page = DB::table('a_site_pages')->get();            
            $data['pages'] = $page;

            return View::make('Admin.pages')->with($data);

        } else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }
    }

    public function edit_page($pageid = ''){
        
        $data = Input::all();
        $login=$this->loginchk();
        
        if ($login == 'true') {
            $data = array();
            $page = DB::table('a_site_pages')->where('id', $pageid)->get();            
            $data['page'] = $page;
           
            return View::make('Admin.edit_page')->with($data);

        } else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }

    }

    public function pageedit(){
        $uid = Session::get('user_id');
        $data = Input::all();
        $login=$this->loginchk();
        if ($login == 'true') {

            if ($data['_token'] != '') {

            $pageid = $data['page_id'];
            
            $array = array(
               'name' => $data['name'],
                'body' => $data['body'],
                'title' => $data['title'],
               'keyword' => $data['keyword'],
               'modified_by' => $uid,
               'modified_date' => date('Y-m-d H:i:s'),
               'modified_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $check = DB::table('a_site_pages')->where('id', $pageid)->update($array);
                
                if ($check) {
                    $notification = array(
                            'message' => 'Successfully Update Page.', 
                            'alert-type' => 'success'
                        );
                    return Redirect::back()->with($notification);
                } else {
                    $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                   return Redirect::back()->with($notification);
                }
            
            }
            else {

                $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                return Redirect::back('admin/afilliate-list')->with($notification);
            }
        } 
        else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }
    }

    public function dispute_info($contract_id) {
        $uid = Session::get('user_id');
        
        $login=$this->loginchk();
        if ($login == 'true') {
            $contract = DB::table('a_contract')->where(array('id' => $contract_id, 'despute' => '2'))->first();

            if ($contract != '') {
                $offer = DB::table('a_offers')->where('id', $contract->offer_id)->first();
                $dispute = DB::table('a_dispute')->where('contract_id', $contract_id)->first();
                $coin = DB::table('a_coin_info')->where('id', $contract->coin_id)->first();
                $currency = DB::table('a_currency_list')->where('id', $contract->currency_id)->first();
                
                if ($dispute != '') {
                    $dispute_info = DB::table('a_dispute_info')->where('dispute_id', $dispute->id)->get();

                    if ($offer->type_id == '14') {
                        $offer_type = 'Buy_Offer';
                        $buyer_id = $contract->to_user;
                        $seller_id = $contract->from_user;
                    }
                    if ($offer->type_id == '15') {
                        $offer_type = 'Sell_Offer';
                        $buyer_id = $contract->from_user;
                        $seller_id = $contract->to_user;
                    }

                    $buyer = DB::table('a_users')->where('id', $buyer_id)->first();
                    $seller = DB::table('a_users')->where('id', $seller_id)->first();

                    $data['buyer_id']=$buyer_id;
                    $data['buyer_info']=$buyer;
                    $data['seller_id']=$seller_id;
                    $data['seller_info']=$seller;
                    $data['contract']=$contract;
                    $data['offer']=$offer;
                    $data['dispute']=$dispute;
                    $data['dispute_info']=$dispute_info;
                    $data['coin_info']=$coin;
                    $data['currency']=$currency->short;
                    $data['user_id']= $uid;
                    $data['username']= Session::get('user_name');

                    // print_r($data); exit;
                    return View::make('Admin/dispute-info')->with($data);
                } else {
                    $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                    return Redirect::to('admin/contract-list')->with($notification);
                } 
            } else {
                $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
                return Redirect::to('admin/contract-list')->with($notification);
            }
        } else {
            $notification = array(
                            'message' => 'Error occured, Please try again', 
                            'alert-type' => 'warning'
                        );
            return Redirect::to('home')->with($notification);
        }
    }

    public function contract_approve() {
        $uid = Session::get('user_id');
        $post = Input::all();
        $login=$this->loginchk();
        if ($login == 'true') {

            if (empty($post['approval'])|| empty($post['contract_id']) || empty($post['_token'])) {
                $notification = array( 'message' => 'Validation error, Please try again', 'alert-type' => 'error' );
                return Redirect::back()->with($notification);
            } else {
               
                if($post['approval'] == '1') {
                    // Execute contract
                    $co_status = '19';
                    $tr_status = '1';
                    $message = "Successfully! Executed trade successfully.";
                } elseif ($post['approval'] == '2') {
                    // Cancel contract
                    $co_status = '18';
                    $message = "Successfully! Cancelled trade successfully.";
                    $tr_status = '2';
                } else {
                    $notification = array( 'message' => 'Error occured, Please try again', 'alert-type' => 'error' );
                    return Redirect::back()->with($notification);
                }

                $contract = DB::table('a_contract')->where(array('id' => $post['contract_id'], 'despute' => '2'))->first();
                if(!empty($contract)) {

                    if ($contract->co_status == '16' || '17') {
                        $array = array(
                            'tr_status' => $tr_status,
                            'co_status' => $co_status,
                            'modified_by' => $uid,
                            'modified_date' => date("Y-m-d H:i:s"),
                            'modified_ip' => $_SERVER['REMOTE_ADDR'],
                         );
                         $select = DB::table('a_contract')->where('id', $post['contract_id'])->update($array);
                         if ($select) {
                            $notification = array( 'message' => $message, 'alert-type' => 'success' );
                            return Redirect::back()->with($notification);
                         } else {
                            $notification = array( 'message' => 'Error occured, Please try again', 'alert-type' => 'error' );
                            return Redirect::back()->with($notification);
                         }
                    } else {
                        $notification = array( 'message' => 'Error occured, Please try again', 'alert-type' => 'error' );
                        return Redirect::back()->with($notification);
                    }
                } else {
                    $notification = array( 'message' => 'Error occured, Please try again', 'alert-type' => 'error' );
                    return Redirect::back()->with($notification);
                }
            }
        } else {
            $notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'warning');
            return Redirect::to('home')->with($notification);
        }
    }

    public function dispute_chat() {       
        $uid = Session::get('user_id');
        $post = Input::all();
        $user = DB::table('a_users')->where('id',$uid)->first();
        $array = array(
                "dispute_id" => $post['dispute_id'],
                "type" => $user->user_type,
                "user_id" => $uid,
                'message' => $post['message'],
                //'file' => $file1,
                "status" => "1",
                "created_by" => $uid,
                "created_date" =>  date("Y-m-d H:i:s"),
                'created_ip' => $_SERVER['REMOTE_ADDR']
        );
        $chk = DB::table('a_dispute_info')->insertGetId($array);

        if ($chk == '') {
            echo json_encode(array('status'=>'2', 'message'=>"Sorry! Message not send."));
        } else {
            echo json_encode(array('status'=>'1', 'message'=>"Successfully! Message send."));
        }        
    }

    public function getdisputchat(){
        $data = array();
        $uid = Session::get('user_id');
        $dispute_id = Input::get('dispute_id');
        $dispute = DB::table('a_dispute')->where('id', $dispute_id)->first();
        $dispute_info = DB::table('a_dispute_info')->where('dispute_id', $dispute_id)->get();
        $contract = DB::table('a_contract')->where('id', $dispute->contract_id)->first();
        $offer = DB::table('a_offers')->where('id', $contract->offer_id)->first();
        if ($offer->type_id == '14') {
            $offer_type = 'Buy_Offer';
            $buyer_id = $contract->to_user;
            $seller_id = $contract->from_user;
        }
        if ($offer->type_id == '15') {
            $offer_type = 'Sell_Offer';
            $buyer_id = $contract->from_user;
            $seller_id = $contract->to_user;
        }
        $buyer = DB::table('a_users')->where('id', $buyer_id)->first();
        $seller = DB::table('a_users')->where('id', $seller_id)->first();
        $data['buyer_info']=$buyer;
        $data['seller_info']=$seller;
        $data['dispute_info']=$dispute_info;
        return View::make('Admin/getchat-dispute')->with($data);
    }

    public function wallet(){
        $uid = Session::get('user_id');
        $login=$this->loginchk();

        if ($login == 'true') {
            $data = array();
            $array = array();

            $coins = DB::table('a_coin_info')->select('id','logo', 'name','label','contract_address')->get();
            $contracts = DB::table('a_contract')->select('id','coin_id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->get();            
            $withdraw = DB::table('a_withdraw_list')->select('amount')->where(array('user_id' => $uid))->get();

            $eth_wallet = DB::table('a_coin_wallet')->select('id','coin_id','user_id','address')->where(array('user_id' => $uid, 'coin_id' => '2'))->first();

             $wallets = DB::table('a_coin_wallet')->select('id','coin_id','user_id','address','type','balance')
             ->where(array('user_id' => $uid))->get();

            foreach ($coins as $coin) {
                $feesArr=array(0);
                $lockArr=array(0);
                $withdrawArr=array(0);
                $update = '';
                if ($coin->id =='1' || $coin->id =='2' || $coin->id =='3') {
                        
                        if ($coin->id =='1') {
                            $update = "/btcupdate";
                        } elseif( $coin->id =='2') {
                            $update = "/ethupdate";
                        } else if($coin->id =='3') {
                            $update = "/ltcupdate";
                        }

                        foreach ($wallets as $wallet) {
                            if($wallet->coin_id == $coin->id) {
                                if(count($contracts)>0) {
                                    foreach ($contracts as $crow) {
                                        if($wallet->coin_id == $crow->coin_id){
                                            if ($crow->co_status == 17) {
                                                // Contract pending
                                                array_push($lockArr,number_format($crow->fees, 18, '.', ''));
                                                array_push($lockArr,number_format($crow->fees2, 18, '.', ''));
                                            } elseif ($crow->co_status == 19){
                                                // Contract executed.
                                                array_push($feesArr,number_format($crow->fees, 18, '.', ''));
                                                array_push($feesArr,number_format($crow->fees2, 18, '.', ''));
                                            }
                                        }
                                    }                   
                                }

                                // Withdraw(Debit) balance info
                                if (count($withdraw)>0) {
                                    foreach ($withdraw as $wrow) {
                                        if($wallet->coin_id == $wrow->coin_id) {
                                            array_push($withdrawArr,$wrow->amount);
                                        }
                                    }
                                }
                                
                                if ($wallet->balance == '') {
                                    $balance = 0;
                                } else {
                                    $balance = $wallet->balance;
                                }

                                array_push($feesArr,$balance);
                                $fees_balance  = number_format(array_sum($feesArr), 18, '.', '');
                                $lock_balance  = number_format(array_sum($lockArr), 18, '.', '');
                                $withdraw_balance  = number_format(array_sum($withdrawArr), 18, '.', '');

                                // $array[$coin->label]
                                $array[] = array(
                                    'id' => $wallet->id,
                                    'coin_id' => $wallet->coin_id,
                                    'user_id' => $wallet->user_id,
                                    'address' => $wallet->address,
                                    'type' => 'Coin',
                                    'coin_label' => $coin->label,
                                    'coin_name' => $coin->name,
                                    'lock_balance' => $lock_balance,
                                    'avalable_balance' => number_format($fees_balance-$withdraw_balance, 18, '.',''),
                                    'withdraw_balance' => $withdraw_balance,
                                    'live_balance' => number_format($balance, 18, '.',''),                               
                                    'update' => $update,                               
                                );
                            }
                        }
                        
                }
                else {
                    $update = '/tokenupdate/'.$coin->id;

                    // Withdraw(Debit) balance info
                    if (count($withdraw)>0) {
                        foreach ($withdraw as $wrow) {
                            if($coin->id == $wrow->coin_id) {
                                array_push($withdrawArr,$wrow->amount);
                            }
                        }
                    }
                    $withdraw_balance  = array_sum($withdrawArr);

                    if(count($contracts)>0) {
                        foreach ($contracts as $crow) {
                            if($coin->id == $crow->coin_id){
                                if ($crow->co_status == 17) {
                                    // Contract pending
                                    array_push($lockArr,(float)$crow->fees);
                                    array_push($lockArr,(float)$crow->fees2);
                                } elseif ($crow->co_status == 19){
                                    // Contract executed.
                                    array_push($feesArr,(float)$crow->fees);
                                    array_push($feesArr,(float)$crow->fees2);                                   
                                }
                            }
                        }                   
                    }


                    // Get erc token live balance
                    $url = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$coin->contract_address."&address=".$eth_wallet->address."&tag=latest";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL,$url);
                    $result = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    
                    if ($result['status'] == 1) {
                        $balance = $result['result']/1000000000000000000;
                    } else {
                        $balance = 0;
                    }

                    array_push($feesArr,$balance);
                    $fees_balance  = number_format(array_sum($feesArr), 18, '.', '');
                    $lock_balance  = number_format(array_sum($lockArr), 18, '.', '');
                    $withdraw_balance  = number_format(array_sum($withdrawArr), 18, '.', '');

                    // $array['token'][] 
                    $array[] = array(
                        'id' => $eth_wallet->id,
                        'coin_id' => $coin->id,
                        'user_id' =>  $uid,
                        'address' => $eth_wallet->address,                        
                        'type' => 'Token',
                        'coin_label' => $coin->label,
                        'coin_name' => $coin->name,
                        'lock_balance' => $lock_balance,
                        'avalable_balance' => number_format($fees_balance-$withdraw_balance, 18, '.',''),
                        'withdraw_balance' => $withdraw_balance,
                        'live_balance' => number_format($balance, 18, '.',''),
                        'update' => $update,
                    );
                }
            }
            $data['wallet'] = $array;
            $data['i'] = 1;
            // print_r($data); 
            // exit;
            return View::make('Admin/wallet')->with($data);

        } else {
            $notification = array( 'message' => 'Error occured, Please login your account.', 'alert-type' => 'error' );
            return Redirect::to('home')->with($notification);
        }
    }

    public function report_user_list(){
        $uid = Session::get('user_id');
        $login=$this->loginchk();
        if ($login == 'true') {

            $report_list = DB::table('a_report_user')->get();            
            $report_users = DB::table('a_report_user as r')
            ->join('a_users as to', 'to.id', '=', 'r.report_to')
            ->select('to.*', 'to.mobile','r.id as rid','r.report_to')
            ->orderBy('r.id','DESC')->groupBy('r.report_to')->get();            

            $array = array();
            if(count($report_users)>0) {
                foreach ($report_users as $user) {
                    $count = 0;
                     foreach ($report_list as $row) {
                        if ($row->report_to == $user->report_to) {
                            $count++;
                        }
                    }
                    $array[] = array(
                        'user_id' => $row->report_to,
                        'username' => $user->user_name,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'mobile' => $user->mobile,
                        'status' => $user->status,
                        'total' => $count,
                    );
                }
            }
            $data = array('reports' => $array, 'i' => 1);

            return View::make('Admin/report_user')->with($data);

        } else { 
            $notification = array( 'message' => 'Error occured, Please login your account.', 'alert-type' => 'error' );
            return Redirect::to('home')->with($notification);   
        }
    }



    public function PaymentMethod(){
        
        $payment_methods = DB::table('a_payment_mode')->where('status','1')->orderBy('id','asc')->get();
        // echo "<pre>"; print_r($payment_methods); exit;

        return view('Admin.payment_method_list', compact('payment_methods'));
    }

    public function addNewPaymentMethod() {
        return view('Admin.add_payment_method');
    }
    public function editPaymentMethod($id) {
        $payment_method = DB::table('a_payment_mode')->where('id', $id)->first();
        return view('Admin.edit_payment_method', compact('payment_method'));
    }

    public function deletePaymentMethod($id) {
        
        $uid = Session::get('user_id');

        $login=$this->loginchk();
        
        if ($login == 'true') {
            $array = array(
                'status' => '3',
                'modified_by' => $uid,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_ip' => $_SERVER['REMOTE_ADDR'],
            );

            if ($id != '') {
                $payment = DB::table('a_payment_mode')->where('id', $id)->first();

                if ($payment != '') {
                    
                    $Check = DB::table('a_payment_mode')->where('id', $id)->update($array);
                    
                    if ($Check) {
                        $notification = array(
                                'message' => 'Payment Method Delete Successfully!',
                                'alert-type' => 'success'
                        );
                        return Redirect::back()->with($notification);
                    }
                    else {
                        $notification = array(
                            'message' => 'Error occured, Please try again',
                            'alert-type' => 'danger'
                        );
                        return Redirect::to('home')->with($notification);
                    }
                }
                else {
                    $notification = array(
                    'message' => 'Payment Method Not Found', 
                    'alert-type' => 'danger'
                );

                return Redirect::to('home')->with($notification);
                }
            }
            else {
                $notification = array(
                    'message' => 'Error occured, Please try again', 
                    'alert-type' => 'warning'
                );
                return Redirect::to('home')->with($notification);
            }
        }

        else {
            $notification = array(
                'message' => 'Error occured, Please try again', 
                'alert-type' => 'warning'
            );
            return Redirect::to('home')->with($notification);
        }
    }
    // Add Payment Method
    public function savePaymentMethod(Request $request) {

        $uid = Session::get('user_id');

        $login=$this->loginchk();
        
        if ($login == 'true') {

            $data = $request->all();
            
            $array = array(
                'name' => ucfirst($data['name']),
                'description' => $data['description'],
                'local' => $data['local'],
                'remarks' => $data['remarks'],
                'status' => '1',
                'created_by' => $uid,
                'created_date' => date('Y-m-d H:i:s'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );

            if (isset($data['add'])) {
                $Check = DB::table('a_payment_mode')->insertGetId($array);
                $message = 'Payment Method Successfully Added.';
            }
            else {
                $Check = DB::table('a_payment_mode')->where('id', $data['id'])->update($array);
                $message = 'Payment Method Successfully Updated.';
            }

            
            if ($Check) {
                $notification = array(
                        'message' => $message,
                        'alert-type' => 'success'
                );
                return Redirect::back()->with($notification);
            }
            else {
                $notification = array(
                    'message' => 'Error occured, Please try again',
                    'alert-type' => 'danger'
                );
                return Redirect::to('home')->with($notification);
            }
            
            return $array;
        } 
        else {

            $notification = array(
                'message' => 'Error occured, Please try again', 
                'alert-type' => 'warning'
            );
            return Redirect::to('home')->with($notification);

        }
    }


}
