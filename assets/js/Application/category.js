var category = {

	actionCancelSave: function()
	{
		// Hide form add new
		Main.buttonTrigger.actionDisplayFormAdd();
		
		// Reset field
		// Check whether form input category for filling name & description have more than one
		var numberOfFormInput = jQuery(".input-child-category").length;
		if(numberOfFormInput > 1){
			// Looping form input category to remove all except one for next input data
			for(var i=1; i<numberOfFormInput; i++){
				// Start with index 1 for leaving one input data
				jQuery(".input-child-category")[i].remove();
			}
		}
		
		// Back to default for next input data
		jQuery("#cbo_parent").val(0);
		jQuery(".txt_name").val("");
		jQuery(".txt_description").val("");
		
	},
	
	/**
	 * Action Input Category Add
	 *
	 * Add element HTML for input data category
	 *
	 * @param		objectJquery		object jQuery		object / location by html tag (div, table, dll) to place input data
	 */
	actionInputCategory_Add: function(objectJquery)
	{
		var inputData = 
			'<div class="input-child-category">' +
				'<br/><hr/>' +
				'<div class="input-group">' +
					'<input type="text" class="form-control txt_name" id="txt_name" name="txt_name[]" placeholder="input category name" />' +
					'<span class="input-group-btn">' +
						'<button class="btn btn-default tooltip-info" data-placement="top" onClick="category.actionInputCategory_Add($(\'#tbl-input-category\'))" title="Add new category" type="button">' +
							'<span class="glyphicon glyphicon-plus-sign"></span>' +
						'</button>' +
						'<button class="btn btn-default tooltip-info" data-placement="top" onClick="category.actionInputCategory_Remove(this)" title="Remove category" type="button">' +
							'<span class="glyphicon glyphicon-minus-sign"></span>' +
						'</button>' +
					'</span>' +
				'</div>' +
				'<br/>' +
				'<textarea class="form-control txt_description" id="txt_description" name="txt_description[]" placeholder="input a descriptions of category (optional)" rows="3"></textarea>' +
			'</div>';
			
		objectJquery.append(inputData);
		
		// Show tooltip for replace title at tag HTML
		jQuery(".tooltip-info").tooltip();
	},
	
	/**
	 * Input Category Action Remove
	 *
	 * Remove field for input category
	 *
	 * @param		elementHTML		Location of tag html (div, table, dll) for input data
	 */
	actionInputCategory_Remove: function(elementHTML)
	{
		if($('.input-child-category').length == 1){
			alert("You cannot remove input data if there is only one");
		} else {
			$(elementHTML).parent().parent().parent().remove();
		}
	},

	/**
	 * Action Save
	 *
	 * Saving data
	 */
	actionSave: function()
	{
		// Set variable
		var listObjectName = $(".txt_name").serializeArray();
		var listObjectDescription = $(".txt_description").serializeArray();
		
		// Validation data
		for(var i=0; i < listObjectName.length; i++){
			if(listObjectName[i].value == ''){
				alert("Category name must be filled");
				return false;
			}
		}
		
		// Set data content
		var content = {
			ParentID: $("#cbo_parent").val(),
			ListData: new Array()
		};
		
		// Loop object name
		// To get object name & object description
		for(var i=0; i<listObjectName.length; i++){
			// Push list category to main content
			content.ListData.push(
				{
					Name: listObjectName[i].value,
					Description: listObjectDescription[i].value
				}
			);
		}
		
		// Send the data to be stored
		jQuery.ajax({
			url: SITE_URL + "/API/Category/AddCategory",
			type: "post",
			dataType: "json",
			data: JSON.stringify(content),
			beforeSend: function() {
				MY_loading.save_loading_waiting("btn-save");
			},
			success: function(result){
				category.reloadListData(); // Reload table list data
			},
			complete: function() {
				MY_loading.save_loading_success("btn-save");
			},
			error: function(e){
				alert("Save Failed. There is an error when save category");
				console.log(e);
			}
		});
	},
	
	/**
	 * Action Update
	 *
	 * Update data
	 */
	actionUpdate: function(elementHTML)
	{
		// Set variable
		var parent_category_id = jQuery("#cbo_parent_edit").val();
		var category_id = jQuery("#txt_category_id_edit").val();
		var name = jQuery("#txt_name_edit").val();
		var description = jQuery("#txt_description_edit").val();
		
		// Validation data
		if(name == ''){
			alert("Category name must be filled");
			return false;
		}
		if(category_id < 1){
			alert("Your data corrupted, please refresh your browser & try again");
			return false;
		}
		
		
		// Send data to update
		jQuery.ajax({
			url: SITE_URL + "/category/update",
			type: "post",
			dataType: "html",
			data: {
				parent_category_id: parent_category_id,
				category_id: category_id,
				name: name,
				description: description
			},
			success: function(result){
				result = JSON.parse(result);
				if(result['status'] == true){
					
					// Reload row after update
					category.reloadRowDataAfterUpdate(elementHTML);
					
					// Put fresh data to view
					// At least 1 second after show loading
					setTimeout(function(){
						jQuery("#category_"+ category_id).find(".txt_parent_id").val(parent_category_id);
						jQuery("#category_"+ category_id).find(".txt_name").val(name);
						jQuery("#category_"+ category_id).find(".txt_description").val(description);
						jQuery("#category_"+ category_id).find(".column_name").text(name);
						jQuery("#category_"+ category_id).find(".column_description").text(description);
						jQuery("#category_"+ category_id).find(".column_modified_time").html(
							'<span class="tooltip-info" data-placement="top" title="'+ result['last_modified_on'] +'">' +
								result['last_modified_on'].split(" ")[0] +
							'</span>');
					
						// Show tooltip for replace title at tag HTML
						jQuery(".tooltip-info").tooltip();
					}, 1000);
					
				} else {
					alert("Update failed");
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				
				alert("Delete failed, there is an error at AJAX");
			}
		});
	},
	
	/**
	 * Close Form Edit
	 *
	 * Remove form edit data
	 * Not Hide because will be conflict for next editing data
	 */
	closeFormEdit: function()
	{
		jQuery(".row-edit-data").remove();
		jQuery(".btn-edit").removeClass("active"); // remove color icon (back to default)
	},
	
	openFormAdd: function()
	{
		// Refresh field parent category
		// To get new data
		// -- code --
		
		// Open form
		Main.buttonTrigger.actionDisplayFormAdd();
	},
	
	/**
	 * Open Form Edit
	 *
	 * Display form to edit data category
	 *
	 * @param		elementHTML		Location of tag html (div, table, dll) when call this function
	 */
	openFormEdit: function(elementHTML)
	{
		// Remove form edit data (for other data edit)
		// In order to ONLY ONE DATA to edited at a time
		// Not Hide because will be conflict for next editing data
		this.closeFormEdit(); // call other function
		
		// Change color icon to show this row was edited
		jQuery(".btn-edit").removeClass("active");
		$(elementHTML).addClass("active");
		
		// Set variable
		var id = jQuery(elementHTML).parent().parent().find('.txt_data_id_of_list').val();
		var parent_id = jQuery(elementHTML).parent().parent().find('.txt_parent_id_of_list').val();
		var name = jQuery(elementHTML).parent().parent().find('.txt_name_of_list').val();
		var description = jQuery(elementHTML).parent().parent().find('.txt_description_of_list').val();
		
		// Put form edit data to table (side by side with row from this data)
		// We must put style="padding-left:2%;" because use of plugin no-more-tables
		// Form edit become more smaller than normal, so with set to 2% form edit become normal now
		jQuery(elementHTML).parent().parent().after(
			'<tr class="row-edit-data"><td style="padding-left:2%;" colspan="6">' +
			jQuery(".frm-edit-data").html() +
			'</td></tr>'
		);
		
		// Insert data to field input
		jQuery('#txt_category_id_edit').val(id);
		jQuery('#cbo_parent_edit').val(parent_id);
		jQuery('#txt_name_edit').val(name);
		jQuery('#txt_description_edit').val(description);
	},

	/**
	 * Populate Data
	 *
	 * Populate data category and put in to array
	 */
	populateData: function()
	{
		var listCategory = new Array();
		var dataCategory = new Array();
		
		// Check the availability of data
		if($(".txt_name").length > 0){
			// Loop for get each data
			for(var i=0; i<$(".txt_name").length; i++){
				// Insert data name & description to array
				dataCategory["name"] = $(".txt_name")[i].value;
				dataCategory["description"] = $(".txt_description")[i].value;
				
				// Insert all data to list
				listCategory.push(dataCategory);
				dataCategory = new Array(); // set to default for get value on next loop
			}
			
		}
		
		return listCategory;
		
	},
	
	processDelete: function(elementHTML)
	{
		// Set variable
		var category_id = $(elementHTML).parent().parent().find(".txt_data_id_of_list").val();
		
		// Send data to process delete
		jQuery.ajax({
			url: SITE_URL + "/category/delete",
			type: "post",
			data: {
				category_id: category_id
			},
			success: function(result){
				if(result == 1){
					// Remove row that was category has been deleted
					jQuery(elementHTML).parent().parent().hide("slow");
				} else {
					alert("Delete failed");
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				
				alert("Delete failed, there is an error at AJAX");
			}
		});
	},
	
	/**
	 * Reload List Data
	 *
	 * Reloading again list data to get new list data from database
	 *
	 * @param		elementHTML		this		location element which call this function
	 */
	reloadListData: function()
	{
		// Show loading
		jQuery("#btn-refresh").html('<img src="'+ IMAGES_URL +'/ajax-load-4-1.gif" />');
		jQuery(".section-list-data").html('<center><img src="'+ IMAGES_URL +'/ajax-loader-big.gif" /></center>');
		
		jQuery.get(SITE_URL + "/category/view_list_data",function(data,status){
			console.log(status);
			
			// Add view list data to HTML
			jQuery("#btn-refresh").html('<img src="'+ IMAGES_URL +'/ajax-load-4-1.png" />');
			jQuery(".section-list-data").html(data);
			
			// Show tooltip for replace title at tag HTML
			jQuery(".tooltip-info").tooltip();
		});
		
	},
	
	/**
	 * Reload Row Data After Update
	 *
	 * Reloading again row data to get new list data
	 * But ONLY field "modified time" that from database
	 * For others field that derived from form edit
	 *
	 * @param		elementHTML		this		location element to reload row of data
	 */
	reloadRowDataAfterUpdate: function(elementHTML)
	{
		// Get location row
		var elementRowOfData = jQuery(elementHTML).parent().parent().prev();
		var rowOfName = elementRowOfData.find(".column_name");
		var rowOfDescription = elementRowOfData.find(".column_description");
		var rowOfModifiedTime = elementRowOfData.find(".column_modified_time");
		
		// Set Image Loading
		var imageLoading = '<center><img src="'+ IMAGES_URL +'/ajax-load-4-1.gif" /></center>';
		
		// Show loading
		rowOfName.html(imageLoading);
		rowOfDescription.html(imageLoading);
		rowOfModifiedTime.html(imageLoading);
		
		// Show data
		// Minimum after 1 second
		// setTimeout(function(){
			// elementRowOfData.html('
		// },
		// 1000);
		
	},
	
	/**
	 * Reload Parent Category
	 *
	 * Reload value from dropdown parent category at Form Add
	 */
	reloadParentCategory: function()
	{
		// Get new data
		// -- code --
		
		// Remove old value at dropdown
		// -- code --
		
		// Add new value to dropdown
		// -- code --
	},
	
	/**
	 * Show Loading After Update
	 *
	 * To indicate to the user that the process is running
	 *
	 * @param		elementHTML		this		location element to reload row of data
	 */
	showLoadingAfterUpdate: function(elementHTML)
	{
		// Get location row
		var elementRowOfData = jQuery(elementHTML).parent().parent().prev();
		var rowOfName = elementRowOfData.find(".column_name");
		var rowOfDescription = elementRowOfData.find(".column_description");
		var rowOfModifiedTime = elementRowOfData.find(".column_modified_time");
		
		// Set Image Loading
		var imageLoading = '<center><img src="'+ IMAGES_URL +'/ajax-load-4-1.gif" /></center>';
		
		// Show loading
		rowOfName.html(imageLoading);
		rowOfDescription.html(imageLoading);
		rowOfModifiedTime.html(imageLoading);
	}
	
}