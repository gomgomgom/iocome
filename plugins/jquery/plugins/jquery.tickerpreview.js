/**
 * Plugin to run the ticker text preview. This plugin will show text as single line and run ticker if the text too long.
 * @author Sugeng Wibowo
 */
(function($){
	$.fn.tickerpreview = function(options){
		options = $.extend
						({
							delay 	: 1000,	/* delay before the ticker start */
							mpp		: 25,		/* milliseconds per pixel, determine speed for each px */
							easing	: 'linear'	/* easing used for animation */
						}, options);
		return this.each(function(){
			var content = $(this).html();
			var span = $('<span></span>')
						.html(content)
						.css({
							'white-space' : 'nowrap'
						});
			$(this).html(span)
					.css({
						'overflow' : 'hidden'
					});
			$(this).bind({
						'mouseleave' : function(){
							span.stop(true, true);
							span.css({
								'position' : 'relative',
								'left' : '0px'
							});
						},
						'mouseenter' : function(){
							span.css({
								'position' : 'relative',
								'left' : '0px'
							});

							var diff_width = $(this).width() - span.outerWidth();

							if(diff_width<0)
							{
								span.stop(true, true).delay(options.delay).animate({
									'left' : diff_width
								}, diff_width * -1 * options.mpp, options.easing);
							}
						}
					});
		});
	};
})(jQuery);