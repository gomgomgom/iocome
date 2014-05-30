/** 
 * jquery curtain plugin
 * @author Sugeng Wibowo
 * @copyright StreetDirectory StreetDirectory.com 2011
 */

(function($){
	$.fn.curtain = function(options)
	{
		if(typeof options !== 'object')
			options = {};
		options = $.extend({
			handler : null, // if set to null then the handler will be the element instead
			animate : true, // default for true is 300
			beforeAnimate : null,
			completeAnimate : null
		}, options);
		
		return this.each(function(){
			var handler = null;
			var self = $(this);
			
			// check if the handler is set to null or empty string
			if(options.handler==null || ( typeof options.handler=='string' && $.trim(options.handler)=='' ))
				handler = $(this);
			else
				handler = $(options.handler);
			
			
			var event_object = {
				source : self,
				handler : handler
			};
			
			handler.click(function(){
				if(typeof options.beforeAnimate == 'function')
					options.beforeAnimate(event_object);
				if(options.animate===false || options.animate===null)
				{
					self.stop(true, true).toggle();
					if(typeof options.completeAnimate == 'function')
						options.completeAnimate(event_object);
				}
				else
				{
					var duration = options.animate;
					if(duration===true)
						duration = 300;
					self.stop(true, true).slideToggle(duration, function(){
						if(typeof options.completeAnimate == 'function')
						options.completeAnimate(event_object);
					});
				}
			});
		});
	}
})(jQuery);
