$(document).ready(function(){

	// Set textbox to receive numeric only
	$("#txt_nominal").numeric();
});

var transaction = {

	/**
	 * Action Save
	 *
	 * Menyiapkan data agar bisa di insert ke database
	 */
	actionSave: function()
	{
		var date_transaction = $('#txt_date').val();
		var description_transaction = $('#txt_data_description').val();
		
		var list_type = $('.type-record-detail');
		var list_category = $('.category-record-detail');
		var list_nominal = $('.nominal-record-detail');
		var list_description = $('.description-record-detail');
		
		var array_type = new Array();
		var array_category = new Array(); // category_id
		var array_nominal = new Array();
		var array_description = new Array();
		
		// console.log(date_transaction);
		// console.log(list_type);
		// console.log(list_category);
		// console.log(list_nominal);
		// console.log(list_description);
		// return false;
		
		// Loop untuk memindahkan data list name ke dalam array
		for(var i=0; i<list_type.length; i++) {
			// console.log(array_category[i].value);
			// console.log(array_nominal[i].value);
		
			array_type.push(list_type[i].value);
			array_category.push(list_category[i].value);
			array_nominal.push(list_nominal[i].value);
			array_description.push(list_description[i].value);
		}
		
		// console.log(array_category);
		// console.log(array_nominal);
		
		// Save to database
		this.processSave(array_type, array_category, array_nominal, array_description, date_transaction, description_transaction);
	},

	/**
	 * Add detail transaction
	 *
	 * For adding detail transaction in one day to table temporary
	 *
	 * @param	-
	 * @result	html	langsung menambahkan baris di table (dibagian body)
	 */
	addDetailTransaction: function()
	{
		var no_urut_detail = parseInt($("#txt_no_urut_detail").val()) + 1;
		var type_id = $("#cbo_type").val();
		var type_name = $("#cbo_type").find(":selected").text();
		var category_id = $("#cbo_category").val();
		var category_name = $("#cbo_category").find(":selected").text();
		var nominal = $("#txt_nominal").val() != '' ? $("#txt_nominal").val() : 0;
		var description = $(".transaction#txt_description").val();
		
		$("#txt_no_urut_detail").val(no_urut_detail);
		$("#no-data").hide();
		
		$("#tbl-transaction-detail").append(
			'<tr>' +
				'<td data-title="No">' + no_urut_detail + '</td>' +
				'<td data-title="Type"><input type="text" class="type-record-detail transaction" name="txt_detail_type_id[]" value="' + type_id + '" />' + type_name + '</td>' +
				'<td data-title="Category"><input type="text" class="category-record-detail transaction" name="txt_detail_category_id[]" value="' + category_id + '" />' + category_name + '</td>' +
				'<td data-title="Nominal"><input type="text" class="nominal-record-detail transaction" name="txt_detail_nominal[]" value="' + nominal + '" />' + nominal + '</td>' +
				'<td data-title="Description"><input type="text" class="description-record-detail transaction" name="txt_detail_description[]" value="' + description + '" />' + description + '</td>' +
				'<td align="center" class="delete_detail" data-title="Action" no_urut="' + no_urut_detail + '">XXX</td>' +
			'</tr>'
		);
		
		
		// plus one count record
		this.countRecord("plus");
	},
	
	/**
	 * Clear all record
	 *
	 * For clear all record in table temporary
	 *
	 * @param	string		table_name, table yang akan dihapus baris-barisnya (tapi bukan header-nya)
	 * @result	-			NB : karena hanya menghapus (bukan menambah sesuatu)
	 */
	clearAllRecord: function(table_name)
	{
		$(table_name + ' > tbody').html('<input type="hidden" id="txt_no_urut_detail" value="0" />' +
					'<tr id="no-data">' +
						'<td align="center" colspan="6"><i>---&nbsp; no data &nbsp;---</i></td>' +
					'</tr>');
					
		// minus to zero count record
		this.countRecord("null");
	},

	/**
	 * Operation calculate for Count Record
	 *
	 * @param	int		operation, value = {plus, minus}, for calculate record in table
	 * @result	html	change numeric on label count record
	 */
	countRecord: function(operation)
	{
		// Plus one (+1) count record
		var count_record = parseInt($('#count-record').text());
		// console.log(count_record);
		
		if(operation == "plus") {
			$('#count-record').text(count_record + 1);
		} else if (operation == "minus") {
			$('#count-record').text(count_record - 1);
		} else if (operation == "null") {
			$('#count-record').text(0);
		}
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
	 * Save Transaction
	 *
	 * Save new transaction data
	 *
	 * @param		array_type			Type list from income outcome data for save to database
	 * @param		array_category		Category list from income outcome data for save to database
	 * @param		array_nominal		Nominal list from income outcome data for save to database
	 * @param		array_description	Description list from income outcome data for save to database
	 * @param		date_transaction	Date transaction from income outcome data that will saved to database
	 */
	processSave: function(array_type, array_category, array_nominal, array_description, date_transaction, description_transaction)
	{
		$.ajax({
			dataType: "html",
			url: SITE_URL + "/transaction/save",
			type: "post",
			data: ({
				array_type: array_type,
				array_category: array_category,
				array_nominal: array_nominal,
				array_description: array_description,
				date_transaction: date_transaction,
				description_transaction: description_transaction
			}),
			beforeSend: function() {
				MY_loading.save_loading_waiting("btn-save");
			},
			success: function(data) {
				// $('#txt_name_category').val('');
				// location.reload();
			},
			complete: function() {
				MY_loading.save_loading_success("btn-save");
			},
			error: function(e){
				alert("Save Failed. There is an error when save transaction");
				console.log(e);
			}
		});
	}

	
}