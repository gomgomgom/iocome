jQuery.fn.chainselect = function(target, url, settings)
{
	settings = jQuery.extend({
			usePost : true,
			defaultValue : null,
			parameters : {'_lang' : ''}
		   } , settings);
	
	settings.parameters._id =  $(this).val();
	
	ajaxCallback = function(data, textStatus) {
		$(target).html(""); //clear old options
		
		i = 0;
		$(target).get(0).add(new Option('(please choose one)',''), document.all ? i : null);
		$("row", data).each(function() {
			i += 1;
			$(target).get(0).add(new Option($('value', this).text(),$('id', this).text()), document.all ? i : null);
		});

		if (settings.defaultValue != null)
			$(target).val(settings.defaultValue); //select default value
		else
			$("option:first", target).attr( "selected", "selected" ); //select first option

		$(target).change(); //call next chain
	};
			
	if (settings.usePost == true) {
		$.post( url, settings.parameters, ajaxCallback );
	} else {
		$.get( url, settings.parameters, ajaxCallback );
	}
};