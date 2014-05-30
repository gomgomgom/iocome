jQuery.autocomplete = function(input, options) {
	// Create a link to self
	var me = this;

	// Create jQuery object for input element
	var $input = $(input).attr("autocomplete", "off");

	// Apply inputClass if necessary
	if (options.inputClass) $input.addClass(options.inputClass);
    if (options.formatItem == undefined) {
        options.formatItem = function(data, i, value){
            return "<div class='ac_location'>" + data.v + "</div><div class='ac_street'>" + data.i + "</div>";
        };
    }

	// Create results
	var results = document.createElement("div");
	// Create jQuery object for results
	var $results = $(results);
	$results.hide().addClass(options.resultsClass).css({"position":"absolute", "z-index":2000});
	if( options.width > 0 ) $results.css("width", options.width);
		
	//add mouse leave to result
	//to make sure it will be hidden
	$(results).mouseleave(function(){
		hideResultsNow();
	});
	
	// Add to body element
	$("body").append(results);

	input.autocompleter = me;

	var timeout = null;
	var prev = "";
	var active = -1;
	var keyb = false;
	var hasFocus = false;
	var lastKeyPressCode = null;
	var dataJson = [];

	$input
	.keydown(function(e) {
	
		
		// track last key pressed
		lastKeyPressCode = e.keyCode;
		switch(e.keyCode) {
			case 38: // up
				e.preventDefault();
				moveSelect(-1);
				break;
			case 40: // down
				e.preventDefault();
				moveSelect(1);
				break;
			case 13: // return
				// make sure to blur off the current field
				selectCurrent();
				e.preventDefault();
				break;
			default:
				hideResultsNow();
				active = -1;
				if (timeout) clearTimeout(timeout);
				timeout = setTimeout(function(){onChange();}, options.delay);
				break;
		}
	})
	.focus(function(){
		// track whether the field has focus, we shouldn't process any results if the field no longer has focus
		hasFocus = true;
	})
	.blur(function() {
		// track whether the field has focus
		if (options.onItemUnselect) setTimeout(function() {options.onItemUnselect()}, 1);
		hasFocus = false;
		hideResults();
	});

	hideResultsNow();

	function onChange() {
		// ignore if the following keys are pressed: [del] [shift] [capslock]
		if (lastKeyPressCode == 8 || lastKeyPressCode == 46) {
			if (options.onItemRemove) setTimeout(function() {options.onItemRemove()}, 1);
		}
		if( lastKeyPressCode == 46 || (lastKeyPressCode > 8 && lastKeyPressCode < 32) ) return $results.hide();
		var v = $input.val();
		if (v == prev) return;
		prev = v;
		if (v.length >= options.minChars) {
			if (options.onItemRemove) setTimeout(function() {options.onItemRemove()}, 1);
			$input.addClass(options.loadingClass);
			requestData(v);
		} else {
			$input.removeClass(options.loadingClass);
			$results.hide();
		}
	};

	
 	function moveSelect(step) {
		var lis = $("li", results);
		if (!lis) return;

		active += step;

		if (active < 0) {
			active = 0;
		} else if (active >= lis.size()) {
			active = lis.size() - 1;
		}

		lis.removeClass("ac_over");

		$(lis[active]).addClass("ac_over");

		// Weird behaviour in IE
		// if (lis[active] && lis[active].scrollIntoView) {
		// 	lis[active].scrollIntoView(false);
		// }

	};
	
	function selectCurrent() {
		var li = $("li.ac_over", results)[0];
		if (!li) {
			var $li = $("li", results);
			if (options.selectOnly) {
				if ($li.length == 1) li = $li[0];
			} else if (options.selectFirst) {
				li = $li[0];
			}
		}
		if (li) {
			selectItem(li);
		}
	};

	function selectItem(li) {
		if (!li) {
			li = document.createElement("li");
			li.extra = [];
			li.selectValue = "";
		}		
		var v = $.trim(li.selectValue ? li.selectValue : li.innerHTML);
		var index = $("#" + li.id).index();
		input.lastSelected = v;
		prev = v;
		$results.html("");		
		$input.val(v);
		hideResultsNow();
		if (options.onItemSelect) options.onItemSelect(li, dataJson[index], $input);
//		if (options.onItemSelect) setTimeout(function() { options.onItemSelect(li, dataJson) }, 1);
	};

	// selects a portion of the input string
	function createSelection(start, end){
		// get a reference to the input element
		var field = $input.get(0);
		if( field.createTextRange ){
			var selRange = field.createTextRange();
			selRange.collapse(true);
			selRange.moveStart("character", start);
			selRange.moveEnd("character", end);
			selRange.select();
		} else if( field.setSelectionRange ){
			field.setSelectionRange(start, end);
		} else {
			if( field.selectionStart ){
				field.selectionStart = start;
				field.selectionEnd = end;
			}
		}
		field.focus();
	};

	// fills in the input box w/the first match (assumed to be the best match)
	function autoFill(sValue){
		// if the last user key pressed was backspace, don't autofill
		if( lastKeyPressCode != 8 ){
			// fill in the value (keep the case the user has typed)
			$input.val($input.val() + sValue.substring(prev.length));
			// select the portion of the value not typed by the user (so the next character will erase)
			createSelection(prev.length, sValue.length);
		}
	};

	function showResults() {
		// get the position of the input field right now (in case the DOM is shifted)
		var pos = findPos(input);
		// either use the specified width, or autocalculate based on form element
		var iWidth = (options.width > 0) ? options.width : $input.width();
		
		/* Edited: Added to support min height in options */
		if(options.minHeight > 0 && !isNaN(parseInt(options.minHeight)))
			$results.css('min-height', options.minHeight);
		
		// reposition
		$results.css({
			width: parseInt(iWidth) + "px",
			top: (pos.y + input.offsetHeight) + "px",
			left: pos.x + "px"
		}).show();
	};

	function hideResults() {
		//fix ie hide when scroll
		//if (timeout) clearTimeout(timeout);
		//timeout = setTimeout(hideResultsNow, 200);
	};

	function hideResultsNow() {
		if (timeout) clearTimeout(timeout);
		$input.removeClass(options.loadingClass);
		if ($results.is(":visible")) {
			$results.hide();
		}
		if (options.mustMatch) {
			var v = $input.val();
			if (v != input.lastSelected) {
				selectItem(null);
			}
		}
	};

	function receiveData(q, data) {
		if (data) {
			$input.removeClass(options.loadingClass);
			results.innerHTML = "";

			// if the field no longer has focus or if there are no matches, do not display the drop down
			if( !hasFocus || data.length == 0 ) return hideResultsNow();

			if ($.browser.msie) {
				// we put a styled iframe behind the calendar so HTML SELECT elements don't show through
				$results.append(document.createElement('iframe'));
			}
			results.appendChild(dataToDom(data));
			// autofill in the complete box w/the first match as long as the user hasn't entered in more data
			if( options.autoFill && ($input.val().toLowerCase() == q.toLowerCase()) ) autoFill(data[0][0]);
			showResults();
		} else {
			hideResultsNow();
		}
	};

	function parseData(data) {		
		if (!data) return null;
		if (options.dataType == 'json') return data;
		var parsed = [];
		var rows = data.split(options.lineSeparator);
		for (var i=0; i < rows.length; i++) {
			var row = $.trim(rows[i]);
			if (row) {
				parsed[parsed.length] = row.split(options.cellSeparator);
			}
		}
		return parsed;
	};

	function dataToDom(data) {
		var ul = document.createElement("ul");
		var num = data.length;

		// limited results to a max number
		if( (options.maxItemsToShow > 0) && (options.maxItemsToShow < num) ) num = options.maxItemsToShow;

		for (var i=0; i < num; i++) {
			var row = data[i];
			if (!row) continue;
			var li = document.createElement("li");
			if (options.formatItem) {
				li.innerHTML = options.formatItem(row, i, num);
				li.selectValue = options.selectedValuesProp ? row[options.selectedValuesProp] : row[0];
			} else {
				li.innerHTML = options.selectedValuesProp ? row[options.selectedValuesProp] : row[0];
				li.selectValue = options.selectedValuesProp ? row[options.selectedValuesProp] : row[0];
			}
			li.id = "idx" + i;
			var extra = null;
			if (row.length > 1) {
				extra = [];
				for (var j=1; j < row.length; j++) {
					extra[extra.length] = row[j];
				}
			}
			li.extra = extra;
			ul.appendChild(li);
			$(li).hover(
				function() {$("li", ul).removeClass("ac_over");$(this).addClass("ac_over");
				active = $("li", ul).indexOf($(this).get(0));},
				function() {$(this).removeClass("ac_over"); 
				}
			).click(function(e) {e.preventDefault();e.stopPropagation();selectItem(this)});
		}
		return ul;
	};

	function requestData(q) {
		if (!options.matchCase) q = q.toLowerCase();
		// if an AJAX url has been supplied, try loading the data now
		if( (typeof options.url == "string") && (options.url.length > 0) ){
			//$.get(makeUrl(q), function(data) {
			var defaults = {'q' : q, 'lang' : options.lang};
			if (options.extraParams) defaults = $.extend(defaults, options.extraParams);
			$.post(options.url, defaults, function(data) {
				if (options.retrieveComplete) data = options.retrieveComplete.call(this, data);
				data = parseData(data);
				dataJson = data;
				receiveData(q, data);
			}, options.dataType ? options.dataType : null);
		// if there's been no data found, remove the loading class
		} else {
			$input.removeClass(options.loadingClass);
		}
	};

	function makeUrl(q) {
		q = q.replace('\/', '~~');
		var url = options.url + "/q/" + encodeURI(q);
		for (var i in options.extraParams) {
			url += "&" + i + "=" + encodeURI(options.extraParams[i]);
		}
		return url;
	};
	
	this.setExtraParams = function(p) {
		options.extraParams = p;
	};

	this.findValue = function(){
		var q = $input.val();

		if (!options.matchCase) q = q.toLowerCase();
		var data = null;
		if( (typeof options.url == "string") && (options.url.length > 0) ){
			$.get(makeUrl(q), function(data) {
				data = parseData(data)
				findValueCallback(q, data);
			});
		} else {
			// no matches
			findValueCallback(q, null);
		}
	}

	function findValueCallback(q, data){
		if (data) $input.removeClass(options.loadingClass);

		var num = (data) ? data.length : 0;
		var li = null;

		for (var i=0; i < num; i++) {
			var row = data[i];

			if( row[0].toLowerCase() == q.toLowerCase() ){
				li = document.createElement("li");
				if (options.formatItem) {
					li.innerHTML = options.formatItem(row, i, num);
					li.selectValue = row[0];
				} else {
					li.innerHTML = row[0];
					li.selectValue = row[0];
				}
				var extra = null;
				if( row.length > 1 ){
					extra = [];
					for (var j=1; j < row.length; j++) {
						extra[extra.length] = row[j];
					}
				}
				li.extra = extra;
			}
		}

		if( options.onFindValue ) setTimeout(function() {options.onFindValue(li)}, 1);
	}

	function findPos(obj) {
//		var curleft = obj.offsetLeft || 0;
//		var curtop = obj.offsetTop || 0;
//		while (obj = obj.offsetParent) {
//			curleft += obj.offsetLeft
//			curtop += obj.offsetTop
//		}
		/* Edited to fix the offset */
		var curleft = $(obj).offset().left;
		var curtop = $(obj).offset().top;
		return {x:curleft,y:curtop};
	}
}

