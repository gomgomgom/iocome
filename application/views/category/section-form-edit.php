<!--Data ID -->
<input type="hidden" class="form-control" id="txt_category_id_edit" />

<!-- Choose parent category -->
<!-- If not choose then this category not a child category -->
Parent Category <select class="form-control" id="cbo_parent_edit">
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

Name <input type="text" class="form-control" id="txt_name_edit" placeholder="input category name" />
Description <textarea class="form-control" id="txt_description_edit" placeholder="input a descriptions of category (optional)" rows="3"></textarea>

<br/>

<button class="btn btn-success" onClick="category.actionUpdate(this);"><span class="glyphicon glyphicon-upload"></span> &nbsp; Update &nbsp;</button>
&nbsp;&nbsp;<button class="btn btn-default" onClick="category.closeFormEdit();"><span class="glyphicon glyphicon-remove"></span> &nbsp; Cancel &nbsp;</button>
&nbsp;&nbsp;<span hidden id="info-btn-save"><img src="<?php echo images_url();?>/ajax-load-4-1.gif"></span>