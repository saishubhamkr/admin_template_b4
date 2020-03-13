
<table class="table data-table" id="bootstrap-data-table-export">
    <thead>
        <tr>
        	<?php
            	if(!empty($columns)){
					foreach($columns as $column){
						echo "<th>$column[Field]</th>";
					}
				}
			?>
        </tr>
    </thead>
    <tbody>
        <?php
        if(is_array($data)){
            foreach($data as $row):
        ?>
        <tr>
        	<?php
            	if(!empty($columns)){
					foreach($columns as $column){
						$field=$column['Field'];
			?>
            <td class="editable " data-column="<?php echo $field ?>"><?php echo $row[$field]; ?></td>
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
    <tfoot class="hidden">
        <tr>
        	<?php
            	if(!empty($columns)){
					foreach($columns as $column){
						echo "<th>$column[Field]</th>";
					}
				}
			?>
        </tr>
    </tfoot>
</table>