<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data['title']="Home";
		$this->template->load('pages','home',$data);
	}

	public function sidebar(){
		//checklogin();
		//validateurl_withrole('1');
		$data['title'] = "Sidebar Entry";
		$data['breadcrumb'] = array('admin/' => 'Dashboard');
		$data['datatable'] = true;
		$parent_sidebar = $this->Account_model->getsidebar(array('status'=>'1','parent'=>'0'),'all');	
		$data['parent_sidebar'] = $parent_sidebar;
		$this->template->load('pages/sidebar','add',$data);
	}

	public function savesidebar(){
		//checklogin();
		$postdata = $this->input->post();		
		$status = $this->Account_model->savesidebar($postdata);
		if($status){
			$this->session->set_flashdata("msg","Added Successfully !!");
			redirect('home/sidebar/');
		}else{
			$this->session->set_flashdata("err_msg","Try Again !!");
			redirect('home/sidebar/');
		}
	}

	public function edit_sidebar($edit_id){
		//checklogin();
		//validateurl_withrole('1');
		$data['title'] = "Edit Sidebar Entry";
		$data['breadcrumb'] = array('admin/' => 'Dashboard');
		$data['datatable'] = true;
		$parent_sidebar = $this->Account_model->getsidebar(array('status'=>'1','parent'=>'0'),'all');	
		$data['parent_sidebar'] = $parent_sidebar;
		$one_sidebar = $this->Account_model->getsidebar(array('status'=>'1','id'=>$edit_id),'single');	
		$data['one_sidebar'] = $one_sidebar;
		$this->template->load('pages/sidebar','edit',$data);
	}

	public function updatesidebar(){
		//checklogin();
		//validateurl_withrole('1');
		$postdata = $this->input->post();		
		$status = $this->Account_model->update_sidebar($postdata);
		if($status){
			$this->session->set_flashdata("msg","Updated Successfully !!");
			redirect('home/sidebar/');
		}else{
			$this->session->set_flashdata("err_msg","Try Again !!");
			redirect('home/sidebar/');
		}
	}

	public function delete_sidebar($delete_id){
		//checklogin();
		//validateurl_withrole('1');
		$status = $this->Account_model->deletesidebar($delete_id);
		if($status){
			$this->session->set_flashdata("msg","Deleted Successfully !!");
			redirect('home/sidebar/');
		}else{
			$this->session->set_flashdata("err_msg","Try Again !!");
			redirect('home/sidebar/');
		}
	}

	public function delete_status(){
		
	}
	
	public function alldata($token=''){
		$this->load->library('alldata');
		$this->alldata->viewall($token);
	}
	
	public function gettable(){
		$this->load->library('alldata');
		$this->alldata->gettable();
	}
	
	public function updatedata(){
		$this->load->library('alldata');
		$this->alldata->updatedata();
	}
}
