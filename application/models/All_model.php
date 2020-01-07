<?php
class All_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		//$this->db->db_debug = false;
	}
	
	public function gettables(){
		$query=$this->db->query("Show Tables");
		$tables=[];
		if($query->num_rows()>0){
			$tables=$query->result_array();
		}
		return $tables;
	}
	
	public function getcolumns($table){
		$query=$this->db->query("Show Columns from $table");
		$columns=[];
		if($query->num_rows()>0){
			$columns=$query->result_array();
		}
		return $columns;
	}
	
	public function getdata($table){
		$query=$this->db->get($table);
		$data=[];
		if($query->num_rows()>0){
			$data=$query->result_array();
		}
		return $data;
	}
	
	public function updatedata($table,$data,$where){
		$this->db->where($where);
		$this->db->update($table,$data);
	}
}