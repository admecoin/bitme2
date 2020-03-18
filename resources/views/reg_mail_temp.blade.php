

<?php

$curl = curl_init();
$name = "vipul";
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://control.msg91.com/api/sendmail.php?authkey=209861Ac4nsRCcCa5ad0ae2a&from=no-reply@crypscrow.com&to=vpativala777@gmail.com&subject=asasasasas&body=<h3>Hey ".$name."</h3>
registration email:

Hey deveshsusania,
 
You just signed up to crypscrow.com, so you're ready to buy or sell ether with your local currency.
 
Click here to confirm your e-mail address.
 <p>
Here's what you need to know to protect your account:
Don't forget your password — we can't recover it.
This e-mail address will be used for 2FA.
Please, don't forget your password!
Your account is fully encrypted in your browser, making it impossible for anybody else — including the localethereum team — to read your messages or access your wallet without your password. That's why it's mega-important that you hold on to it.
Confirm your e-mail address
</p>",
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