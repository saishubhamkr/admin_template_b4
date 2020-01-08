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
	if(empty($ntype)){ $ntype=NTYPE; }
	$notify=$nstatus=$nicon=$ntitle=$msg='';
	$notify_options['default']=array("success"=>"success","err"=>"danger","sicon"=>"fa fa-check","eicon"=>"fa fa-exclamation","stitle"=>"Success","etitle"=>"Error","position"=>"topRight");
	$notify_options['sweetalert']=array("success"=>"success","err"=>"error","sicon"=>"fa fa-check","eicon"=>"fa fa-exclamation","stitle"=>"Success","etitle"=>"Error","position"=>"top");
	$notify_options['toastr']=array("success"=>"success","err"=>"error","sicon"=>"fa fa-check","eicon"=>"fa fa-exclamation","stitle"=>"Success","etitle"=>"Error","position"=>"toast-top-center");
	
	if($this->session->flashdata('msg')!==NULL){
		$msg=$this->session->flashdata('msg');
		$nstatus=$notify_options[$ntype]['success'];
		$nicon=$notify_options[$ntype]['sicon'];
		$ntitle=$notify_options[$ntype]['stitle'];
		$notify='notify';
	}
	if($this->session->flashdata('err_msg')!==NULL){
		$msg=$this->session->flashdata('err_msg');
		$nstatus=$notify_options[$ntype]['err'];
		$nicon=$notify_options[$ntype]['eicon'];
		$ntitle=$notify_options[$ntype]['etitle'];
		$notify='notify';
	}
	$nposition=$notify_options[$ntype]['position'];
?>
<div class="hidden <?php echo $ntype.'-'.$notify;; ?>" data-title="<?php echo $ntitle; ?>" 
		data-position="<?php echo $nposition; ?>" data-icon="<?php echo $nicon; ?>" data-status="<?php echo $nstatus; ?>">&nbsp;<?php echo $msg; ?>&nbsp;</div>