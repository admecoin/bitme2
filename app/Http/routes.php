<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MainController@index');
Route::get('/home', 'MainController@index');
// Route::get('/cur', 'MainController@cur');


Route::group(['middleware' => 'userAuth'], function () {
    Route::get('/login', 'MainController@login', function(){
    		Artisan::call('cache:clear');
    		return "Cache is cleared";
    	}
	);
});

// Register Controller
Route::get('/register', 'RegisterationController@index');
Route::post('/insertuser', 'RegisterationController@insertuser');
Route::get('/verify-email/{id}/{email}/', 'RegisterationController@verifyEmail');
Route::get('/verifysendemail', 'RegisterationController@sendemail');


Route::get('/forgot', 'MainController@forgot');
// Route::get('/reset', 'MainController@reset');
Route::post('/forgot-request', 'MainController@forgotRequest'); 
Route::get('/reset-password/{id}/{value}/', 'MainController@resetPassword');
Route::get('/offers-buy', 'MainController@offersbuy');
Route::post('/change-password', 'MainController@changeNewPassword');


Route::get('/msg91/', 'MainController@msg91');

/* All Filter function */  
Route::post('/applyfilter', 'MainController@applyFilter');

// Star Rating
Route::post('/rating', 'MainController@rating');

// Claim
Route::post('/claim', 'MainController@claim');

// KYC
Route::post('/addkyc/{id}', 'MainController@addkyc')->name('addkyc');


// Route::get('/offers-sell', 'MainController@offerssell');
Route::get('/my-trades', 'MainController@mytrades');
Route::get('/my-offers', 'MainController@myoffers');
Route::get('/all-buy-offers', 'MainController@allBuyOffers');
Route::get('/all-sell-offers', 'MainController@allSellOffers');

Route::get('/edit-offer/{id}','MainController@editoffer');
Route::post('/updateoffer','MainController@updateoffer');
Route::get('/delet-offer/{id}','MainController@deletoffer');

Route::get('/wallet', 'WalletController@index'); 

// Route::get('/wallet', 'MainController@wallet'); 
Route::get('/btcupdate', 'MainController@btcupdate');
Route::get('/ethupdate', 'MainController@ethupdate'); 
Route::get('/ltcupdate', 'MainController@ltcupdate'); 
Route::get('/tokenupdate/{token}', 'MainController@tokenupdate'); 

Route::post('/withdrow', 'MainController@withdrow'); 

Route::get('/offer/{offer}', 'MainController@contract');
Route::get('/getcrypto', 'MainController@getcrypto');
Route::post('/createcontract', 'MainController@createcontract');

Route::get('/new-offer', 'MainController@newoffer');
Route::get('/offers', 'MainController@offers');
Route::post('/createoffer', 'MainController@createoffer');
Route::get('/checkprice', 'MainController@checkprice');

Route::get('/my-account', 'MainController@myaccount');
Route::post('/sendotp', 'MainController@sendotp');

Route::get('/profile', 'MainController@profile');
Route::post('/biodata', 'MainController@biodata');
Route::post('/changeemail', 'MainController@changeemail');
Route::post('/changephone', 'MainController@changephone');
Route::post('/changepassword', 'MainController@changepassword'); 
Route::post('/changeauth', 'MainController@changeauth'); 

Route::get('/contact', 'MainController@contact');
Route::get('/apicheck', 'MainController@apicheck');

// Exchange Coin
Route::get('/exchange', 'MainController@exchange');
Route::post('/getmiamount', 'MainController@getMinAmount'); // get minimum amount 
Route::post('/estimate-amt', 'MainController@estimateamt'); // get estimate amount
Route::post('/generateAddress', 'MainController@generateAddress'); 
Route::post('/createTransaction', 'MainController@createTransaction'); 

Route::get('/login', 'MainController@login');
Route::post('/logincheck', 'MainController@logincheck');
Route::post('/otp-verify', 'MainController@otpverify');
Route::get('/login-magic-link/{user_id}/{otp}/{passwd}', 'MainController@loginmagiclink');
Route::get('/logout', 'MainController@logout');


// Route::get('/htmlmail', 'MainController@htmlmail');
Route::get('/mail', 'MainController@mail');


Route::get('/coincron', 'MainController@coincron');
// Route::get('/currencycroninsert', 'MainController@currencycroninsert');
Route::get('/currencycronupdate', 'MainController@currencycronupdate');

Route::get('/trade/{contract}', 'MainController@trade');
Route::post('/report-user', 'MainController@report_user');
// Route::get('/trade/dispute/{contract}', 'MainController@dispute');
Route::get('/trade/dispute-info/{contract_id}', 'MainController@dispute_info');
Route::get('/getdisputchat', 'MainController@getdisputchat');
Route::post('/trade/dispute', 'MainController@dispute');
Route::post('/dispute-chat', 'MainController@dispute_chat');

