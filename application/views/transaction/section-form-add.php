<fieldset>
	<legend>Date Transaction</legend>

	<input type="date" class="form-control" id="txt_date" placeholder="choose date" />
	<br/>
	<textarea type="text" class="form-control" id="txt_data_description" placeholder="input description (optional)" rows="3"></textarea>

	<br/><br/>

	<legend>Detail</legend>
	
	<select class="form-control" id="cbo_type">
		<option> --- Choose type --- </option>
		<option value="1">Income</option>
		<option value="2">Outcome</option>
	</select>
	
	<br/>
	
	<select class="form-control" id="cbo_category">
		<option> --- Choose category --- </option>
		<?php
		if(isset($list_categories)){
			for($i=0; $i<sizeof($list_categories); $i++){
		?>
		<option value="<?=$list_categories[$i]->id;?>"><?=$list_categories[$i]->name;?></option>
		<?php
			}
		}
		?>
	</select>
	
	<br/>
	
	<div class="input-group">
		<span class="input-group-addon">Rp.</span>
		<input type="number" class="form-control" id="txt_nominal" name="txt_nominal" placeholder="input nominal" value="<?php echo set_value('txt_nominal');?>" />
	</div>
	
	<br/>
	
	<textarea class="form-control transaction" rows="3" id="txt_description" placeholder="input description (optional)" name="txt_description"></textarea>
	
	<br/>
	
	<button type="button" class="btn btn-primary btn-sm tooltip-info" data-placement="right" onClick="transaction.addDetailTransaction()" title="Add to Record data temporary">
		<span class="glyphicon glyphicon-plus"></span> &nbsp; Add
	</button>
	
</fieldset>

<br/><br/><br/>


<fieldset>
<legend>Record data temporary &nbsp;
	<span class="label label-default tooltip-info" data-placement="top" id="label-count-record" title="Count of records in the table below">
		<span id="count-record">0</span> record
	</span>&nbsp;&nbsp;
	<button class="btn btn-danger tooltip-info" data-placement="top" title="Clear data temporary" onClick="transaction.clearAllRecord('#tbl-transaction-detail')"><span class="glyphicon glyphicon-trash"></span> &nbsp; Clear &nbsp;</button>
</legend>
</fieldset>

<div id="no-more-tables">
<table class="table table-bordered table-striped" id="tbl-transaction-detail">
	<thead>
	<tr align="center">
		<td width="30"><h5>No</h5></td>
		<td width="10"><h5>Type</h5></td>
		<td width="140"><h5>Category</h5></td>
		<td width="100"><h5>Nominal</h5></td>
		<td><h5>Description</h5></td>
		<td><h5>Action</h5></td>
	</tr>
	</thead>
	<tbody>
		<input type="hidden" id="txt_no_urut_detail" value="0" />
		<tr id="no-data">
			<td align="center" colspan="6"><i>---&nbsp; no data &nbsp;---</i></td>
		</tr>
	</tbody>
</table>
</div>


<br/>
<hr/>

<button class="btn btn-primary" id="btn-save" onClick="transaction.actionSave();"><span class="glyphicon glyphicon-ok"></span> &nbsp; Save &nbsp;</button>
&nbsp;&nbsp;<button class="btn btn-default" onClick="transaction.actionCancelSave();"><span class="glyphicon glyphicon-remove"></span> &nbsp; Cancel &nbsp;</button>
&nbsp;&nbsp;<span hidden id="info-btn-save"><img src="<?php echo $this->config->item('images_url');?>/ajax-load-4-1.gif"></span>

<br/><br/><br/>