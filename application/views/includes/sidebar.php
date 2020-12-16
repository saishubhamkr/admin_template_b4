<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-no-expand <?php echo SIDEBAR_COLOR; ?>">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link <?php echo BRAND_COLOR; ?>">
        <img src="<?php echo file_url("assets/images/icon.png"); ?>" alt="Foodoo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo PROJECT_NAME; ?></span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            	<img src="<?php echo file_url("includes/dist/img/user2-160x160.jpg"); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            	<a href="#" class="d-block">Admin</a>
            </div>
        </div>
        
        <!-- Sidebar Menu -->
        <?php /*?><nav class="mt-2 hidden">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>" class="nav-link <?php echo activate_menu('dashboard'); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo activate_dropdown('category'); ?>">
                    <a href="#" class="nav-link <?php echo activate_dropdown('category','a'); ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Category <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url("category/"); ?>" class="nav-link <?php echo activate_menu('category'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav><?php */?>
        <!-- /.sidebar-menu -->
        <!-- Sidebar Menu -->
         <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">                
            <?php 
            if(!empty($sidebarmenu)){
                foreach($sidebarmenu as $sidebarlist){
                //echo $sidebarlist['id'];
                if(empty($sidebarlist['submenu'])){?>
            <li class="nav-item">
                <a class="<?php echo activate_menu($sidebarlist['activate_menu']); ?> nav-link" href="<?php echo base_url($sidebarlist['base_url']); ?>">
                    <?php echo $sidebarlist['icon'];?>
                    <p><?php echo $sidebarlist['name'];?></p>
                </a>
            </li>
            <?php }else{ $not = json_decode($sidebarlist['activate_not'],true);?>
            <li class="nav-item has-treeview <?php echo activate_dropdown($sidebarlist['activate_menu'],'li',$not); ?>">
                <a class="nav-link <?php echo activate_dropdown($sidebarlist['activate_menu'],'a',$not); ?>" href="#" data-toggle="treeview">
                    <?php echo $sidebarlist['icon'];?>
                    <p><?php echo $sidebarlist['name'];?> <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
            <?php foreach($sidebarlist['submenu'] as $submenu){?>    
                
                    <li class='nav-item'>
                        <a class="nav-link <?php echo activate_menu($submenu['activate_menu']); ?>" href="<?php echo base_url($submenu['base_url']); ?>">
            <?php if(!empty($submenu['icon'])){ echo "$submenu[icon]"; }else{?><i class="nav-icon fa fa-plus"></i><?php } ?> 
                            <p><?php echo $submenu['name'];?></p>
                        </a>
                    </li>
                
            <?php } ?>       
                </ul>
            </li>
            <?php       }
                }
            }else{

            }
            ?>
            </ul>
        </nav> 
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="content-wrapper">
    <?php /*?><div class="overlay" id="loading">
        <i class="fa fa-3x fa-refresh fa-spin"></i>
    </div><?php */?>
	<?php
    	$this->load->view('includes/breadcrumb');
	?>
    <!-- Main content -->
    