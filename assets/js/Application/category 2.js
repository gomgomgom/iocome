$(document).ready(function() {

});

/**
 * Action Cancel Edit Category
 *
 * Membatalkan edit category
 */
function actionCancelEditCategory()
{
	// Revert field input data be null
	$('#txt_category_id').val(0);
	$('#cbo_parent').val(0);
	$('#txt_name').val('');
	$('#txt_description').val('');
	
	// Change button update become save
	$('.category.btn-update').fadeOut(500);
	$('.category.btn-cancel-edit').fadeOut(500);
	setTimeout(function(){$('.category.btn-save').fadeIn(600).removeClass('hide');}, 500);
}

/**
 * Action Edit Category
 *
 * Menampilkan form untuk mengubah data category
 *
 * @param		location_html		Lokasi tag html (div, table, dll) yang akan ditambahkan field untuk input data
 */
function actionEditCategory(location_html)
{
	// Set variable
	var id = $(location_html).attr('category_id');
	var parent_id = $(location_html).attr('parent_category_id');
	var name = $(location_html).parent().parent().find("td:nth-child(2)").text();
	name = name.trim();
	// Menggunakan trim untuk menghilangkan spasi yang dibuat di view (saat value description tidak ada)
	var description = $(location_html).parent().parent().find("td:nth-child(3)").text().trim();
	
	// Check if form input data not shown
	var statusFormInputData = $('.category#input-data').attr('status');
	if(statusFormInputData == "hidden") {
		actionAddNew(); // show input data
	}
	
	// Insert data to field input
	$('#txt_category_id').val(id);
	$('#cbo_parent').val(parent_id);
	$('#txt_name').val(name);
	$('#txt_description').val(description);
	
	// Change button save become update
	$('.category.btn-save').fadeOut(500);
	setTimeout(function(){$('.category.btn-update').fadeIn(600).removeClass('hide');}, 500);
	setTimeout(function(){$('.category.btn-cancel-edit').fadeIn(600).removeClass('hide');}, 500);
}

/**
 * Input Category Action Remove
 *
 * Menghapus field input category
 *
 * @param		location_html		Lokasi tag html (div, table, dll) yang akan ditambahkan field untuk input data
 */
function actionInputCategory_Remove(location_html)
{
	if($('.input-child-category').length == 1){
		alert("You cannot remove input data if there is only one");
	} else {
		$(location_html).parent().parent().parent().remove();
	}
}

/**
 * Action Save Category
 *
 * Menyiapkan data agar bisa di insert ke database
 */
function actionSaveCategory()
{
	var array_name = new Array();
	var array_description = new Array();
	var parent_id = $('#cbo_parent').val();
	var list_name = $('.input-child-category').find('.txt_name');
	var list_description = $('.input-child-category').find('.txt_description');
	
	// Loop untuk memindahkan data list name ke dalam array
	for(var i=0; i<list_name.length; i++) {
		// console.log(list_name[i].value);
		// console.log(list_description[i].value);
		
		if(list_name[i].value == '') {
			alert("Category name must be filled");
			return false;
		}
	
		array_name.push(list_name[i].value);
		array_description.push(list_description[i].value);
	}
	
	// console.log(array_name);
	// console.log(array_description);
	
	// Save to database
	processSaveCategory(array_name, array_description, parent_id);
}

/**
 * Action Update Category
 *
 * Menyiapkan data agar bisa di update ke database
 */
function actionUpdateCategory()
{
	var name = $('.input-child-category').find('.txt_name').val();
	var description = $('.input-child-category').find('.txt_description').val();
	var category_id = $('#txt_category_id').val();
	var parent_id = $('#cbo_parent').val();
	
	// console.log(name);
	// console.log(description);
	// console.log(category_id);
	// console.log(parent_id);
	
	// Update to database
	processUpdateCategory(name, description, category_id, parent_id);
}

/**
 * Process Delete Category
 *
 * Delete category data
 *
 * @param		location_html		Lokasi tag html (div, table, dll) yang akan ditambahkan field untuk input data
 */
function processDeleteCategory(location_html)
{
	console.log($(location_html).parent().parent());
	var category_id = $(location_html).attr('category_id');
	var tr = $(location_html).parent().parent();
	console.log(category_id);
	
	$.ajax({
		dataType: "html",
		url: SITE_URL + "/category/delete",
		type: "post",
		data: ({
			category_id : category_id
		}),
		beforeSend: function() {
		},
		success: function(data) {
			location.reload();
		},
		complete: function() {
		},
		error: function(xhr) {
		}
	});
}

/**
 * Process Save Category
 *
 * Save new category data
 *
 * @param		array_name			array	Name list from category data for save to database
 * @param		array_description	array	Description list from category data for save to database
 * @param		parent_id			int		Parent category from new category data that will saved to database
 */
function processSaveCategory(array_name, array_description, parent_id)
{
	$.ajax({
		dataType: "html",
		url: SITE_URL + "/category/save",
		type: "post",
		data: ({
			array_name: array_name,
			array_description: array_description,
			parent_id: parent_id
		}),
		beforeSend: function() {
			save_loading_waiting("btn-save");
		},
		success: function(data) {
			// $('#txt_name_category').val('');
			location.reload();
		},
		complete: function() {
			save_loading_success("btn-save");
		},
		error: function(xhr) {
		}
	});
}

/**
 * Process Update Category
 *
 * Update data category at database
 *
 * @param		name			string		Name list from category data for save to database
 * @param		description		string		Description list from category data for save to database
 * @param		category_id		int
 * @param		parent_id		int			Parent category from new category data that will saved to database
 */
function processUpdateCategory(name, description, category_id, parent_id)
{
	$.ajax({
		dataType: "html",
		url: SITE_URL + "/category/update",
		type: "post",
		data: ({
			name: name,
			description: description,
			category_id: category_id,
			parent_id: parent_id
		}),
		beforeSend: function() {
			save_loading_waiting("btn-save");
		},
		success: function(data) {
			// $('#txt_name_category').val('');
			location.reload();
		},
		complete: function() {
			save_loading_success("btn-save");
		},
		error: function(xhr) {
		}
	});
}










