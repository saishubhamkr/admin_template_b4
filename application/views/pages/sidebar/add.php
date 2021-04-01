<section class="content">
      <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header">
                    	<h3 class="card-title"><?php echo $title; ?></h3>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="row">
                        	<div class="col-md-5 col-lg-4">
                                <?php echo form_open_multipart('home/savesidebar');?>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'activate_menu','id'=>'activate_menu','class'=>'form-control','placeholder'=>'Enter Activate Menu','required'=>'true'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'activate_not','id'=>'activate_not','class'=>'form-control','placeholder'=>'Enter Not Activate On'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'base_url','id'=>'base_url','class'=>'form-control','placeholder'=>'Enter Base URL','required'=>'true'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'icon','id'=>'icon','class'=>'form-control','placeholder'=>'Fav Icon'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'name','id'=>'name','class'=>'form-control','placeholder'=>'Sidebar Name','required'=>'true'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php $parent_option[] = '-- Select Parent --'; $parent_option['0'] = 'SELF';
                                        if(!empty($parent_sidebar)){
                                            foreach($parent_sidebar as $pside){
                                                $parent_option[$pside['id']] = $pside['name'];
                                            }
                                        }
                                        echo form_dropdown(array('class'=>'form-control','name'=>'parent','id'=>'parent_id','required'=>'true'),$parent_option,array('0'));
                                        ?>
                                    </div>                                    
                                </div>
                                <?php /*?><div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'number','min'=>'0','name'=>'position','id'=>'position','class'=>'form-control','placeholder'=>'Position'));?>
                                    </div>                                    
                                </div>  <?php */?>   
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php 
                                            echo create_form_input("select","position","",true,'',array('id'=>'position'),array(""=>"Select Position"));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'role_id','id'=>'roles','class'=>'form-control','placeholder'=>'Enter Allowed Roles (as 1|2|3 if multiple)','required'=>'true'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'number','min'=>'0','max'=>'1','name'=>'status','id'=>'status','class'=>'form-control','placeholder'=>'Enter Status','required'=>'true'));?>
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <?php echo form_submit(array('name'=>'save_cat','id'=>'save_cat','value'=>'Save Sidebar','class'=>'form-control btn btn-success'));?>
                                    </div>
                                    <div class="col-md-4"></div>                                    
                                </div>
                                <?php echo form_close();?>
                            </div>
                            <div class="col-md-2 col-lg-2"></div>
                        	<div class="col-md-5 col-lg-6 table-responsive">
                            	<table class="table table-bordered text-center">
                                    <thead>
                                        <tr>    
                                            <th>#</th>
                                            <th>Name</th>                                            
                                            <th>Activation</th>                                            
                                            <th>Base URL</th>                                            
                                            <th>Icon</th>                                            
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($parent_sidebar)){
                                            foreach($parent_sidebar as $pside){ $id=$pside['id']; ?>
                                        <tr>
                                            <td colspan="2"><?php echo $pside['name'];?></td>
                                            <td><?php echo $pside['activate_menu'];?><br><?php echo $pside['activate_not'];?></td>
                                            <td><?php echo $pside['base_url'];?></td>
                                            <td><?php echo $pside['icon'];?></td>
                                            <td><span class="float-right">
                                            <a href='<?php echo base_url("home/delete_sidebar/$pside[id]");?>'><button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></a>
                                            <a href="<?php echo base_url("home/edit_sidebar/$pside[id]");?>"><button class="btn btn-success btn-xs"><i class="fa fa-edit"></i></button></a>
                                            <button class="btn btn-info btn-xs duplicate" type="button" data-dupid="<?php echo $pside['id'];?>"><i class="fa fa-network-wired"></i></button>
                                            </span></td>
                                        </tr>
                                        <?php  $child_sidebar = $this->Account_model->getsidebar(array('status'=>'1','parent'=>$id),'all');
                                        if(!empty($child_sidebar)){
                                            foreach($child_sidebar as $cside){ $cid=$cside['id'];?>
                                        <tr>
                                            <td ><b>>>>></b></td>
                                            <td><?php echo $cside['name'];?></td>
                                            <td><?php echo $cside['activate_menu'];?><br><?php echo $cside['activate_not'];?></td>
                                            <td><?php echo $cside['base_url'];?></td>
                                            <td><?php echo $cside['icon'];?></td>
                                            <td width='20%'><span class="float-right">
                                            <a href="<?php echo base_url("home/delete_sidebar/$cside[id]");?>"><button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></a>
                                            <a href="<?php echo base_url("home/edit_sidebar/$cside[id]");?>"><button class="btn btn-success btn-xs"><i class="fa fa-edit"></i></button></a>
                                            <button class="btn btn-info btn-xs duplicate" type="button" data-dupid="<?php echo $cside['id'];?>"><i class="fa fa-network-wired"></i></button>
                                            </span></td>
                                        </tr>
                                        <?php $last_sidebar = $this->Account_model->getsidebar(array('status'=>'1','parent'=>$cid),'all');
                                        if(!empty($last_sidebar)){
                                            foreach($last_sidebar as $lside){ ?>
                                        <tr>
                                            <td width='5%'><b>>>>></b></td>
                                            <td width='5%'><b>>>>></b></td>
                                            <td width='70%'><?php echo $lside['name'];?></td>
                                            <td width='20%'><span class="float-right">
                                            <a href="<?php echo base_url("home/delete_sidebar/$lside[id]");?>"><button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></a>
                                            <a href="<?php echo base_url("home/edit_sidebar/$lside[id]");?>"><button class="btn btn-success btn-xs"><i class="fa fa-edit"></i></button></a>
                                            <button class="btn btn-info btn-xs duplicate" type="button" data-dupid="<?php echo $lside['id'];?>"><i class="fa fa-network-wired"></i></button>
                                            </span></td>
                                        </tr>
                                        <?php }
                                        }
                                            }
                                        }
                                            }
                                        }?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>    
