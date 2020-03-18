<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use Input;
use DB;
use Redirect;
use Alert;
use Illuminate\Support\Facades\Mail;
use Location;
use Session;
use Cookie;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Routing\UrlGenerator;
use Exception;
use Torann\GeoIP\Support\HttpClient;
use Torann\GeoIP\Services\AbstractService;
use Storage;
use Image;
// use Illuminate\Support\Facades\Validator;
use Validator;


class MainController extends Controller {
   
	protected $url;
	protected $client;
	

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
    }

    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
       
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {

                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

	public function index() {

		// Get Current Location by IP Address
		// $ip = $_SERVER['REMOTE_ADDR'];
  		//   	$current_location  = file_get_contents("http://ipinfo.io/".$ip."/geo");
		// $live  =  json_decode($current_location, true);
		$live = $this->ip_info();

		/// GET BUY OFFERS
		$data['buy_offer']  = DB::table('a_offers as offer')
            ->join('a_users as user', 'user.id', '=', 'offer.user_id')
            ->join('a_currency_list as currency', 'currency.id', '=', 'offer.currency_id')
            ->join('a_payment_mode as payment', 'payment.id', '=', 'offer.mode_id')
            ->join('a_coin_info as coin', 'coin.id', '=', 'offer.coin_id')
            ->select('offer.id as offer_id','offer.type_id','offer.min','offer.max','offer.trade','offer.location','user.user_name','user.email', 'user.id as user_id','currency.short','currency.rate','payment.name as payment_mode','coin.price as coinprice','coin.label')
            ->where(['offer.type_id'=>'14','offer.status'=>'1'])->limit(5)
            ->orderBy('offer.id','desc')->get();

		/// GET SELL OFFERS
		$data['sell_offer']  = DB::table('a_offers as offer')
            ->join('a_users as user', 'user.id', '=', 'offer.user_id')
            ->join('a_currency_list as currency', 'currency.id', '=', 'offer.currency_id')
            ->join('a_payment_mode as payment', 'payment.id', '=', 'offer.mode_id')
            ->join('a_coin_info as coin', 'coin.id', '=', 'offer.coin_id')
            ->select('offer.id as offer_id','offer.type_id','offer.min','offer.max','offer.trade','offer.location','user.user_name','user.email', 'user.id as user_id','currency.short','currency.rate','payment.name as payment_mode','coin.price as coinprice','coin.label')
            ->where(['offer.type_id'=>'15','offer.status'=>'1'])->limit(5)
            ->orderBy('offer.id','desc')->get();

        /// GET LOCATION SELL OFFERS
		$data['location_sell_offer']  = DB::table('a_offers as offer')
            ->join('a_users as user', 'user.id', '=', 'offer.user_id')
            ->join('a_currency_list as currency', 'currency.id', '=', 'offer.currency_id')
            ->join('a_payment_mode as payment', 'payment.id', '=', 'offer.mode_id')
            ->join('a_coin_info as coin', 'coin.id', '=', 'offer.coin_id')
            ->select('offer.id as offer_id','offer.type_id','offer.min','offer.max','offer.trade','offer.location','user.user_name','user.email', 'user.id as user_id','currency.short','currency.rate','payment.name as payment_mode','coin.price as coinprice','coin.label')
            ->where(['offer.type_id'=>'15','offer.mode_id'=> '1','offer.status'=>'1'])
            ->where('offer.location', 'like', '%'.$live['state'].'%')
            ->limit(5)->orderBy('offer.id','desc')->get();

        /// GET LOCATION BUY OFFERS
		$data['location_buy_offer']  = DB::table('a_offers as offer')
            ->join('a_users as user', 'user.id', '=', 'offer.user_id')
            ->join('a_currency_list as currency', 'currency.id', '=', 'offer.currency_id')
            ->join('a_payment_mode as payment', 'payment.id', '=', 'offer.mode_id')
            ->join('a_coin_info as coin', 'coin.id', '=', 'offer.coin_id')
            ->select('offer.id as offer_id','offer.type_id','offer.min','offer.max','offer.trade','offer.location','user.user_name','user.email', 'user.id as user_id','currency.short','currency.rate','payment.name as payment_mode','coin.price as coinprice','coin.label')
            ->where(['offer.type_id'=>'14','offer.mode_id'=> '1','offer.status'=>'1'])
            ->where('offer.location', 'like', '%'.$live['state'].'%')
            ->limit(5)->orderBy('offer.id','desc')->get();

        $data['live'] = $live;

		return View::make('main')->with($data);;
	}
	
	
	public function otpverify(Request $request){
		
		$data = Input::all();
		
		if($data['_token']=="") { 
			$notification = array('message' => 'Bad request', 'alert-type' => 'warning');
			return Redirect::to('offer/'.$data['oid'])->with($notification);
		} else {
			$uid = $data['user_id'];
			$otp = $data['otp'];
			
			$select_otp = DB::table('a_otp_list')->where('user_id',$uid)->where('otp',$otp)->get();
			
			if(count($select_otp)>0){
				$user = DB::table('a_users')->where('id',$uid)->get();
				
				if(count($user)>0){
					
					$email = $user[0]->email;
					$uname = $user[0]->user_name;
					$user_type = $user[0]->user_type;
					
					$code = md5(mt_rand(100000, 999999));
					$request->session()->put('user_id', $user[0]->id);
					$request->session()->put('session_code', $code);
					$request->session()->put('user_type', $user[0]->user_type);
					$request->session()->put('user_name', $user[0]->user_name);
					$request->session()->put('lastActivityTime', time());
					
					$session_id = Session::get('session_code');
					$userAgent = $request->server('HTTP_USER_AGENT');

					$dd = new DeviceDetector($userAgent);
					$dd->parse();
					$osInfo = $dd->getOs();

					$array = array(
						"user_id" => $uid,
						"session_code" => $session_id,
						"in_time" => date("Y-m-d H:i:s"),
						"os" => $osInfo['name']." ".$osInfo['version']. " ". $osInfo['platform'],
						"user_agent" => $request->server('HTTP_USER_AGENT'),
						"status" => "1",
						"created_by" => $user[0]->id,
						"created_date" => date("Y-m-d H:i:s"),
						"created_ip" => $request->ip(),
					);
					
					$check = DB::table('a_users_log')->insertGetId($array);
					DB::table('a_otp_list')->where('user_id',$uid)->where('otp',$otp)->update(array('status' => '2'));
					
					if($check) { 
						$site_conf = DB::table('a_site_config')->where('id',2)->get();
						$authkey = $site_conf[0]->value;
						$to = $email;
						$from = "no-reply@crypscrow.com";							
						$subject = "Login Confirmation";
						$body = "<body> <h2>Dear ".$uname.",</h2><br><p>We noticed a recent login from your account. Please find below details of your login:</p><br><p>IP Address : ". $request->ip() ." <br>Date:".date('Y-m-d')."<br> Time:". date('H:i:s ') ." GMT</p><br><p>Thank you,</p><p>Team BitcoinNearMe</p></body>";

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
						$res = json_decode($response,true);

						$array3 = array(
			                'user_id'      => $uid,
			                'page'      => url('/').'otpverify/',
			                'from'      => $from,
			                'subject'      => $subject,
			                'to'      => $to,
			                'body' => $body,
			                'status'    => "1",
			                'created_by'  => $uid,
			                'created_date'  => date("Y-m-d H:i:s"),
			                'created_ip' => $_SERVER['REMOTE_ADDR']
		            	);
						
						$check3 = DB::table('a_mail_log')->insertGetId($array3);

						$notification = array('message' => 'Your Login is Successful','alert-type' => 'success');
						if ($user_type == 1) {							
							return Redirect::to('admin')->with($notification);
						} else {
							return Redirect::to('offers-buy')->with($notification);
						}
					}
				}
			}
			else{
				$notification = array('message' => 'It Seems you have entered wrong OTP please try again.', 
					'alert-type' => 'error');
				return Redirect::to('login')->with($notification);
			}
		}
	}
   
   	public function offersbuy() {

   		$uid = Session::get('user_id'); 

   		$buy_offers = array();
   		$sell_offers = array();

   		$where = array('type_id'=>'14','status'=>'1');
   		$where2 = array('type_id'=>'15','status'=>'1');
   		
   		if ($uid != '') {
   			$select = DB::table('a_offers')->where($where)->whereNotIn('user_id', [$uid])->limit(8)->get();
			$select2 = DB::table('a_offers')->where($where2)->whereNotIn('user_id', [$uid])->limit(8)->get();
   		} 
   		else {
   			$select = DB::table('a_offers')->where($where)->limit(8)->get();
			$select2 = DB::table('a_offers')->where($where2)->limit(8)->get();
   		}
		
		foreach($select as $row){

		//	if($uid != $row->user_id){    // Offer Show to all where user logged in or not //  Changed by Vipul
					$coin_info = DB::table('a_coin_info')->where("id",$row->coin_id)->get();
					foreach($coin_info as $ci){}

					$user = DB::table('a_users')->where("id",$row->user_id)->get();
					foreach($user as $u){}

					$coin = DB::table('a_coin_info')->where("id",$row->coin_id)->get();
					foreach($coin as $c){}

					$type = DB::table('a_master_values')->where("id",$row->type_id)->get();
					foreach($type as $t){}	

					$mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
					foreach($mode as $m){}	

					$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
					foreach($currency as $cr){}		

					$contract = DB::table('a_contract')->where("from_user",$uid)->where('offer_id',$row->id)->get();

					if(count($contract)=="0")	{
						$result = "OK";
					} else {
						$result = "NOTOK";
					}

					$location = explode(",",$row->location);
					$cur = explode("USD",$cr->short);

					if($row->mark_id=="1"){
						$mark = "Above";
					} else {
						$mark = "Below";
					}

					$close = date("H:i", strtotime($row->close));
   					$open = date("H:i", strtotime($row->open));

						$buy_offers[] = array(
							"offer_id" => $row->id,
							"user_name" => $u->user_name,
							"coin" => $c->name,
							"type" => $t->name,
							"city" => isset($location[0]) ? $location[0] : '',
							"state" => isset($location[1]) ? $location[1] : '',
							"country" => isset($location[2]) ? $location[2] : '',
							"mode" => $m->name,
							"currency" => $cur[1],
							"coin_name" => $ci->name,
							"mark" => $mark,
							"mark_value" => $row->mark_value,
							"min" => $row->min,
							"max" => $row->max,
							"heading" => $row->headline,
							"open" => $row->open,
							"close" => $row->close,
							"result" => $result
				);
		}  

		foreach ($select2 as $row2) {
					$coin_info2 = DB::table('a_coin_info')->where("id",$row2->coin_id)->get();
					foreach($coin_info2 as $ci2){}

					$user2 = DB::table('a_users')->where("id",$row2->user_id)->get();
					foreach($user2 as $u2){}

					$coin2 = DB::table('a_coin_info')->where("id",$row2->coin_id)->get();
					foreach($coin2 as $c2){}

					$type2 = DB::table('a_master_values')->where("id",$row2->type_id)->get();
					foreach($type2 as $t2){}	

					$mode2 = DB::table('a_payment_mode')->where("id",$row2->mode_id)->get();
					foreach($mode2 as $m2){}	

					$currency2 = DB::table('a_currency_list')->where("id",$row2->currency_id)->get();
					foreach($currency2 as $cr2){}		

					$contract2 = DB::table('a_contract')->where("from_user",$uid)->where('offer_id',$row2->id)->get();

					if(count($contract2)=="0")	{
						$result2 = "OK";
					} else {
						$result2 = "NOTOK";
					}

					$location2 = explode(",",$row2->location);
					$cur2 = explode("USD",$cr2->short);

					if($row2->mark_id=="1"){
						$mark2 = "Above";
					} else {
						$mark2 = "Below";
					}

			$sell_offers[] = array(
						"offer_id" => $row2->id,
						"user_name" => $u2->user_name,
						"coin" => $c2->name,
						"type" => $t2->name,
						"city" => isset($location[0]) ? $location[0] : '',
						"state" => isset($location[1]) ? $location[1] : '',
						"country" => isset($location[2]) ? $location[2] : '',
						"mode" => $m2->name,
						"currency" => $cur2[1],
						"coin_name" => $ci2->name,
						"mark" => $mark2,
						"mark_value" => $row2->mark_value,
						"min" => $row2->min,
						"max" => $row2->max,
						"heading" => $row2->headline,
						"open" => $row2->open,
						"close" => $row2->close,
						"result" => $result2
					);
		}

		$coins = DB::table('a_coin_info')->get();
		$offertype = DB::table('a_master_values')->where('type_id','6')->get();
		$payment_method = DB::table('a_payment_mode')->get();
		
		$data = array("buy"=>$buy_offers,"sell"=>$sell_offers,"coins" => $coins, "offertype" => $offertype ,"payment_method" => $payment_method) ;
		
		return View::make('offers-buy')->with($data);
		
	}

   	public function offerssell() {       
   		
		$buy_offers = array();
   		$sell_offers = array();

   		$uid = Session::get('user_id'); 

		$select = DB::table('a_offers')->get();
		foreach($select as $row){

			if($uid!=$row->user_id){

				$user = DB::table('a_users')->where("id",$row->user_id)->get();
				foreach($user as $u){}

				$coin = DB::table('a_master_values')->where("id",$row->coin_id)->get();
				foreach($coin as $c){}

				$type = DB::table('a_master_values')->where("id",$row->type_id)->get();
				foreach($type as $t){}	

				$mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
				foreach($mode as $m){}	

				$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
				foreach($currency as $cr){}		

				$contract = DB::table('a_contract')->where("from_user",$uid)->where('offer_id',$row->id)->get();

				if(count($contract)=="0") {
					$result = "OK";
				} else {
					$result = "NOTOK";
				}

				$location = explode(",",$row->location);
				$cur = explode("USD",$cr->short);

				if($row->mark_id=="1"){
					$mark = "Above";
				} else {
					$mark = "Below";
				}

				if($row->type_id=="14"){

					$buy_offers[] = array(
						"offer_id" => $row->id,
						"user_name" => $u->user_name,
						"coin" => $c->name,
						"type" => $t->name,
						"city" => isset($location[0]) ? $location[0] : '',
						"state" => isset($location[1]) ? $location[1] : '',
						"country" => isset($location[2]) ? $location[2] : '',
						"mode" => $m->name,
						"currency" => $cur[1],
						"mark" => $mark,
						"mark_value" => $row->mark_value,
						"min" => $row->min,
						"max" => $row->max,
						"heading" => $row->headline,
						"result" => $result
					);

				} else {

					$sell_offers[] = array(
						"offer_id" => $row->id,
						"user_name" => $u->user_name,
						"coin" => $c->name,
						"type" => $t->name,
						"city" => isset($location[0]) ? $location[0] : '',
						"state" => isset($location[1]) ? $location[1] : '',
						"country" => isset($location[2]) ? $location[2] : '',
						"mode" => $m->name,
						"currency" => $cur[1],
						"mark" => $mark,
						"mark_value" => $row->mark_value,
						"min" => $row->min,
						"max" => $row->max,
						"heading" => $row->headline,
						"result" => $result
					);

				}

			}		

		}  

		$data = array("buy"=>$buy_offers,"sell"=>$sell_offers) ;


		return View::make('offers-sell')->with($data);
		
	}

	// All Sell Offers
	public function allSellOffers(){
		$uid = Session::get('user_id'); 

   		$sell_offers = array();
   		$where = array(
   			'type_id'=>'15',
   			'status'=>'1',
   		);
   		
   		if ($uid != '') {
   			$select = DB::table('a_offers')->where($where)->whereNotIn('user_id', [$uid])->get();
   		} 
   		else {
			$select = DB::table('a_offers')->where($where)->get();
   		}
   		$select = DB::table('a_offers')->where($where)->get();
   		foreach($select as $row){

			//	if($uid != $row->user_id){    // Offer Show to all where user logged in or not //  Changed by Vipul
   				$coin_info = DB::table('a_coin_info')->where("id",$row->coin_id)->get();
				foreach($coin_info as $ci){}
				
				$user = DB::table('a_users')->where("id",$row->user_id)->get();
				foreach($user as $u){}

				$coin = DB::table('a_master_values')->where("id",$row->coin_id)->get();
				foreach($coin as $c){}

				$type = DB::table('a_master_values')->where("id",$row->type_id)->get();
				foreach($type as $t){}	

				$mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
				foreach($mode as $m){}	

				$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
				foreach($currency as $cr){}		

				$contract = DB::table('a_contract')->where("from_user",$uid)->where('offer_id',$row->id)->get();

				if(count($contract)=="0")	{
					$result = "OK";
				} else {
					$result = "NOTOK";
				}

				$location = explode(",",$row->location);
				$cur = explode("USD",$cr->short);

				if($row->mark_id=="1"){
					$mark = "Above";
				} else {
					$mark = "Below";
				}

				$sell_offers[] = array(
					"offer_id" => $row->id,
					"user_name" => $u->user_name,
					"coin" => $c->name,
					"type" => $t->name,
					"city" => $location[0],
					"state" => $location[1],
					"country" => $location[2],
					"mode" => $m->name,
					"coin_name" => $ci->name,
					"currency" => $cur[1],
					"mark" => $mark,
					"mark_value" => $row->mark_value,
					"min" => $row->min,
					"max" => $row->max,
					"heading" => $row->headline,
					"open" => $row->open,
					"close" => $row->close,
					"result" => $result
				);
			// }
		}  

		$data = array(
			"sell" => $sell_offers
		);

		// return $data;

		return View::make('all-sell-offers')->with($data);

	}

	// All Sell Offers
	public function allBuyOffers(){
		
		$uid = Session::get('user_id'); 

   		$buy_offers = array();
   		$where = array(
   			'type_id'=>'14',
   			'status'=>'1',
   		);
   		if ($uid != '') {
   			$select = DB::table('a_offers')->where($where)->whereNotIn('user_id', [$uid])->get();
   		} 
   		else {
			$select = DB::table('a_offers')->where($where)->get();
   		}



   		foreach($select as $row){

		//	if($uid != $row->user_id){    // Offer Show to all where user logged in or not //  Changed by Vipul

   			$coin_info = DB::table('a_coin_info')->where("id",$row->coin_id)->get();
			foreach($coin_info as $ci){}

			// print_r($coin_info); exit;

			$user = DB::table('a_users')->where("id",$row->user_id)->get();
			foreach($user as $u){}

			$coin = DB::table('a_master_values')->where("id",$row->coin_id)->get();
			foreach($coin as $c){}

			$type = DB::table('a_master_values')->where("id",$row->type_id)->get();
			foreach($type as $t){}	

			$mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
			foreach($mode as $m){}	

			$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
			foreach($currency as $cr){}		

			$contract = DB::table('a_contract')->where("from_user",$uid)->where('offer_id',$row->id)->get();

			if(count($contract)=="0")	{
				$result = "OK";
			} else {
				$result = "NOTOK";
			}

			$location = explode(",",$row->location);
			$cur = explode("USD",$cr->short);

			if($row->mark_id=="1"){
				$mark = "Above";
			} else {
				$mark = "Below";
			}

				$buy_offers[] = array(
					"offer_id" => $row->id,
					"user_name" => $u->user_name,
					"coin" => $c->name,
					"type" => $t->name,
					"city" => isset($location[0]) ? $location[0] : '' ,
					"state" => isset($location[1]) ? $location[1] : '',
					"country" => isset($location[2]) ? $location[2] : '',
					"mode" => $m->name,
					"currency" => $cur[1],
					"coin_name" => $ci->name,
					"mark" => $mark,
					"mark_value" => $row->mark_value,
					"min" => $row->min,
					"max" => $row->max,
					"heading" => $row->headline,
					"open" => $row->open,
					"close" => $row->close,
					"result" => $result
				);

		}
		$data = array(
			"buy" => $buy_offers
		);
		// return $data;
		return View::make('all-buy-offers')->with($data);

	}
	
	public function contract() {
		
    	$offer = request()->segment(2);
    	
    	$uid = Session::get('user_id'); 

    	if($uid==""){
			
			return Redirect::to('login');

    	} else {

	    	$select = DB::table('a_offers')->where("id",$offer)->whereNotIn("user_id",[$uid])->get();

	    	if (count($select)>0) {

				foreach($select as $row){
					
					$user = DB::table('a_users')->where("id",$row->user_id)->get();
					foreach($user as $u){}
					
					$trades = DB::table('a_contract')->where(array("to_user"=>$row->user_id,"co_status"=>"17"))->count();
					
					$coin = DB::table('a_coin_info')->where("id",$row->coin_id)->get();
					foreach($coin as $c){}
					
		//echo "<pre>"; print_R($coin); exit;
		
					$type = DB::table('a_master_values')->where("id",$row->type_id)->get();

					foreach($type as $t){}	

					$mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
					foreach($mode as $m){}	

					$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
					foreach($currency as $cr){}		

					$location = explode(",",$row->location);
					if ($cr->short != "USDUSD") {
						$cur = explode("USD",$cr->short);
					}
					else {
						$cur[1] = "USD";
					}

					if($row->mark_id == "1"){
						$mark = "Above";
					} else {
						$mark = "Below";
					}

					if($row->type_id=="14"){
						$a = "Sell";
						$trader = "Seller";
						$trader1 = "Buyer";
					} 
					else if($row->type_id=="15") {
						$a = "Buy";
						$trader = "Buyer";
						$trader1 = "Seller";
					}
					
					$check = DB::table('a_coin_info')->where('id', $row->coin_id)->get();
					foreach($check as $row2){}

					$cname = $row2->label;

					// echo $row2->id;
				
					// GET LATEST COIN PRICE
					$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=7e7c8486-0798-417d-8fa2-755a26e16bf3';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_URL, $url);	
					$result = curl_exec($ch);
					curl_close($ch);
					$result = json_decode($result);


					if ($row2->id == "1") {
						$balance_update = 'btcupdate';
						$usd = $result->data[0]->quote->USD->price;
					} else if ($row2->id == "2") {
						$balance_update = 'ethupdate';
						$usd = $result->data[1]->quote->USD->price;
					} else if ($row2->id == "3") {
						$balance_update = 'ltcupdate';
						$usd = $result->data[4]->quote->USD->price;
					}


					// END PRICE
				
					// Get USD Price from Database
					// $usd = $row2->price;

					$sc = "USD".$cur[1];

					$check3 = DB::table('a_currency_list')->where('short',$sc)->get();
					foreach($check3 as $row3){}
					
					$cur_value = $row3->rate;	

					$main_total = round($usd*$cur_value);
					
					Cookie::queue("cry", $cname);
					Cookie::queue("oid", $row->id );
					Cookie::queue("cid", $row->currency_id );
				
				$rate_count = DB::table('a_rating')->where('offer_id',$offer)->count();
				$user_count = DB::table('a_users')->where('user_type',2)->count();
				$f_back_count = $rate_count*100/$user_count;
				
					$array[] = array(
						"offer_id" => $row->id,
						"user_name" => $u->user_name,
						"registered" => date("F, Y", strtotime($u->created_date)),
						"type_name" => $a,
						"coin" => $c->label,
						"coin_id" => $row->coin_id,
						"cname" => $cname,
						"main_total" => $main_total,
						"trader" => $trader,
						"trader1" => $trader1,
						"type" => $t->name,
						"city" => isset($location[0]) ? $location[0] : '',
						"state" => isset($location[1]) ? $location[1] : '',
						"country" => isset($location[2]) ? $location[2] : '',
						"mode" => $m->name,
						"currency" => $cur[1],
						"mark" => $mark,
						"mark_value" => $row->mark_value,
						"min" => $row->min,
						"max" => $row->max,
						"good_feedback" => $f_back_count,
						"success_trade" => $trades,
						"heading" => $row->headline,
						"description" => $row->offer
					);
				}
				
				$rating = DB::table('a_rating')->where('offer_id',$offer)->orderBy("id","DESC")->limit(3)->get();
				
				$rate_array = array();
				
				if(count($rating) > 0){	
					foreach($rating as $rate){
						$r_users = DB::table('a_users')->select('user_name')->where('id',$rate->user_id)->get();
						foreach($r_users as $ru){}
						$rate_array[] = array(
							'id' => $rate->id,
							'username'=> $ru->user_name,
							'rating' => $rate->rating,
							'review' => $rate->review,
						);
					}
				}
				foreach($array as $row){}
		    	
				$data = array("offer"=>$row,"rating"=>$rate_array);
		   		
				return View::make('buyer')->with($data);
	    	} 
	    	else {
	    		$notification = array(
					'message' => 'Bad request', 
					'alert-type' => 'warning'
				);
	    		return Redirect::to('offers-buy')->with($notification);
	    	}
		}
	}

	public function getcrypto() {

		$data  = Input::all();
		
		$check = DB::table('a_coin_info')->where('label',$data['cry'])->get();
		foreach($check as $row){}

		$usd = $row->price;

		$sc = "USD".$data['cur'];

		$check2 = DB::table('a_currency_list')->where('short',$sc)->get();
		foreach($check2 as $row2){}

		$cur_value = $row2->rate;	

		$main_total = round($usd*$cur_value);

		echo bcdiv($data['amount'], $main_total, 8);

	}

	public function createcontract() {

		$data = Input::all();
		$uid = Session::get('user_id');

		if($data['_token']=="") { 

			$notification = array(
				'message' => 'Bad request', 
				'alert-type' => 'warning'
			);
			
			return Redirect::to('offer/'.$data['oid'])->with($notification);

		} else {

			// REFERREL CODE CHECK
			$affiliate = DB::table('a_affiliate_list')->where("source",$uid)->where("transaction",Null)->orderby('id','DESC')->first();
			$site_conf = DB::table('a_site_config')->where("id",'1')->get();			
			$fees1 = DB::table('a_site_config')->where("id",'3')->get();
			$fees2 = DB::table('a_site_config')->where("id",'4')->get();
			
			if ($affiliate != '') {
				
				$refId = $affiliate->id;
				
				$array_aff = array(
					'transaction' => date("Y-m-d H:i:s"),
					"value" => $site_conf[0]->value,
				);

				$referrel_check = DB::table('a_affiliate_list')->where("id",$refId)->update($array_aff);
			}
			// END REFERREL CODE CHECK

			$currency = DB::table('a_coin_info')->where("label",Cookie::get('cry'))->get();
			foreach($currency as $cr){}	

			$offer = DB::table('a_offers')->where("id",Cookie::get('oid'))->get();
			
			if(count($offer)>0) {
				foreach($offer as $o){}
				$crypto = $data['crypto']; //number_format(($data['crypto'])*(pow(10, -18)), 8, '.', '');
				
				$commission_fees1 = $crypto*$fees1[0]->value/100;
				$commission_fees2 = $crypto*$fees2[0]->value/100;
				
				$cf_1 = number_format($commission_fees1, 8);
				$cf_2 = number_format($commission_fees2, 8);
				
				if($o->type_id == "14") {

					$wallet = DB::table('a_coin_wallet')->select('balance')->where('coin_id', $o->coin_id)->where('user_id',$uid)->get();

					if (count($wallet)>0) {
						if ($wallet[0]->balance == '') {
							$current_bal = 0;
						} else {
							$current_bal = $wallet[0]->balance;
						}
					} else {
						$current_bal=0;
					}

					// For logged in User created offers contracts
					$contracts1 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->where('to_user', $uid)->where('coin_id', $o->coin_id)->get();
					// For logged in User created offers contracts
					$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')->where('from_user', $uid)->where('coin_id', $o->coin_id)->get();

					$arr=array(0);
					$saleArr=array(0);
					$buyArr=array(0);
					$feesArr=array(0);

					if(count($contracts1)>0){
						foreach($contracts1 as $cnt1) {
							$offer1 = DB::table('a_offers')->select('*')->where('id', $cnt1->offer_id)->get();
							if(count($offer1)>0){
								if ($cnt1->co_status == 17) {
									
									foreach($offer1 as $of1) {
										$crypto_value = $cnt1->crypto_value;
										$crypto_fees = $cnt1->fees;
										
										if($of1->type_id == 15){ // sell offer  user seller
											array_push($arr,$crypto_value);
											array_push($arr,$crypto_fees);
										}
									}
								}  else if ($cnt1->co_status == 19) {
									
									foreach($offer1 as $of1){
										$crypto_value = $cnt1->crypto_value;
										$crypto_fees = $cnt1->fees;
										
										if($of1->type_id == 15) { // sell offer  user seller	
											array_push($saleArr,$crypto_value);
											array_push($feesArr,$crypto_fees);
										} else {
											//$crypto_value = $cnt1->crypto_value-$cnt1->fees;
											array_push($buyArr,$crypto_value);
											array_push($feesArr,$crypto_fees);
										}
									}
									
								}
							}
						}
					}

					if(count($contracts2)>0 || !empty($contracts2)) {
						foreach($contracts2 as $cnt2) {
							
							$offer2 = DB::table('a_offers')->select('*')->where('id', $cnt2->offer_id)->get();

							if (count($offer2)>0) {
								if ($cnt2->co_status == 17) {
									foreach($offer2 as $of2) {
										$crypto_value = $cnt2->crypto_value;
										$crypto_fees = $cnt2->fees2;
										
										if($of2->type_id == 14){ // buy offer  user seller
											array_push($arr,$crypto_value);
											array_push($arr,$crypto_fees);
										}
									}
								}
								else if($cnt2->co_status == 19) {
									foreach($offer2 as $of2) {
										$crypto_value = $cnt2->crypto_value;
										$crypto_fees = $cnt2->fees2;
										
										if($of2->type_id == 14) { // buy offer // user seller
											array_push($saleArr,$crypto_value);
											array_push($feesArr,$crypto_fees);
										} else {
											array_push($buyArr,$crypto_value);
											array_push($feesArr,$crypto_fees);
										}
									}
								}
							}
						}
					}

					$locked = array_sum($arr);
					$buy = array_sum($buyArr);
					$sale = array_sum($saleArr);
					$fees = array_sum($feesArr);

					$aval_balance = ($buy+$current_bal)-($locked+$sale+$fees);

					$req_amt = $cf_2 + $data['crypto'];

					if($aval_balance < $req_amt) {
						$notification = array(
							'message' => 'You currently have insufficiant balance for this trade. Your current balance is ' . $aval_balance . " and required balance is " . $req_amt, 'alert-type' => 'error');
						return Redirect::to('offer/'.Cookie::get('oid'))->with($notification);
					} else {
						$array = array(
							"offer_id" => Cookie::get('oid'),
							"coin_id" => $o->coin_id,
							"from_user" => $uid,
							"to_user" => $o->user_id,
							"currency_id" => Cookie::get('cid'),
							"crypto_value" => $data['crypto'],
							"fiat_value" => $data['currency'],
							"fees" => $cf_1,
							"fees2" => $cf_2,
							"co_status" => "16",
							"despute" => "1",
							"status" => "1",
							"created_by" => $uid,
							"created_date" => date("Y-m-d H:i:s"),
							"created_ip" => $_SERVER['REMOTE_ADDR']
						);
					
						$check = DB::table('a_contract')->insertGetId($array);
				
						if($check) {

							$trd_bal = $cf_2 + $data['crypto'];
							$array1 = array(
									"contract_id" => $check,
									"user_id" => $uid,
									"coin_id" => $o->coin_id,
									"balance" => "-".$trd_bal,
									"status" => "2",
									"create_by" => $uid,
									"create_on" =>  date("Y-m-d H:i:s"),
									'created_ip' => $_SERVER['REMOTE_ADDR']
							);
							$ch1 = DB::table('a_trade_wallet')->insertGetId($array1);
							
							Cookie::forget('oid');
							Cookie::forget('cid');
							Cookie::forget('cty');

							$notification = array('message' => 'Contract Has been created', 'alert-type' => 'success');
							return Redirect::to('my-trades')->with($notification);
						
						} else {
							$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
							return Redirect::to('offer/'.Cookie::get('oid'))->with($notification);
						}
					}

				} else {
				
					$array = array(
						"offer_id" => Cookie::get('oid'),
						"coin_id" => $o->coin_id,
						"from_user" => $uid,
						"to_user" => $o->user_id,
						"currency_id" => Cookie::get('cid'),
						"crypto_value" => $data['crypto'],
						"fiat_value" => $data['currency'],
						"fees" => $cf_1,
						"fees2" => $cf_2,
						"co_status" => "16",
						"despute" => "1",
						"status" => "1",
						"created_by" => $uid,
						"created_date" => date("Y-m-d H:i:s"),
						"created_ip" => $_SERVER['REMOTE_ADDR']
					);
				
					$check = DB::table('a_contract')->insertGetId($array);
			
					if($check) {
						if($o->type_id == "14"){ // Check Offer type is 'Buy'
							$trd_bal = $cf_2 + $data['crypto'];
							$array1 = array(
									"contract_id" => $check,
									"user_id" => $uid,
									"coin_id" => $o->coin_id,
									"balance" => "-".$trd_bal,
									"status" => "2",
									"create_by" => $uid,
									"create_on" =>  date("Y-m-d H:i:s"),
									'created_ip' => $_SERVER['REMOTE_ADDR']
							);
							$ch1 = DB::table('a_trade_wallet')->insertGetId($array1);
						}
						
						Cookie::forget('oid');
						Cookie::forget('cid');
						Cookie::forget('cty');

						$notification = array(
							'message' => 'Contract Has been created', 
							'alert-type' => 'success'
						);
						return Redirect::to('my-trades')->with($notification);
					
					} else {
						$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
						return Redirect::to('offer/'.Cookie::get('oid'))->with($notification);
					}
				}
			} else {
				$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
				return Redirect::to('my-trades')->with($notification);
			}
		}
	}

   	public function mytrades() {

   		$uid = Session::get('user_id');
   		$array = array();
   		$array2 = array();

   		if($uid==""){
			
			return Redirect::to('login');

    	} else {

   		$select = DB::table('a_contract')->where("from_user",$uid)->orWhere('to_user', $uid)->get();
   		
	   		foreach($select as $row){

	   			$offer = DB::table('a_offers')->where("id",$row->offer_id)->get();
	   			foreach($offer as $o){}

	   			$coin_info = DB::table('a_coin_info')->where("id",$o->coin_id)->get();
	   			foreach($coin_info as $ci){}

				$user = DB::table('a_users')->where('id',$row->from_user)->get();
				foreach($user as $u){}
				
				$user2 = DB::table('a_users')->where('id',$row->to_user)->get();
				foreach($user2 as $u2){}
				
				$mode = DB::table('a_payment_mode')->where("id",$o->mode_id)->get();
				foreach($mode as $m){}	

				$currency = DB::table('a_currency_list')->where("id",$o->currency_id)->get();
				foreach($currency as $cr){}					

				$location = explode(",",$o->location);
				$cur = explode("USD",$cr->short);

				if($o->type_id=="14"){
					$a = "Buy";
					
				} else {
					$a = "Sell";					
				}

				$array[] = array(
					"id" => $row->id,
					"from_user" => $row->from_user,
					"to_user" => $row->to_user,
					"sid" => $uid,
					'user_name' => $u->user_name,
					'to_usename' => $u2->user_name,
					'mode' => $m->name,
					'heading' => $o->headline,
					'coin_name' => $ci->name,
					"city" => isset($location[0]) ? $location[0] : '',
					"state" => isset($location[1]) ? $location[1] : '',
					"country" => isset($location[2]) ? $location[2] : '',
					"currency" => $cur[1],
					"min" => $o->min,
					"max" => $o->max,
					"type" => $a,
					"co_status" => $row->co_status
				);	

	   		}
   		
   			$data = array("active_contract"=>$array);

   			// print_r($data); exit;
   			
			return View::make('my-trades')->with($data);
		}
		
	}

    public function myoffers() {   

    	$uid = Session::get('user_id');
    	$array = array();

    	$where = array(
    		'user_id' => $uid,
    		'status' => '1'
    	);
    	if($uid==""){
			
			return Redirect::to('login');

    	} else {

	    	$select = DB::table('a_offers')->where($where)->get();
			foreach($select as $row){

				$user = DB::table('a_users')->where("id",$row->user_id)->get();
				foreach($user as $u){}

				$coin = DB::table('a_coin_info')->where("id",$row->coin_id)->get();
				foreach($coin as $c){}

				$type = DB::table('a_master_values')->where("id",$row->type_id)->get();
				foreach($type as $t){}	

				$mode = DB::table('a_payment_mode')->where("id",$row->mode_id)->get();
				foreach($mode as $m){}	

				$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
				foreach($currency as $cr){}		

				$cur = explode("USD",$cr->short);
				
				$array[] = array(
					"offer_id" => $row->id,
					"user_name" => $u->user_name,
					"coin" => $c->name,
					"coin_id" => $row->coin_id,
					"type" => $t->name,				
					"mode" => $m->name,
					"currency" => $cur[1],
					"min" => $row->min,
					"max" => $row->max,
					"heading" => $row->headline,
					"offer" => $row->offer,
				);

			}  

			$data = array("offers"=>$array);

	   		
			return View::make('my-offers')->with($data);

		}
		
	}
	
	public function  editoffer($id){
		
		$uid = Session::get('user_id');
    	
    	if($uid==""){
			
			return Redirect::to('login');

    	} else {

	    	$select = DB::table('a_offers')->where('id',$id)->get();
			
			foreach($select as $row){}

			$select1 = DB::table('a_currency_list')->where('id',$row->currency_id)->get();
			
			foreach($select1 as $row1){}

				$a = explode("USD",$row1->short);
			
			$ip = $_SERVER['REMOTE_ADDR'];
	    	$json  = file_get_contents("http://ipinfo.io/".$ip."/geo");
			$json  =  json_decode($json ,true);

			$country =  $json['country'];
			$region= $json['region'];
			$city = $json['city'];

			$json2 = file_get_contents("http://restcountries.eu/rest/v2/alpha/".$country);
			$json2  =  json_decode($json2 ,true);
			$currency = $json2['currencies'][0]['code'];
			$timezones = $json2['timezones'][0];

			$json3 = file_get_contents("http://restcountries.eu/rest/v2/all");
			$json3  =  json_decode($json3 ,true);
			// $currency = $json2['currencies'][0]['code'];
			
			$check = DB::table('a_payment_mode')->where('status',"1")->get();
			
			$coins = DB::table('a_coin_info')->where('type',"coin")->where('status',"1")->get();

			$data = array(
				"country" => $country,
				"state" => $region,
				"city" => $city,
				"currency" => $currency,
				"payment_methods" => $check,
				"all_currency" => $json3,
				"timezones" => $timezones,
				"data"=>$row,
				"coins" => $coins,
				"cur_name" => $a[1]
			);
			// echo "<pre>"; print_R($data); exit;
			
			return View::make('editoffer')->with($data);
		}
	}

	public function  deletoffer($id){
		
		$uid = Session::get('user_id');
		if($uid==""){
			
			return Redirect::to('login');

    	} else {
	    	$select = DB::table('a_offers')->where('id',$id)->get();
			
			if ($select != '') {
				
				$check = DB::table('a_offers')->where('id',$id)->where('user_id',$uid)->update(['status'=>'3']);
				
				// if ($check) {
				
					$notification = array(
						'message' => 'Offer has been deleted', 
						'alert-type' => 'success'
					);
					return Redirect::to('my-offers')->with($notification);
		
				//}		
			
			} else {

				$notification = array(
					'message' => 'Bad Request', 
					'alert-type' => 'error'
				);
				
				return Redirect::to('my-offers')->with($notification);
			}
		}
	}
    
    public function wallet() {
    	
    	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=86f9c151-721f-493e-8f02-6a4e98a81483';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);	
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result);

    	$uid = Session::get('user_id');

    	if ($uid != '') {
			$coins = DB::table('a_coin_info')->select('id','label','name','contract_address')->where('status', '1')->get();
			
			// For logged in User created offers contracts
			$contracts1 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->where('to_user', $uid)->get();
			// For logged in User created offers contracts
			$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')->where('from_user', $uid)->get();

			foreach ($coins as $c ) {

				$wallet = DB::table('a_coin_wallet')->select('id','coin_id','user_id','address','balance')->where('user_id', $uid)->where('coin_id', $c->id)->get();

				$withdrow_list = DB::table('a_withdraw_list')->select('amount')->where('user_id', $uid)->where('coin_id', $c->id)->get();
				 $withdrow_balance = 0;

				if (count($withdrow_list)>0) {
					foreach($withdrow_list as $wh) { $withdrow_balance += $wh->amount; }
				} 

		    	if (count($wallet) > 0) {
		    		foreach ($wallet as $w) { }
		    			
		    			$arr=array(0);
						$saleArr=array(0);
						$buyArr=array(0);
						$feesArr=array(0);


			    		if ($c->id == "1") {
							$balance_update = 'btcupdate';							
							$coinusd = $result->data[0]->quote->USD->price;								
							$locked = 0;
							
							if(count($contracts1)>0) {
								foreach($contracts1 as $cnt1) {

									$offer1 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt1->offer_id)->get();

									if(count($offer1)>0) {
										if ($cnt1->co_status == 17) {
										
										foreach($offer1 as $of1) {
											$crypto_value = $cnt1->crypto_value;
											$crypto_fees = $cnt1->fees;
											
											if($of1->type_id == 15) { // sell offer	
												array_push($arr,$crypto_value);
												array_push($arr,$crypto_fees);
											}
										}
									} else if ($cnt1->co_status == 19) {

											foreach($offer1 as $of1) {

												$crypto_value = $cnt1->crypto_value;
												$crypto_fees = $cnt1->fees;

												if($of1->type_id == 15) { // sell offer 
													array_push($saleArr,$crypto_value);
													array_push($feesArr,$crypto_fees);
												} else {
													array_push($buyArr,$crypto_value);
													array_push($feesArr,$crypto_fees);
												}
											}
										}
									}
								}
							}							
							
							if(count($contracts2)>0) {
								foreach($contracts2 as $cnt2) {
									
									$offer2 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt2->offer_id)->get();
									if(count($offer2)>0) {

									if ($cnt2->co_status == 17) {
										foreach($offer2 as $of2) {
											$crypto_value = $cnt2->crypto_value;
											$crypto_fees = $cnt2->fees2;

											if($of2->type_id == 14){ // buy offer	
												array_push($arr,$crypto_value);
												array_push($arr,$crypto_fees);
											} 
										}
									} else if ($cnt2->co_status == 19) {
										foreach($offer2 as $of2) {
											$crypto_value = $cnt2->crypto_value;
											$crypto_fees = $cnt2->fees2;

											if($of2->type_id == 14) { // buy offer
												array_push($saleArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											} else {
												array_push($buyArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											}
										}
										}
									}
								}
							}

							$locked  = array_sum($arr);
							$sale  = array_sum($saleArr); 
							$buy  = array_sum($buyArr);
							$fees  = array_sum($feesArr);
							
						} else if ($c->id == "2") {
							$locked=0;
							$balance_update = 'ethupdate';							
							$coinusd = $result->data[1]->quote->USD->price;

							if(count($contracts1)>0) {
								foreach($contracts1 as $cnt1) {

									$offer1 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt1->offer_id)->get();

									if(count($offer1)>0) {
										if ($cnt1->co_status == 17) {
										
										foreach($offer1 as $of1) {
											$crypto_value = $cnt1->crypto_value;
											$crypto_fees = $cnt1->fees;
											
											if($of1->type_id == 15) { // sell offer	
												array_push($arr,$crypto_value);
												array_push($arr,$crypto_fees);
											} 
											// else {
											// 	$crypto_value = $cnt1->crypto_value-$cnt1->fees;
											// 	array_push($saleArr, $crypto_fees);
											// }
										}
									} else if ($cnt1->co_status == 19) {

											foreach($offer1 as $of1) {

												$crypto_value = $cnt1->crypto_value;
												$crypto_fees = $cnt1->fees;

												if($of1->type_id == 15) { // sell offer 
													array_push($saleArr,$crypto_value);
													array_push($feesArr,$crypto_fees);
												} else {
													array_push($buyArr,$crypto_value);
													array_push($feesArr,$crypto_fees);
												}
											}
										}
									}
								}
							}							
							
							if(count($contracts2)>0) {
								foreach($contracts2 as $cnt2) {
									
									$offer2 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt2->offer_id)->get();
									if(count($offer2)>0) {

									if ($cnt2->co_status == 17) {
										foreach($offer2 as $of2) {
											$crypto_value = $cnt2->crypto_value;
											$crypto_fees = $cnt2->fees2;

											if($of2->type_id == 14){ // buy offer	
												array_push($arr,$crypto_value);
												array_push($arr,$crypto_fees);
											} 
										}
									} else if ($cnt2->co_status == 19) {
										foreach($offer2 as $of2) {
											$crypto_value = $cnt2->crypto_value;
											$crypto_fees = $cnt2->fees2;

											if($of2->type_id == 14) { // buy offer
												array_push($saleArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											} else {
												array_push($buyArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											}
										}
										}
									}
								}
							}

							$locked  = array_sum($arr);
							$sale  = array_sum($saleArr); 
							$buy  = array_sum($buyArr);
							$fees  = array_sum($feesArr);
							
						} else if ($c->id == "3") {
							$locked=0;
							$balance_update = 'ltcupdate';
							$coinusd = $result->data[4]->quote->USD->price;

							if(count($contracts1)>0) {
								foreach($contracts1 as $cnt1) {

									$offer1 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt1->offer_id)->get();

									if(count($offer1)>0) {
										if ($cnt1->co_status == 17) {
										
										foreach($offer1 as $of1) {
											$crypto_value = $cnt1->crypto_value;
											$crypto_fees = $cnt1->fees;
											
											if($of1->type_id == 15) { // sell offer	
												array_push($arr,$crypto_value);
												array_push($arr,$crypto_fees);
											} 
											// else {
											// 	$crypto_value = $cnt1->crypto_value-$cnt1->fees;
											// 	array_push($saleArr, $crypto_fees);
											// }
										}
									} else if ($cnt1->co_status == 19) {

											foreach($offer1 as $of1) {

												$crypto_value = $cnt1->crypto_value;
												$crypto_fees = $cnt1->fees;

												if($of1->type_id == 15) { // sell offer 
													array_push($saleArr,$crypto_value);
													array_push($feesArr,$crypto_fees);
												} else {
													array_push($buyArr,$crypto_value);
													array_push($feesArr,$crypto_fees);
												}
											}
										}
									}
								}
							}							
							
							if(count($contracts2)>0) {
								foreach($contracts2 as $cnt2) {
									
									$offer2 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt2->offer_id)->get();
									if(count($offer2)>0) {

									if ($cnt2->co_status == 17) {
										foreach($offer2 as $of2) {
											$crypto_value = $cnt2->crypto_value;
											$crypto_fees = $cnt2->fees2;

											if($of2->type_id == 14){ // buy offer	
												array_push($arr,$crypto_value);
												array_push($arr,$crypto_fees);
											} 
										}
									} else if ($cnt2->co_status == 19) {
										foreach($offer2 as $of2) {
											$crypto_value = $cnt2->crypto_value;
											$crypto_fees = $cnt2->fees2;

											if($of2->type_id == 14) { // buy offer
												array_push($saleArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											} else {
												array_push($buyArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											}
										}
										}
									}
								}
							}

							$locked  = array_sum($arr);
							$sale  = array_sum($saleArr); 
							$buy  = array_sum($buyArr);
							$fees  = array_sum($feesArr);
							
						}

						$url1 = 'https://free.currencyconverterapi.com/api/v6/convert?q=USD_INR&compact=ultra&apiKey=7ffdebad767d5d7ac75f';
						$ch1 = curl_init();
						curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch1, CURLOPT_URL,$url1);
						$result1 = curl_exec($ch1);
						curl_close($ch1);
						$live1 = json_decode($result1, true);
						// $inr =  substr($live1['USD_INR'],0,5);
						$inr = 69;

						$avalable_balance = ($w->balance+$buy) - ($locked+$sale+$fees+$withdrow_balance);
						$total_balance = ($w->balance+$buy+$locked) - ($sale+$fees+$withdrow_balance);
			    		
			    		$array[] = array(
			    			"coin_id" => $c->id,
			    			"label" => $c->label,
			    			"name" => $c->name,
							"user_id" => $w->user_id,
			    			"address" => $w->address,
			    			"balance" => $w->balance,
			    			"total_balance" => $total_balance,
			    			"sale" => $sale,
			    			"buy" => $buy,
			    			"fees" => $fees,
							"locked" => $locked,
							"avail_bal" => $avalable_balance,
							// "avail_bal" => $w->balance-$locked,
			    			"usd" => $coinusd,
			    			"usd_inr" => $coinusd * $inr,
				    		"balance_update" => $balance_update,
			    		);

		    	} else {
					
					$arr=array(0);
					$saleArr=array(0);
					$buyArr=array(0);
					$feesArr=array(0);

					$ethaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "2")->get();   
					

					foreach ($ethaddr as $e) { }
						$coinusd = $result->data[1]->quote->USD->price; // ETH convert to USD
						$inr = 69;
						$contract_addr = $c->contract_address;
						$addr = $e->address;

						// ETH Token balance get
						$url3 = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contract_addr."&address=".$addr."&tag=latest";
						$ch3 = curl_init();
						curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch3, CURLOPT_URL,$url3);
						$result3 = curl_exec($ch3);
						$result3 = json_decode($result3, true);
						curl_close($ch3);
						
						if ($result3['status'] == 1) {
							$balance = $result3['result']/1000000000000000000;
						} else {
							$balance = 0;
						}
						

						if(count($contracts1)>0) {
							foreach($contracts1 as $cnt1) {

								$offer1 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt1->offer_id)->get();

								if(count($offer1)>0) {
									if ($cnt1->co_status == 17) {
									
									foreach($offer1 as $of1) {
										$crypto_value = $cnt1->crypto_value;
										$crypto_fees = $cnt1->fees;
										
										if($of1->type_id == 15) { // sell offer	
											array_push($arr,$crypto_value);
											array_push($arr,$crypto_fees);
										} 
									}
								} else if ($cnt1->co_status == 19) {

										foreach($offer1 as $of1) {

											$crypto_value = $cnt1->crypto_value;
											$crypto_fees = $cnt1->fees;

											if($of1->type_id == 15) { // sell offer 
												array_push($saleArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											} else {
												array_push($buyArr,$crypto_value);
												array_push($feesArr,$crypto_fees);
											}
										}
									}
								}
							}
						}							
							
						if(count($contracts2)>0) {
							foreach($contracts2 as $cnt2) {
								
								$offer2 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt2->offer_id)->get();
								if(count($offer2)>0) {

								if ($cnt2->co_status == 17) {
									foreach($offer2 as $of2) {
										$crypto_value = $cnt2->crypto_value;
										$crypto_fees = $cnt2->fees2;

										if($of2->type_id == 14){ // buy offer	
											array_push($arr,$crypto_value);
											array_push($arr,$crypto_fees);
										} 
									}
								} else if ($cnt2->co_status == 19) {
									foreach($offer2 as $of2) {
										$crypto_value = $cnt2->crypto_value;
										$crypto_fees = $cnt2->fees2;

										if($of2->type_id == 14) { // buy offer
											array_push($saleArr,$crypto_value);
											array_push($feesArr,$crypto_fees);
										} else {
											array_push($buyArr,$crypto_value);
											array_push($feesArr,$crypto_fees);
										}
									}
									}
								}
							}
						}

						$locked  = array_sum($arr);
						$sale  = array_sum($saleArr); 
						$buy  = array_sum($buyArr);
						$fees  = array_sum($feesArr);
						$avalable_balance = ($balance+$buy) - ($locked+$sale+$fees+$withdrow_balance);
						$total_balance = ($w->balance+$buy+$locked) - ($sale+$fees+$withdrow_balance);

			    		$array[] = array(
			    			"coin_id" => $c->id,
				    		"label" => $c->label,
				    		"name" => $c->name,
				    		"user_id" => $e->user_id,
				    		"address" => $e->address,
				    		"balance" => $balance,
				    		"total_balance" => $total_balance,
				    		"sale" => $sale,
				    		"buy" => $buy,
				    		"fees" => $fees,
							"locked" => $locked,
							"avail_bal" => $avalable_balance,
				    		"usd" => $coinusd,
				    		"usd_inr" => $coinusd*$inr,
				    		"balance_update" => "tokenupdate/".$c->id,
			    		);
		    		
		    	}
			}
						
			$lock_bal = '';
			$avail_bal='';
			$data = array("coins" => $coins, "wallet_history" => $array);
		    
			// echo"<pre>";print_R($data); exit;
			return View::make('wallet')->with($data);
		} else {

    		$notification = array(
				'message' => 'Please Login Your Account!',
				'alert-type' => 'error'
			);
			
			return Redirect::to('home')->with($notification);
    	}		
	}

	// Withdrow Entry in Database function 
	public function withdrow(Request $res) {
		
		$data = Input::all();
		$uid = Session::get('user_id');

		if ($uid != '') {

			$coin_id = $data['coin_id'];
			$coin = DB::table('a_coin_info')->where('id',$coin_id)->get();
			foreach ($coin as $c) {}
				$cointype = $c->label;

			if ($cointype == 'BTC') {
				$wallet = DB::table('a_coin_wallet')->select('id','balance','address')->where('coin_id',$coin_id)->where('user_id',$uid)->first();
				$wallet_data = $this->lock_balance($coin_id);
				
			}
			else if ($cointype == 'ETH') {
				
				$wallet = DB::table('a_coin_wallet')->select('id','balance','address')->where('coin_id',$coin_id)->where('user_id',$uid)->first();

				$wallet_data = $this->lock_balance($coin_id);
			}

			$balance = $wallet_data['avalable_balance'];
			$amount = $data['amount'];

			if ($balance >= $amount) {

				$array = array(
					'user_id' => $uid,
					'coin_id' => $data['coin_id'],
					'from_address' => $wallet->address,
					'to_address' => $data['to'],
					'amount' => $data['amount'],
					"status" => "1",
					"created_by" => $uid,
					"created_date" => date("Y-m-d H:i:s"),
					"created_ip" => $_SERVER['REMOTE_ADDR'],
				);

				$check = DB::table('a_withdraw_list')->insertGetId($array);


				if ($check) {
					$notification = array(
							'message' => 'Withdrow Request Successfully Send',
							'alert-type' => 'success' );
					return Redirect::back()->with($notification);

				} 
				else {
					$notification = array(
						'message' => 'Error occured, try again', 
						'alert-type' => 'error'	);
					return Redirect::back()->with($notification);
				}
            }
            else {
            	$notification = array(
						'message' => 'Insufficiant balance please add funds to complete transaction"', 
						'alert-type' => 'error'	);
				return Redirect::back()->with($notification);
            }

		} 
		else {
			$notification = array(
					'message' => 'Please Login Your Account',
					'alert-type' => 'error'	);
			return Redirect::to('home')->with($notification);
		}		
	}

	public function btcupdate() {

		$uid = Session::get('user_id');

		if($uid=="") {
			
			return Redirect::to('login');

    	} else {
    	
    	$btcaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "1")->get();     
    	foreach($btcaddr as $btc){}
		
		if (!empty($btc->balance) || $btc->balance != 0) {
			$balance = $btc->balance;
		} else {
			$balance = 0;
		}		
	          
		/* Change 03/08/2019 */
	            $url1 = "https://api.blockcypher.com/v1/btc/main/addrs/".$btc->address; // BTC(bitcoin) Addaress token generation API
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url1);
                curl_setopt($ch1, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
               
                $dt = curl_exec($ch1);
                $res1 = json_decode($dt,true);
                curl_close($ch1);
                
                $balance = $res1['total_received']/100000000;

			$array = array(
				"balance" => $balance,
				"modified_by" => $uid,
				"modified_date" => date("Y-m-d H:i:s"),
				"modified_ip" => $_SERVER['REMOTE_ADDR']
			);
			
			$check = DB::table('a_coin_wallet')->where("user_id",$uid)->where("coin_id","1")->update($array);

    	if($check) { 
			$notification = array(
				'message' => 'Balance has been updated', 
				'alert-type' => 'success'
			);
			
			return Redirect::back()->with($notification);
		} else {

			$notification = array(
				'message' => 'Error occured, try again', 
				'alert-type' => 'error'
			);
			
			return Redirect::back()->with($notification);

			}
		}
	}

	public function ethupdate() {

		$uid = Session::get('user_id');
		
		if($uid==""){
			
			return Redirect::to('login');

    	} else {
			$arr=array(0);
			$arr2=array(0);
			$locked = 0;
	    	$ethaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "2")->get();     
	    	foreach($ethaddr as $eth){}

			$curl1 = curl_init();
			curl_setopt_array($curl1, array(
			    CURLOPT_URL => "http://54.175.53.61:8080/ethmainbal/".$eth->address,
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_ENCODING => "",
			    CURLOPT_TIMEOUT => 30000,
			    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			    CURLOPT_CUSTOMREQUEST => "GET",
			    CURLOPT_HTTPHEADER => array('Content-Type: application/json',),
			));
			$response1 = curl_exec($curl1);
			curl_close($curl1);
		    $balance = json_decode($response1);
			
			$locked = array_sum($arr); 
			
			if($balance != ''){
				$total =  $balance;//($locked) + ($balance+$eth->balance);
			}else {
				$total = 0 ; //($locked) + ($eth->balance + 0);
			}
			
			
		    $array = array(
		    	"balance" => $total,
		    	"modified_by" => $uid,
		    	"modified_date" => date("Y-m-d H:i:s"),
		    	"modified_ip" => $_SERVER['REMOTE_ADDR']
	    	);

			$check = DB::table('a_coin_wallet')->where("user_id",$uid)->where("coin_id","2")->update($array);

			if($check) { 
				$notification = array(
					'message' => 'Balance has been updated', 
					'alert-type' => 'success'
				);
			
				return Redirect::back()->with($notification);
			} else {
				$notification = array(
					'message' => 'Error occured, try again', 
					'alert-type' => 'error'
				);
				return Redirect::back()->with($notification);
			}			
		}
	}

	public function tokenupdate($token_id){
		$uid = Session::get('user_id');
		
		if($uid==""){
			return Redirect::to('login');
    	} else {

    		$token = DB::table('a_coin_info')->select('*')->where('id',$token_id)->get();
			foreach($token as $row){}

			$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=7e7c8486-0798-417d-8fa2-755a26e16bf3';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);	
			$result = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result);

			$name = $row->label;
			$coin_id = $row->id;

			if($token_id==$coin_id){
				for ($i=0; $i < count($result->data); $i++) {
					if ($name == $result->data[$i]->symbol) {
						$usd_price = $result->data[$i]->quote->USD->price;
					}
				}
			}

    		if (!isset($token_id) || empty($token_id)) {

				$notification = array(
					'message' => 'please select token id', 
					'alert-type' => 'error'
				);
				return Redirect::to('wallet')->with($notification);

			} else {

				$token_wallet = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', $token_id)->get();
				$ethaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "2")->get();

				foreach ($ethaddr as $e) { }
				$inr = 69;
				$contract_addr = $row->contract_address;
				$addr = $e->address;

				// ETH Token balance get
				$url3 = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contract_addr."&address=".$addr."&tag=latest";
				$ch3 = curl_init();
				curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch3, CURLOPT_URL,$url3);
				$result3 = curl_exec($ch3);
				$result3 = json_decode($result3, true);
				curl_close($ch3);
				
				if ($result3['status'] == 1) {
					$balance = $result3['result']/1000000000000000000;
				} else {
					$balance = 0;
				}

				if (count($token_wallet)>0) {	
					$array = array(
						
						'balance' => $balance,
						"modified_by" => $uid,
				    	"modified_date" => date("Y-m-d H:i:s"),
				    	"modified_ip" => $_SERVER['REMOTE_ADDR']
					);

					$check = DB::table('a_coin_wallet')->where("user_id",$uid)->where("coin_id", $token_id)->update($array);

					if($check) { 
						$notification = array(
							'message' => 'Balance has been updated', 
							'alert-type' => 'success'
						);					
						return Redirect::to('wallet')->with($notification);
					} else {
						$notification = array(
							'message' => 'Balance has been updated', 
							'alert-type' => 'success'
						);
					
						return Redirect::to('wallet')->with($notification);
					}

				} else {
					$array = array(
						'coin_id' => $token_id,
						'user_id' => $uid,
						'address' => $addr,
						'type' => '20',
						'balance' => $balance,
						'status' => '1',
						'created_by' => '1',
						'created_date' => date("Y-m-d H:i:s"),
						'created_ip' => $_SERVER['REMOTE_ADDR'],
					);

					$inserId = DB::table('a_coin_wallet')->insertGetId($array);

					if ($inserId != '') {
						$notification = array(
							'message' => 'Balance has been updated', 
							'alert-type' => 'success'
						);
					
						return Redirect::to('wallet')->with($notification);
					} else {
						$notification = array(
							'message' => 'Error occured, try again', 
							'alert-type' => 'error'
						);
						return Redirect::to('wallet')->with($notification);
					}
				}
			}
    	}		
	}


	public function ltcupdate() {

		$uid = Session::get('user_id');
		
		if($uid==""){
			return Redirect::to('login');
    	} else {
			
	    	$ltcaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "3")->get();     
	    	foreach($ltcaddr as $ltc){}
			
			$arr=array(0);
			$arr2=array(0);
			$locked = 0;
			
			// $trade_wallet = DB::table('a_trade_wallet')->where('user_id', $uid)->where('coin_id', '3')->get();
			
			// if(count($trade_wallet)>0){
			// 	echo $ltc->address;
			// 	foreach($trade_wallet as $tw){
			// 		$contracts1 = DB::table('a_contract')->select('id','offer_id','coin_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2')->where('id', $tw->contract_id)->orWhere(array('co_status'=>"17",'co_status'=>"19"))->get();
					
			// 		if(count($contracts1)>0){
			// 			foreach($contracts1 as $cnt1){
			// 				if($tw->coin_id == 3 && $cnt1->coin_id == 3){
			// 					array_push($arr, $tw->balance);
			// 				}
			// 			}
			// 		}
			// 	}
			// }
			
				// GET TRANSACTION HISTORY FROM BLOCKCYPHER API
				$url1 = "https://api.blockcypher.com/v1/ltc/main/addrs/".$ltc->address; // LTC(Litecoin) Addaress token generation API
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url1);
                curl_setopt($ch1, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
               
                $dt = curl_exec($ch1);
                $res1 = json_decode($dt,true);
                curl_close($ch1);
                
                $balance = $res1['total_received']/100000000;


			/*$curl1 = curl_init();
			curl_setopt_array($curl1, array(
			    CURLOPT_URL => "http://54.175.53.61:8080/ltcmainbal/".$ltc->address,
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_ENCODING => "",
			    CURLOPT_TIMEOUT => 30000,
			    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			    CURLOPT_CUSTOMREQUEST => "GET",
			    CURLOPT_HTTPHEADER => array('Content-Type: application/json',),
			));
			$response1 = curl_exec($curl1);
			
			curl_close($curl1);
			$balance = json_decode($response1);*/
			
			if($balance != ''){
				$total = $balance;  //($locked) + ($balance + $ltc->balance);
			}else {
				$total = 0;// ($locked) + (0 + $ltc->balance);
			}
			
		    $array = array(

		    	"balance" => $total,
		    	"modified_by" => $uid,
		    	"modified_date" => date("Y-m-d H:i:s"),
		    	"modified_ip" => $_SERVER['REMOTE_ADDR']

	    	);

	    	$check = DB::table('a_coin_wallet')->where("user_id",$uid)->where("coin_id","3")->update($array);

	    	if($check) { 
				$notification = array(
					'message' => 'Balance has been updated', 
					'alert-type' => 'success'
				);
				
				return Redirect::back()->with($notification);
			} else {

				$notification = array(
					'message' => 'Error occured, try again', 
					'alert-type' => 'error'
				);
				
				return Redirect::back()->with($notification);

			}
		}
	}
    
    public function myaccount() {       
   		
    	$uid = Session::get('user_id');
    	$utype = Session::get('user_type');

    	if ($uid != '' && $utype != '') {
    			
	    	$users = DB::table('a_users')->where('id', $uid)->get();     
	    	foreach($users as $user){}
			
			$sop = DB::table('a_site_config')->where('id', '7')->get();     
	    	foreach($sop as $op){}

			$userinfo = DB::table('a_users_info')->where('user_id', $uid)->get();     
	    	foreach($userinfo as $useri){}
			
			$userkyc = DB::table('a_kyc_list')->where('user_id', $uid)->get();     

			//$userpass = DB::table('a_users_auth')->where('user_id', $uid)->where('auth_type',"1")->get();
			$userpass = DB::table('a_users_auth')->where('user_id', $uid)->get();
	    	
			foreach($userpass as $userp){}
			
			$ref_user = DB::table('a_affiliate_list')->where('source', $uid)->get();
			
				$arr_aff_user = array();

			foreach($ref_user as $rf_u) {
				
				$ref_u_details = DB::table('a_users')->select('user_name','email')->where('id', $rf_u->user_id)->get();
				
				
					foreach($ref_u_details as $row3){}
					
					$arr_aff_user[] = array(
						'af_id' => $rf_u->id,
						'user_name' => $row3->user_name,
						'email' => $row3->email,
						'claim' => $rf_u->claim,
					);
		
			}
			
	    	$data = array(
	    		"user_name" => $user->user_name,
	    		"user_id" => $user->id,
	    		"email" => $user->email,
	    		"biodata" => $useri->bio_data,
	    		"phone" => $user->mobile,
	    		"country_code" => $user->country,
	    		"password" => $userp->value,
				"affiliate_list" => $arr_aff_user,
				"auth_type" => $userp->auth_type,
				"user_kyc" => $userkyc,
				"kyc_op" => $op->status
			);
			
			return View::make('my-account')->with($data);

		} else {
				$notification = array(
					'message' => 'Error occured, Please try again', 
					'alert-type' => 'error'
				);
			return Redirect::to('login')->with($notification);
		}		
	}
	
	public function addkyc(Request $request, $id){
		//print_r($request->all()); exit;
		if ($request->hasFile('pictures') && $request->hasFile('pictures2')) 
		{
			$uid = Session::get('user_id');
			$users = DB::table('a_users')->where('id', $uid)->get();     
	    	foreach($users as $user){}

    		$image = $request->file('pictures');
    		$image2 = $request->file('pictures2');
    		
    		$ext_array = array("jpg","jpeg","png","gif");

    		if(!in_array($image->getClientOriginalExtension(), $ext_array)) {

    			$message = array(
						'success' => false,
						'message' => 'Only jpeg, png, gif,jpg are allowed.'
					);
				
				return Redirect::to('my-account')->with($message);	

    		} else if(!in_array($image2->getClientOriginalExtension(), $ext_array)) { 

    			$message = array(
						'success' => false,
						'message' => 'Only jpeg, png, gif,jpg are allowed.'
					);
				
				return Redirect::to('my-account')->with($message);	

    		} else {

    				
			        $name = 'I'.time().'.'.$image->getClientOriginalExtension();
			        $destinationPath = public_path('/images');
			        $image->move($destinationPath, $name);

			        $name2 = 'R'.time().'.'.$image2->getClientOriginalExtension();
			        $destinationPath2 = public_path('/images');
			        $image2->move($destinationPath2, $name2);

	  
					$array = array(
					 "user_id" => $uid,
		            "Identity_proof" => $name,
		            "residential_proof" => $name2,
		            "created_by" => $uid,
		            "created_date" => date('Y-m-d H:i:s'),
		            "created_ip" => $_SERVER['REMOTE_ADDR'] );
					
					$insert = DB::table('a_kyc_list')->insertGetId($array);
					
						$message = array(
							'success' => true,
							'message' => 'Document upload successfull! Your document is under verification, please check again in sometime for upadte in status'
						);
					
					return Redirect::to('my-account')->with($message);	
			} 
			// }
			
		} else {
			$message = array(
				'success' => false,
				'message' => 'Please submit your Indentity Proof and Residential Proof.'
			);
			return Redirect::to('my-account')->with($message);	
		}
	}
	
	/* Claim */
	public function claim(){
		
		$uid = Session::get('user_id');
		$data = Input::all();
		
		$affiliate = DB::table('a_affiliate_list')->where('id',$data['claim'])->where('source',$uid)->get();
		
		if(count($affiliate)>0){
			$check = DB::table('a_affiliate_list')->where('id',$data['claim'])->where('source',$uid)->update(array('claim' => "1"));
			
			if($check){
				$message = array(
					'success' => true,
					'message' => 'Successfully! Claimed'
				);
			}
			else {
				$message = array(
					'success' => false,
					'message' => 'Oops Sorry! Something Wrong.'
				);
			}
		}
		else{
			$message = array(
				'success' => false,
				'message' => 'Record Not found!'
			);
		}
		return $message;		
	}
	
	/* SEND OTP For Change Mobile number */
	public function sendotp(){

		// $uid = Session::get('user_id');
		$data = Input::all();

		$uid = $data['user_id'];
		
		$mobile = $data['phone'];

		$user = DB::table('a_users')->where('id',$uid)->first();
		$userOTP = DB::table('a_otp_list')->where('user_id',$uid)->get();
		
		$select = DB::table('a_site_config')->where('id',2)->get();
    	
		$otp =  mt_rand(100000, 999999);
        
        $array = array(
            "user_id" => $uid,
            "otp" => $otp,
            "status" => "1",
            "created_by" => $uid,
            "created_date" => date('Y-m-d H:i:s'),
            "created_ip" => $_SERVER['REMOTE_ADDR']
        );

        if (!empty($userOTP)) {
        	$check = DB::table('a_otp_list')->where('user_id',$uid)->update($array);
        } 
        else {
        	$check = DB::table('a_otp_list')->insertGetId($array);
        }

        if ($check) {
        		$authKey = $select[0]->value; //$select[0]->value;
	            $mobileNumber = $mobile; // 228449AcyEZTO4J5b5aac18
	            $senderId = "CRYPTO";
	            $otp = "Your otp is ".$otp;
	            $message = urlencode($otp);
	            $route = "4";

	            $postData = array( 
	                'authkey' => $authKey,
	                'country' => $user->country,
	                'mobiles' => $mobileNumber,
	                'message' => $message,
	                'sender' => $senderId,
	                'route' => $route
	            );
	            
				
				/* OLD API */
	           $url="http://api.msg91.com/api/sendhttp.php";
	            
				$ch = curl_init();
	            curl_setopt_array($ch, array(
	                CURLOPT_URL => $url,
	                CURLOPT_RETURNTRANSFER => true,
	                CURLOPT_POST => true,
	                CURLOPT_POSTFIELDS => $postData
	                //,CURLOPT_FOLLOWLOCATION => true
	            ));
	            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	            $output = curl_exec($ch);
	            
	            if(curl_errno($ch)) {
	                echo 'error:' . curl_error($ch);
	            }
	            curl_close($ch); 
				/* END */
				
				/*
				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?authkey=".$authKey."&message=".$message."&sender=".$senderId."&mobile=".$mobileNumber."&otp=".$otp."&email=&otp_expiry=&template=",
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
				*/
        	}
        	$response = array( 'phone' => $mobile, "smsId" => $output);
        return $response;
	}

	/*public function verifyOTP(){

		$data = Input::all();
		
		$select = DB::table('a_site_config')->where('id',2)->get();
    	
		$otp =  mt_rand(100000, 999999);
        $uid = Session::get('user_id');
        $userOTP = DB::table('a_otp_list')->where('user_id',$uid)->get();

        $array = array(
            "user_id" => $uid,
            "otp" => $otp,
            "status" => "1",
            "created_by" => $uid,
            "created_date" => date('Y-m-d H:i:s'),
            "created_ip" => $_SERVER['REMOTE_ADDR']
        );

        if (!empty($userOTP)) {
        	$check = DB::table('a_otp_list')->where('user_id',$uid)->update($array);
        } 
        else {
        	$check = DB::table('a_otp_list')->insertGetId($array);
        }

        if ($check) {
        		$authKey = $select[0]->value;
	            $mobileNumber = $data['phone']; // 228449AcyEZTO4J5b5aac18
	            $senderId = "CRYPTO";
	            $otp = "Your otp is ".$otp;
	            $message = urlencode($otp);
	            $route = "4";

	            $postData = array( 
	                'authkey' => $authKey,
	                'mobiles' => $mobileNumber, 
	                'message' => $message,
	                'sender' => $senderId,
	                'route' => $route
	            );
	            
	            $url="http://api.msg91.com/api/sendhttp.php";
	            $ch = curl_init();
	            curl_setopt_array($ch, array(
	                CURLOPT_URL => $url,
	                CURLOPT_RETURNTRANSFER => true,
	                CURLOPT_POST => true,
	                CURLOPT_POSTFIELDS => $postData
	                //,CURLOPT_FOLLOWLOCATION => true
	            ));
	            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	            $output = curl_exec($ch);
	            
	            if(curl_errno($ch)) {
	                echo 'error:' . curl_error($ch);
	            }
	            curl_close($ch);
        	}
        return $output;
	}
	*/


	public function biodata() {

		$data = Input::all();

		if($data['_token']=="") { 

			$notification = array(
				'message' => 'Bad request', 
				'alert-type' => 'warning'
			);
			
			return Redirect::to('login')->with($notification);

		} else {

			$uid = Session::get('user_id');

	    	$user_info = DB::table('a_users_info')->where('user_id', $uid)->get();     

	    	if(count($user_info)=="0"){

	    		$array = array(

	    			"user_id" => $uid,
	    			"bio_data" => $data['biodata'],
	    			"status" => "1",
	    			"created_by" => $uid,
	    			"created_date" => date("Y-m-d H:i:s"),
	    			"created_ip" => $_SERVER['REMOTE_ADDR']

				);

				$check = DB::table('a_users_info')->insertGetId($array);

				if($check) { 
					$notification = array(
						'message' => 'Biodata has been updated', 
						'alert-type' => 'success'
					);
					
					return Redirect::to('my-account')->with($notification);
				} else {

					$notification = array(
						'message' => 'Error occured, Please try again', 
						'alert-type' => 'error'
					);
					
					return Redirect::to('my-account')->with($notification);

				}

	    	} else {

				$array = array(

	    			"bio_data" => $data['biodata'],    			
	    			"modified_by" => $uid,
	    			"modified_date" => date("Y-m-d H:i:s"),
	    			"modified_ip" => $_SERVER['REMOTE_ADDR']

				);

				$user = DB::table('a_users')->where('id',$uid)->get();
			
				if (count($user)>0) {
					foreach ($user as $row) { 
						$to = $row->email; 
						$uname = $row->user_name;
					}

					$check = DB::table('a_users_info')->where('user_id',$uid)->update($array);

					if($check) { 
						$select = DB::table('a_site_config')->where('id',2)->get();
    					$authkey = $select[0]->value;

						$from = "no-reply@crypscrow.com";
						$subject = "BitcoinNearMe Bio Update";
						$body = "<body><h2>Hello ".$uname.",</h2><p>Your Bio has been Update with : <br><b><u>+". $data['biodata'] ."</u></b>. </p><p><b>Thank you,</b></p><p><b>BitcoinNearMe</b></p></body>";
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
							'message' => 'Biodata has been updated', 
							'alert-type' => 'success'
						);
						
						return Redirect::to('my-account')->with($notification);
					} else {

						$notification = array(
							'message' => 'Error occured, Please try again', 
							'alert-type' => 'error'
						);
						
						return Redirect::to('my-account')->with($notification);

					}
				} 
				else {
					$notification = array(
							'message' => 'Error occured, Please try again', 
							'alert-type' => 'error'
						);
						
					return Redirect::back()->with($notification);
				}
	    	}
    	
    	}

	}
    
    public function changeemail() {
		$data = Input::all();
		if($data['_token']=="") { 
			$notification = array(
				'message' => 'Bad request', 
				'alert-type' => 'warning'
			);
			return Redirect::to('login')->with($notification);
		} else {
			$uid = Session::get('user_id');
			$array = array(

    			"email" => $data['email'],    			
    			"modified_by" => $uid,
    			"modified_date" => date("Y-m-d H:i:s"),
    			"modified_ip" => $_SERVER['REMOTE_ADDR']

			);
			$check = DB::table('a_users')->where('id',$uid)->update($array);
			if($check) { 
				$notification = array(
					'message' => 'Email has been changed', 
					'alert-type' => 'success'
				);
				return Redirect::to('my-account')->with($notification);
			} else {
				$notification = array(
					'message' => 'Error occured, Please try again', 
					'alert-type' => 'error'
				);
				return Redirect::to('my-account')->with($notification);
			}
    	}
	}

	public function changepassword() {
		$data = Input::all();
		
		if($data['_token']=="") { 
			$notification = array(
				'message' => 'Bad request', 
				'alert-type' => 'warning'
			);
			return Redirect::to('login')->with($notification);

		} else {

			$uid = Session::get('user_id');

			if($data['password']==$data['cpassword']) {
				$array = array(
	    			"value" => md5($data['password']),    			
	    			"modified_by" => $uid,
	    			"modified_date" => date("Y-m-d H:i:s"),
	    			"modified_ip" => $_SERVER['REMOTE_ADDR']
				);
				$check = DB::table('a_users_auth')->where('user_id',$uid)->where('auth_type',"1")->update($array);
				if($check) { 
					$notification = array(
						'message' => 'Password has been changed', 
						'alert-type' => 'success'
					);
					
					return Redirect::to('my-account')->with($notification);
				} else {
					$notification = array(
						'message' => 'Error occured, Please try again', 
						'alert-type' => 'error'
					);
					return Redirect::to('my-account')->with($notification);
				}
			} else {
				$notification = array('message' => 'Password does not matched', 'alert-type' => 'error');
				return Redirect::to('login')->with($notification);
			}
		}
	}
    
    public function changeauth(){
		$data = Input::all();
		$uid = Session::get('user_id');
		
		if($uid == ''){
			$notification = array('message' => 'Please Login your account!', 'alert-type' => 'error');
			return Redirect::to('login')->with($notification);
		} else {
			if($data['_token']=="") { 
				$notification = array('message' => 'Bad request! Try again.','alert-type' => 'warning');
				return Redirect::back()->with($notification);
			} else {
				$select = DB::table('a_users_auth')->where('user_id',$uid)->get();
				if(count($select)>0){
					$array = array(
						'auth_type' => $data['otp_login'],
						"modified_by" => $uid,
						"modified_date" => date("Y-m-d H:i:s"),
						"modified_ip" => $_SERVER['REMOTE_ADDR']
					);
					
					$check = DB::table('a_users_auth')->where('user_id',$uid)->update($array);
					if($check){
						$notification = array('message' => 'Successfully Save!', 'alert-type' => 'success');
						return Redirect::back()->with($notification);
					} else {
						$not1ification = array('message' => 'Something is went Wrong', 'alert-type' => 'error');
						return Redirect::back()->with($notification);
					}
				} else { 
					$not1ification = array('message' => 'Something is went Wrong', 'alert-type' => 'error');
					return Redirect::back()->with($notification);
				}
			}
		}
	}
	
	public function changephone() {

		$data = Input::all();
		if($data['_token']=="") {
			$notification = array('message' => 'Bad request', 'alert-type' => 'warning');
			return Redirect::to('login')->with($notification);
		} else {
			$uid = Session::get('user_id');
			$otp = $data['verify_otp'];

			$where = array('user_id'=>$uid, 'otp' => $otp);
			
			$otpVerify = DB::table('a_otp_list')->where($where)->get();
			
			if (count($otpVerify)>0) {
			
				$array = array(
	    			"mobile" => $data['new_number'],    			
	    			"country" => $data['country_code'],
	    			"modified_by" => $uid,
	    			"modified_date" => date("Y-m-d H:i:s"),
	    			"modified_ip" => $_SERVER['REMOTE_ADDR']
				);

				$user = DB::table('a_users')->where('id',$uid)->get();
				
				if (count($user)>0) {
					foreach ($user as $row) { 
						$to = $row->email; 
						$uname = $row->user_name;
					}

					$check = DB::table('a_users')->where('id',$uid)->update($array);

					if($check) { 
						$select = DB::table('a_site_config')->where('id',2)->get();
	    				$authkey = $select[0]->value;

						$from = "no-reply@crypscrow.com";							
						$subject = "BitcoinNearMe Phone Number Update";
						$body = "<body><h2>Hello ".$uname.",</h2><p>Your Phone Number has been changed with <b><u>+". $data['phone2'] ."</u></b> Number</p><p><b>Thank you,</b></p><p><b>BitcoinNearMe</b></p></body>";
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


						$notification = array('message' => 'Phone Number has been changed', 'alert-type' => 'success');
						
						return Redirect::to('my-account')->with($notification);
					} else {

						$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
						return Redirect::to('my-account')->with($notification);

					}
				} else {
						$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
						return Redirect::back()->with($notification);

				}
			} else {
				$notification = array('message' => 'Something is went Wrong', 'alert-type' => 'error');
				return Redirect::back()->with($notification);
			}
    	}

	}
    
    public function newoffer() {
		return View::make('new-offer');	
	}
    
	public function offers(Request $request) {   

    	$uid = Session::get('user_id');
    	$utype = Session::get('user_type');

    	if ($uid != '' && $utype != '') {
	    	
	    	$ip = "122.170.73.148";
	    	$json  = file_get_contents("http://ipinfo.io/".$ip."/geo");
			$json  =  json_decode($json ,true);

			$country =  $json['country'];
			$region= $json['region'];
			$city = $json['city'];

			$json2 = file_get_contents("http://restcountries.eu/rest/v2/alpha/".$country);
			$json2  =  json_decode($json2 ,true);
			$currency = $json2['currencies'][0]['code'];
			$timezones = $json2['timezones'][0];

			$json3 = file_get_contents("http://restcountries.eu/rest/v2/all");
			$json3  =  json_decode($json3 ,true);
			
			$check = DB::table('a_payment_mode')->where('status',"1")->get();
			
			$coins = DB::table('a_coin_info')->where('type',"coin")->where('status',"1")->get();

			$coin_arr =array();

			$data = array(

				"country" => $country,
				"state" => $region,
				"city" => $city,
				"currency" => $currency,
				"payment_methods" => $check,
				"all_currency" => $json3,
				"timezones" => $timezones,
				"coins" => $coins,
			);
			return View::make('offers')->with($data);
		} else {
			$notification = array('message' => 'Login Your Account!', 'alert-type' => 'error');	
			return Redirect::to('login')->with($notification);
		}
	}

	/* Filter Buy & sell offers */
	public function applyFilter(Request $req){
		
		$data = Input::all();

		$coinid = $data['send_data']['coinid'];
		$location = $data['send_data']['location'];
		$offertype = $data['send_data']['offertype'];
		$paymethod = $data['send_data']['paymethod'];
		$select_offers = array();

		if ($coinid != '' && $offertype != '' && $paymethod != '' && $location != '') {
			$where = array(
				"coin_id" => $coinid,
				"type_id" => $offertype,
				"mode_id" => $paymethod,
				"status" => '1',
				);
			$select = DB::table('a_offers')->where($where)->where('location', 'LIKE', '%' . $location . '%')->get();	
		}
		
		if ($coinid != '' && $offertype != '' && $paymethod != '') {
			$where = array(
				"coin_id" => $coinid,
				"type_id" => $offertype,
				"mode_id" => $paymethod,
				"status" => '1',
				);
			$select = DB::table('a_offers')->where($where)->get();	
		}
		
		if ($coinid != '' && $offertype != '') {
			$where = array(
				"coin_id" => $coinid,
				"type_id" => $offertype,
				"status" => '1',
				);
			$select = DB::table('a_offers')->where($where)->get();	
		}
		if ($coinid != '') {
			$where = array("coin_id" => $coinid, "status" => '1');
			$select = DB::table('a_offers')->where($where)->get();

		} 
		if ($offertype != '' && $coinid != '') {
			$where = array("type_id" => $offertype, "coin_id" => $coinid, "status" => '1');
			$select = DB::table('a_offers')->where($where)->get();
		}
		if ($offertype != '') {
			$where = array("type_id" => $offertype, "status" => '1');
			$select = DB::table('a_offers')->where($where)->get();
		}
		if ($paymethod != '') {
			$where = array("mode_id" => $paymethod, "status" => '1');
			$select = DB::table('a_offers')->where($where)->get();
		}
		if ($location != '') {
			$select = DB::table('a_offers')
			->where('status', '1')
			->where('location', 'LIKE', '%' . $location . '%')->get();	
		} 
	
		if (!empty($select)) {
			
			foreach($select as $row) {
				if ($row->status == '1') {

					$user = DB::table('a_users')->select('user_name')->where("id",$row->user_id)->first();
					$coin = DB::table('a_master_values')->select('name')->where("id",$row->coin_id)->first();
					$coin_info = DB::table('a_coin_info')->select('name','price')
					->where("id",$row->coin_id)->where('status',"1")->first();
					$type = DB::table('a_master_values')->select('name')->where("id",$row->type_id)->first();
					$mode = DB::table('a_payment_mode')->select('name')->where("id",$row->mode_id)->first();
					$currency = DB::table('a_currency_list')->select('short')->where("id",$row->currency_id)->first();

					
					$select_offers[] = array(
						"offer_id" => $row->id,
						"user_name" => $user->user_name,
						"coin" => $coin->name,
						"type" => $type->name,
						"coin_name" => $coin_info->name,
						"coin_price" => $coin_info->price,
						"location" => isset($row->location) ? $row->location : '' ,
						"mode" => $mode->name,
						"currency" => $currency->short,
						"mark_value" => $row->mark_value,
						"min" => $row->min,
						"max" => $row->max,						
						"result" => "OK"
					);
				}
			}
		} 

		$html['search_Data'] = $select_offers;
		$response = View::make('filter_offer')->with($html);
		return $response;
	}

	/* Offer Rating */
	public function rating(){
		$data = Input::all();
		
		$uid = Session::get('user_id');
		$offer_id = $data['offer_id'];
		$rating = $data['ratingValue'];
		$review = $data['review'];
		
		$chk1 = DB::table('a_rating')->where(array('offer_id'=>$offer_id,"user_id" => $uid))->count();
		if($chk1==0){
			$array = array(
					"offer_id" =>$offer_id,
					"user_id" => $uid,
					"rating" => $rating,
					"review" => $review,
					"status" => "1",
					"created_by" => $uid,
					"created_date" => date("Y-m-d H:i:s"),
					"created_ip" => $_SERVER['REMOTE_ADDR']
				);
			$check = DB::table('a_rating')->insertGetId($array);
			
			if($check){
				$msg = array(
					"success" => true,
					"message" => "You have successfully rated"
				);
			} else {
				$msg = array(
					"success" => false,
					"message" => "Error occured, Please try again"
				);
			}
		}
		else {
			$msg = array(
					"success" => false,
					"message" => "You have already rated"
				);
		}
		return $msg;
	}
		
	public function checkprice() {

		$data = Input::all();

		$uid = Session::get('user_id');
		$cur =  $data['currency'];
		$offer = $data['offer'];
		$per = $data['per'];
		$con = $data['con'];
		$coin = $data['coin'];

		$check = DB::table('a_coin_info')->where('id',$coin)->get();
		foreach($check as $row){}

		$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=7e7c8486-0798-417d-8fa2-755a26e16bf3';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);	
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result);

		$name = $row->label;
		$coin_id = $row->id;


		if($coin==$coin_id) {
			for ($i=0; $i < count($result->data); $i++) {
				if ($name == $result->data[$i]->symbol) {
					$usd = $result->data[$i]->quote->USD->price;
				}
			}
		}

		$sc = "USD".$cur;

		$check2 = DB::table('a_currency_list')->where('short',$sc)->get();
		foreach($check2 as $row2){}

		$check3 = DB::table('a_coin_wallet')->where('user_id',$uid)->where("coin_id",$coin)->get();
		
		if (count($check3)>0) {
			foreach($check3 as $row3){}
			$aval_balance = $row3->balance;
		} else {
			$aval_balance=0;
		}

		// For logged in User created offers contracts
		$contracts1 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->where('to_user', $uid)->where('coin_id', $coin)->get();
		// For logged in User created offers contracts
		$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')->where('from_user', $uid)->where('coin_id', $coin)->get();

		$arr=array(0);
		$saleArr=array(0);
		$buyArr=array(0);
		$feesArr=array(0);

		if(count($contracts1)>0){
			foreach($contracts1 as $cnt1) {
				$offer1 = DB::table('a_offers')->select('*')->where('id', $cnt1->offer_id)->get();
				if(count($offer1)>0){
					if ($cnt1->co_status == 17) {
						
						foreach($offer1 as $of1) {
							$crypto_value = $cnt1->crypto_value;
							$crypto_fees = $cnt1->fees;
							
							if($of1->type_id == 15){ // sell offer  user seller
								array_push($arr,$crypto_value);
								array_push($arr,$crypto_fees);
							}
						}
					}  else if ($cnt1->co_status == 19) {
						
						foreach($offer1 as $of1){
							$crypto_value = $cnt1->crypto_value;
							$crypto_fees = $cnt1->fees;
							
							if($of1->type_id == 15) { // sell offer  user seller	
								array_push($saleArr,$crypto_value);
								array_push($feesArr,$crypto_fees);
							} else {
								//$crypto_value = $cnt1->crypto_value-$cnt1->fees;
								array_push($buyArr,$crypto_value);
								array_push($feesArr,$crypto_fees);
							}
						}
						
					}
				}
			}
		}

		if(count($contracts2)>0 || !empty($contracts2)) {
			foreach($contracts2 as $cnt2) {
				
				$offer2 = DB::table('a_offers')->select('*')->where('id', $cnt2->offer_id)->get();

				if (count($offer2)>0) {
					if ($cnt2->co_status == 17) {
						foreach($offer2 as $of2) {
							$crypto_value = $cnt2->crypto_value;
							$crypto_fees = $cnt2->fees2;
							
							if($of2->type_id == 14){ // buy offer  user seller
								array_push($arr,$crypto_value);
								array_push($arr,$crypto_fees);
							}
						}
					}
					else if($cnt2->co_status == 19) {
						foreach($offer2 as $of2) {
							$crypto_value = $cnt2->crypto_value;
							$crypto_fees = $cnt2->fees2;
							
							if($of2->type_id == 14) { // buy offer // user seller
								array_push($saleArr,$crypto_value);
								array_push($feesArr,$crypto_fees);
							} else {
								array_push($buyArr,$crypto_value);
								array_push($feesArr,$crypto_fees);
							}
						}
					}
				}
			}
		}

		$locked = array_sum($arr);
		$buy = array_sum($buyArr);
		$sale = array_sum($saleArr);
		$fees = array_sum($feesArr);
		$aval_balance = ($buy+$aval_balance)-($locked+$sale+$fees);


		$cur_value = $row2->rate;		

		$main_total = round(str_replace(",","",$usd)*$cur_value);		

		$st = $main_total*$per/100;

		if($con=="1"){
			$your_total = round($main_total+$st);
		} else {
			$your_total = round($main_total-$st);
		}
		// echo $your_total;
		if($offer=="14") {
			echo "
				<input type='hidden' value='".$main_total."' name='main_price'>
				<input type='hidden' value='".$your_total."' name='user_price'>

				<div class='row'>
					<div class='col-sm-6'>
						<p>Currency current rate:</p>
						<p><b>".$main_total." ".$cur."</b></p>
					</div>
					<div class='col-sm-6'>
						<p>Your current rate (as a buyer):</p>
						<p><b>".$your_total." ".$cur."</b></p>
					</div>
				</div>
			";
 		} else if($offer=="15"){

 			echo "
 				<input type='hidden' value='".$main_total."' name='main_price'>
 				<input type='hidden' value='".$your_total."' name='user_price'>
 				<input type='hidden' value='".$aval_balance."' name='aval_balance'>
 				<div class='row'>
 					<div class='col-sm-6'>
 						<p>Cuurency current rate:</p>
 						<p><b>".$main_total." ".$cur."</b></p>
					</div>
					<div class='col-sm-6'>
						<p>Your current rate (as a seller):</p>
						<p><b>".$your_total." ".$cur."</b></p>
					</div>
					<div class='col-sm-6'>
						<p>Your ".$name." Balance : </p>
						<input type='text' name='balance' class='form-control' value='".$aval_balance."' readonly>
					</div>
					<div class='col-sm-6'>
						<p>You want to Sell : </p>
						<input type='text' name='wanttobuy' class='form-control'>
					</div>
				</div>
			";
 		}

	}

	public function createoffer() {

		$uid = Session::get('user_id');

		$data = Input::all();

		if($data['_token']=="") { 

			$notification = array(
				'message' => 'Bad request', 
				'alert-type' => 'warning'
			);
			
			return Redirect::back()->with($notification);

		} else {

			if($data['location2']=="") {
				$location = $data['location'];
			} else {
				$location = $data['location2'];
			}

			if($data['trade_cur2']=="") {

				$n = "USDINR";
				$check2 = DB::table('a_currency_list')->where('short',$n)->get();
				foreach($check2 as $row2){}
				$currency_id = $row2->id;

			} else {

				$n = "USD".$data['trade_cur2'];
				$check2 = DB::table('a_currency_list')->where('short',$n)->get();
				foreach($check2 as $row2){}
				$currency_id = $row2->id;
			}
			$coin_id = $data['coins'];
			// Get Current Live Balance
			$wallet = DB::table('a_coin_wallet')->select('*')->where('user_id', $uid)->where('coin_id', $data['coins'])->get();
			// For logged in User created offers contracts
			$contracts1 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->where('coin_id', $coin_id)->where('to_user', $uid)->get();
			// For logged in User created offers contracts
			$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')->where('coin_id', $coin_id)->where('from_user', $uid)->get();

			$arr=array(0);
			$saleArr=array(0);
			$buyArr=array(0);
			$feesArr = array(0);

			if(count($wallet)>0) {

				foreach ($wallet as $w) { }
				$current_bal = $w->balance;			

				if(count($contracts1)>0){
					foreach($contracts1 as $cnt1) {
						$offer1 = DB::table('a_offers')->select('*')->where('id', $cnt1->offer_id)->get();
						if(count($offer1)>0){
							if ($cnt1->co_status == 17) {
								
								foreach($offer1 as $of1) {
									$crypto_value = $cnt1->crypto_value;
									$crypto_fees = $cnt1->fees;
									
									if($of1->type_id == 15){ // sell offer  user seller
										array_push($arr,$crypto_value);
										array_push($arr,$crypto_fees);
									}
								}
							}  else if ($cnt1->co_status == 19) {
								
								foreach($offer1 as $of1){
									$crypto_value = $cnt1->crypto_value;
									$crypto_fees = $cnt1->fees;
									
									if($of1->type_id == 15) { // sell offer  user seller	
										array_push($saleArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									} else {
										//$crypto_value = $cnt1->crypto_value-$cnt1->fees;
										array_push($buyArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									}
								}
								
							}
						}
					}
				}

				if(count($contracts2)>0 || !empty($contracts2)) {
					foreach($contracts2 as $cnt2) {
						
						$offer2 = DB::table('a_offers')->select('*')->where('id', $cnt2->offer_id)->get();

						if (count($offer2)>0) {
							if ($cnt2->co_status == 17) {
								foreach($offer2 as $of2) {
									$crypto_value = $cnt2->crypto_value;
									$crypto_fees = $cnt2->fees2;
									
									if($of2->type_id == 14){ // buy offer  user seller
										array_push($arr,$crypto_value);
										array_push($arr,$crypto_fees);
									}
								}
							}
							else if($cnt2->co_status == 19) {
								foreach($offer2 as $of2) {
									$crypto_value = $cnt2->crypto_value;
									$crypto_fees = $cnt2->fees2;
									
									if($of2->type_id == 14) { // buy offer // user seller
										array_push($saleArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									} else {
										array_push($buyArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									}
								}
							}
						}
					}
				}

				$locked = array_sum($arr);
				$buy = array_sum($buyArr);
				$sale = array_sum($saleArr);
				$fees = array_sum($feesArr);
				$aval_balance = ($buy+$current_bal)-($locked+$sale+$fees);
			
			} else {

				$coins = DB::table('a_coin_info')->select('*')->where('id', $data['coins'])->where('status',"1")->get();
				foreach ($coins as $c) { }
				$contract_addr = $c->contract_address;

				$ethaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "2")->get();
				foreach ($ethaddr as $e) { }
				$addr = $e->address;

				// ETH Token balance get
				$url = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contract_addr."&address=".$addr."&tag=latest";

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL,$url);
				$res1 = curl_exec($ch);
				$res1 = json_decode($res1, true);
				curl_close($ch);
				
				if ($res1['status'] == 1) {
					$balance = $res1['result']/1000000000000000000;
				} else {
					$balance = 0;
				}

			}

			if($data['type']=="14") {
				// Create Buy Offer
				$array = array(
					"user_id" => $uid,
					"coin_id" => $data['coins'],
					"type_id" => $data['type'],
					"location" => $location,
					"mode_id" => $data['payment_method'],
					"currency_id" => $currency_id,
					"mark_id" => $data['ab_bl'],
					"mark_value" => $data['per'],
					"min" => $data['min_range'],
					"max" => $data['max_range'],
					"headline" => $data['headline'],
					"offer" => $data['terms'],
					"timezone" => $data['timezone'],
					"open" => $data['timezone2'],
					"close" => $data['timezone3'],
					"status" => "1",
	    			"created_by" => $uid,
	    			"created_date" => date("Y-m-d H:i:s"),
	    			"created_ip" => $_SERVER['REMOTE_ADDR']
				);

				$check = DB::table('a_offers')->insertGetId($array);						

				if($check) { 

					$notification = array(
						'message' => 'Offer Has been created', 
						'alert-type' => 'success'
					);
					return Redirect::to('my-offers')->with($notification);
				} else {

					$notification = array(
						'message' => 'Error occured, Please try again', 
						'alert-type' => 'error'
					);
					return Redirect::to('offers')->with($notification);
				}
			} else {	
				// Create Sale Offer
				if(count($wallet)>0){
					$offerArr = array(
						"user_id" => $uid,
						"coin_id" => $data['coins'],
						"type_id" => $data['type'],
						"location" => $location,
						"mode_id" => $data['payment_method'],
						"currency_id" => $currency_id,
						"mark_id" => $data['ab_bl'],
						"mark_value" => $data['per'],
						"trade" => $data['wanttobuy'],
						"min" => $data['min_range'],
						"max" => $data['max_range'],
						"headline" => $data['headline'],
						"offer" => $data['terms'],
						"timezone" => $data['timezone'],
						"open" => $data['timezone2'],
						"close" => $data['timezone3'],
						"status" => "1",
		    			"created_by" => $uid,
		    			"created_date" => date("Y-m-d H:i:s"),
		    			"created_ip" => $_SERVER['REMOTE_ADDR']
					);

					if($data['wanttobuy'] > $aval_balance) {

						$notification = array('message' => 'Insufficiant balance in your wallet to create an sell offer', 
							'alert-type' => 'error');
						return Redirect::to('offers')->with($notification);

					} else if($data['wanttobuy'] == $aval_balance) {

						$check = DB::table('a_offers')->insertGetId($offerArr);
						
						if($check) { 
							$notification = array( 'message' => 'Offer Has been created','alert-type' => 'success');
							return Redirect::to('my-offers')->with($notification);
						} else {
							$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
							return Redirect::to('offers')->with($notification);
						}
					} else {
						$check = DB::table('a_offers')->insertGetId($offerArr);
						if($check) { 
							$notification = array('message' => 'Offer Has been created', 'alert-type' => 'success');
							return Redirect::to('my-offers')->with($notification);
						} else {
							$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
							return Redirect::to('offers')->with($notification);
						}
					}
				} else {
					$notification = array('message' => 'please add token', 'alert-type' => 'error');
					return Redirect::to('offers')->with($notification);
				}
			}
		}
	}
    
	public function updateoffer() {

		$uid = Session::get('user_id');
		$data = Input::all();
		$offerId = $data['offerId'];

		if($data['_token']=="") { 
			$notification = array('message' => 'Bad request', 'alert-type' => 'warning');	
			return Redirect::to('login')->with($notification);
		} else {

			// if($data['location2']=="") {
			// 	$location = $data['location'];
			// } else {
			// 	$location = $data['location2'];
			// }

			// if($data['trade_cur2']=="") {

			// 	$n = "USDINR";
			// 	$check2 = DB::table('a_currency_list')->where('short',$n)->get();
			// 	foreach($check2 as $row2){}
			// 	$currency_id = $row2->id;

			// } else {

			// 	$n = "USD".$data['trade_cur2'];
			// 	$check2 = DB::table('a_currency_list')->where('short',$n)->get();
			// 	foreach($check2 as $row2){}
			// 	$currency_id = $row2->id;
			// }

			if($data['type']=="14") {

				$id = $data['offerId'];

				$array = array(
					// "user_id" => $uid,
					// "coin_id" => $data['coins'],
					// "type_id" => $data['type'],
					// "location" => $location,
					// "mode_id" => $data['payment_method'],
					// "currency_id" => $currency_id,
					// "mark_id" => $data['ab_bl'],
					// "mark_value" => $data['per'],
					"min" => $data['min_range'],
					"max" => $data['max_range'],
					// "headline" => $data['headline'],
					// "offer" => $data['terms'],
					// "timezone" => $data['timezone'],
					// "open" => $data['timezone2'],
					// "close" => $data['timezone3'],
	    			"modified_by" => $uid,
	    			"modified_date" => date("Y-m-d H:i:s"),
	    			"modified_ip" => $_SERVER['REMOTE_ADDR']
				);

				$check = DB::table('a_offers')->where('id',$offerId)->update($array);

				if($check) { 

					$notification = array(
						'message' => 'Offer Has been updated', 
						'alert-type' => 'success'
					);
					
					return Redirect::to('my-offers')->with($notification);

				} else {

					$notification = array(
						'message' => 'Error occured, Please try again', 
						'alert-type' => 'error'
					);
					
					return Redirect::to('offers')->with($notification);

				}

				
			} else {	 		

				// if($data['balance'] < $data['wanttobuy']) {

				// 	$notification = array(
				// 		'message' => 'Insufficiant balance in your wallet to create sell offer', 
				// 		'alert-type' => 'error'
				// 	);
					
				// 	return Redirect::to('offers')->with($notification);

				// } else {

					$array = array(

						// "user_id" => $uid,
						// "coin_id" => $data['coins'],
						// "type_id" => $data['type'],
						// "location" => $location,
						// "mode_id" => $data['payment_method'],
						// "currency_id" => $currency_id,
						// "mark_id" => $data['ab_bl'],
						// "mark_value" => $data['per'],
						// "trade" => $data['wanttobuy'],
						"min" => $data['min_range'],
						"max" => $data['max_range'],
						// "headline" => $data['headline'],
						// "offer" => $data['terms'],
						// "timezone" => $data['timezone'],
						// "open" => $data['timezone2'],
						// "close" => $data['timezone3'],
						// "modified_by" => $uid,
		    // 			"modified_date" => date("Y-m-d H:i:s"),
		    // 			"modified_ip" => $_SERVER['REMOTE_ADDR']
					);

					$check = DB::table('a_offers')->where('id',$offerId)->update($array);
					
					if($check) { 
						$notification = array('message' => 'Offer Has been updated', 'alert-type' => 'success');
						return Redirect::to('my-offers')->with($notification);
					} else {
						$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
						return Redirect::to('offers')->with($notification);
					}
			}			
		}
	}

    public function profile() {
		return View::make('profile');
	}
    
    public function contact() { 
		return View::make('contact');
	}
    
	
	// EXCHANGE COIN
	public function exchange() {
		$uid = Session::get('user_id'); 
		
		// if($uid==""){
		// 	return Redirect::to('login');
  //   	} else {
			
			$selectKey = DB::table('a_site_config')->select('value')->where('id','5')->get();
			$selectSecret = DB::table('a_site_config')->select('value')->where('id','6')->get();

			$data = array();		
			
			$apiKey  = $selectKey[0]->value;
			$apiSecret = $selectSecret[0]->value;

			// $apiKey  = "b1a12083dae2411f8e4830b6d9c1c2be";
			// $apiSecret = "24060b9c4eea8a52ab34c7855a5a5d80a677961c1005f22886fb05249aed5872";
			
			$apiUrl = 'https://api.changelly.com';
			
			// GET COIN LIST FROM API
			$message = json_encode(
				array('jsonrpc' => '2.0', 'id' => 1, 'method' => 'getCurrencies', 'params' => array())
			);
			$sign = hash_hmac('sha512', $message, $apiSecret);
			$requestHeaders = [
				'api-key:' . $apiKey,
				'sign:' . $sign,
				'Content-type: application/json'
			];
			$ch = curl_init($apiUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);			
			$response = curl_exec($ch);
			curl_close($ch);			
			$res = json_decode($response);
			$data['coins'] = $res->result;
			
			return View::make('exchange')->with($data);
		//}
	}
	
	// GET MINIMUM AMOUNT FOR EXACHANGE COIN FROM CHANGELLY API
	public function getMinAmount(){
		$data = Input::all();
		
		$selectKey = DB::table('a_site_config')->select('value')->where('id','5')->get();
		$selectSecret = DB::table('a_site_config')->select('value')->where('id','6')->get();

		$data = array();		
		$apiKey  = $selectKey[0]->value;
		$apiSecret = $selectSecret[0]->value;

		/*$apiKey  = "b1a12083dae2411f8e4830b6d9c1c2be";
		$apiSecret = "24060b9c4eea8a52ab34c7855a5a5d80a677961c1005f22886fb05249aed5872";*/
		$apiUrl = 'https://api.changelly.com';
		
		$message = json_encode( array('jsonrpc' => '2.0', 'id' => 'test', 'method' => 'getMinAmount', 
			'params' => array('from' => $data['form_coin'], 'to' => $data['to_coin'])));
			
		$sign = hash_hmac('sha512', $message, $apiSecret);
		$requestHeaders = [
			'api-key:' . $apiKey,
			'sign:' . $sign,
			'Content-type: application/json'
		];
		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	
	// ESTIMATE AMOUNT FOR COIN EXCHANGE
	public function estimateamt(){
		$data = Input::all();
		$to = $data['to_coin'];
		$from = $data['form_coin'];
		$amt = $data['exc_ammount'];
		
		$selectKey = DB::table('a_site_config')->select('value')->where('id','5')->get();
		$selectSecret = DB::table('a_site_config')->select('value')->where('id','6')->get();

		$data = array();		
		$apiKey  = $selectKey[0]->value;
		$apiSecret = $selectSecret[0]->value;

		$data = array();		
		/*$apiKey  = "b1a12083dae2411f8e4830b6d9c1c2be";
		$apiSecret = "24060b9c4eea8a52ab34c7855a5a5d80a677961c1005f22886fb05249aed5872";*/
		$apiUrl = 'https://api.changelly.com';
		
		$message = json_encode( array('jsonrpc' => '2.0', 'id' => 'test', 'method' => 'getExchangeAmount', 
			'params' => array('from' => $from, 'to' => $to, 'amount' => 1)));
		
		$sign = hash_hmac('sha512', $message, $apiSecret);
		$requestHeaders = [
			'api-key:' . $apiKey,
			'sign:' . $sign,
			'Content-type: application/json'
		];
		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
		$response = curl_exec($ch);
		curl_close($ch); 
		
		return $response;
	}
	
	public function generateAddress(){
		$data = Input::all();
		
		$from = $data['form_coin'];
		$to = $data['to_coin'];
		$address = $data['address'];
		
		$selectKey = DB::table('a_site_config')->select('value')->where('id','5')->get();
		$selectSecret = DB::table('a_site_config')->select('value')->where('id','6')->get();

		$data = array();		
		$apiKey  = $selectKey[0]->value;
		$apiSecret = $selectSecret[0]->value;
		

		/*$apiKey  = "b1a12083dae2411f8e4830b6d9c1c2be";
		$apiSecret = "24060b9c4eea8a52ab34c7855a5a5d80a677961c1005f22886fb05249aed5872";*/
		$apiUrl = 'https://api.changelly.com';
		
		$message1 = json_encode( array('jsonrpc' => '2.0', 'id' => 'test', 'method' => 'validateAddress', 
			'params' => array('currency' => $to, 'address' => $address)));
		$sign1 = hash_hmac('sha512', $message1, $apiSecret);
		$requestHeaders1 = [
			'api-key:' . $apiKey,
			'sign:' . $sign1,
			'Content-type: application/json'
		];
		$ch1 = curl_init($apiUrl);
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $message1);
		curl_setopt($ch1, CURLOPT_HTTPHEADER, $requestHeaders1);
		$response1 = curl_exec($ch1);
		curl_close($ch1);
		
		$res = json_decode($response1,true);
		
		if($res['result']['result'] == 1){
			$message = json_encode( array('jsonrpc' => '2.0', 'id' => 'test', 'method' => 'generateAddress', 
			'params' => array("from" => $from, 'to' => $to, 'address' => $address)));
			
			$sign = hash_hmac('sha512', $message, $apiSecret);
			$requestHeaders = [
				'api-key:' . $apiKey,
				'sign:' . $sign,
				'Content-type: application/json'
			];
			$ch = curl_init($apiUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
			$response = curl_exec($ch);
			curl_close($ch);
			
			return $response;
		}
		else {
			return $response1;
		}
	}
	
	// CREATE TRANSACTION API
	public function createTransaction(){
		
		$data = Input::all();
		
		if($data['_token'] ==''){
			$notification = array(
				'message' => 'Bad request', 
				'alert-type' => 'warning'
			);
			
			return Redirect::back()->with($notification);
		} else {
			
			$from = $data['form_coin'];
			$to = $data['to_coin'];
			$address = $data['user_address'];
			$amount = $data['exc_ammount'];
			
			$selectKey = DB::table('a_site_config')->select('value')->where('id','5')->get();
			$selectSecret = DB::table('a_site_config')->select('value')->where('id','6')->get();

			$data = array();		
			$apiKey  = $selectKey[0]->value;
			$apiSecret = $selectSecret[0]->value;
		

			/*$apiKey  = "b1a12083dae2411f8e4830b6d9c1c2be";
			$apiSecret = "24060b9c4eea8a52ab34c7855a5a5d80a677961c1005f22886fb05249aed5872";*/
			$apiUrl = 'https://api.changelly.com';
			
			$message = json_encode( array('jsonrpc' => '2.0', 'id' => 'test', 'method' => 'createTransaction', 
			'params' => array("from" => $from, 'to' => $to, 'address' => $address , 'amount' => $amount)));
			
			$sign = hash_hmac('sha512', $message, $apiSecret);
			$requestHeaders = [
				'api-key:' . $apiKey,
				'sign:' . $sign,
				'Content-type: application/json'
			];
			$ch = curl_init($apiUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
			$response = curl_exec($ch);
			curl_close($ch);
			$res = json_decode($response,true);
			
			// print_r($res); exit;

			if($res['result']['id'] != ''){
				$notification = array('message' => 'Exchange request placed successfully', 'alert-type' => 'success');
				return Redirect::back()->with($notification);
			}
			else {
				$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
				return Redirect::back()->with($notification);
			}
		}
	}
	
	
	
    public function apicheck() { 
	
   		$apiKey  = "b1a12083dae2411f8e4830b6d9c1c2be";
		$apiSecret = "24060b9c4eea8a52ab34c7855a5a5d80a677961c1005f22886fb05249aed5872";
		$apiUrl = 'https://api.changelly.com';
		
		$message = json_encode( array('jsonrpc' => '2.0', 'id' => 'test', 'method' => 'generateAddress', 
			'params' => array("from" => 'btc', 'to' => 'eth', 'address' => '0x45349aa0B3e945dA045d583422d3A553b03256B1')));
			
		$sign = hash_hmac('sha512', $message, $apiSecret);
		$requestHeaders = [
			'api-key:' . $apiKey,
			'sign:' . $sign,
			'Content-type: application/json'
		];
		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
		
	}
    

	/* FORGET PASSWORD */
    public function forgot() { 
		return View::make('forgot');
	}

	// update password link in mail 
	public function forgotRequest() {

		$data = Input::all();
   		$email = $data['email'];

   		if ($data['_token'] != '') {
   			
   			$user = DB::table('a_users')->where('email',$email)->get();
   		
	   		if (count($user)>0) {
	   			foreach ($user as $u) { }

			   	$userauth = DB::table('a_users_auth')->where('user_id',$u->id)->get();
			   	
				$value = rand(10000000,99999999);
				$link = url('/').'/reset-password/'.$u->id.'/'.$value.'?AuthToken='.md5($value);

				$changeauth = DB::table('a_users_auth')->where('user_id',$u->id)->update(array('value' => md5($value)));
				
				if ($changeauth) {

					$mail_data = array (
                            'email' => $user[0]->email, 
                            'user_name' => $user[0]->user_name, 
                            'actionURL' => $link);
                    
                    $mail = Mail::send(['html' => 'emails.forgot'], $mail_data, function($message) use ($mail_data) {
                        $message->to($mail_data['email'], $mail_data['user_name']);
                        $message->subject('Reset Password Link');
                        $message->from('info@erience.com', 'BitCoinNearMe');
                    });

					$notification = array('message' => 'Check your mail for reset password',
								'alert-type' => 'success');
					return Redirect::to('login')->with($notification);
				}
				else {
					$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
					return Redirect::to('login')->with($notification);
				}		
	   		} 
	   		else {
	   			$notification = array('message' => 'Email does not exists !', 'alert-type' => 'error');
				return Redirect::to('login')->with($notification);
	   		}
   		} else{
			$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error' );
			return Redirect::to('login')->with($notification);
   		}
	}

	// template form for reset password
	public function resetPassword($id='', $value='') {

		$data = array(
			'user_id' => $id,
			'value' => $value,
			'AuthToken' => $_GET['AuthToken'],
		);

		return View::make('reset_password')->with($data);
	}
    
    // update Password with auth token
	public function changeNewPassword(){

		$data = Input::all();
		if ($data['_token'] != '') {
			
			$id=$data['id'];
			$value=$data['value'];
			$token=$data['token'];

			$user = DB::table('a_users')->where('id',$id)->get();

			if (count($user)>0) {
	   			foreach ($user as $u) { }

			   	$userauth = DB::table('a_users_auth')->where('user_id',$u->id)->get();

	   			foreach ($userauth as $ua) { }

	   			if ($ua->value == $token && $ua->value == md5($value)) {

	   				if ($data['cPass'] == $data['newPass']) {

	   					$newPass = array('value'=>md5($data['cPass']));

		   				$changeauth = DB::table('a_users_auth')->where('user_id',$u->id)->update($newPass);

		   				if ($changeauth) {
		   					$notification = array(
								'message' => 'Password Has been Changed', 
								'alert-type' => 'success'
							);
							return Redirect::to('login')->with($notification);
		   				} else {
		   					$notification = array(
								'message' => 'Oops! Something Went Wrong.', 
								'alert-type' => 'error'
							);
							return Redirect::to('login')->with($notification);
		   				}
	   				} else {
	   					$notification = array(
							'message' => 'New Password And Confirm Password does not Match', 
							'alert-type' => 'error'
						);
						return Redirect::to('login')->with($notification);
	   				}

	   			} else {
	   				$notification = array(
							'message' => 'Authentication Token Not Valid! Try again.', 
							'alert-type' => 'error'
						);
					return Redirect::to('login')->with($notification);
	   			}
			} else {
				$notification = array(
							'message' => 'Error occured !', 
							'alert-type' => 'error'
						);
				return Redirect::to('login')->with($notification);
			}
		}
	}

	/* END FORGET PASSWORD */

    public function reset() {
		return View::make('reset');
	}
    
    public function login() {       
   		
   		$userType = Session::get('user_type');
   		$userName = Session::get('user_name');

   		if ($userType == '' && $userType == '') {
   			header("Cache-Control", "no-store,no-cache, must-revalidate, post-check=0, pre-check=0");
   			return View::make('login');
   		} else {
			return redirect('home');
   		}
	}

	public function logincheck(Request $request) {

		$data = Input::all();

		if($data['_token']=="") { 

			$notification = array('message' => 'Bad request', 'alert-type' => 'warning');
			return Redirect::to('login')->with($notification);

		} else {

			$user = DB::table('a_users')->where('user_name', $data['user_name'])->get();
			foreach ($user as $u) {
				$uname = $u->user_name;
				$user_type = $u->user_type;
				$email = $u->email;
				$mobile = $u->mobile;
				$uid = $u->id;
				$status = $u->status; 
			}

			if(count($user)=="0") {

				$notification = array(
					'message' => 'Username does not exist.', 
					'alert-type' => 'error'
				);
				
				return Redirect::to('login')->with($notification);

			} else {
				
				$password = DB::table('a_users_auth')->where('user_id', $user[0]->id)->get();

				if($password[0]->value == md5($data['password'])){

					if ($status == '1') {

						$code = md5(mt_rand(100000, 999999));
						$request->session()->put('user_id', $user[0]->id);
						$request->session()->put('session_code', $code);
						$request->session()->put('user_type', $user[0]->user_type);
						$request->session()->put('user_name', $user[0]->user_name);
						$request->session()->put('lastActivityTime', time());
						$session_id = Session::get('session_code');
						$userAgent = $request->server('HTTP_USER_AGENT');

						$dd = new DeviceDetector($userAgent);
						$dd->parse();
						$osInfo = $dd->getOs();

						$array = array(
							"user_id" => $user[0]->id,
							"session_code" => $session_id,
							"in_time" => date("Y-m-d H:i:s"),
							"os" => $osInfo['name']." ".$osInfo['version']. " ". $osInfo['platform'],
							"user_agent" => $request->server('HTTP_USER_AGENT'),
							"status" => "1",
							"created_by" => $user[0]->id,
							"created_date" => date("Y-m-d H:i:s"),
							"created_ip" => $request->ip(),
						);
					
						$check = DB::table('a_users_log')->insertGetId($array);

						$notification = array('message' => 'Your Login is Successful','alert-type' => 'success');
						if ($user[0]->user_type == 1) {							
							return Redirect::to('admin')->with($notification);
						} else {
							return Redirect::to('home')->with($notification);
						}

					} else if($status =='0'){
						$notification = array(
							'message' => 'Verify Your Account to start using BitcoinNearMe.',
							'alert-type' => 'warning'
						);
						return Redirect::to('login')->with($notification);
					} elseif ($status =='2') {
						$notification = array(
							'message' => 'Your account is suspended. Kindly contact support.',
							'alert-type' => 'warning'
						);
						return Redirect::to('login')->with($notification);
					}
				} else {
					$notification = array(
						'message' => 'Password Invalid.', 
						'alert-type' => 'error'
					);	
					return Redirect::to('login')->with($notification);
				}
			}
		}
	}
    
   /* public function register() {
   		
   		$userType = Session::get('user_type');
   		$userName = Session::get('user_name');

   		if ($userType == '' && $userType == '') {

			return View::make('register2');
		}
		else {
			return Redirect::to('home');
		}
		
	}*/

	public function faqs() {
		$data = array();
		$select= DB::table('a_site_pages')->where('id','1')->get();
		$data['body'] = $select[0]->body;
		$data['title'] = $select[0]->title; 
		$data['keyword'] = $select[0]->keyword;
		return View::make('faqs')->with($data);
	}

	public function affiliate() {
		$data = array();
		$select= DB::table('a_site_pages')->where('id','5')->get();
		$data['body'] = $select[0]->body;
		$data['title'] = $select[0]->title; 
		$data['keyword'] = $select[0]->keyword;
		return View::make('affiliate')->with($data);
	}
	public function how_to_buy() {
		$data = array();
		$select= DB::table('a_site_pages')->where('id','4')->get();
		$data['body'] = $select[0]->body;
		$data['title'] = $select[0]->title; 
		$data['keyword'] = $select[0]->keyword;
		return View::make('howtobuy')->with($data);
	}

	public function terms(){
		$data = array();
		$select= DB::table('a_site_pages')->where('id','2')->get();
		$data['body'] = $select[0]->body;
		$data['title'] = $select[0]->title; 
		$data['keyword'] = $select[0]->keyword; 
		return View::make('Terms')->with($data);
	}

	public function privacy_policy(){
		$data = array();
		$select= DB::table('a_site_pages')->where('id','3')->get();
		$data['body'] = $select[0]->body;
		$data['title'] = $select[0]->title; 
		$data['keyword'] = $select[0]->keyword; 
		return View::make('privacy_policy')->with($data);
	}

	public function logout(Request $request) {
	
	$uid = Session::get('user_id');

		if ($uid == '') {
			$notification = array('message' => 'Logout success', 'alert-type' => 'success' );
			return Redirect::to('home')->with($notification);
		} else {
			$session_id = Session::get('session_code');
			$array = array("out_time" => date("Y-m-d H:i:s"));
			$check = DB::table('a_users_log')->where('session_code',$session_id)->update($array);

			if($check) {

				$ses = array('user_id', 'session_code', 'user_type', 'user_name');
				$request->session()->forget($ses);
				$request->session()->flush();

				$notification = array('message' => 'Logout success', 'alert-type' => 'success');
				
				return Redirect::to('home')->with($notification);
			} else{
				return Redirect::to('home');	
			}
		}
	}

	/*public function insertuser(Request $request) {

		$data = Input::all();

		if($data['_token']=="") { 

			$notification = array('message' => 'Bad request', 'alert-type' => 'warning');
			
			return Redirect::to('register')->with($notification);

		} else {

		        $validator = Validator::make($data, 
		        	[ 
		        		'user_name' => 'required|string|max:16|alpha_dash',
		        		'email' => 'required|email|unique:users,email,user_name',
		        		'mobile' => 'required|numeric',
		        		'country' => 'required',
		        		'password' => 'required|string|min:6|max:14',
		        		'cpassword' => 'required|string|min:6|max:14',
		        	],
		        	[
		        		'user_name.required' => "Username must be Required!",
		        		'user_name.string' => "Username should contain only string!",
		        		'user_name.max' => "Username should contain Maximum 16 character!",
		        		'user_name.alpha_dash' => "White space not allowed in username!",
		        		'email.required' => "Email must be Required!",
		        		'email.email' => "Please enter your valid email id!",
		        		'email.unique' => "Already exist this email!",
		        		'country.required' => "Country must be required!",
		        		'mobile.required' => "Mobile number must be Required!",
		        		'mobile.string' => "Mobile should contain only number digit!",
		        		'password.required' => "Password is required!",
		        		'password.min' => "Password should contain minimum 6 letter!",
		        		'cpassword.required' => "Confirm Password is required!",
		        		'cpassword.required' => "Confirm Password is required!",
		        		'cpassword.min' => "Confirm Password should contain minimum 6 letter!",
		        	]
		    	);

	            if ($validator->fails()) {
					return Redirect::to('register')->withErrors($validator);
	            } 
	            else {

						if($data['password']!=$data['cpassword']) {

							$notification = array('message' => 'Password does not matched', 'alert-type' => 'error');
							return Redirect::to('register')->with($notification);

						} else  {

							$user = DB::table('a_users')->where('user_name', $data['user_name'])->get();
							
							// Referrel Check 
							if (!empty($data['referral']) && $data['referral'] != '') {
								
								$ref_user = DB::table('a_users')->where('user_name',$data['referral'])->get();

								if (!empty($ref_user) && $ref_user != '') {
									foreach ($ref_user as $row) {
										$ref_uid = $row->id;
									}
								}
								else {
									$notification = array('message' => 'Invalid Referrel Code', 'alert-type' => 'error');
										
									return Redirect::to('register')->with($notification);
								}
							}
							// end refferal Check

							if(count($user) === 0) {

								// echo "Username not exist"; exit;

								$email = DB::table('a_users')->where('email', $data['email'])->get();

								if(count($email) == 0){

									$array = array(
			                            'user_type'      => "2",
			                            'user_name'     => $data['user_name'],
			                            'email'      => $data['email'],
			                            'mobile'   => 	$data['mobile'],
			                            'country'   => 	$data['country'],
			                            'status'    => "0",
			                            'created_by'       => "1",
			                            'created_date'  => date("Y-m-d H:i:s"),
			                            'created_ip' => $_SERVER['REMOTE_ADDR']
			                        );

									$check = DB::table('a_users')->insertGetId($array);

									$insert_id = DB::getPdo()->lastInsertId();

										if (!empty($ref_uid) && $ref_uid != '') {
										
											$array_aff = array(
					                            'user_id'      => $insert_id,
					                            'source'     => $ref_uid,
												'claim' => "2",
					                            'status'    => "1",
					                            'created_by'       => "1",
					                            'created_date'  => date("Y-m-d H:i:s"),
					                            'created_ip' => $_SERVER['REMOTE_ADDR']
					                        );

											$check_aff = DB::table('a_affiliate_list')->insertGetId($array_aff);

									}

									$array_p = array(
			                            'user_id'      => $insert_id,
			                            'auth_type'     => "1",
			                            'value'      => md5($data['password']),
			                            'status'    => "0",
			                            'created_by'       => "1",
			                            'created_date'  => date("Y-m-d H:i:s"),
			                            'created_ip' => $_SERVER['REMOTE_ADDR']
			                        );

									$check_p = DB::table('a_users_auth')->insertGetId($array_p);
									
									$array_info = array(
										'user_id'      => $insert_id,
										'status'    => "0",
			                            'created_by'       => "1",
			                            'created_date'  => date("Y-m-d H:i:s"),
			                            'created_ip' => $_SERVER['REMOTE_ADDR']
									);
									
									$chk_info = DB::table('a_users_info')->insertGetId($array_info);

									$curl1 = curl_init();
									curl_setopt_array($curl1, array(
									    CURLOPT_URL => "http://54.175.53.61:8080/createbtc/",
									    CURLOPT_RETURNTRANSFER => true,
									    CURLOPT_ENCODING => "",
									    CURLOPT_TIMEOUT => 30000,
									    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									    CURLOPT_CUSTOMREQUEST => "GET",
									    CURLOPT_HTTPHEADER => array('Content-Type: application/json',),
									));
									$response1 = curl_exec($curl1);
									curl_close($curl1);
								    $btc = json_decode($response1,true);

								    $curl2 = curl_init();
									curl_setopt_array($curl2, array(
									    CURLOPT_URL => "http://54.175.53.61:8080/createhdeth/".$insert_id,
									    CURLOPT_RETURNTRANSFER => true,
									    CURLOPT_ENCODING => "",
									    CURLOPT_TIMEOUT => 30000,
									    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									    CURLOPT_CUSTOMREQUEST => "GET",
									    CURLOPT_HTTPHEADER => array('Content-Type: application/json',),
									));
									$response2 = curl_exec($curl2);
									curl_close($curl2);
								    $eth = json_decode($response2,true);

								    $curl3 = curl_init();
									curl_setopt_array($curl3, array(
									    CURLOPT_URL => "http://54.175.53.61:8080/createltc/",
									    CURLOPT_RETURNTRANSFER => true,
									    CURLOPT_ENCODING => "",
									    CURLOPT_TIMEOUT => 30000,
									    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									    CURLOPT_CUSTOMREQUEST => "GET",
									    CURLOPT_HTTPHEADER => array('Content-Type: application/json',),
									));
									$response3 = curl_exec($curl3);
									curl_close($curl3);
								    $ltc = json_decode($response3,true);

									$array1 = array(
										'coin_id'     => "1",
			                            'user_id'      => $insert_id,
			                            'address'      => $btc['address'],
			                            "type" => "8",
			                            'status'    => "1",
			                            'created_by'       => "1",
			                            'created_date'  => date("Y-m-d H:i:s"),
			                            'created_ip' => $_SERVER['REMOTE_ADDR']
			                        );

									$check1 = DB::table('a_coin_wallet')->insertGetId($array1);	

									$array2 = array(
										'coin_id'     => "2",
			                            'user_id'      => $insert_id,
			                            'address'      => $eth['address'],
			                            "type" => "8",
			                            'status'    => "1",
			                            'created_by'       => "1",
			                            'created_date'  => date("Y-m-d H:i:s"),
			                            'created_ip' => $_SERVER['REMOTE_ADDR']
			                        );
									$check2 = DB::table('a_coin_wallet')->insertGetId($array2);	

									$array3 = array(
										'coin_id'     => "3",
			                            'user_id'      => $insert_id,
			                            'address'      => $ltc['address'],
			                            "type" => "8",
			                            'status'    => "1",
			                            'created_by'       => "1",
			                            'created_date'  => date("Y-m-d H:i:s"),
			                            'created_ip' => $_SERVER['REMOTE_ADDR']
			                        );
									$check3 = DB::table('a_coin_wallet')->insertGetId($array3);

									if($check && $check1 && $check2 && $check3) { 

										$select = DB::table('a_site_config')->where('id',2)->get();
										$authkey = $select[0]->value;
										$link = url('/').'/verify-email/'.$insert_id.'/'.$data['email'].'?VerifyMailToken='.md5($data['password']);
										$to = $data['email'];
										$from = "no-reply@crypscrow.com";							
										$subject = "BitcoinNearMe Account Activation";
										$body = "<body><h2>Dear ".$data['user_name'].",</h2><br><p>Please verify your account by clicking on <a href=".$link." target=_blank>".$link."</a>. You would not be able to login unless you verify your account.</p><br><p>Thank you,</p><p>Team BitcoinNearMe</p></body>";

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

										$notification = array(
											'message' => 'Registration Successfull! Please Verify your account to activate.', 
											'alert-type' => 'success' );
										return Redirect::to('register')->with($notification);
									} else {
										$notification = array('message' => 'Error occured, Please try again', 
											'alert-type' => 'error');
										return Redirect::to('register')->with($notification);
									}
								} else {
									$notification = array('message' => 'Email already exists', 'alert-type' => 'error');
									return Redirect::to('register')->with($notification);
								}

							} else {
								// echo "Username already exist"; exit;

								$notification = array('message' => 'Username already exists', 'alert-type' => 'error');
								return Redirect::to('register')->with($notification);
							}
						}
				}
		}
	}*/

	/*public function verifyEmail($id='', $email=''){
		
		$where = array('id' => $id, 'email'=>$email);
		$user = DB::table('a_users')->where($where)->get();
		$token = $_GET['VerifyMailToken'];
		if ($user != '') {			

			$userAuth = DB::table('a_users_auth')->where(array('user_id'=>$id))->get();

			if ($userAuth[0]->value == $token) {
				DB::table('a_users')->where($where)->update(array('status'=> '1'));
				DB::table('a_users_auth')->where(array('user_id'=>$id))->update(array('status'=> '1'));
				DB::table('a_users_info')->where(array('user_id'=>$id))->update(array('status'=> '1'));
				$notification = array('message' => 'Account Verified Successfully!', 'alert-type' => 'success');
				return Redirect::to('login')->with($notification);
			} 
			else {
				$notification = array('message' => 'Token Not Valid!', 'alert-type' => 'error');
				return Redirect::to('login')->with($notification);
			}
		}
		else {
			$notification = array('message' => 'Error occured, Please try again', 'alert-type' => 'error');
			return Redirect::to('login')->with($notification);
		}
	}*/


	public function coincron(){


		$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=7e7c8486-0798-417d-8fa2-755a26e16bf3';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);	
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result);
	    
	    $btc_ticker = array(
	    	"label" => $result->data[0]->symbol,
	    	"name" => $result->data[0]->name,
	    	"description" => $result->data[0]->name,
	    	"type" => "coin",
	    	// "chart" => $result->data[0]->symbol,
	    	"price" => $result->data[0]->quote->USD->price,
	    	// "status" => "1",
	    	"modified_by" => "1",
	    	"modified_date" => date("Y-m-d H:i:s"),
	    	"modified_ip" => $_SERVER['REMOTE_ADDR']
    	);

    	$check = DB::table('a_coin_info')->where('label',"BTC")->update($btc_ticker);

    	$eth_ticker = array(

	    	"label" => $result->data[1]->symbol,
	    	"name" => $result->data[1]->name,
	    	"description" => $result->data[1]->name,
	    	"type" => "coin",
	    	// "chart" => $result->data[1]->symbol,
	    	"price" => $result->data[1]->quote->USD->price,
	    	// "status" => "1",
	    	"modified_by" => "1",
	    	"modified_date" => date("Y-m-d H:i:s"),
	    	"modified_ip" => $_SERVER['REMOTE_ADDR']

    	);

    	$check1 = DB::table('a_coin_info')->where('label',"ETH")->update($eth_ticker);

    	$ltc_ticker = array(

	    	"label" => $result->data[3]->symbol,
	    	"name" => $result->data[3]->name,
	    	"description" => $result->data[3]->name,
	    	"type" => "coin",
	    	// "chart" => $result->data[3]->symbol,
	    	"price" => $result->data[3]->quote->USD->price,
	    	// "status" => "1",
	    	"modified_by" => "1",
	    	"modified_date" => date("Y-m-d H:i:s"),
	    	"modified_ip" => $_SERVER['REMOTE_ADDR']

    	);

    	$check2 = DB::table('a_coin_info')->where('label',"LTC")->update($ltc_ticker);

	}

	/*public function currencycroninsert() {

		$url = "https://www.freeforexapi.com/api/live?pairs=USDAED,USDAFN,USDALL,USDAMD,USDANG,USDAOA,USDARS,USDATS,USDAUD,USDAWG,USDAZM,USDAZN,USDBAM,USDBBD,USDBDT,USDBEF,USDBGN,USDBHD,USDBIF,USDBMD,USDBND,USDBOB,USDBRL,USDBSD,USDBTN,USDBWP,USDBYN,USDBYR,USDBZD,USDCAD,USDCDF,USDCHF,USDCLP,USDCNH,USDCNY,USDCOP,USDCRC,USDCUC,USDCUP,USDCVE,USDCYP,USDCZK,USDDEM,USDDJF,USDDKK,USDDOP,USDDZD,USDEEK,USDEGP,USDERN,USDESP,USDETB,USDEUR,USDFIM,USDFJD,USDFKP,USDFRF,USDGBP,USDGEL,USDGGP,USDGHC,USDGHS,USDGIP,USDGMD,USDGNF,USDGRD,USDGTQ,USDGYD,USDHKD,USDHNL,USDHRK,USDHTG,USDHUF,USDIDR,USDIEP,USDILS,USDIMP,USDINR,USDIQD,USDIRR,USDISK,USDITL,USDJEP,USDJMD,USDJOD,USDJPY,USDKES,USDKGS,USDKHR,USDKMF,USDKPW,USDKRW,USDKWD,USDKYD,USDKZT,USDLAK,USDLBP,USDLKR,USDLRD,USDLSL,USDLTL,USDLUF,USDLVL,USDLYD,USDMAD,USDMDL,USDMGA,USDMGF,USDMKD,USDMMK,USDMNT,USDMOP,USDMRO,USDMRU,USDMTL,USDMUR,USDMVR,USDMWK,USDMXN,USDMYR,USDMZM,USDMZN,USDNAD,USDNGN,USDNIO,USDNLG,USDNOK,USDNPR,USDNZD,USDOMR,USDPAB,USDPEN,USDPGK,USDPHP,USDPKR,USDPLN,USDPTE,USDPYG,USDQAR,USDROL,USDRON,USDRSD,USDRUB,USDRWF,USDSAR,USDSBD,USDSCR,USDSDD,USDSDG,USDSEK,USDSGD,USDSHP,USDSIT,USDSKK,USDSLL,USDSOS,USDSPL,USDSRD,USDSRG,USDSTD,USDSTN,USDSVC,USDSYP,USDSZL,USDTHB,USDTJS,USDTMM,USDTMT,USDTND,USDTOP,USDTRL,USDTRY,USDTTD,USDTVD,USDTWD,USDTZS,USDUAH,USDUGX,USDUSD,USDUYU,USDUZS,USDVAL,USDVEB,USDVEF,USDVES,USDVND,USDVUV,USDWST,USDXAF,USDXAG,USDXAU,USDXBT,USDXCD,USDXDR,USDXOF,USDXPD,USDXPF,USDXPT,USDYER,USDZAR,USDZMK,USDZMW,USDZWD";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);	
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result);
		// echo "<pre>";
		foreach ($response->rates as $key=>$value){

			$short = $key;
			$rate = $value->rate;

			$array2 = array(
				'short'     => $short,
                'rate'      => $rate,
                'status'    => "1",
                'created_by'       => "1",
                'created_date'  => date("Y-m-d H:i:s"),
                'created_ip' => $_SERVER['REMOTE_ADDR']
            );

			$check2 = DB::table('a_currency_list')->insertGetId($array2);	
			
		}
	}*/

	public function currencycronupdate() {

		$url = "https://www.freeforexapi.com/api/live?pairs=USDAED,USDAFN,USDALL,USDAMD,USDANG,USDAOA,USDARS,USDATS,USDAUD,USDAWG,USDAZM,USDAZN,USDBAM,USDBBD,USDBDT,USDBEF,USDBGN,USDBHD,USDBIF,USDBMD,USDBND,USDBOB,USDBRL,USDBSD,USDBTN,USDBWP,USDBYN,USDBYR,USDBZD,USDCAD,USDCDF,USDCHF,USDCLP,USDCNH,USDCNY,USDCOP,USDCRC,USDCUC,USDCUP,USDCVE,USDCYP,USDCZK,USDDEM,USDDJF,USDDKK,USDDOP,USDDZD,USDEEK,USDEGP,USDERN,USDESP,USDETB,USDEUR,USDFIM,USDFJD,USDFKP,USDFRF,USDGBP,USDGEL,USDGGP,USDGHC,USDGHS,USDGIP,USDGMD,USDGNF,USDGRD,USDGTQ,USDGYD,USDHKD,USDHNL,USDHRK,USDHTG,USDHUF,USDIDR,USDIEP,USDILS,USDIMP,USDINR,USDIQD,USDIRR,USDISK,USDITL,USDJEP,USDJMD,USDJOD,USDJPY,USDKES,USDKGS,USDKHR,USDKMF,USDKPW,USDKRW,USDKWD,USDKYD,USDKZT,USDLAK,USDLBP,USDLKR,USDLRD,USDLSL,USDLTL,USDLUF,USDLVL,USDLYD,USDMAD,USDMDL,USDMGA,USDMGF,USDMKD,USDMMK,USDMNT,USDMOP,USDMRO,USDMRU,USDMTL,USDMUR,USDMVR,USDMWK,USDMXN,USDMYR,USDMZM,USDMZN,USDNAD,USDNGN,USDNIO,USDNLG,USDNOK,USDNPR,USDNZD,USDOMR,USDPAB,USDPEN,USDPGK,USDPHP,USDPKR,USDPLN,USDPTE,USDPYG,USDQAR,USDROL,USDRON,USDRSD,USDRUB,USDRWF,USDSAR,USDSBD,USDSCR,USDSDD,USDSDG,USDSEK,USDSGD,USDSHP,USDSIT,USDSKK,USDSLL,USDSOS,USDSPL,USDSRD,USDSRG,USDSTD,USDSTN,USDSVC,USDSYP,USDSZL,USDTHB,USDTJS,USDTMM,USDTMT,USDTND,USDTOP,USDTRL,USDTRY,USDTTD,USDTVD,USDTWD,USDTZS,USDUAH,USDUGX,USDUSD,USDUYU,USDUZS,USDVAL,USDVEB,USDVEF,USDVES,USDVND,USDVUV,USDWST,USDXAF,USDXAG,USDXAU,USDXBT,USDXCD,USDXDR,USDXOF,USDXPD,USDXPF,USDXPT,USDYER,USDZAR,USDZMK,USDZMW,USDZWD";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);	
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result);
		// echo "<pre>";
		foreach ($response->rates as $key=>$value){

			$short = $key;
			$rate = $value->rate;

			$array2 = array('rate' => $rate);

			$check2 = DB::table('a_currency_list')->where("short",$key)->update($array2);	
			
		}
	}
    
    public function trade() {
    	$uid = Session::get('user_id');
    	$contract = request()->segment(2);
    	if($uid==""){			
			return Redirect::to('login');
    	} else {
	    	$array = array();
	    	$select = DB::table('a_contract')->where('id',$contract)->get();
			if(count($select) > 0){
				foreach($select as $row) {

					$offer = DB::table('a_offers')->where('id',$row->offer_id)->get();
					foreach($offer as $o){}

					if($o->type_id=="15") {

						Cookie::queue("contract_id", $row->id);
						$msg = DB::table('a_chat')->where('contract_id',$row->id)->get();
						$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
						foreach($currency as $cr){}		

						$cur = explode("USD",$cr->short);

						if($row->from_user==$uid) {	

							$off_user = DB::table('a_users')->where('id',$row->to_user)->get();
							foreach($off_user as $ou){}

						} else if($row->to_user==$uid) {	

							$off_user = DB::table('a_users')->where('id',$row->from_user)->get();
							foreach($off_user as $ou){}				

						}

						$cinfo = DB::table('a_coin_info')->where("id",$o->coin_id)->where('status',"1")->get();
						foreach($cinfo as $ci){}
						$cname = $ci->label;

						if($o->user_id==$uid && $o->type_id=="14"){
							$type="Buying";
						} else if($o->user_id==$uid && $o->type_id=="15"){
							$type="Selling";
						}

						if($row->from_user==$uid && $o->type_id=="14"){
							$type1="Selling";
						} else if($row->from_user==$uid && $o->type_id=="15"){
							$type1="Buying";
						}

						if($row->from_user==$uid) {	
							$ty = $type1;
						} else if($row->to_user==$uid){
							$ty = $type;
						}

						if($ty=="Buying"){
							$dir = "from";
							$ty2 = "Seller";
						} else if($ty=="Selling"){
							$dir = "to";
							$ty2 = "Buyer";
						}

						if($row->from_user==$uid){
							$can = "OK";
						} else {
							$can = "NOTOK";
						}

						$mode = DB::table('a_payment_mode')->where("id",$o->mode_id)->get();
						foreach($mode as $m){}

							$scrp = "1";

						$array[] = array(
							"user_name" => $ou->user_name,
							"cname" => $cname,
							"from_user" => $row->from_user,
							"to_user" => $row->to_user,
							"type" => $ty,
							"ses_id" => $uid, 
							"dir" => $dir,
							"type2" => $ty2,
							"can" => $can,
							"crypto" => $row->crypto_value,
							"fiat" => $row->fiat_value,
							"currency" => $cur[1],
							"crusd" => $ci->price,
							"mod" => $m->name,
							"des" => $o->offer,
							"id" => $row->id,
							"co_status" => $row->co_status,
							"messages" => $msg,
							"uid" => $uid,
							"from_user" => $row->from_user,
							"to_user" => $row->to_user,
							"tr_status" => $row->tr_status,
							"despute" => $row->despute,
							"scrp" => $scrp
						);

					} else if($o->type_id=="14") {

						Cookie::queue("contract_id", $row->id);

						$msg = DB::table('a_chat')->where('contract_id',$row->id)->get();						

						$currency = DB::table('a_currency_list')->where("id",$row->currency_id)->get();
						foreach($currency as $cr){}		

						$cur = explode("USD",$cr->short);

						if($row->from_user==$uid) {	

							$off_user = DB::table('a_users')->where('id',$row->to_user)->get();
							foreach($off_user as $ou){}

						} else if($row->to_user==$uid) {	

							$off_user = DB::table('a_users')->where('id',$row->from_user)->get();
							foreach($off_user as $ou){}				

						}

						$cinfo = DB::table('a_coin_info')->where("id",$o->coin_id)->get();
						foreach($cinfo as $ci){}	
						$cname = $ci->label;

						if($o->user_id==$uid && $o->type_id=="14"){
							$type="Buying";
						} else if($o->user_id==$uid && $o->type_id=="15"){
							$type="Selling";
						}

						if($row->from_user==$uid && $o->type_id=="14"){
							$type1="Selling";
						} else if($row->from_user==$uid && $o->type_id=="15"){
							$type1="Buying";
						}

						if($row->from_user==$uid) {	
							$ty = $type1;
						} else if($row->to_user==$uid){
							$ty = $type;
						}

						if($ty=="Buying") {
							$dir = "from";
							$ty2 = "Seller";
						} else if($ty=="Selling") {
							$dir = "to";
							$ty2 = "Buyer";
						}

						if($row->from_user==$uid){
							$can = "OK";
						} else {
							$can = "NOTOK";
						}

						$mode = DB::table('a_payment_mode')->where("id",$o->mode_id)->get();
						foreach($mode as $m){}	
							$scrp = "2";
						$array[] = array(
							"user_name" => $ou->user_name,
							"cname" => $cname,
							"from_user" => $row->from_user,
							"to_user" => $row->to_user,
							"type" => $ty,
							"ses_id" => $uid,
							"dir" => $dir,
							"type2" => $ty2,
							"can" => $can,
							"crypto" => $row->crypto_value,
							"fiat" => $row->fiat_value,
							"currency" => $cur[1],
							"crusd" => $ci->price,
							"mod" => $m->name,
							"des" => $o->offer,
							"id" => $row->id,
							"co_status" => $row->co_status,
							"messages" => $msg,
							"uid" => $uid,
							"from_user" => $row->from_user,
							"to_user" => $row->to_user,
							"tr_status" => $row->tr_status,
							"despute" => $row->despute,
							"scrp" => $scrp
						);
					}
				}
				foreach($array as $row){}
				$data = array("contract"=>$row);
				return View::make('open-trades')->with($data);
			}
			else {
				$notification = array('message' => 'Oops! Something wrong.','alert-type' => 'error');
				return Redirect::to('my-trades')->with($notification);
			}
		}
	}
	
	public function report_user(Request $request){
		$uid = Session::get('user_id');
		
		if($uid=="") {
			return Redirect::to('login');
    	} else {

    		$post = Input::all();
    		// $contract_id = $post['contract_id'];
    		$report_to = $post['report_to'];
    		// $title = $post['title'];
    		// $message = $post['comment'];
    		// $file = $request->file('image');

			/*if($file=="") {
				$file1 = "";
				$validator = Validator::make($request->all(),['title' => 'required', 'comment' => 'required']);
			} else {
				$validator = Validator::make($request->all(), ['title' => 'required', 'comment' => 'required']);
				$file->move('images',$file->getClientOriginalName());
				$file1 = $file->getClientOriginalName();
			}	*/	
/*
    		if ($validator->fails()) {
    			$error = '';
    			$errors = $validator->errors();

    			foreach ($errors->all() as $err) {
    				$error = $error .' ' . $err;
    			}
				$notification = array('message' => $error,'alert-type' => 'error');
    			return Redirect::back()->with($notification);
    		} else{ 

    			// $contract = DB::table('a_contract')->where('id',$contract_id)->get();
		    	// foreach ($contract as $row) { } */
		    	
		    	$users = DB::table('a_users')->where('id',$report_to)->first();
		    	$report = DB::table('a_report_user')

		    	->where('user_id',$uid)->where('report_to',$report_to)->get();
		    	if (count($report) > 0) {
		    		$notification = array('message' => 'This user has already been reported by you.','alert-type' => 'error');
					return Redirect::back()->with($notification);
		    	} else {	
			    	$array = array(
						//"contract_id" => $contract_id,
						"user_id" => $uid,
						"report_to" => $report_to,
						//'title' => $title,
						//'message' => $message,
						//'file' => $file1,
						"status" => "1",
						"created_by" => $uid,
						"created_date" =>  date("Y-m-d H:i:s"),
		                'created_ip' => $_SERVER['REMOTE_ADDR']
					);
			    	$inserId = DB::table('a_report_user')->insertGetId($array);
			    	if ($inserId != '') {
						$notification = array('message' => 'The request to report '. $users->user_name.' has been sent successfully.', 
							'alert-type' => 'success');
						return Redirect::back()->with($notification);
					} else {
						$notification = array('message' => 'Oops! Something wrong, please try again.','alert-type' => 'error');
						return Redirect::back()->with($notification);
					}
    		}			
    	}
	}


	public function dispute(Request $request) {
		
		$uid = Session::get('user_id');
		
		if($uid=="") {
			return Redirect::to('login');
    	} else {
    	
    		$post = Input::all();
    		$contract_id = $post['contract_id'];
    		$title = $post['title'];
    		$message = $post['comment'];
    		$file = $request->file('image');

			if($file=="") {
				$file1 = "";
			} else {
				$file->move('images',$file->getClientOriginalName());
				$file1 = $file->getClientOriginalName();
			}

    		$contract = DB::table('a_contract')->where('id',$contract_id)->get();
	    	foreach ($contract as $row) { }

    		if ($row->despute == '2') {
    			$notification = array('message' => 'Already dispute.','alert-type' => 'warning');
				return Redirect::to('trade/'.$contract_id)->with($notification);
			} else {
				$array = array(
						"contract_id" => $contract_id,
						"user_id" => $uid,
						'title' => $title,
						'message' => $message,
						'file' => $file1,
						"status" => "1",
						"created_by" => $uid,
						"created_date" =>  date("Y-m-d H:i:s"),
	                    'created_ip' => $_SERVER['REMOTE_ADDR']
				);

				$ch1 = DB::table('a_dispute')->insertGetId($array);

				if ($ch1 != '') {
					$check = DB::table('a_contract')->where('id',$contract_id)->update(array('despute' => "2"));
						if ($check) {
							$notification = array('message' => 'The request for dispute has been successfully sent.', 'alert-type' => 'success');
							return Redirect::to('trade/'.$contract_id)->with($notification);
						} else {
							$notification = array('message' => 'Oops! Something wrong, please try again.','alert-type' => 'error');
							return Redirect::to('trade/'.$contract_id)->with($notification);
						}	
				} else {
					$notification = array('message' => 'Oops! Something wrong, please try again.','alert-type' => 'error');
					return Redirect::to('trade/'.$contract_id)->with($notification);
				}
			}
		}
	}
	
	public function dispute_info($contract_id) {
		$uid = Session::get('user_id');
		if ($uid == '') {
			return Redirect::to('login');
		} else {
			$data = array();
			$where = array('id' => $contract_id, 'despute' => '2');
			$data['contract_id'] = $contract_id;
			$contract = DB::table('a_contract')->where($where)->first();
			if (!empty($contract)) {
				if ($uid == $contract->from_user || $uid == $contract->to_user) {

					$offer = DB::table('a_offers')->where('id',$contract->offer_id)->first();
					$despute = DB::table('a_dispute')->select('id','contract_id','user_id','title','message','file')->where('contract_id',$contract_id)->first();
					$currency = DB::table('a_currency_list')->where("id",$contract->currency_id)->first();
					$cur = explode("USD",$currency->short);
					$pay_type = DB::table('a_payment_mode')->where("id",$offer->mode_id)->first();
					$cinfo = DB::table('a_coin_info')->where("id",$offer->coin_id)->first();
					$msg = DB::table('a_dispute_info')->where('dispute_id',$despute->id)->get();
					$dispute_by = DB::table('a_users')->select('id','user_name','email','mobile')->where("id",$despute->user_id)->first();

					if ($offer->type_id == '15') { // Sell offer
						//echo "Sell";
						if ($uid == $contract->from_user) {
							// User is Buyer
							$type="Buying";
							$role = "Buyer";
							$dir = "from";
						} else {
							// User is Seller
							$type="Selling";
							$role = "Seller";
							$dir = "to";
						}
						$scrp = "1";

						if ($offer->user_id == $contract->from_user) {
							$buyer_id = $contract->from_user;
							$seller_id = $contract->to_user;
						} else {
							$seller_id = $contract->from_user;
							$buyer_id = $contract->to_user;
						}
					}
					if ($offer->type_id == '14') {  // Buy offer
						// echo "Buy";	
						if ($uid == $contract->from_user) {
							// User is Seller 
							$type="Selling";
							$role = "Seller";
							$dir = "to";
						} else {
							// User is Buyer
							$type="Buying";
							$role = "Buyer";
							$dir = "from";
						}
						$scrp = "2";
						if ($offer->user_id == $contract->from_user) {
							$buyer_id = $contract->from_user;
							$seller_id = $contract->to_user;
						} else {
							$seller_id = $contract->from_user;
							$buyer_id = $contract->to_user;
						}
					}

					$buyer_info = DB::table('a_users')->select('id','user_name','email','mobile')->where("id",$buyer_id)->first();
					$seller_info = DB::table('a_users')->select('id','user_name','email','mobile')->where("id",$seller_id)->first();
					
					if($type=="Buying"){
						$dir = "from";
						$type2 = "Seller";
					} else if($type=="Selling"){
						$dir = "to";
						$type2 = "Buyer";
					}

					if ($contract->tr_status == '') {
						$tr_status = '2';
					} else {
						$tr_status = $contract->tr_status;
					}
					$data['ses_id'] = $uid;
					$data['uid'] = $uid;
					$data['from_user'] = $contract->from_user;
					$data['to_user'] = $contract->to_user;
					$data['crypto'] = $contract->crypto_value;
					$data['fiat'] = $contract->fiat_value;
					$data['co_status'] = $contract->co_status;
					$data['tr_status'] = $tr_status;
					$data['curusd'] = $cinfo->price;
					$data['dir'] = $dir;
					$data['coin_name'] = $cinfo->label;
					$data['currency'] = $cur[1];
					$data['type'] = $type;
					$data['type2'] = $type2;
					$data['role'] = $role;
					$data['scrp'] = $scrp;
					$data['description'] = $offer->offer;
					$data['payment_mode'] = $pay_type->name;
					$data['dispute_info'] = $despute;
					$data['dispute_by'] = $dispute_by;
					$data['buyer_info'] = $buyer_info;
					$data['seller_info'] = $seller_info;
					$data['messages'] = $msg;
					
					// echo "<pre>"; print_r($data); exit;

					return View::make('dispute-info')->with($data);

				} else {
					$notification = array('message' => 'Oops! Something wrong.','alert-type' => 'error');
					return Redirect::to('trade/'.$contract_id)->with($notification);
				}	
			} else {
				$notification = array('message' => 'Oops! This trade in not disputed.','alert-type' => 'error');
				return Redirect::to('trade/'.$contract_id)->with($notification);
			}
		}
	}

	public function dispute_chat(Request $request) {
		$uid = Session::get('user_id');
		if ($uid == '') {
			return Redirect::to('login');
		} else {
			$data = Input::all();

			$despute = DB::table('a_dispute')->where('id',$data['dispute_id'])->first();
			$contract = DB::table('a_contract')->where('id',$despute->contract_id)->first();
			$user = DB::table('a_users')->where('id',$uid)->first();
			$type = $user->user_type;

			$file = $request->file('image');

			if($file==""){
				$file1 = "";
			} else {
				$file->move('images',$file->getClientOriginalName());
				$file1 = $file->getClientOriginalName();
			}

			$array = array(
					"dispute_id" => $data['dispute_id'],
					"type" => $type,
					"user_id" => $uid,
					'message' => $data['message'],
					'file' => $file1,
					"status" => "1",
					"created_by" => $uid,
					"created_date" =>  date("Y-m-d H:i:s"),
                    'created_ip' => $_SERVER['REMOTE_ADDR']
			);

			$chk = DB::table('a_dispute_info')->insertGetId($array);

			if ($chk != '') {
				return Redirect::back();
			} else {
				return Redirect::back();
			}
		}
	}



	public function getdisputchat() {
   		
   		$data = array();
    	$uid = Session::get('user_id');
    	$dispute_id = Input::get('dispute_id');
    	$dispute = DB::table('a_dispute')->where('id',$dispute_id)->first();
    	$contract = DB::table('a_contract')->where('id', $dispute->contract_id)->first();
    	$msg = DB::table('a_dispute_info')->where('dispute_id',$dispute_id)->get();
    	//print_r($msg);
		$data = array("messages"=>$msg,"from_user"=>$contract->from_user,"to_user"=>$contract->to_user,"uid"=>$uid);
    	return View::make('getchat-dispute')->with($data);
    }

    public function disputelist(){
    	$uid = Session::get('user_id');
		if ($uid == '') {
			return Redirect::to('login');
		} else {
			$data = array();
			$array = array();

            $contract = DB::table('a_contract')
            ->join('a_dispute', 'a_contract.id', '=', 'a_dispute.contract_id')
            ->join('a_users', 'a_dispute.user_id', '=', 'a_users.id')
            ->select('a_contract.*', 'a_dispute.title','a_dispute.title','a_users.user_name')
            ->where(array('a_contract.despute' => '2'))
            ->get();


			if (count($contract)>0) {
				foreach ($contract as $row) {
					if ($row->from_user == $uid || $row->to_user == $uid) {
						$array[] = $row;
					}
				}
			}
			$data['dispute'] = $array;
			// echo "<pre>"; print_r($data); exit;
			return View::make('dispute-list')->with($data);			
		}
    }

	public function paymentdone(){
		
		$uid = Session::get('user_id');
    	$contract = request()->segment(2);

    	if($uid==""){
			return Redirect::to('login');
    	} else {
			$select = DB::table('a_contract')->where('id',$contract)->get();
	    	
			foreach($select as $row){ }
			
			$offer = DB::table('a_offers')->where('id',$row->offer_id)->get();
			
			$p_mode_type = DB::table('a_payment_mode')->where('id',$offer[0]->mode_id)->get();
			
			$coins = DB::table('a_coin_info')->where('id',$offer[0]->coin_id)->get();
			
			
			$to_user = DB::table('a_users')->where('id',$row->to_user)->get();
			
			$from_user = DB::table('a_users')->where('id',$row->from_user)->get();
			
			$to_username = $to_user[0]->user_name;

			$to = $to_user[0]->email;
			$select2 = DB::table('a_site_config')->where('id',2)->get();
			$authkey = $select2[0]->value;
			$from = "no-reply@crypscrow.com";
			$subject = "Contract Payment";
			
			$fiat_value = $row->fiat_value;
			$coin = $coins[0]->label;
			$crypto_value = $row->crypto_value;
			$from_username = $from_user[0]->user_name;

			$p_method = $p_mode_type[0]->name;
			
			$body = "<body><h2>Dear ".$to_username.",</h2><br><p>The ".$from_username." has transferred the mentioned amount ". $fiat_value ." towards purchase of " .$coin. " through the ".$p_method." mentioned in the contract. <br>Please verify the payment and release the  " .$coin. " to the ".$from_username.".</p><p>Thank you,</p><p>Team BitcoinNearMe</p></body>";

			/*$body = "The buyer has transferred the mentioned amount ". $fiat_value ." for the " .$coin. " contract through the payment method ".$p_method." mentioned in the contract. <br> Please verify the payment and release the " .$coin. " to the buyer ".$from_username.".";*/
			
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
			
			DB::table('a_contract')->where('id',$contract)->update(array('tr_status' => "2"));
			if ($err) {
				$notification = array('message' => 'Oops! Mail not Send.','alert-type' => 'warning');
				return Redirect::to('trade/'.$contract)->with($notification);
			} else {
				$notification = array('message' => 'Payment success.', 'alert-type' => 'success');
				return Redirect::to('trade/'.$contract)->with($notification);
			}
			
		}
	}
	
	public function releasecrypto() {
		
		$uid = Session::get('user_id');
    	$contract = request()->segment(2);
    	$type = request()->segment(3);
		
    	if($uid==""){
			return Redirect::to('login');
    	} else {
			$select = DB::table('a_contract')->where('id',$contract)->get(); // select contact details
			//echo count($select); exit;
			
			if(count($select) > 0){
				foreach($select as $row){}
				$user1 = DB::table('a_users')->where('id',$row->from_user)->get(); // select buyer user deatail
				foreach($user1 as $u1){}

				$user2 = DB::table('a_users')->where('id',$row->to_user)->get(); // select Seller user detail
				foreach($user2 as $u2){}

				$offer = DB::table('a_offers')->where('id',$row->offer_id)->get(); // Select offers of created contract
				foreach($offer as $of){}
				
				$wallet1 = DB::table('a_coin_wallet')->where('coin_id',$of->coin_id)->where('user_id',$row->from_user)->get(); // Select wallet for seller 
				foreach($wallet1 as $wl1){}
				$wallet2 = DB::table('a_coin_wallet')->where('coin_id',$of->coin_id)->where('user_id',$row->to_user)->get(); // Select wallet for buyer 
				foreach($wallet2 as $wl2){}
				
			//	$wallet3 = DB::table('a_coin_wallet')->where('coin_id',$of->coin_id)->where('user_id',$of->coin_id)->get(); // Select wallet for seller 
			//	foreach($wallet3 as $wl3){}
				
				if($type=="1"){
					$cuuid = $u2->id;
				} else {
					$cuuid = $u1->id;
				}
				
				if($cuuid == $uid){
					if($row->tr_status == 2 && $row->co_status == 17){
						
						$array1 = array(
							"contract_id" => $row->id,
							"user_id" => $row->from_user,
							"balance" => $row->crypto_value,
							"status" => "1",
							"create_by" => $row->id,
							"create_on" =>  date("Y-m-d H:i:s"),
                            'created_ip' => $_SERVER['REMOTE_ADDR']
						);
						$ch1 = DB::table('a_trade_wallet')->insertGetId($array1);
						
						$array2 = array(
							"contract_id" => $row->id,
							"user_id" => $row->to_user,
							"balance" => "-".$row->crypto_value,
							"status" => "1",
							"create_by" => $row->id,
							"create_on" =>  date("Y-m-d H:i:s"),
                            'created_ip' => $_SERVER['REMOTE_ADDR']
						);
						$ch2 = DB::table('a_trade_wallet')->insertGetId($array2);
						
						DB::table('a_contract')->where('id',$row->id)->update(array('tr_status' => "1", "co_status" => "19"));
						
						DB::table('a_offers')->where('id',$row->offer_id)->update(array("status" => "4")); // offer completed

						$notification = array( 'message' => 'crypto has been released', 'alert-type' => 'success');
						return Redirect::to('trade/'.$contract)->with($notification);
					}
					else {
						$notification = array(
							'message' => 'Error occured, Please try again',
							'alert-type' => 'error'
						);
						return Redirect::to('trade/'.$contract)->with($notification);
					}				
				}
				else {
					$notification = array(
						'message' => 'Error occured, Please try again',
						'alert-type' => 'error'
					);
					return Redirect::to('trade/'.$contract)->with($notification);
				}
			}
			else {
				$notification = array(
						'message' => 'Error occured, Please try again',
						'alert-type' => 'error'
					);
				return Redirect::to('trade/'.$contract)->with($notification);
			}
		}
	}
	
	public function acceptoffer() {
		
		$uid = Session::get('user_id');
    	
		if($uid==""){
			return Redirect::to('login');
    	} else {
		
		$contract = request()->segment(2);
		$contract = DB::table('a_contract')->where('id',$contract)->get();
			if(count($contract)>0){
				
			foreach($contract as $contr)
			
			$offer = DB::table('a_offers')->where('id',$contr->offer_id)->get();
			foreach($offer as $of)
			
			if($of->type_id == "14") { // Check Offer type is 'Buy Offer'
				
				$trd_bal2 = $contr->crypto_value - $contr->fees2;
				// Buyer Accept offer 
				$array1 = array(
					"contract_id" => $contr->id,
					"user_id" => $uid,
					"coin_id" => $of->coin_id,
					"balance" => $trd_bal2,
					"status" => "2",
					"create_by" => $uid,
					"create_on" =>  date("Y-m-d H:i:s"),
					'created_ip' => $_SERVER['REMOTE_ADDR']
				);
				$ch1 = DB::table('a_trade_wallet')->insertGetId($array1);
			}
			// echo $contr->offer_id;	echo $of->type_id;  exit;

			if($of->type_id == "15" && $of->user_id == $uid) { // Check Offer type is 'Sell Offer'
				
				$wallet = DB::table('a_coin_wallet')->select('balance')->where('coin_id', $of->coin_id)->where('user_id',$uid)->get();

				if (count($wallet)>0) {
					if ($wallet[0]->balance == '') {
						$current_bal = 0;
					} else {
						$current_bal = $wallet[0]->balance;
					}
				} else {
					$current_bal=0;
				}

				// For logged in User created offers contracts
				$contracts1 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->where('to_user', $uid)->where('coin_id', $of->coin_id)->get();
				// For logged in User created offers contracts
				$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')->where('from_user', $uid)->where('coin_id', $of->coin_id)->get();

				$arr=array(0);
				$saleArr=array(0);
				$buyArr=array(0);
				$feesArr=array(0);

				if(count($contracts1)>0){
					foreach($contracts1 as $cnt1) {
						$offer1 = DB::table('a_offers')->select('*')->where('id', $cnt1->offer_id)->get();
						if(count($offer1)>0){
							if ($cnt1->co_status == 17) {									
								foreach($offer1 as $of1) {
									$crypto_value = $cnt1->crypto_value;
									$crypto_fees = $cnt1->fees;
									
									if($of1->type_id == 15){ // sell offer  user seller
										array_push($arr,$crypto_value);
										array_push($arr,$crypto_fees);
									}
								}
							}  else if ($cnt1->co_status == 19) {
								
								foreach($offer1 as $of1){
									$crypto_value = $cnt1->crypto_value;
									$crypto_fees = $cnt1->fees;
									
									if($of1->type_id == 15) { // sell offer  user seller	
										array_push($saleArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									} else {
										//$crypto_value = $cnt1->crypto_value-$cnt1->fees;
										array_push($buyArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									}
								}
								
							}
						}
					}
				}

				if(count($contracts2)>0 || !empty($contracts2)) {
					foreach($contracts2 as $cnt2) {
						
						$offer2 = DB::table('a_offers')->select('*')->where('id', $cnt2->offer_id)->get();

						if (count($offer2)>0) {
							if ($cnt2->co_status == 17) {
								foreach($offer2 as $of2) {
									$crypto_value = $cnt2->crypto_value;
									$crypto_fees = $cnt2->fees2;
									
									if($of2->type_id == 14){ // buy offer  user seller
										array_push($arr,$crypto_value);
										array_push($arr,$crypto_fees);
									}
								}
							}
							else if($cnt2->co_status == 19) {
								foreach($offer2 as $of2) {
									$crypto_value = $cnt2->crypto_value;
									$crypto_fees = $cnt2->fees2;
									
									if($of2->type_id == 14) { // buy offer // user seller
										array_push($saleArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									} else {
										array_push($buyArr,$crypto_value);
										array_push($feesArr,$crypto_fees);
									}
								}
							}
						}
					}
				}

				$locked  = array_sum($arr); // Total Sum of coin locked balance
				$buy = array_sum($buyArr); // Total Sum of buy coin
				$sale = array_sum($saleArr); // Total Sum of sell coin
				$fees = array_sum($feesArr); // Total Sum of fees

				$aval_balance = ($buy+$current_bal)-($locked+$sale+$fees);

				$req_amt = $contr->fees + $contr->crypto_value;
				$bal = $wallet[0]->balance;

				if($aval_balance < $req_amt) {
					$notification = array(
						'message' => 'Insufficiant balance for this trade. Your current balance is ' . $aval_balance . " and required balance is " . $req_amt ,
						'alert-type' => 'error'
						);
					return Redirect::to('my-trades')->with($notification);
				}				
				
				$trd_bal1 = $contr->fees + $contr->crypto_value;
				$trd_bal2 = $contr->crypto_value - $contr->fees2;
				
				// Seller Accept offer
				$array1 = array(
					"contract_id" => $contr->id,
					"user_id" => $uid,
					"coin_id" => $of->coin_id,
					"balance" => "-".$trd_bal1,
					"status" => "2",
					"create_by" => $uid,
					"create_on" =>  date("Y-m-d H:i:s"),
					'created_ip' => $_SERVER['REMOTE_ADDR']
				);
				
				// Seller Entry in 'a_trade_wallet' database table
				$ch1 = DB::table('a_trade_wallet')->insertGetId($array1);

				$array2 = array(
					"contract_id" => $contr->id,
					"user_id" => $contr->from_user,
					"coin_id" => $of->coin_id, 
					"balance" => $trd_bal2,
					"status" => "2",
					"create_by" => $contr->from_user,
					"create_on" =>  date("Y-m-d H:i:s"),
					'created_ip' => $_SERVER['REMOTE_ADDR']
				);
				// Buyer Entry in 'a_trade_wallet' database table
				$ch2 = DB::table('a_trade_wallet')->insertGetId($array2);				
			}
			

			$array = array("co_status" => "17");
			$check2 = DB::table('a_contract')->where('id',$contr->id)->update($array);

			if($check2){
				$notification = array(
					'message' => 'offer has been accepted',
					'alert-type' => 'success'
				);
				return Redirect::to('trade/'.$contr->id)->with($notification);
			} else {
				$notification = array(
					'message' => 'error occured,try again', 
					'alert-type' => 'error'
				);
				return Redirect::to('my-trades')->with($notification);
			}
		}else {
			$notification = array(
					'message' => 'Opps! Bad Request', 
					'alert-type' => 'error'
				);
				return Redirect::to('my-trades')->with($notification);
			}
		}
	}
	public function rejectoffer() {

		$contract = request()->segment(2);

		$array = array("co_status"=>"18");

		$update = DB::table('a_contract')->where('id',$contract)->update($array);

		if($update){

			$notification = array(
				'message' => 'offer has been rejected', 
				'alert-type' => 'success'
			);
			
			return Redirect::to('my-trades')->with($notification);

		} else {

			$notification = array(
				'message' => 'error occured,try again', 
				'alert-type' => 'error'
			);
			
			return Redirect::to('my-trades')->with($notification);

		}

	}

	public function sendmessage(Request $request){

		$data = Input::all();
		$uid = Session::get('user_id');

		if($data['message']==""){
			$message = "";
		} else {
			$message = $data['message'];
		}

		$file = $request->file('image');
		if($file==""){
			$file1 = "";
		} else {
			$destinationPath = 'images';
			$file->move($destinationPath,$file->getClientOriginalName());	
			$file1 = $file->getClientOriginalName();
		}

		$array2 = array(
			'contract_id' => $data['cid'],
            'user_id'      => $uid,
            'text'      => $message,
            'media'      => $file1,
            'status'    => "1",
            'created_by'       => "1",
            'created_date'  => date("Y-m-d H:i:s"),
            'created_ip' => $_SERVER['REMOTE_ADDR']
        );

		$check2 = DB::table('a_chat')->insertGetId($array2);
		$contract = DB::table('a_contract')->where(array('id' => $data['cid']))->get();

		if ($contract[0]->from_user == $uid) {
			$userID = $contract[0]->to_user;
			$userID1 = $contract[0]->from_user;
		} else if ($contract[0]->to_user == $uid) {
			$userID = $contract[0]->from_user;
			$userID1 = $contract[0]->to_user;
		}

		$chatGet = DB::table('a_chat')->where(array('contract_id' => $data['cid'], 'user_id' => $uid))->get();

		if (count($chatGet) > 0) {
			$logincheck = DB::table('a_users_log')->Select('out_time','in_time')->where(array('user_id' => $userID))->orderBy("id","DESC")->limit(1)->get();

			if (count($logincheck)>0) {

				if ($logincheck[0]->out_time != '') {

					$SelectUser = DB::table('a_users')->Select('email','user_name')->where(array('id' => $userID))->limit(1)->get();
					foreach ($SelectUser as $su) { }

					$SelectUser2 = DB::table('a_users')->Select('user_name')->where(array('id' => $userID1))->limit(1)->get();
					foreach ($SelectUser2 as $su2) { }

						$email = $su->email;
						$uname = $su->user_name;
						$uname2 = $su2->user_name;

					$site_conf = DB::table('a_site_config')->Select('value')->where('id',2)->get();
					
					foreach ($site_conf as $sc) {}
					$authkey = $sc->value;

					$to = $email;
					$from = "no-reply@crypscrow.com";							
					$subject = "You received an message from ".$uname2;
					
					$body = "<body> <h2>Dear ".$uname.",</h2><br><p>This is the inform about your recent trade with ".$uname2.". The ".$uname2." want to chat with you about trade.</p><br><p>Thank you,</p><p>Team BitcoinNearMe</p></body>";

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
					
					$array3 = array(
		                'user_id'      => $uid,
		                'page'      => url('/').'trade/'.$data['cid'],
		                'from'      => $from,
		                'subject'      => $subject,
		                'to'      => $to,
		                'body' => $body,
		                'status'    => "1",
		                'created_by'  => $uid,
		                'created_date'  => date("Y-m-d H:i:s"),
		                'created_ip' => $_SERVER['REMOTE_ADDR']
	            	);

					$check3 = DB::table('a_mail_log')->insertGetId($array3);
					return Redirect::to('trade/'.$data['cid']);

				} else {
					return Redirect::to('trade/'.$data['cid']);
				}	
			} else {
				return Redirect::to('trade/'.$data['cid']);
			}
		} else {
			return Redirect::to('trade/'.$data['cid']);
		}
	}

    public function getchat() {

    	$cid = Cookie::get('contract_id');
    	$uid = Session::get('user_id');

    	$select = DB::table('a_contract')->where('id',$cid)->get();
    	foreach($select as $row){}

    	$msg = DB::table('a_chat')->where('contract_id',$cid)->get();

    	$data = array("messages"=>$msg,"id"=>$row->id,"from_user"=>$row->from_user,"to_user"=>$row->to_user,"uid"=>$uid);

    	return View::make('getchat')->with($data);

    }

    public function lock_balance($coin_id) {

		$uid = Session::get('user_id');
		// Get Current Live Balance
		$wallet = DB::table('a_coin_wallet')->select('*')->where('user_id', $uid)->where('coin_id', $coin_id)->get();
		// For logged in User created offers contracts
		$contracts1 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')->where('coin_id', $coin_id)->where('to_user', $uid)->get();
		// For logged in User created offers contracts
		$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')->where('from_user', $uid)->where('coin_id', $coin_id)->get();

		$withdrow_list = DB::table('a_withdraw_list')->select('amount')->where('user_id', $uid)->where('coin_id', $coin_id)->get();
		 $withdrow_balance = 0;

		if (count($withdrow_list)>0) {
			foreach($withdrow_list as $wh) { $withdrow_balance += floatval($wh->amount); }
		} 

		if ($withdrow_balance == '') {
			$withdrow_balance = 0;
		}

		$arr=array(0);
		$saleArr=array(0);
		$buyArr=array(0);
		$feesArr = array(0);

		if(count($wallet)>0) {

			foreach ($wallet as $w) { }
			$current_bal = $w->balance;			

			if(count($contracts1)>0){
				foreach($contracts1 as $cnt1) {
					$offer1 = DB::table('a_offers')->select('*')->where('id', $cnt1->offer_id)->get();
					if(count($offer1)>0){
						if ($cnt1->co_status == 17) {
							
							foreach($offer1 as $of1) {
								$crypto_value = $cnt1->crypto_value;
								$crypto_fees = $cnt1->fees;
								
								if($of1->type_id == 15){ // sell offer  user seller
									array_push($arr,$crypto_value);
									array_push($arr,$crypto_fees);
								}
							}
						}  else if ($cnt1->co_status == 19) {
							
							foreach($offer1 as $of1){
								$crypto_value = $cnt1->crypto_value;
								$crypto_fees = $cnt1->fees;
								
								if($of1->type_id == 15) { // sell offer  user seller	
									array_push($saleArr,$crypto_value);
									array_push($feesArr,$crypto_fees);
								} else {
									//$crypto_value = $cnt1->crypto_value-$cnt1->fees;
									array_push($buyArr,$crypto_value);
									array_push($feesArr,$crypto_fees);
								}
							}
							
						}
					}
				}
			}

			if(count($contracts2)>0 || !empty($contracts2)) {
				foreach($contracts2 as $cnt2) {
					
					$offer2 = DB::table('a_offers')->select('*')->where('id', $cnt2->offer_id)->get();

					if (count($offer2)>0) {
						if ($cnt2->co_status == 17) {
							foreach($offer2 as $of2) {
								$crypto_value = $cnt2->crypto_value;
								$crypto_fees = $cnt2->fees2;
								
								if($of2->type_id == 14){ // buy offer  user seller
									array_push($arr,$crypto_value);
									array_push($arr,$crypto_fees);
								}
							}
						}
						else if($cnt2->co_status == 19) {
							foreach($offer2 as $of2) {
								$crypto_value = $cnt2->crypto_value;
								$crypto_fees = $cnt2->fees2;
								
								if($of2->type_id == 14) { // buy offer // user seller
									array_push($saleArr,$crypto_value);
									array_push($feesArr,$crypto_fees);
								} else {
									array_push($buyArr,$crypto_value);
									array_push($feesArr,$crypto_fees);
								}
							}
						}
					}
				}
			}

			$locked = array_sum($arr);
			$buy = array_sum($buyArr);
			$sale = array_sum($saleArr);
			$fees = array_sum($feesArr);

			$avalable_balance = ($current_bal+$buy) - ($locked+$sale+$fees+$withdrow_balance);
			$total_balance = ($current_bal+$buy+$locked) - ($sale+$fees+$withdrow_balance);
			
			$array = array(
				'lock_balance' => $locked+$withdrow_balance,
				'buy' => $buy,
				'sale' => $sale,
				'fees' => $fees,
				'withdrowal_balance' => $withdrow_balance,
				'avalable_balance' => $avalable_balance,
				'total_balance' => $total_balance,
			);
			return $array; 
			
		} else {

			$arr=array(0);
			$saleArr=array(0);
			$buyArr=array(0);
			$feesArr=array(0);

			$ethaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "2")->get();   
			$withdrow_balance = DB::table('a_withdraw_list')->where('user_id', $uid)->where('coin_id', "2")->sum('amount');
			
			if ($withdrow_balance == '') {
				$withdrow_balance = 0;
			}

			foreach ($ethaddr as $e) { }

			$coinusd = $result->data[1]->quote->USD->price; // ETH convert to USD
			$inr = 69;
			$contract_addr = $c->contract_address;
			$addr = $e->address;

			// ETH Token balance get
			$url3 = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contract_addr."&address=".$addr."&tag=latest";
			$ch3 = curl_init();
			curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch3, CURLOPT_URL,$url3);
			$result3 = curl_exec($ch3);
			$result3 = json_decode($result3, true);
			curl_close($ch3);
			
			if ($result3['status'] == 1) {
				$balance = $result3['result']/1000000000000000000;
			} else {
				$balance = 0;
			}
			
			if(count($contracts1)>0) {
				foreach($contracts1 as $cnt1) {

					$offer1 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt1->offer_id)->get();

					if(count($offer1)>0) {
						if ($cnt1->co_status == 17) {
						
						foreach($offer1 as $of1) {
							$crypto_value = $cnt1->crypto_value;
							$crypto_fees = $cnt1->fees;
							
							if($of1->type_id == 15) { // sell offer	
								array_push($arr,$crypto_value);
								array_push($arr,$crypto_fees);
							} 
						}
					} else if ($cnt1->co_status == 19) {
							foreach($offer1 as $of1) {
								$crypto_value = $cnt1->crypto_value;
								$crypto_fees = $cnt1->fees;

								if($of1->type_id == 15) { // sell offer 
									array_push($saleArr,$crypto_value);
									array_push($feesArr,$crypto_fees);
								} else {
									array_push($buyArr,$crypto_value);
									array_push($feesArr,$crypto_fees);
								}
							}
						}
					}
				}
			}							
				
			if(count($contracts2)>0) {
				foreach($contracts2 as $cnt2) {
					
					$offer2 = DB::table('a_offers')->select('*')->where('coin_id', $c->id)->where('id', $cnt2->offer_id)->get();
					if(count($offer2)>0) {

					if ($cnt2->co_status == 17) {
						foreach($offer2 as $of2) {
							$crypto_value = $cnt2->crypto_value;
							$crypto_fees = $cnt2->fees2;

							if($of2->type_id == 14){ // buy offer	
								array_push($arr,$crypto_value);
								array_push($arr,$crypto_fees);
							} 
						}
					} else if ($cnt2->co_status == 19) {
						foreach($offer2 as $of2) {
							$crypto_value = $cnt2->crypto_value;
							$crypto_fees = $cnt2->fees2;

							if($of2->type_id == 14) { // buy offer
								array_push($saleArr,$crypto_value);
								array_push($feesArr,$crypto_fees);
							} else {
								array_push($buyArr,$crypto_value);
								array_push($feesArr,$crypto_fees);
							}
						}
						}
					}
				}
			}

			$locked  = array_sum($arr);
			$sale  = array_sum($saleArr); 
			$buy  = array_sum($buyArr);
			$fees  = array_sum($feesArr);
			$avalable_balance = ($balance+$buy) - ($locked+$sale+$fees+$withdrow_balance);
			$total_balance = ($balance+$buy+$locked) - ($sale+$fees+$withdrow_balance);

			$array = array(
				'lock_balance' => $locked+$withdrow_balance,
				'buy' => $buy,
				'sale' => $sale,
				'fees' => $fees,
				'withdrowal_balance' => $withdrow_balance,
				'avalable_balance' => $avalable_balance,
				'total_balance' => $total_balance,
			);
			return $array; 
		}
    }


   // Sample Email API 
    public function msg91(){
		$curl = curl_init();
		$name = "vipul";
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://control.msg91.com/api/sendmail.php?authkey=209861Ac4nsRCcCa5ad0ae2a&from=no-reply@crypscrow.com&to=vpativala777@gmail.com&subject=asasasasas&body=<h3>Hey ".$name."</h3></p>",
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
    }


    public function cur(){
    	$cur = DB::table('a_currency_list')->get();   
    	

    	foreach ($cur as $row) {

    		DB::table('a_currency_list')->where()->update(array('name'=> substr($row->short,4)));
    		exit();
    	}

    }

}
