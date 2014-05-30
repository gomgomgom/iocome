<table class="table table-bordered maja-table-sorting" id="table-record-data-transaction">
	<thead>
		<tr>
			<td width="50px"><h4>No</h4></td>
			<td><h4>Date</h4></td>
			<td><h4>Summary Transaction</h4></td>
			<td align="center" width="130px"><h4>Created Time</h4></td>
			<td align="center" width="130px"><h4>Modified Time</h4></td>
			<td align="center" width="120px"><h4>Action</h4></td>
		</tr>
	</thead>
	<tbody>
		<?php
		if(isset($list_data)) {
			if(count($list_data) > 0) {
				for($i=0; $i<sizeof($list_data); $i++){
				?>
				<tr class="record-data" onClick="viewRecordDetail(this)" transaction_data_id="<?=$val['id'];?>">
					<td data-title="No"><?=$key+1;?></td>
					<td data-title="Date">
						<span class="tooltip-info" data-placement="top" title="<?=date('d-M-Y H:i:s', strtotime($val['date']));?>">
							<?=date('d-M-Y', strtotime($val['date']));?>
						</span>
					</td>
					<td data-title="Summary Transaction"><?=($val['summary_transaction'] ? $val['summary_transaction'] : "&nbsp;");?></td>
					<td align="center" data-title="Created Time">
						<span class="tooltip-info" data-placement="top" title="<?=date('d-M-Y H:i:s', strtotime($val['created_on']));?>">
							<?=date('d-M-Y', strtotime($val['created_on']));?>
						</span>
					</td>
					<td align="center" data-title="Modified Time">
						<span class="tooltip-info" data-placement="top" title="<?=date('d-M-Y H:i:s', strtotime($val['last_modified_on']));?>">
							<?=date('d-M-Y', strtotime($val['last_modified_on']));?>
						</span>
					</td>
					<td align="center" data-title="Action">
						<span class="transaction glyphicon glyphicon-search tooltip-info" data-placement="left" id="btn-view" title="view" category_id="<?=$val['id'];?>"></span>
						&nbsp;&nbsp;&nbsp;
						<span class="transaction glyphicon glyphicon-pencil tooltip-info" data-placement="top" id="btn-edit" title="edit"></span>
						&nbsp;&nbsp;&nbsp;
						<span class="transaction glyphicon glyphicon-remove-circle tooltip-info" data-placement="right" id="btn-delete" title="delete" category_id="<?=$val['id'];?>"></span>
					</td>
				</tr>
				<tr hidden class="record-detail" status="hidden" transaction_data_id="<?=$val['id'];?>"><!-- id on table "tbl_transaction_data" -->
					<td colspan="6" style="background-color:#EEEEEE;">
						<b>Description : </b><?=($val['description'] ? $val['description'] : "&nbsp;");?>
						<br/><br/>
						<table width="100%">
							<thead style="font-weight:bold;">
							<tr>
								<td>No</td>
								<td>Category Name</td>
								<td>Nominal</td>
								<td>Description</td>
								<td>Created Time</td>
								<td>Modified Time</td>
								<td align="center">Action</td>
							</tr>
							</thead>
							<tbody>
							<?php
							if(count($transaction_detail) > 0){
								$no = 0;
								foreach($transaction_detail as $val_detail){
									if($val_detail['transaction_data_id'] == $val['id']){
									$no++;
							?>
							<tr>
								<td data-title="No"><?=$no;?></td>
								<td data-title="Category Name"><?=$val_detail['category_name'];?></td>
								<td data-title="Nominal"><?=$this->config->item('currency') . number_format($val_detail['nominal'], 0, '', '.');?></td>
								<td data-title="Description"><?=($val_detail['description'] ? $val_detail['description'] : "&nbsp;");?></td>
								<td data-title="Created Time"><?=date('d-M-Y', strtotime($val_detail['created_on']));?></td>
								<td data-title="Modified Time"><?=date('d-M-Y', strtotime($val_detail['last_modified_on']));?></td>
								<td align="center" data-title="Action">
									<span class="btn-edit-detail glyphicon glyphicon-pencil tooltip-info transaction" data-placement="top" title="edit"></span>
									&nbsp;&nbsp;&nbsp;
									<span class="btn-delete-detail glyphicon glyphicon-remove-circle tooltip-info transaction" data-placement="right" title="delete" transaction_detail_id="<?=$val_detail['id'];?>"></span>
								</td>
							</tr>
							<?php
									}
								}
							}
							
							// Show "no found data" for transaction that have not data
							if($no == 0){
							?>
							<tr>
								<td align="center" class="danger" colspan="6"><p class="text-info">No found data</p></td>
							<?php
							}
							?>
							</tbody>
						</table>
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