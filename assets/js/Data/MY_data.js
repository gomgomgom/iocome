function MY_data()
{
	// list of table name at database
	this.table = ["tbl_category", "tbl_transaction_data", "tbl_transaction_detail"];
	
	
	/**
	 * Get Content by URL
	 *
	 * Show content at view page (content section)
	 * 
	 * @param		controller		string		url web service to get view content with these data
	 */
	this.getContentByURL = function(urlController, elementHTML)
	{
		jQuery.ajax({
			url: SITE_URL +'/'+ urlController,
			dataType: "html",
			type: "post",
			data: ({
				isPageFromAjax: true
			}),
			beforeSend: function(){
				showLoadingAtContentPage(elementHTML);
			},
			success: function(result){
				jQuery(elementHTML).html(result);
				
				// Show tooltip for replace title at tag HTML
				jQuery(".tooltip-info").tooltip();
			},
			error: function(e){
				alert("There is an error when get content page");
				console.log(e);
			}
			
		});
	};
	
	/**
	 * Save Data
	 *
	 * Saving data to database
	 *
	 * @param		data		array		field & value for save to database
	 */
	this.saveData = function(data, table)
	{
		jQuery.ajax({
			url: SITE_URL + urlController,
			dataType: "html",
			type: "post",
			data: ({
				isPageFromAjax: true
			}),
			success: function(result){
				alert("Save success");
			},
			error: function(e){
				alert("Save Failed. There is an error when saving data");
				console.log(e);
			}
			
		});
	};
	
}