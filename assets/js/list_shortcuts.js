$(document).ready(function() {
	
	
	/******************************************************
		BEGIN : Make Jquery Shortcuts
	******************************************************/
	$.Shortcuts.add({
		type: 'down',
		mask: 'Shift+C',
		handler: function() {
			var hash = window.location.hash;
			var hash_split = hash.split('/');
			
			// cek hash tag, agar hanya bisa dipakai di menu tertentu saja
			switch(hash_split[0])
			{
				case "#category" :
					$('#add-category').trigger('click');
					break;
				case "#income-outcome" :
					break;
				case "#report" :
					break;
				case "#administration" :
					break;
			}
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'Shift+V',
		handler: function() {
			var hash = window.location.hash;
			var hash_split = hash.split('/');
			
			// cek hash tag, agar hanya bisa dipakai di menu tertentu saja
			switch(hash_split[0])
			{
				case "#category" :
					$('#add-child-category').trigger('click');
					break;
				case "#income-outcome" :
					break;
				case "#report" :
					break;
				case "#administration" :
					break;
			}
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'Shift+A',
		handler: function() {
			var hash = window.location.hash;
			var hash_split = hash.split('/');
			
			// cek hash tag, agar hanya bisa dipakai di menu tertentu saja
			switch(hash_split[0])
			{
				case "#category" :
					break;
				case "#income-outcome" :
					$('#add-detail-outcome').trigger('click');
					break;
				case "#report" :
					break;
				case "#administration" :
					break;
			}
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'Shift+S',
		handler: function() {
			var hash = window.location.hash;
			var hash_split = hash.split('/');
			
			// cek hash tag, agar hanya bisa dipakai di menu tertentu saja
			switch(hash_split[0])
			{
				case "#category" :
					$('#btn-save-category').trigger('click');
					break;
				case "#income-outcome" :
					$('#btn-save-income-outcome').trigger('click');
					break;
				case "#report" :
					break;
				case "#administration" :
					break;
			}
		}
	});
	
	$.Shortcuts.start();
	/******************************************************
		END : Make Jquery Shortcuts
	******************************************************/
});
