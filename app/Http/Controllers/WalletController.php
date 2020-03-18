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


class WalletController extends Controller {

	function update_currency_rate(){

		$url1 = 'https://free.currencyconverterapi.com/api/v6/convert?q=USD_INR&compact=ultra&apiKey=7ffdebad767d5d7ac75f';
		
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL,$url1);
		if (curl_exec($ch1) != FALSE) {
			$result1 = curl_exec($ch1);
			$live1 = json_decode($result1, true);
			$rate =  number_format($live1['USD_INR'], 2);
			DB::table('a_currency_list')->where('id', '78')->update(['rate' => $rate]);
		}
		curl_close($ch1);
	}

	function update_coin_rate(){

		$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=86f9c151-721f-493e-8f02-6a4e98a81483';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);

		if (curl_exec($ch) != FALSE) {
			$result = json_decode(curl_exec($ch));
			foreach ($result->data as $row) {
				$array = array(
					'price' => number_format($row->quote->USD->price, 4, '.', ''),
					"modified_date" => date('Y:m:d H:i:s')
				);

				if($row->symbol == 'BTC') {
					DB::table('a_coin_info')->where('id', '1')->update($array);
				}
				else if ($row->symbol == 'ETH') {
					DB::table('a_coin_info')->where('id', '2')->update($array);
				}
				else if ($row->symbol == 'LTC') {
					DB::table('a_coin_info')->where('id', '3')->update($array);
				}
				else if ($row->symbol == 'BNB') {
					DB::table('a_coin_info')->where('id', '4')->update($array);
				}
				else if ($row->symbol == 'OMG') {
					DB::table('a_coin_info')->where('id', '5')->update($array);
				}
				else if ($row->symbol == 'TUSD') {
					DB::table('a_coin_info')->where('id', '7')->update($array);
				}
				else if ($row->symbol == 'LINK') {
					DB::table('a_coin_info')->where('id', '9')->update($array);
				}
				else if ($row->symbol == 'REP') {
					DB::table('a_coin_info')->where('id', '10')->update($array);
				}
				else if ($row->symbol == 'HOT') {
					DB::table('a_coin_info')->where('id', '11')->update($array);
				}
				else if ($row->symbol == 'IOST') {
					$ltcarray = array('price' => $row->quote->USD->price,
				"modified_date" => date('Y:m:d H:i:s'));
					DB::table('a_coin_info')->where('id', '12')->update($array);
				}
				else if ($row->symbol == 'MATIC') {
					DB::table('a_coin_info')->where('id', '15')->update($array);
				}
				//$coinusd = $result->data[0]->quote->USD->price;
			}
		}
		curl_close($ch);
		
	}

	public function index() {
    	
    	$uid = Session::get('user_id');

    	if ($uid != '') {

    		$this->update_currency_rate();
    		$this->update_coin_rate();
    	
    		$uid = Session::get('user_id');

			$coins = DB::table('a_coin_info')->select('id','label','name','contract_address','price')
			->where('status', '1')->where('type', 'coin')->get();
			
			// For logged in User created offers contracts
			$contracts1 = DB::table('a_contract')
			->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2','co_status')
			->where('to_user', $uid)->get();

			// For logged in User created offers contracts
			$contracts2 = DB::table('a_contract')->select('id','offer_id','from_user','to_user','currency_id','crypto_value','fiat_value','fees','fees2', 'co_status')
			->where('from_user', $uid)->get();

			foreach ($coins as $c) {
				$coinusd = $c->price;
				$wallet = DB::table('a_coin_wallet')->select('id','coin_id','user_id','address','balance')->where('user_id', $uid)
				->where('coin_id', $c->id)->get();

				$withdrow_list = DB::table('a_withdraw_list')->select('amount')
				->where('user_id', $uid)->where('coin_id', $c->id)->get();
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
						$locked = 0;

			    		if ($c->id == "1") {
							$balance_update = 'btcupdate';

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
							$balance_update = 'ethupdate';
							// $coinusd = $result->data[1]->quote->USD->price;
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
							
						} else if ($c->id == "3") {
							$balance_update = 'ltcupdate';
							// $coinusd = $result->data[4]->quote->USD->price;

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
						}

						$inr_rate = DB::table('a_currency_list')->where('id', '78')->first();
						$inr = $inr_rate->rate;

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
			    			"usd" => $coinusd,
			    			"usd_inr" => $coinusd * $inr,
				    		"balance_update" => $balance_update,
			    		);

		    	} 
		    	/* else {
					
					$arr=array(0);
					$saleArr=array(0);
					$buyArr=array(0);
					$feesArr=array(0);
					
					$ethaddr = DB::table('a_coin_wallet')->where('user_id', $uid)->where('coin_id', "2")->get();
					foreach ($ethaddr as $e) { }
						//	$coinusd = $result->data[1]->quote->USD->price; // ETH convert to USD
						$coinusd = $c->price;
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
		    		
		    	} */
			}
						
			$lock_bal = '';
			$avail_bal='';
			$data = array("coins" => $coins, "wallet_history" => $array);
			return View::make('wallet')->with($data);
		} else {

    		$notification = array(
				'message' => 'Please Login Your Account!',
				'alert-type' => 'error'
			);
			
			return Redirect::to('home')->with($notification);
    	}		
	}




}
   