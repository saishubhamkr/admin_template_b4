<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            	<h1 class="m-0 text-dark"><?php echo $title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
				<?php 
                if(!empty($breadcrumb) && is_array($breadcrumb)){ 
                ?>
                <ol class="breadcrumb float-sm-right">
					<?php
                        if(!empty($breadcrumb) && is_array($breadcrumb)){
                            $breadcrumb=$breadcrumb;
                            if(!isset($breadcrumb['active'])){ $breadcrumb['active']=$title; }
                            foreach($breadcrumb as $link=>$crumb){
                                if($link=='active'){
                                    echo '<li class="breadcrumb-item active" aria-current="page">'.$crumb.'</li>';
                                }
                                elseif($link==''){
                                    echo '<li class="breadcrumb-item" >'.$crumb.'</li>';
                                }
                                else{
                                    echo '<li class="breadcrumb-item"><a href="'.base_url($link).'">'.$crumb.'</a></li>';
                                }
                            }	
                        }
                    ?>
                </ol>
                <?php
				}
				?>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?php 
	$popup="hidden";
	$msg=$pstatus=$picon='';
	if($this->session->flashdata('msg')!==NULL){
		$msg=$this->session->flashdata('msg');
		$pstatus="success";
		$picon="check";
		$popup="";
	}
	if($this->session->flashdata('err_msg')!==NULL){
		$msg=$this->session->flashdata('err_msg');
		$pstatus="danger";
		$picon="exclamation";
		$popup="";
	}
?>
<div class="alert alert-<?php echo $pstatus ?> alert-dismissible msg-popup <?php echo $popup ?>">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-<?php echo $picon ?>"></i>
    <?php echo $msg; ?>
</div>
    