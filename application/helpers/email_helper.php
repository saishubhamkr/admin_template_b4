<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('sendemail')) {
  		function sendemail($email,$subject,$message,$fieldname=false,$upload_path=false,$allowed_types=false,$file_name=false) {
    		// Getting CI class instance.
    		$CI = get_instance();
			if(!$CI->load->is_loaded('email')){
				$CI->load->library('email');
			} 
			if(!function_exists('upload')){
				$CI->load->helper('upload');
			} 
			$from="prateek.atal@gmail.com";
			if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost'){
				ini_set('smtp','localhost');
				ini_set('smtp_port',25);
				
				$config['protocol']='smtp';
				$config['smtp_host']='ssl://smtp.ionos.com';
				$config['smtp_port']='465';
				$config['smtp_timeout']='30';
				$config['smtp_user']='';
				$config['smtp_pass']='';
				$from=$config['smtp_user'];
			}
			
			$config['newline']="\r\n";
			$config['wordwrap'] = TRUE;
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = "html";
			
			$CI->email->initialize($config);
			$CI->email->from($from,SITE_SALT);
			$CI->email->to($email);
			$CI->email->subject($subject);
			$CI->email->message($message);
			
			if($fieldname!==false && $upload_path!==false && $allowed_types!==false){
				if($file_name===false){
					$file_name=$fieldname.'-attachment';
				}
				if(is_array($_FILES[$fieldname]['name'])){
					$count=count($_FILES[$fieldname]['name']);
					for($i=0; $i<$count; $i++) {
						if(is_uploaded_file($_FILES[$fieldname]['tmp_name'][$i])){
							$_FILES['multi']['name']     = $_FILES[$fieldname]['name'][$i];
							$_FILES['multi']['type']     = $_FILES[$fieldname]['type'][$i];
							$_FILES['multi']['tmp_name'] = $_FILES[$fieldname]['tmp_name'][$i];
							$_FILES['multi']['error']     = $_FILES[$fieldname]['error'][$i];
							$_FILES['multi']['size']     = $_FILES[$fieldname]['size'][$i];
								
							$attachment=upload_file('multi',$upload_path,$allowed_types,$file_name);
							$CI->email->attach(file_url($attachment));
							$attachment='.'.$attachment;
							if(file_exists($attachment)){
								unlink($attachment);
							}
						}
					}
				}
				else{
					$attachment=upload_file($fieldname,$upload_path,$allowed_types,$file_name);
					$CI->email->attach(file_url($attachment));
					$attachment='.'.$attachment;
					if(file_exists($attachment)){
						unlink($attachment);
					}
				}
			}
			
			if($CI->email->send()){
				return true;
			}
			else{
				return false;
			}
		}  
	}
?>