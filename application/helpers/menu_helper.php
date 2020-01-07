<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('activate_menu')) {
  		function activate_menu($controller) {
    		$CI = get_instance();
    		$class = $CI->router->fetch_class();
			$method = $CI->router->fetch_method();
			$active=$class;
			if($method!="index"){ $active.='/'.$method; }
			if(is_array($controller)){
				foreach($controller as $single){
					if($active == $single){
						return 'active';
					}
				}
			}
			else{
				return ($active == $controller) ? 'active' : '';
			}
		}  
	}
	if(!function_exists('activate_dropdown')) {
		function activate_dropdown($controller,$type="li",$not=array()){
    		$CI = get_instance();
			$method = $CI->router->fetch_method();
			if(array_search($method,$not)!==false){
				return false;
			}
    		$class = $CI->router->fetch_class();
			if(is_array($controller)){
				foreach($controller as $single){
					if($class == $single){
						if($type=='li'){
							return 'menu-open';
						}
						else{
							return 'active';
						}
					}
				}
			}
			else{
				if($type=='li'){
					return ($class == $controller) ? 'menu-open' : '';
				}else{
					return ($class == $controller) ? 'active' : '';
				}
			}
		}
	}
	if(!function_exists('checkuri')){
		function checkuri(){
    		$CI = get_instance();
			$default = array('name', 'gender', 'location', 'type', 'sort');
			$array = $CI->uri->segment(4);
			print_r($array);
		}
	}
?>
