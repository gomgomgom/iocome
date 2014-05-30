/**
* jQuery plugin to handle "checkall" checkbox
*
* @author Sugeng Wibowo
* @copyright 2011 StreetDirectory StreetDirectory.com
*/
(function($){
	$.fn.extend({
		checkbox_selector : function(option){
			var option = $.extend({
				handler : null,
				checked	: true
			} , option);
			try{
				if(option.handler==null || typeof option.handler != 'object')
					return this;
				var is_return_now = false;
				option.handler.each(function(){
					if($(this)[0].tagName.toLowerCase()!='input' || $(this).attr('type')!='checkbox')
						is_return_now = true;
				});
				
				if(is_return_now)
					return this;
			}catch(e)
			{
				return this;
			}
			try{
				if(checked===null || checked!==false)
					checked = true;
			}catch(e)
			{
				checked = true;
			}
			
			var global_self = $(this);
			
			option.handler.unbind('change').attr('checked' , option.checked);;
				
			return this.each(function(){
				var self = $(this);
				$(option.handler).change(function(){
					self.attr('checked' , $(this).is(':checked'));
				});
				
				self.attr('checked' , option.checked);
				
				self.change(function(){
					if(global_self.not(':checked').length < 1 )
						$(option.handler).attr('checked' , true);
					else
						$(option.handler).attr('checked' , false);
				});
			});
		}
	});
})(jQuery);