<script>
	
	$(document).ready(function(e) {
        $('.hoverable').mouseenter(function(){
            //$('[data-toggle="popover"]').popover();
            $(this).popover('show');                    
        }); 

        $('.hoverable').mouseleave(function(){
            $(this).popover('hide');
        });

        

        $('.duplicate').click(function(){
            var dupid = $(this).data('dupid');
            $.ajax({
                url:"<?php echo base_url('home/ajax_sidebar') ;?>",
                method:"POST",
                data:{dupid:dupid},
                success:function(data){
                    //console.log(data);
                    var setdata = JSON.parse(data);
                    //console.log(setdata);
                    $('#activate_menu').val(setdata.activate_menu);
                    $('#activate_not').val(setdata.activate_not);
                    $('#base_url').val(setdata.base_url);
                    $('#icon').val(setdata.icon);
                    $('#parent_id').val(setdata.parent).trigger('change');
                    $('#position').val(setdata.position);
                    var role_text = setdata.role_id;                    
                    $('#roles').val(role_text);
                    $('#status').val(setdata.status);
                }
            });
        });
        
		var table=$('.data-table').DataTable({
			scrollCollapse: true,
			autoWidth: false,
			responsive: true,
			columnDefs: [{
				targets: "no-sort",
				orderable: false,
			}],
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		});		
        
		$('body').on('change','#parent_id',function(){
			var parent_id=$(this).val();
			var option="<select name='position' id='position' class='form-control' required>";
			option+="<option value=''>Select </option>";
			option+="<option value='0'>Top</option>";
			$.ajax({
				type:"POST",
				url:"<?php echo base_url("home/getOrderList"); ?>",
				data:{parent_id:parent_id},
				dataType:"json",
				beforeSend: function(){
					//$(".box-overlay").show();
				},
				success: function(data){
					$(data).each(function(i, val) {
						option+="<option value='"+val['position']+"'>After "+val['name']+"</option>";
					});
					option+='</select>';
					$('#position').replaceWith(option);
					$('.box-overlay').hide();
				}
			});
		});
        $('#parent_id').trigger('change');
    });
</script>