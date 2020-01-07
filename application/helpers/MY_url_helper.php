<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('file_url')) {
  		function file_url($uri=''){
			$url=base_url($uri);
			$url=str_replace("/index.php","",$url);
			return $url;
		}
	}
	
?>