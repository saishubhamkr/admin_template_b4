<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paging {
	protected $CI;
	
	protected $url;
	
	protected $num_links=2;
	
	protected $pages;
	
	protected $page;
	
	protected $display_links=array();
	
	protected $display_type="individual";
	
	protected $prevnext=array("prev"=>"&lt; Prev","next"=>"Next &gt;");
	
	protected $skip=array("num"=>5,"skip_prev"=>"&lt; Skip 5","skip_next"=>"Skip 5 &gt;");
	
	protected $firstlast=array("first"=>"&lsaquo; First","last"=>"Last &rsaquo;");
	
	protected $pagefilters=false;
	
	protected $ul_class=array("pagination");
	
	protected $num_class=array();
	
	protected $link_class=array();
	
	protected $anchor_class=array();
	
	protected $config=false;

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
			// Assign the CodeIgniter super-object
			$this->CI =& get_instance();
	}
	
	public function initialize($config=array()){
		$this->config=false;
		if(!empty($config)){
			if(!isset($config['url'])){
				echo "Please add Page URL!";
				return false;
			}
			if(!isset($config['pages'])){
				echo "Please add Total Pages!";
				return false;
			}
			if(!isset($config['page'])){
				echo "Please add Current Page!";
				return false;
			}
			foreach ($config as $key => $val){
				if (property_exists($this, $key)){
					if(is_array($val)){
						foreach($val as $key2=>$val2){
							$this->{$key}[$key2]= $val2;
						}
					}
					else{
						$this->$key = $val;
					}
				}
			}
			$this->config=true;
		}
		else{
			echo "Please add Paging Configuration!";
			return false;
		}
	}
	
	public function pagination(){
		if($this->config){
			$pagination="";
			if($this->pages>1){
				if($this->display_type=="individual"){
					$pagination="";
				}
				else{
					$pagination="<ul ";
					if(is_array($this->ul_class))
						$pagination.="class='".implode(" ",$this->ul_class)."'";
					$pagination.=">";
				}
				$current=false;
			
				if(array_search("firstlast",$this->display_links)!==false && $this->page!=1){
					$pagination.=$this->createpagelinks(1,$this->firstlast['first'],false,$this->link_class);
				}
				if(array_search("skip",$this->display_links)!==false && $this->page-$this->skip['num']>0){
					$pagination.=$this->createpagelinks($this->page-$this->skip['num'],$this->skip['skip_prev'],false,$this->link_class);
				}
				if(array_search("prevnext",$this->display_links)!==false && $this->page!=1){
					$pagination.=$this->createpagelinks($this->page-1,$this->prevnext['prev'],false,$this->link_class);
				}
				if(array_search("pages",$this->display_links)!==false){
					for($i=1;$i<=$this->pages;$i++){
						if($i<=$this->num_links || $i>$this->pages-$this->num_links || ($i>$this->page-$this->num_links && $i<$this->page+$this->num_links)){
							if($i==$this->page){ $current=true; }else{ $current=false; }
							$pagination.=$this->createpagelinks($i,$i,$current,$this->num_class);
						}
						elseif($i==$this->num_links+1 || $i==$this->pages-$this->num_links){
							$pagination.=$this->createpagelinks("","...",$current,$this->num_class);
						}
					}
				}
				if(array_search("prevnext",$this->display_links)!==false && $this->page!=$this->pages){
					$pagination.=$this->createpagelinks($this->page+1,$this->prevnext['next'],false,$this->link_class);
				}
				if(array_search("skip",$this->display_links)!==false && $this->pages-$this->page>=$this->skip['num']){
					$pagination.=$this->createpagelinks($this->page+$this->skip['num'],$this->skip['skip_next'],false,$this->link_class);
				}
				if(array_search("firstlast",$this->display_links)!==false && $this->page!=$this->pages){
					$pagination.=$this->createpagelinks($this->pages,$this->firstlast['last'],false,$this->link_class);
				}
				if($this->display_type!="individual"){
					$pagination.="</ul>";
				}
			}
			return $pagination;
		}
		else{
			echo "Please add Paging Configuration!";
			return false;
		}
	}
		
	public function createpagelinks($page,$link,$current,$class){
		if(!empty($this->pagefilters) && is_array($this->pagefilters)){
			$this->pagefilters=http_build_query($this->pagefilters);
			$this->pagefilters="?".$this->pagefilters;
		}
		if($this->display_type=="individual"){
			$pagelink="<ul ";
			if(is_array($this->ul_class))
				$pagelink.="class='".implode(" ",$this->ul_class)."'";
			$pagelink.=">";
		}
		else{
			$pagelink="";
		}
		$pagelink.="<li class='".implode(" ",$class)." ";
		if($current===true){$pagelink.="active";}
		$pagelink.="'>";
		if($page!=""){
			$href=$this->url."page/".$page."/".$this->pagefilters;
		}
		else{
			$href="#";
		}
		$pagelink.="<a href='$href' class=' ".implode(" ",$this->anchor_class)." ";
		$pagelink.="'>".$link."</a></li>";
		
		if($this->display_type=="individual"){
			$pagelink.="</ul> ";
		}
		return $pagelink;
	}
	
}