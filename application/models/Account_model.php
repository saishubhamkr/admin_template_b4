<?php
class Account_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
	
	public function createadmin($data){
		$table=TP."users";
		$salt=random_string('alnum', 16);
		$password=md5($data['password'].SITE_SALT.$salt);
		$data['vp']=$data['password'];
		$data['password']=$password;
		$data['salt']=$salt;
		$data['created_on']=date('Y-m-d H:i:s');
		$data['updated_on']=date('Y-m-d H:i:s');
		$data['status']=1;
		if($this->db->insert($table,$data)){
			return true;
		}
	}
	
	public function login($data){
		$table=TP."users";
		$username=$data['username'];		
		$password=$data['password'];
		$this->db->where('username', $username);
		$query = $this->db->get($table);
		$result=$query->unbuffered_row('array');
		if(!empty($result)){
			$salt=$result['salt'];
			$password=md5($password.SITE_SALT.$salt);
			$hashpassword=$result['password'];
			if($password==$hashpassword && $result['status']==1){
				$result['verify']=true;
			}
		}
		if(!isset($result['verify'])){ $result=array('verify'=>"Wrong Credentials!"); }
		return $result;
	}
	
}