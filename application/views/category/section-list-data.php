<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<td width="50px"><h4>No</h4></td>
			<td><h4>Category</h4></td>
			<td><h4>Description</h4></td>
			<td align="center" width="130px"><h4>Created Time</h4></td>
			<td align="center" width="130px"><h4>Modified Time</h4></td>
			<td align="center" width="80px"><h4>Action</h4></td>
		</tr>
	</thead>
	<tbody>
		<?php
		if(isset($list_data)) {
			if(count($list_data) > 0) {
				for($i=0; $i<sizeof($list_data); $i++){
				?>
				<tr class="record-data" id="category_<?=$list_data[$i]->id;?>">
					<td data-title="No"><?=$i+1;?>
						<input type="hidden" class="txt_data_id_of_list" value="<?=$list_data[$i]->id;?>" />
						<input type="hidden" class="txt_parent_id_of_list" value="<?=$list_data[$i]->parent_id;?>" />
						<input type="hidden" class="txt_name_of_list" value="<?=$list_data[$i]->name;?>" />
						<input type="hidden" class="txt_description_of_list" value="<?=($list_data[$i]->description ? $list_data[$i]->description : "&nbsp;");?>" />
					</td>
					<td class="column_name" data-title="Category"><?=$list_data[$i]->name;?></td>
					<td class="column_description" data-title="Description"><?=($list_data[$i]->description ? $list_data[$i]->description : "&nbsp;");?></td>
					<td align="center" class="column_created_time" data-title="Created Time">
						<span class="tooltip-info" data-placement="top" title="<?=date('d-M-Y H:i:s', strtotime($list_data[$i]->created_on));?>">
							<?=date('d-M-Y', strtotime($list_data[$i]->created_on));?>
						</span>
					</td>
					<td align="center" class="column_modified_time" data-title="Modified Time">
						<span class="tooltip-info" data-placement="top" title="<?=date('d-M-Y H:i:s', strtotime($list_data[$i]->last_modified_on));?>">
							<?=date('d-M-Y', strtotime($list_data[$i]->last_modified_on));?>
						</span>
					</td>
					<td align="center" data-title="Action">
						<span class="btn-edit glyphicon glyphicon-pencil tooltip-info" data-placement="left" onClick="category.openFormEdit(this)" title="edit"></span>
						&nbsp;&nbsp;&nbsp;
						<span class="btn-remove glyphicon glyphicon-remove-circle tooltip-info" data-placement="right" onClick="category.processDelete(this)" title="delete"></span>
					</td>
				</tr>
				<?php
				}
			} else {
			?>
			<tr>
				<td align="center" class="danger" colspan="6"><p class="text-info">No found data</p></td>
			</tr>
			<?php
			}
		} else {
		?>
		<tr>
			<td align="center" class="danger" colspan="6"><p class="text-info">No found data</p></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>