<!-- Load JavaScript for this Menu -->
<script type="text/javascript" src="<?php echo js_url();?>/Application/category.js"></script>

<div class="category" id="content-page-category">

	<div class="row">
		<div class="col-xs-6">
			<span class="subtitle-page">Category</span> &nbsp;
			<button class="btn btn-primary btn-xs" onClick="Main.buttonTrigger.actionToggleShortcut()">
				<span class="glyphicon glyphicon-share-alt"></span> &nbsp;|&nbsp; Shortcuts
			</button>
		</div>
		<div align="right" class="col-xs-6">
			<button type="button" class="btn btn-success btn-lg tooltip-info" data-placement="bottom" onClick="category.openFormAdd();" title="Show form input data">
				<span class="glyphicon glyphicon-plus-sign"></span> &nbsp; Add new
			</button>
		</div>
	</div>
	<br/><br/>
	
	
	<!-- Section :: Info Shortcuts -->
	<div class="bs-callout bs-callout-info section-info-shortcuts" style="display:none;">
		<blockquote class="iocome-blockquote">
			<?php echo $page_section_info_shortcuts;?>
		</blockquote>
	</div>
	
	
	<!-- Section : Form Add Data -->
	<div class="section-form-add" style="display:none;">
		<?php echo $page_section_form_add;?>
	</div>
	
	
	<!-- Record data -->
	<fieldset>
		<legend>Record data &nbsp;
			<button class="btn btn-default btn-sm tooltip-info" id="btn-refresh" data-placement="right" onClick="category.reloadListData(this);" title="Refresh">
				<img src="<?php echo images_url();?>/ajax-load-4-1.png" />
			</button>
		</legend>
	</fieldset>
	
	
	<!-- Section : List Data -->
	<div class="section-list-data" id="no-more-tables">
		<?php echo $page_section_list_data;?>
	</div>
	
	
	<!-- Section : Form Edit Data -->
	<!-- Form to edit data from section list data (at above) -->
	<div class="frm-edit-data" style="display:none;">
		<?php echo $page_section_form_edit;?>
	</div>

	
</div>