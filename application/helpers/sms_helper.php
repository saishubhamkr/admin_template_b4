<?php 
	define("BASE_URL","http://167.114.117.218/rest/services/sendSMS/sendGroupSms?");
	if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost'){
		define("AUTH_KEY","");
	}
	else{
		define("AUTH_KEY","");
	}
	define("SENDER_ID","DEMOOS");
	define("ROUTE",3);
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	//include('getpost-lib.php');
	if(!function_exists('send_sms')) {
  		function send_sms($data) {
			$mobile=$data['mobile'];
			$message=$data['message'];
			$base_url=BASE_URL."AUTH_KEY=".AUTH_KEY;
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $base_url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "{\"smsContent\":\"$message\",\"routeId\":\"".ROUTE."\",\"mobileNumbers\":\"$mobile\",\"senderId\":\"".SENDER_ID."\",\"signature\":\"signature\",\"smsContentType\":\"english\"}",
			  CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: application/json"
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
				//echo "cURL Error #:" . $err;
				return false;
			} else {
				// $response;
				return true;
			}
		}  
	}
	
?>