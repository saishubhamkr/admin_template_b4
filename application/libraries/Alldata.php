<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alldata {
	protected $CI;
	
	protected $config=false;

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct(){
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		if(!is_dir('./application/views/alldata')){
			mkdir('./application/views/alldata');
		}
		$data=$this->alldataview();
		write_file('./application/views/alldata/all.php',$data);
		$data=$this->datatableview();
		write_file('./application/views/alldata/table.php',$data);
	}
	
	
	public function viewall($auth=''){
		if($auth!='superadmin'){ redirect('/');}
		$data['title']="All Data";
		$data['datatable']=true;
		$tables=$this->gettables();
		$option['']="Select Table";
		if(is_array($tables)){
			foreach($tables as $table){
				$key = key($table);
				$option[$table[$key]]=$table[$key];
			}
		}
		$data['tables']=$option;
		$this->CI->template->load('alldata','all',$data);
	}
	
	public function gettable(){
		$table=$this->CI->input->post('table');
		if($table!=''){
			$data['columns']=$this->getcolumns($table);
			$data['data']=$this->getdata($table);
		}
		else{
			$data['columns'][]=array("Field"=>"Columns in Table");
			$data['data']=array();
		}
		$this->CI->load->view("alldata/table",$data);
	}
	
	public function updatedata(){
		if($this->CI->input->post('table')!==NULL){
			$table=$this->CI->input->post('table');
			$id=$this->CI->input->post('id');
			$where['id']=$id;
			unset($_POST['table']);
			unset($_POST['id']);
			$this->update($table,$_POST,$where);
		}
	}
	
	public function alldataview(){
		$html="
<section class=\"content\">
	<div class=\"container-fluid\">
		<div class=\"row\">
			<div class=\"col-md-12\">
				<div class=\"card\">
					<div class=\"card-header\">
						<h3 class=\"card-title\"><?php echo \$title; ?></h3>
					</div>
					<!-- /.card-header -->
					<div class=\"card-body\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<div class=\"row\">
									<div class=\"col-md-4\">
										<div class=\"form-group\">
											<label class=\"col-form-label\">Select Table</label>
											<?php 
												echo form_dropdown('table', \$tables,'',array('id'=>'table', 'class'=>'form-control'));
											?>
										</div>
									</div>
									<div class=\"col-md-4\"><br>
										<button type=\"button\" class=\"btn btn-bg-info btn-sm\" onClick=\"$('#table').trigger('change');\">Refresh</button>
									</div>
								</div><br>
				
								<div class=\"row\">
									<div class=\"col-md-12\">
										<div class=\"table-responsive\" id=\"datatable\">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>  
</section>
<input type=\"hidden\" name=\"table\" id=\"uptable\">
<input type=\"hidden\" name=\"id\" id=\"id\">
<input type=\"hidden\" id=\"temp_val\">
<input type=\"submit\" value=\"save\" class=\"hidden\">
        <script>
        	
			$(document).ready(function(e) {
                createTable();
				$('#table').change(function(){
					var table=$(this).val();
					$.ajax({
						type:\"POST\",
						url:\"<?php echo site_url(\"home/gettable/\"); ?>\",
						data:{table:table},
						success: function(data){
							$('#datatable').html(data);
							createTable();
						}
					});
				});
				$('body').on('dblclick','.editable',function(e){
					if(e.target.id==\"column\"){ return false; }
					//var prevVal=$('#column').val();
					//$('#column').closest('td').text(prevVal);
					var id=$(this).parent().children(\":eq(0)\").html();
					var column=$(this).attr('data-column');
					var value=$(this).text();
					var table=$('#table').val();
					$('#uptable').val(table);
					$('#id').val(id);
					$(this).html('<input type=\"text\" id=\"column\" value=\"\">');
					$('#column').attr(\"name\",column);
					$('#column').val(value).focus();
					$('#temp_val').val(value);
				});
				$('body').on('keyup',function(e){
					if(e.which==13){
						if($('#column').length==1){
							var table=$('#uptable').val();
							var id=$('#id').val();
							var column=$('#column').attr(\"name\");
							var value=$('#column').val();
							var data = {};
							data['table']=table;
							data['id']=id;
							data[column] = value;
							$.ajax({
								type:\"POST\",
								url:\"<?php echo base_url('home/updatedata'); ?>\",
								data:data,
								success: function(data){
									$('#table').trigger('change');
								}
							});
						}
					}
				});
				$('body').on('click',function(e){
					if(e.target.classList!='editable' && e.target.nodeName!='INPUT'){	
						var value=$('#temp_val').val();
						$('#column').closest('td').text(value);
					}
				});
            });
			
			function createTable(){
				$('#bootstrap-data-table-export').DataTable();
			}
        </script>";
		return $html;
	}
	
	public function datatableview(){
		$html="
<table class=\"table data-table\" id=\"bootstrap-data-table-export\">
    <thead>
        <tr>
        	<?php
            	if(!empty(\$columns)){
					foreach(\$columns as \$column){
						echo \"<th>\$column[Field]</th>\";
					}
				}
			?>
        </tr>
    </thead>
    <tbody>
        <?php
        if(is_array(\$data)){
            foreach(\$data as \$row):
        ?>
        <tr>
        	<?php
            	if(!empty(\$columns)){
					foreach(\$columns as \$column){
						\$field=\$column['Field'];
			?>
            <td class=\"editable \" data-column=\"<?php echo \$field ?>\"><?php echo \$row[\$field]; ?></td>
            <?php
					}
				}
			?>
        </tr>
        <?php
            endforeach; 
        } 
        ?> 
    </tbody>

</table>";
		return $html;
	}
	
	public function gettables(){
		$query=$this->CI->db->query("Show Tables");
		$tables=[];
		if($query->num_rows()>0){
			$tables=$query->result_array();
		}
		return $tables;
	}
	
	public function getcolumns($table){
		$query=$this->CI->db->query("Show Columns from $table");
		$columns=[];
		if($query->num_rows()>0){
			$columns=$query->result_array();
		}
		return $columns;
	}
	
	public function getdata($table){
		$query=$this->CI->db->get($table);
		$data=[];
		if($query->num_rows()>0){
			$data=$query->result_array();
		}
		return $data;
	}
	
	public function update($table,$data,$where){
		$this->CI->db->where($where);
		$this->CI->db->update($table,$data);
	}
	
	
}