<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('upload_file')) {
  		function upload_file($name,$upload_path,$allowed_types,$file_name,$max_size=3000,$replace=false) {
    		// Getting CI class instance.
    		$CI = get_instance();
			if(!$CI->load->is_loaded('upload')){
				$CI->load->library('upload');
			} 
			$dirs=explode('/',$upload_path);
			$upload_path='';
			foreach($dirs as $dir){
				if($dir==''){ break; }
				$upload_path.=$dir.'/';
				if(!is_dir($upload_path)){
					mkdir($upload_path);
				}
			}
			$file_name=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file_name)));
    		$config['upload_path']   = $upload_path; 
			$config['allowed_types'] = $allowed_types; 
			$config['file_name'] = $file_name;
			$config['max_size']      = $max_size;  
			if($replace===true){
				$config['overwrite'] = TRUE;  
			}
			$CI->upload->initialize($config);
			$return = array('status'=>false,'msg'=>'Image Not Uploaded !!');
			if(is_uploaded_file($_FILES[$name]['tmp_name'])){
				if ( ! $CI->upload->do_upload($name)) {
					/*$info=get_file_info($_FILES[$name]['tmp_name']);
					print_r($_FILES);
					print_r($info);
					die;*/
					$error = $CI->upload->display_errors(); 
					$file=false;
					////////////////////
					$return['status'] = false;
					$return['msg'] = $error;
				}
				else { 
					$filedata = $CI->upload->data(); 
					$file=$filedata['raw_name'].$filedata['file_ext'];
					$src=$upload_path."$file";
					$result=substr($src,1);
					/////////////////////
					$return['status'] = true;
					$return['path'] = $result;
				}
			}
			return $return;
		}  
	}
?>
