<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Template {
    var $ci;
	private $styles=array("link"=>array(),"file"=>array());
	private $top_script=array("link"=>array(),"file"=>array());
	private $bottom_script=array("link"=>array(),"file"=>array());
      
    function __construct() {
       $this->ci =& get_instance();
    }
	
    function load($folder, $view, $data=array("title"=>"Page")) {
		$location=$folder.'/';
		$data['sidebarmenu'] = $this->ci->Account_model->getdynamic_sidebar();
		if(!empty($data['styles'])){ 
			$styles=$data['styles'];
			foreach($styles as $key=>$style){
				if(is_array($style)){
					foreach($style as $single_style){
						if(array_search($single_style,$this->styles[$key])===false)
							$this->styles[$key][]=$single_style;
					}
				}
				else{
					if(array_search($style,$this->styles[$key])===false)
						$this->styles[$key][]=$style;
				}
			}
		}
		
		if(!empty($data['top_script'])){ 
			$top_script=$data['top_script'];
			foreach($top_script as $key=>$script){
				if(is_array($script)){
					foreach($script as $single_script){
						if(array_search($single_script,$this->top_script[$key])===false)
							$this->top_script[$key][]=$single_script;
					}
				}
				else{
					if(array_search($script,$this->top_script[$key])===false)
						$this->top_script[$key][]=$script;
				}
			}
		}
		
		if(!empty($data['bottom_script'])){ 
			$bottom_script=$data['bottom_script'];
			foreach($bottom_script as $key=>$script){
				if(is_array($script)){
					foreach($script as $single_script){
						if(array_search($single_script,$this->bottom_script[$key])===false)
							$this->bottom_script[$key][]=$single_script;
					}
				}
				else{
					if(array_search($script,$this->bottom_script[$key])===false)
						$this->bottom_script[$key][]=$script;
				}
			}
		}
		if(isset($data['datatable']) && $data['datatable']===true){
			$this->loaddatatable();
		}
		if(isset($data['select2']) && $data['select2']===true){
			$this->loadselect2();
		}
		if(isset($data['switchery']) && $data['switchery']===true){
			$this->loadswitchery();
		}
		if(isset($data['datepicker']) && $data['datepicker']===true){
			$this->loaddatepicker();
		}
		if(isset($data['timepicker']) && $data['timepicker']===true){
			$this->loadtimepicker();
		}
		if(isset($data['ckeditor']) && $data['ckeditor']===true){
			$this->loadckeditor();
		}
		if(isset($data['rangepicker']) && $data['rangepicker']===true){
			$this->loadrangepicker();
		}
		if(NTYPE=='sweetalert' || (isset($data['ntype']) && $data['ntype']==='sweetalert')){
			$this->loadsweetalert();
		}
		if(NTYPE=='toastr' || (isset($data['ntype']) && $data['ntype']==='toastr')){
			$this->loadtoastr();
		}
		$data['styles']=$this->styles;
		$data['top_script']=$this->top_script;
		$data['bottom_script']=$this->bottom_script;
		$this->ci->load->view('includes/top-section',$data);
		$this->ci->load->view('includes/header');
		$this->ci->load->view('includes/sidebar');
		$this->ci->load->view($location.$view);
		$this->ci->load->view('includes/bottom-section');
	}
	
	function loaddatatable(){
		$this->styles['link'][]="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css";
		$this->top_script['link'][]="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js";
	}
	
	function loadselect2(){
		$this->styles['file'][]="includes/plugins/select2/select2.min.css";
		$this->bottom_script['file'][]="includes/plugins/select2/select2.full.min.js";
	}
	
	function rangepicker(){
		$this->styles['file'][]="plugins/daterangepicker/daterangepicker.css";
		$this->bottom_script['link'][]="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js";
		$this->bottom_script['file'][]="plugins/daterangepicker/daterangepicker.js";
	}
	
	function loadtimepicker(){
		$this->styles['file'][]="includes/plugins/timepicker/bootstrap-timepicker.min.css";
		$this->bottom_script['file'][]="includes/plugins/timepicker/bootstrap-timepicker.min.js";
	}
	function loaddatepicker(){
		$this->styles['file'][]="includes/plugins/datepicker/datepicker3.css";
		$this->bottom_script['file'][]="includes/plugins/datepicker/bootstrap-datepicker.js";
	}
	
	function loadckeditor(){
		$this->top_script['link'][]="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js";
	}
	
	function loadswitchery(){
		$this->styles['file'][]="includes/plugins/switchery/dist/switchery.css";
		$this->top_script['file'][]="includes/plugins/switchery/dist/switchery.js";
	}
	
	function loadsweetalert(){
		$this->styles['file'][]="includes/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css";
		$this->bottom_script['file'][]="includes/plugins/sweetalert2/sweetalert2.min.js";
	}
	
	function loadtoastr(){
		$this->styles['file'][]="includes/plugins/toastr/toastr.min.css";
		$this->bottom_script['file'][]="includes/plugins/toastr/toastr.min.js";
	}
	
	function loadplugins($data=array()){
		if(isset($data['datatable']) && $data['datatable']===true){
			$this->loaddatatable();
		}
		if(isset($data['select2']) && $data['select2']===true){
			$this->loadselect2();
		}
		if(isset($data['switchery']) && $data['switchery']===true){
			$this->loadswitchery();
		}
		if(isset($data['datepicker']) && $data['datepicker']===true){
			$this->loaddatepicker();
		}
		if(isset($data['timepicker']) && $data['timepicker']===true){
			$this->loadtimepicker();
		}
		if(isset($data['ckeditor']) && $data['ckeditor']===true){
			$this->loadckeditor();
		}
		if(isset($data['rangepicker']) && $data['rangepicker']===true){
			$this->loadrangepicker();
		}
		$result=array();
		$result['styles']=$this->styles;
		$result['top_script']=$this->top_script;
		$result['bottom_script']=$this->bottom_script;
		return $result;
	}
}
