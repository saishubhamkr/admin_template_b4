<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('setredirecturl')) {
  		function setredirecturl() {
    		$CI = get_instance();
			$current_url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$CI->session->set_userdata('redirecturl',$current_url);
			$data=$CI->input->post();
			$CI->session->set_userdata('submission',$data);
		}  
	}
	if(!function_exists('getsubmission')) {
  		function getsubmission() {
    		$CI = get_instance();
			if($CI->session->userdata('submission')!==NULL){
				$data = $CI->session->userdata('submission');
				$_POST=$data;
				$CI->session->unset_userdata('submission');
			}
		}  
	}
	if(!function_exists('checkadminlogin')) {
  		function checkadminlogin() {
    		$CI = get_instance();
			if($CI->session->user===NULL || $CI->session->role!='admin'){
				setredirecturl();
				redirect('login/');
			}
			else{
				//getsubmission();
			}
		}  
	}
	if(!function_exists('loginredirect')) {
  		function loginredirect($url='/') {
    		$CI = get_instance();
			if($CI->session->user!==NULL && $CI->session->role=='admin'){
				if($CI->session->redirecturl!=NULL) {
					$redirecturl=$CI->session->redirecturl;
					$CI->session->unset_userdata('redirecturl');
					redirect($redirecturl);
				}
				else{
					redirect(getadminlink($url));
				}
			}
		}  
	}
	if(!function_exists('getadminlink')) {
  		function getadminlink($link) {
			return str_replace('','',$link);
		}  
	}
?>
