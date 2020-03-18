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
use Illuminate\Support\Facades\Mail;
use Location;
use Session;
use Cookie;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Routing\UrlGenerator;
use Exception;
use Torann\GeoIP\Support\HttpClient;
use Torann\GeoIP\Services\AbstractService;
use RegistersUsers;
use Storage;
use Image;
use Validator;

class RegisterationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userType = Session::get('user_type');
        $userName = Session::get('user_name');
        if ($userType == '' && $userType == '') {

            return View::make('register2');
        } else {
            return Redirect::to('home');
        }
    }

    public function insertuser(Request $request) {

        $data = Input::all();

        if($data['_token']=="") { 
            $notification = array('message' => 'Bad request', 'alert-type' => 'warning');
            return Redirect::to('register')->with($notification);
        } else {

                $validator = Validator::make($data, 
                    [ 
                        'user_name' => 'required|string|max:16|alpha_dash',
                        'email' => 'required|email|unique:users,email,user_name',
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
                            
                            if(count($user) === 0) {

                                $email = DB::table('a_users')->where('email', $data['email'])->get();

                                if(count($email) == 0){

                                    $array = array(
                                        'user_type'      => "2",
                                        'user_name'     => $data['user_name'],
                                        'email'      => $data['email'],
                                        'status'    => "0",
                                        'created_by'       => "1",
                                        'created_date'  => date("Y-m-d H:i:s"),
                                        'created_ip' => $_SERVER['REMOTE_ADDR']
                                    );

                                    $check = DB::table('a_users')->insertGetId($array);

                                    $insert_id = DB::getPdo()->lastInsertId();

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
                                        CURLOPT_URL => "http://159.89.44.224:3000/createbtc",
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
                                        CURLOPT_URL => "http://159.89.44.224:3000/createeth",
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
                                    $array1 = array(
                                        'coin_id'     => "1",
                                        'user_id'      => $insert_id,
                                        'address'      => $btc['address'],
                                        'balance'      => '0',
                                        "type" => "8",
                                        'status'    => "1",
                                        'created_by'       => "1",
                                        'created_date'  => date("Y-m-d H:i:s"),
                                        'created_ip' => $_SERVER['REMOTE_ADDR']
                                    );

                                    $check1 = DB::table('a_coin_wallet')->insertGetId($array1); 
                                    DB::table('a_address')->insertGetId([
                                        'coin_id'     => "1",
                                        'user_id'      => $insert_id,
                                        'address'      => $btc['address'],
                                        'balance'      => '0',
                                        'private_key'      => $btc['private_key'],
                                        'status'    => "1",
                                        'created_by'       => "1",
                                        'created_date'  => date("Y-m-d H:i:s"),
                                        'created_ip' => $_SERVER['REMOTE_ADDR']
                                    ]);

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
                                        
                                    DB::table('a_address')->insertGetId([
                                        'coin_id'     => "2",
                                        'user_id'      => $insert_id,
                                        'address'      => $eth['address'],
                                        'private_key'      => $eth['private_key'],
                                        'status'    => "1",
                                        'created_by'       => "1",
                                        'created_date'  => date("Y-m-d H:i:s"),
                                        'created_ip' => $_SERVER['REMOTE_ADDR']
                                    ]);

                                    if($check && $check1 && $check2 && $check3) { 

                                        $select = DB::table('a_site_config')->where('id',2)->get();
                                        $authkey = $select[0]->value;
                                        $link = url('/').'/verify-email/'.$insert_id.'/'.$data['email'].'?VerifyMailToken='.md5($data['password']);

                                        $mail_data = array (
                                                'email' => $data['email'], 
                                                'user_name' => $data['user_name'], 
                                                'actionURL' => $link);

                                        $mail = Mail::send(['html' => 'emails.verification'], $mail_data, function($message) use ($mail_data) {
                                            $message->to($mail_data['email'], $mail_data['user_name']);
                                            $message->subject('BitCoinNearMe Account Activation');
                                            $message->from('info@erience.com', 'BitCoinNearMe');
                                        });
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
                                $notification = array('message' => 'Username already exists', 'alert-type' => 'error');
                                return Redirect::to('register')->with($notification);
                            }
                        }
                }
        }
    }

    public function verifyEmail($id='', $email='') {
        
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
    }

    public function sendemail() {

        $data = array('name' => 'Peter Ordonez', 'email' => 'test.erience@gmail.com' , 'user_name' => 'Eriecne', 'link' => 'bitcoinnearme.com');
        $data['user'] = array('name' => 'Peter Ordonez', 'email' => 'test.erience@gmail.com' , 'user_name' => 'Eriecne', 'link' => 'bitcoinnearme.com');

        $mail = Mail::send(['html' => 'emails.verification'], $data, function($message) use ($data) {
            $message->to($data['email'], 'Sample Mail')->subject('Sample Mail');
            $message->from('info@erience.com', 'Sample');
        });

        return response()->json($mail);

    }

}
