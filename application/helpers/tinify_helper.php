<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	include APPPATH . 'third_party/Tinify/Tinify/Exception.php';
	include APPPATH . 'third_party/Tinify/Tinify/ResultMeta.php';
	include APPPATH . 'third_party/Tinify/Tinify/Result.php';
	include APPPATH . 'third_party/Tinify/Tinify/Source.php';
	include APPPATH . 'third_party/Tinify/Tinify/Client.php';
	include APPPATH . 'third_party/Tinify/Tinify.php';
	
	\Tinify\setKey("TNjxZfxVHlGvcPH5lrDRgkg27jtPdDrb");
	
	if(!function_exists('tinifyimage')) {
		function tinifyimage($src){
			$source = \Tinify\fromFile($src);
			$source->toFile($src);   
		}
	}
	
	if(!function_exists('tinifyresizeimage')) {
		function tinifyresizeimage($src,$width,$height,$method="scale"){
			$source = \Tinify\fromFile($src);
			$resized = $source->resize(array(
				"method" => $method,
				"width" => $width,
				"height" => $height
			));
			$resized->toFile($src);   
		}
	}
	if(!function_exists('compressioncount')) {
		function compressioncount(){
			$compressioncount = \Tinify\compressionCount();
			return $compressioncount;
		}
	}
?>
