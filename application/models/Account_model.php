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

	public function getsidebar($where=array(),$type='all',$like=array()){
		if(!empty($like)){
            $this->db->like($like);
        }
        $this->db->order_by('position');
       $query = $this->db->get_where('sidebar',$where);
       if($type == 'all'){
           $return = $query->result_array();
       }else{
           $return = $query->unbuffered_row('array');
       }
       return $return;
    }

    public function savesidebar($postdata){
        unset($postdata['save_cat']);
        if(empty($postdata['activate_not'])){
            $postdata['activate_not'] = '{"0":""}';
        }
        if(empty($postdata['position'])){
            $postdata['position'] = 0;
        }
		if(!empty($postdata['icon'])){
            if(preg_match('/nav-icon/',$postdata['icon']) == 0){
                $icon_text = str_replace('class="','class="nav-icon ',$postdata['icon']);
                $postdata['icon'] = $icon_text;
            }
        }
        if(!empty($postdata['role_id'])){
            $role_array = explode('|',$postdata['role_id']);
            $role = array();
            if(!empty($role_array)){                
                foreach($role_array as $r){
                    $role[] = "\"$r\"";
                }                
            }else{
                $role[] = "\"1\"";
            }
            $postdata['role_id'] = implode(',',$role);
        }
        $position=$postdata['position'];
        if($postdata['parent']!=0){
			if($position==0){
				$this->db->where("id",$postdata['parent']);
				$query = $this->db->get("sidebar");
				$array=$query->unbuffered_row('array');
				$postdata['position']=$position=$array['position'];
			}
			if($postdata['status']==1){
				$query="UPDATE ".TP."sidebar set `status`='1' where `id`='$postdata[parent]'";
				$this->db->query($query);
			}
		}
		else{
			$this->db->select_max('position');
			$this->db->where("parent=(select id from ".TP."sidebar where `position`='$postdata[position]')");
			$query = $this->db->get("sidebar");
			$array=$query->row_array();
			if($array['position']!=0){
				$postdata['position']=$position=$array['position'];
			}
		}
        $query="UPDATE ".TP."sidebar set `position`=`position`+1 where `position`>'$position'";
		$this->db->query($query);
		$postdata['position']++;
        
        $insert_status = $this->db->insert('sidebar',$postdata);
        if($insert_status){
            return $postdata['position'];
        }else{
            return false;
        }
    }

    public function deletesidebar($id){
        $update_status = $this->db->update('sidebar',array('status'=>'0'),array('id'=>$id,'status'=>'1'));
        if($update_status){
            return true;
        }else{
            return false;
        }
    }

    public function update_sidebar($postdata){
        unset($postdata['save_cat']);
        $edit_id = $postdata['edit_id'];
        unset($postdata['edit_id']);
        if(empty($postdata['activate_not'])){
            $postdata['activate_not'] = '{"0":""}';
        }
        if(empty($postdata['position'])){
            $postdata['position'] = 0;
        }
		if(!empty($postdata['icon'])){
            if(preg_match('/nav-icon/',$postdata['icon']) == 0){
                $icon_text = str_replace('class="','class="nav-icon ',$postdata['icon']);
                $postdata['icon'] = $icon_text;
            }
        }
        if(!empty($postdata['role_id'])){
            $role_array = explode('|',$postdata['role_id']);
            $role = array();
            if(!empty($role_array)){                
                foreach($role_array as $r){
                    $role[] = "\"$r\"";
                }                
            }else{
                $role[] = "\"1\"";
            }
            $postdata['role_id'] = implode(',',$role);
        }
        
		$where="id='$edit_id' or parent='$edit_id'";
		$this->db->order_by('position');
		$getquery=$this->db->get_where("sidebar",$where);
		$array=$getquery->result_array();
        //Array ( [0] => Array ( [id] => 16 [activate_menu] => home [activate_not] => {"0":""} [base_url] => payment/report/ [icon] => [name] => adsfa [parent] => 12 [position] => 4 [role_id] => "member" [status] => 1 ) )
        if(is_array($array)){
			foreach($array as $key=>$row){
				$i=0;
				if($row['parent']==0){
					if($postdata['position']>$row['position']){ $postdata['position']-=count($array); }
					$array[$key]['activate_menu']=$postdata['activate_menu'];
					$array[$key]['activate_not']=$postdata['activate_not'];
					$array[$key]['base_url']=$postdata['base_url'];
					$array[$key]['icon']=$postdata['icon'];
					$array[$key]['name']=	$postdata['name'];
					$array[$key]['parent']=$postdata['parent'];
					$array[$key]['position']=$postdata['position'];
					$array[$key]['role_id']=$postdata['role_id'];
					$array[$key]['status']=$postdata['status'];
				}
				else{
					if($key>0){
						$array[$key]['position']=	$i++;
						$array[$key]['status']=$postdata['status'];
					}
					else{
						if($postdata['position']>$row['position']){ $postdata['position']-=count($array); }
						$array[$key]['activate_menu']=$postdata['activate_menu'];
						$array[$key]['activate_not']=$postdata['activate_not'];
						$array[$key]['base_url']=$postdata['base_url'];
						$array[$key]['icon']=$postdata['icon'];
						$array[$key]['name']=	$postdata['name'];
						$array[$key]['parent']=$postdata['parent'];
                        $array[$key]['position']=$postdata['position'];
                        $array[$key]['role_id']=$postdata['role_id'];
                        $array[$key]['status']=$postdata['status'];
					}
				}
			}
		}
        $this->db->delete("sidebar",$where);
		$this->reordermenu();
		$neworder=$array[0]['position'];
		if(is_array($array)){
			foreach($array as $key=>$data){
				if($key>1){
					$data['position']=++$neworder;
				}
				$neworder=$this->savesidebar($data);
			}
		}
    }

    public function getdynamic_sidebar(){
        // need to have role
        $role = $this->session->role;        
		$parentsidebar = $this->getsidebar(array('status'=>'1','parent'=>'0'),'all',array('role_id'=>"\"$role\""));		
		$returnsidebar = array(); 
		$returnsidebar = $this->getall_parentwise_sidebar($parentsidebar);
		//print_r($returnsidebar);die;
       	return $returnsidebar;
    }

    public function getall_parentwise_sidebar($allsidebarparentid){
        $returnarray = array();
		$role = $this->session->role;
        if(!empty($allsidebarparentid)){
            foreach($allsidebarparentid as $key=>$oneid){
                $returnarray[$key] =$this->getsidebar(array('id'=>$oneid['id'],'status'=>'1'),'single',array('role_id'=>"\"$role\""));
                $onesubdata = $this->getsidebar(array('parent'=>$oneid['id'],'status'=>'1'),'all',array('role_id'=>"\"$role\""));
                if(!empty($onesubdata)){
                    $returnarray[$key]['submenu'] = $onesubdata;
                }else{
                    $returnarray[$key]['submenu'] = 0;
                }
            }
        }
        return $returnarray;
    }
	
	public function getOrderList($parent_id=0){
		$this->db->where("parent",$parent_id);
		$this->db->order_by('position');
		$query = $this->db->get("sidebar");
		$data=$query->result_array();
		return $data;
	}
	
	public function reordermenu(){
		$this->db->order_by('position');
		$getquery=$this->db->get_where("sidebar");
		$array=$getquery->result_array();
		if(is_array($array)){
			$i=0;
			foreach($array as $key=>$row){
				$i++;
				$update=array("position"=>$i);
				$this->db->update("sidebar",$update,array("id"=>$row['id']));
			}
		}
	}
}