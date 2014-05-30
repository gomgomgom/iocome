(function($){
	$.fn.smoothtab = function(options, value){
		if(typeof options == 'string')
		{
			return this.each(function(){
				switch(options)
				{
					case 'selected':
					{
						var tabview = $(this).children('div.smoothtab-ui-content').children('div');
						value = parseInt(value);
						if(isNaN(value)) return;
						$(this).children('div.smoothtab-ui-tabpanel').children('a').filter(function(i){
							return i===value;
						}).addClass('smoothtab-state-selected').siblings().removeClass('smoothtab-state-selected');
						try{
							nextView.stop(true, true);
						}catch(exception){}
						nextView = tabview.filter(function(i){
							return i===value;
						});
						tabview.filter(function(i){
							return i !== value;
						}).stop(true, true).hide();
						nextView.stop(true, true).show();
						$(this).children('div.smoothtab-ui-content').stop(true, true).css({
							'height' : 'auto'
						});
					}break;
				}
			});
		}
		options = $.extend({
			selected: 0,
			animation: false
		}, options);
		return this.each(function(){
			var element = $(this).addClass('smoothtab-ui');
			var tabpanel = element.children("div:eq(0)").addClass('smoothtab-ui-tabpanel');
			var tabviewwrapper = element.children("div:eq(1)").addClass('smoothtab-ui-content');
			var tabview = tabviewwrapper.children('div').hide();
			var defaultView = tabview.filter(function(i){
				return i===options.selected;
			});
			var nextView;
			var defaultTab = tabpanel.children('a').filter(function(i){
				return i===options.selected
			});
			defaultView.show();
			defaultTab.addClass('smoothtab-state-selected');
			
			tabpanel.append('<br style="clear:both;" />');
			
			tabpanel.children('a').click(function(event){
				if($(this).hasClass('smoothtab-state-selected')) return;
				$(this).addClass('smoothtab-state-selected').siblings().removeClass('smoothtab-state-selected');
				var index = $(this).index();
				try{
					nextView.stop(true, true);
				}catch(exception){}
				nextView = tabview.filter(function(i){
					return i===index;
				});
				var nextViewHeight = nextView.outerHeight(true) || 0;
				if(options.animation === false)
				{
					tabview.filter(function(i){
						return i !== index;
					}).stop(true, true).hide();
					nextView.stop(true, true).show();
					tabviewwrapper.stop(true, true).css({
						'height' : 'auto'
					});
				}
				else
				{
					var animate = function(){
						tabview.filter(function(i){
							return i !== index;
						}).stop(true, true).fadeOut(options.animation);
						tabview.promise().done(function(){
							nextView.stop(true, true).fadeIn(options.animation);
						});
					};

					tabviewwrapper.stop().animate({
						height: nextViewHeight
					}, options.animation + 200, function(){
						$(this).css({
							'height' : 'auto'
						});
					});
					animate();
				}
				
				return false;
			});
		});
	}
})(jQuery);