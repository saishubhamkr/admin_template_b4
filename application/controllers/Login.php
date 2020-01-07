<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		loginredirect();
		$this->session->unset_userdata("username");
		$data['title']="Login";
		$data['body_class']="login-page";
		$this->load->view('includes/top-section',$data);
		$this->load->view('pages/login');
	}
	
	public function forgotpassword(){
		$this->session->unset_userdata("username");
		$data['title']="Forgot Password";
		$data['body_class']="login-page";
		$this->load->view('includes/top-section',$data);
		$this->load->view('pages/forgotpassword');
	}
	
	public function enterotp(){
		if($this->session->userdata('username')===NULL){redirect('login/');}
		$data['title']="Enter OTP";
		$data['body_class']="login-page";
		$this->load->view('includes/top-section',$data);
		$this->load->view('pages/enterotp');
	}
	
	public function resetpassword(){
		if($this->session->username===NULL){redirect('login/');}
		$data['title']="Reset Password";
		$data['body_class']="login-page";
		$this->load->view('includes/top-section',$data);
		$this->load->view('pages/resetpassword');
	}
	
	public function logout(){
		if($this->session->user!==NULL){
			$data=array("user","name","role");
			$this->session->unset_userdata($data);
		}	
		redirect('login/');
	}
	
	
	public function validatelogin(){
		$data=$this->input->post();
		unset($data['login']);
		$result=$this->Account_model->login($data);
		if($result['verify']===true){
			$this->startsession($result);
			loginredirect();
		}
		else{ 
			$this->session->set_flashdata('logerr',$result['verify']);
			redirect('login/');
		}
	}
	
	public function startsession($result){
		$data['user']=md5($result['id']);
		$data['name']=$result['name'];
		$data['role']=$result['role'];
		$this->session->set_userdata($data);
	}
	
	public function validateUser(){
		if($this->input->post('forgotpassword')!==NULL){
			$username=$this->input->post('username');
			$result=$this->Account_model->sendotp($username);
			if($result['status']===true){
				$otp=$result['otp'];
				$verification_msg="$otp is your One Time Password to Reset password . This OTP is valid for 15 minutes.";
				$smsdata=array("mobile"=>$result['mobile'],"message"=>$verification_msg);
				send_sms($smsdata);
				$this->session->set_userdata("username",$username);
				redirect('admin/login/enterotp/'.$otp);
			}
			else{
				$this->session->set_flashdata("logerr","Username not valid!");
				redirect('admin/login/forgotpassword/');
			}
		}
		else{
			redirect('admin/login/');
		}
	}
	
	public function createadmin(){
		$data['title']="Create Admin";
		$data['body_class']="login-page";
		$this->load->view('includes/top-section',$data);
		$this->load->view('pages/createadmin');
	}
	
	public function insertadmin(){
		if($this->input->post('createadmin')!==NULL){
			$data=$this->input->post();
			unset($data['createadmin']);
			$this->Account_model->createadmin($data);
		}
		redirect('login/');
	}
}
