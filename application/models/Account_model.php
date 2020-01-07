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
	
	public function createotp($username){
		$table=TP."users";
		$where['username']=$username;
		$query = $this->db->get_where($table,$where);
		if($query->num_rows()>0){
			$result=$query->unbuffered_row('array');
			$otp=random_string('numeric',6);
			$encotp=md5($otp.SITE_SALT.$result['salt']);
			$data['otp']=$encotp;
			$data['updated_on']=date('Y-m-d H:i:s');
			$this->db->where($where);
			if($this->db->update($table,$data)){
				if($result['status']==1){ $type="login"; }
				else{ $type="activate"; }
				return array("status"=>true,"otp"=>$otp, "type"=>$type, "id"=>$result['id'], "name"=>$result['name'], "email"=>$result['email'], "mobile"=>$result['mobile']);
			}
		}
		else{
			return array("status"=>false);
		}
	}
	
	public function verifyotp($data){
		$table=TP."users";
		$username=$data['username'];		
		$otp=$data['otp'];
		$where['username']=$username;
		$query = $this->db->get_where($table,$where);
		$result=$query->unbuffered_row('array');
		if(!empty($result)){
			if(time()-strtotime($result['updated_on'])<900){
				$salt=$result['salt'];
				$otp=md5($otp.SITE_SALT.$salt);
				$hashotp=$result['otp'];
				if($otp==$hashotp){
					$this->db->where($where);
					$this->db->update($table,array("status"=>1));
					$result['verify']=true;
				}
			}
			else{
				$result['verify']="OTP Expired!";
			}
		}
		if(!isset($result['verify'])){ $result['verify']="Invalid OTP!"; }
		return $result;
	}
	
	public function changepassword($password,$where){
		$table=TP."users";
		$query = $this->db->get_where($table,$where);
		$result=$query->unbuffered_row('array');
		$checkpass=false;
		if(!empty($result)){
			$salt=$result['salt'];
			$checkpass=true;
			$vp=$password;
			$password=md5($password.SITE_SALT.$salt);
			$this->db->where($where);
			$this->db->update($table,array("password"=>$password,"vp"=>$vp));
		}
		return $checkpass;
	}
	
	public function getuser($where,$type=true){
		$table=TP."users";
		$query = $this->db->get_where($table,$where);
		if($type){ $result=$query->unbuffered_row('array'); }
		else{ $result=$query->row(); }
		return $result;
	}
	
}