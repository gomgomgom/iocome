/**
 * Save Loading Waiting
 *
 * Show process loading to user (change button or view info)
 * Just authenticate this process was working
 *
 * @param	string	id_tag_html, id dari attribute button save html
 * @return	string	menghasilkan class untuk merubah button menjadi disabled
 */
function save_loading_waiting(id_tag_html) {
	document.getElementById(id_tag_html).className += " disabled";
	$("#info-" + id_tag_html).show(500);
}

/**
 * Save Loading Success
 *
 * Back to normal after loading
 *
 * @param	string	id, id dari attribute button save html
 * @return	string	menghasilkan class untuk merubah button menjadi normal
 */
function save_loading_success(id_tag_html) {
	$("#info-" + id_tag_html).fadeOut(1000, function() {
		
		document.getElementById(id_tag_html).className = document.getElementById(id_tag_html).className.replace( /(?:^|\s)disabled(?!\S)/g , '' );
		/* code wrapped for readability - above is all one statement
		
		(?:^|\s) # match the start of the string, or any single whitespace character

		MyClass  # the literal text for the classname to remove

		(?!\S)   # negative lookahead to verify the above is the whole classname
				 # ensures there is no non-space character following
				 # (i.e. must be end of string or a space)
		*/
	});
}