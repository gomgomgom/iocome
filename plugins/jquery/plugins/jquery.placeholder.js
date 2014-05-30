/* 
 * jQuery Placeholder
 * This plugin is intended to provide placeholder in the input that's usually used in search box.
 * 
 * @Author Sugeng Wibowo
 * @Copyright Streetdirectory streedirectory.com 2011
 */

(function($){
	$.fn.extend({
		placeholder: function(options){
			var settings = $.extend({
				text: 'Input your text here',
				inputClass: 'search-placeholder'
			}, options);
			return this.each(function(){
				if(!$(this).is('input'))
					return;
				$(this).val(settings.text).addClass(settings.inputClass)
				.bind({
					focus: function(){
						if($(this).hasClass(settings.inputClass))
							$(this).val('').removeClass(settings.inputClass);
					},
					blur: function(){
						if($(this).val()==='')
							$(this).val(settings.text).addClass(settings.inputClass);
					}
				});
			});
		}
	});
})(jQuery);