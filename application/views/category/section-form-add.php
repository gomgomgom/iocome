<fieldset>
	<legend>Input data</legend>

	<div id="tbl-input-category">
		<!-- Choose parent category -->
		<!-- If not choose then this category not a child category -->
		<select class="form-control" id="cbo_parent" name="cbo_parent">
			<option value=0>--- choose parent category (optional) ---</option><?php
			if(sizeof($list_nested_category) > 0) {
				foreach($list_nested_category as $key=>$val) {
			?>
			<option value="<?=$val->id;?>"><?=$val->name;?></option>
			<?php
				}
			}
			?>
		</select>
		
		<div class="input-child-category">
			<br/><hr/>
			<div class="input-group">
				<input type="text" class="form-control txt_name" id="txt_name" name="txt_name[]" placeholder="input category name" />
				<span class="input-group-btn">
					<button class="btn btn-default tooltip-info" data-placement="top" onClick="category.actionInputCategory_Add($('#tbl-input-category'))" title="Add new category" type="button">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
					<button class="btn btn-default tooltip-info" data-placement="top" onClick="category.actionInputCategory_Remove(this)" title="Remove category" type="button">
						<span class="glyphicon glyphicon-minus-sign"></span>
					</button>
				</span>
			</div>
			<br/>
			<textarea class="form-control txt_description" id="txt_description" name="txt_description[]" placeholder="input a descriptions of category (optional)" rows="3"></textarea>
		</div>
		
	</div>

	<br/><br/><br/>

	<button class="btn btn-primary" id="btn-save" onClick="category.actionSave();"><span class="glyphicon glyphicon-ok"></span> &nbsp; Save &nbsp;</button>
	&nbsp;&nbsp;<button class="btn btn-default" onClick="category.actionCancelSave();"><span class="glyphicon glyphicon-remove"></span> &nbsp; Cancel &nbsp;</button>
	&nbsp;&nbsp;<span hidden id="info-btn-save"><img src="<?php echo $this->config->item('images_url');?>/ajax-load-4-1.gif"></span>

</fieldset>

<br/><br/><br/>