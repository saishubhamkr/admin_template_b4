
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?php echo $title; ?></h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-form-label">Select Table</label>
											<?php 
												echo form_dropdown('table', $tables,'',array('id'=>'table', 'class'=>'form-control'));
											?>
										</div>
									</div>
									<div class="col-md-4"><br><br>
										<button type="button" class="btn btn-info btn-sm" onClick="$('#table').trigger('change');$(this).next().toggleClass('btn-primary btn-danger');">Refresh</button>
										<button type="button" class="btn btn-primary btn-sm" onClick="$('#bootstrap-data-table-export tfoot').toggleClass('hidden');$(this).toggleClass('btn-primary btn-danger');$('.search-col').val('').trigger('keyup');">
											Toggle Search
										</button>
									</div>
								</div><br>
				
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive" id="datatable">
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
<input type="hidden" name="table" id="uptable">
<input type="hidden" name="id" id="id">
<input type="hidden" id="temp_val">
<input type="submit" value="save" class="hidden">
        <script>
        	
			$(document).ready(function(e) {
                createTable();
				$('#table').change(function(){
					var table=$(this).val();
					$.ajax({
						type:"POST",
						url:"<?php echo site_url("home/gettable/"); ?>",
						data:{table:table},
						success: function(data){
							$('#datatable').html(data);
							createTable();
						}
					});
				});
				$('body').on('dblclick','.editable',function(e){
					if(e.target.id=="column"){ return false; }
					//var prevVal=$('#column').val();
					//$('#column').closest('td').text(prevVal);
					var id=$(this).parent().children(":eq(0)").html();
					var column=$(this).attr('data-column');
					var value=$(this).text();
					var table=$('#table').val();
					$('#uptable').val(table);
					$('#id').val(id);
					$(this).html('<input type="text" id="column" value="">');
					$('#column').attr("name",column);
					$('#column').val(value).focus();
					$('#temp_val').val(value);
				});
				$('body').on('keyup',function(e){
					if(e.which==13){
						if($('#column').length==1){
							var table=$('#uptable').val();
							var id=$('#id').val();
							var column=$('#column').attr("name");
							var value=$('#column').val();
							var data = {};
							data['table']=table;
							data['id']=id;
							data[column] = value;
							$.ajax({
								type:"POST",
								url:"<?php echo base_url('home/updatedata'); ?>",
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
				$('#bootstrap-data-table-export tfoot th').each( function () {
					var title = $(this).text();
					$(this).html( '<input type="text" class="search-col" placeholder="Search '+title+'" />' );
				} );
				var table = $('#bootstrap-data-table-export').DataTable();
				table.columns().every( function () {
					var that = this;
			 
					$( 'input', this.footer() ).on( 'keyup change clear', function () {
						if ( that.search() !== this.value ) {
							that
								.search( this.value )
								.draw();
						}
					} );
				} );
			}
        </script>