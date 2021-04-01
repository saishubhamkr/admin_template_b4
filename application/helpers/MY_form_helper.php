<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('create_form_input')) {
  		function create_form_input($type,$name,$label,$required=false,$value='',$attributes=array(),$options=array()){
			if($required===true){ $attributes['required']='required'; }
			$form_input="";
			$form_input.=get_label($name,$label,$required);
			
			switch($type){
				case 'date': $form_input.=create_simple_input($type,$name,$value,$attributes);
				break;
				case 'email': $form_input.=create_simple_input($type,$name,$value,$attributes);
				break;
				case 'password': $form_input.=create_simple_input($type,$name,$value,$attributes);
				break;
				case 'file': $form_input.=create_file_input($name,$value,$attributes);
				break;
				case 'hidden': $form_input=create_simple_input($type,$name,$value,$attributes);
				break;
				case 'radio': $form_input=create_radio_input($name,$label,$value,$attributes,$options);
				break;
				case 'checkbox': $form_input=create_checkbox_input($name,$label,$value,$attributes,$options);
				break;
				case 'select': 	if(empty($options)){ return "Please Add Options!"; }
								$form_input.=create_select_input($name,$value,$attributes,$options);
				break;
				case 'text': $form_input.=create_simple_input($type,$name,$value,$attributes);
				break;
				case 'textarea': $form_input.=create_textarea_input($name,$value,$attributes);
				break;
				default: $form_input.=create_simple_input($type,$name,$value,$attributes);
			}
			return $form_input;
		}
	}
	
	if(!function_exists('get_label')) {
  		function get_label($name,$label,$required){
			$form_label='';
			if($label!=''){
				$form_label='<label for="'.$name.'">'.$label;
				if($required===true){
					$form_label.=' <span class="text-danger">*</span>';
				}
				$form_label.='</label>';
			}
			return $form_label;
			
		}
	}
	if(!function_exists('set_attributes')) {
		function set_attributes($data,$attributes){
			if(is_array($attributes) && !empty($attributes)){
				foreach($attributes as $attribute=>$attrvalue){
					if($attribute=='class' && isset($data['class'])){
						$data['class'].=" $attrvalue";
					}
					else{
						$data[$attribute]=$attrvalue;
					}
				}
			}
			return $data;
		}
	}
	
	if(!function_exists('create_simple_input')) {
  		function create_simple_input($type,$name,$value,$attributes){
			$data=array("type"=>$type,"name"=>$name,"value"=>$value,"class"=>"form-control");
			$data=set_attributes($data,$attributes);
			return form_input($data);
		}
	}
	
	if(!function_exists('create_file_input')) {
  		function create_file_input($name,$value,$attributes){
			$data=array("type"=>'file',"name"=>$name,"value"=>$value);
			$data=set_attributes($data,$attributes);
			return form_input($data);
		}
	}
	
	if(!function_exists('create_checkbox_input')) {
  		function create_checkbox_input($name,$label,$value,$attributes,$options){
			$class="checkbox";
			$input='';
			if(isset($options['display']) && $options['display']=='inline'){
				$class="checkbox-inline";
			}
			if(isset($options['class'])){
				$class.=" $options[class]";
			}
			$input.='<div class="'.$class.'"><label>';
			$data=array("name"=>$name,"value"=>$value);
			$data=set_attributes($data,$attributes);
			$input.= form_checkbox($data);
			$input.=$label.'</label></div>';
			return $input;
		}
	}
	
	if(!function_exists('create_radio_input')) {
  		function create_radio_input($name,$label,$value,$attributes,$options){
			$class="radio";
			$input='';
			if(isset($options['display']) && $options['display']=='inline'){
				$class="radio-inline";
			}
			if(isset($options['class'])){
				$class.=" $options[class]";
			}
			$input.='<div class="'.$class.'"><label>';
			$data=array("name"=>$name,"value"=>$value);
			$data=set_attributes($data,$attributes);
			$input.= form_radio($data);
			$input.=$label.'</label></div>';
			return $input;
		}
	}
	
	if(!function_exists('create_textarea_input')) {
		function create_textarea_input($name,$value,$attributes){
			$data=array("name"=>$name,"value"=>$value,"class"=>"form-control");
			$data=set_attributes($data,$attributes);
			return form_textarea($data);
		}
	}
	
	if(!function_exists('create_select_input')) {
		function create_select_input($name,$value,$attributes,$options){
			$data=array("class"=>"form-control");
			$data=set_attributes($data,$attributes);
			return form_dropdown($name,$options,$value,$data);
		}
	}
	
?>