<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title.' | '.PROJECT_NAME; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo file_url("includes/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo file_url("includes/dist/css/adminlte.min.css"); ?>">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?php echo file_url("includes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"); ?>">
        <?php
			if(!empty($styles)){
				foreach($styles as $key=>$style){
					if($key=="link"){
						if(is_array($style)){
							foreach($style as $single_style){
								echo "<link rel='stylesheet' href='$single_style'>\n\t";
							}
						}
						else{
							echo "<link rel='stylesheet' href='$style'>\n\t";
						}
					}
					elseif($key=="file"){
						if(is_array($style)){
							foreach($style as $single_style){
								echo "<link rel='stylesheet' href='".file_url("$single_style")."'>\n\t";
							}
						}
						else{
							echo "<link rel='stylesheet' href='".file_url("$style")."'>\n\t";
						}
					}
				}
			}
		?>   
        <!-- Custom style -->
        <link rel="stylesheet" href="<?php echo file_url('includes/custom/custom.css'); ?>">     
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <script src="https://kit.fontawesome.com/512e5abe13.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<?php
            if(!empty($top_script)){
                foreach($top_script as $key=>$script){
                    if($key=="link"){
                        if(is_array($script)){
                            foreach($script as $single_script){
                                echo "<script src='$single_script'></script>\n\t";
                            }
                        }
                        else{
                            echo "<script src='$script'></script>\n\t";
                        }
                    }
                    elseif($key=="file"){
                        if(is_array($script)){
                            foreach($script as $single_script){
                                echo "<script src='".file_url("$single_script")."'></script>\n\t";
                            }
                        }
                        else{
                            echo "<script src='".file_url("$script")."'></script>\n\t";
                        }
                    }
                }
            }
        ?>
    </head>
    <body class="hold-transition <?php if(!empty($body_class)){echo "$body_class ";}else{ echo "sidebar-mini layout-fixed text-sm "; } echo ACCENT_COLOR; ?> ">
    	<?php if(empty($body_class)){?>
        <div class="wrapper">
        <?php } ?>