Route::get('/paymentdone/{contract}', 'MainController@paymentdone');
Route::get('/release-crypto/{contract}/{type}', 'MainController@releasecrypto');

Route::get('/acceptoffer/{contract}', 'MainController@acceptoffer');
Route::get('/rejectoffer/{contract}', 'MainController@rejectoffer');
Route::post('/sendmessage', 'MainController@sendmessage');
Route::get('/getchat', 'MainController@getchat');
Route::get('/faq', 'MainController@faqs');
Route::get('/terms-&-condition', 'MainController@terms');
Route::get('/terms', 'MainController@terms');
Route::get('/how-to-buy', 'MainController@how_to_buy');
Route::get('/affiliate', 'MainController@affiliate');
Route::get('/privacy-policy', 'MainController@privacy_policy');


// Route::get('/update_username', 'RegisterationController@update_username');



Route::get('/help',[
	'as' => 'help', 
	'uses' => 'MainController@disputelist'
]);
// Route::get('/privacy-policy', function(){
// 	return View::make('privacy');
// });



/*Route::get('/users', function () {
    return view('users');
});*/

/**** AFFILIATE REGISTRATION ****/

// Route::get('/register-refferal', 'RegisterationController@index');


/**** BACKEND PANEL ****/

Route::get('/admin', 'BackendController@index');
Route::get('/admin/dashboard', 'BackendController@index');
Route::get('/admin/users', 'BackendController@users_list');
Route::get('/admin/status-change/{userid}', 'BackendController@userstatus');

Route::get('/admin/role-change/{userid}', 'BackendController@userrole');

Route::get('/admin/buy-offers-list', 'BackendController@buyOfferList');
Route::get('/admin/sell-offers-list', 'BackendController@sellOfferList');
Route::get('/admin/contract-list', 'BackendController@contractList');
Route::get('/admin/currency-list', 'BackendController@currencyList');
Route::get('/admin/loginchk', 'BackendController@loginchk'); 
Route::get('/admin/withdraw-list', 'BackendController@withdrawList'); 
Route::get('/admin/coin-list', 'BackendController@coinList'); 
Route::post('/admin/add-new-coin', 'BackendController@addNewCoin'); 
Route::get('/admin/user-log', 'BackendController@users_log'); 
Route::get('/admin/site-config', 'BackendController@site_config'); 

// Dispute contract/trade
Route::get('/admin/contract/dispute-info/{contract_id}',[
	'as' => 'dispute-info', 
	'uses' => 'BackendController@dispute_info'
]);
Route::post('/admin/contract-approve',[
	'as' => 'contract-approve', 
	'uses' => 'BackendController@contract_approve'
]);

Route::get('/admin/dispute-chat',[
	'as' => 'dispute-chat', 
	'uses' => 'BackendController@dispute_chat'
]);
Route::get('/admin/getdisputchat',[
	'as' => 'getdisputchat', 
	'uses' => 'BackendController@getdisputchat'
]);
Route::get('/admin/wallet',[
	'as' => 'admin-wallet', 
	'uses' => 'BackendController@wallet'
]);



Route::get('/admin/afilliate-list', 'BackendController@afilliate_list'); 
Route::get('/admin/approve-affiliate/{id}', 'BackendController@approve_affiliate');

Route::get('/admin/edit-siteconfig/{id}', 'BackendController@siteconfig_edit'); 
Route::post('/admin/editsiteconfig', 'BackendController@editsiteconfig'); 
Route::get('/admin/edit-affiliate/{id}', 'BackendController@affiliate_edit');
Route::post('/admin/editaffiliate', 'BackendController@editaffiliate');
Route::get('/admin/pages', 'BackendController@pages'); 
Route::get('/admin/edit-page/{id}', 'BackendController@edit_page'); 
Route::post('/admin/page-edit', 'BackendController@pageedit'); 
Route::get('/admin/accept-withdraw/{id}', 'BackendController@acceptwithdraw'); 

Route::get('/admin/kyclist','BackendController@kyclist')->name('adminkyc');
Route::get('/admin/actionkyc/{id}/{status}','BackendController@actionkyc');
Route::get('/admin/kycoption/{id}/{status}','BackendController@kycoption');
Route::get('/admin/report-user-list','BackendController@report_user_list');

Route::get('/admin/payment-method','BackendController@PaymentMethod');
Route::get('/admin/add-payment','BackendController@addNewPaymentMethod');
Route::get('/admin/edit-payment/{id}','BackendController@editPaymentMethod');
Route::get('/admin/delete-payment/{id}','BackendController@deletePaymentMethod');
Route::post('/admin/save-payment','BackendController@savePaymentMethod');
