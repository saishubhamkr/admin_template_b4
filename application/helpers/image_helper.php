<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('create_image_thumb')) {
  		function create_image_thumb($src,$destination="",$thumb=FALSE,$dimensions=array()) {
    		// Getting CI class instance.
    		$ci=& get_instance();
			if(!$ci->load->is_loaded('image_lib')){
				$ci->load->library('image_lib');
			} 
			$ci->image_lib->clear();
			$width=$height=200;
			if($destination==''){
				$destination=$src;
			}
			if(!empty($dimensions)){
				if(isset($dimensions['width'])){ $width=$dimensions['width']; }
				if(isset($dimensions['height'])){ $height=$dimensions['height']; }
			}
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = $src;
			$config['new_image'] = $destination;
			$config['create_thumb'] = $thumb;
			$config['maintain_ratio'] = FALSE;
			$config['width']     = $width;
			$config['height']   = $height;
			$ci->image_lib->initialize($config);
			$ci->image_lib->resize();
		}  
	}
?>