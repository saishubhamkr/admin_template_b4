                
        	</div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; <?php echo SESSION_YEAR; ?> <a href="http://adminlte.io" class="hidden">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    
                </div>
            </footer>
            
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo file_url("includes/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo file_url("includes/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
        <!-- overlayScrollbars -->
        <script src="<?php echo file_url("includes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo file_url("includes/dist/js/adminlte.js"); ?>"></script>
        
        <?php
		if(!empty($bottom_script)){
		  foreach($bottom_script as $key=>$script){
			  if($key=="link"){
					if(is_array($script)){
						foreach($script as $single_script){
							echo "<script src='$single_script'></script>\n\t\t";
						}
					}
					else{
						echo "<script src='$script'></script>\n\t\t";
					}
			  }
			  elseif($key=="file"){
				if(is_array($script)){
					foreach($script as $single_script){
						echo "<script src='".file_url("$single_script")."'></script>\n\t\t";
					}
				}
				else{
					echo "<script src='".file_url("$script")."'></script>\n\t\t";
				}
			  }
		  }
		}
		?>
        
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo file_url("includes/dist/js/demo.js"); ?>"></script>
        <script src="<?php echo file_url("includes/custom/custom.js"); ?>"></script>
    </body>
</html>