jQuery.fn.autocomplete = function(url, options, data) {
	// Make sure options exists
	options = options || {};
	// Set url as option
	options.url = url;
	// set some bulk local data
	options.data = ((typeof data == "object") && (data.constructor == Array)) ? data : null;

	// Set default values for required options
	options.lang = options.lang || "eng";
	options.inputClass = options.inputClass || "ac_input";
	options.resultsClass = options.resultsClass || "ac_results";
	options.lineSeparator = options.lineSeparator || "\n";
	options.cellSeparator = options.cellSeparator || "|";
	options.minChars = options.minChars || 1;
	options.delay = options.delay || 400;
	options.matchCase = options.matchCase || 0;
	options.mustMatch = options.mustMatch || 0;
	options.extraParams = options.extraParams || {};
	options.loadingClass = options.loadingClass || "ac_loading";
	options.selectFirst = options.selectFirst || false;
	options.selectOnly = options.selectOnly || false;
	options.maxItemsToShow = options.maxItemsToShow || -1;
	options.autoFill = options.autoFill || false;
	options.width = parseInt(options.width, 10) || 0;

	this.each(function() {
		var input = this;
		new jQuery.autocomplete(input, options);
	});

	// Don't break the chain
	return this;
}

jQuery.fn.autocompleteArray = function(data, options) {
	return this.autocomplete(null, options, data);
}

jQuery.fn.indexOf = function(e){
	for( var i=0; i<this.length; i++ ){
		if( this[i] == e ) return i;
	}
	return -1;
};
