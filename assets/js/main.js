$(document).ready(function() {
	$('#txt_date').datepicker({
		changeMonth: true,
		changeYear: true
	});
	
	// use tooltip from bootstrap
	$('.tooltip-info').tooltip();
	
	// For alert message
	if($(".message").text() != '') {
		setTimeout(function() {
			$(".message").fadeOut();
		}, 3000);
	}
	
	urlCheck();
	
});

/**
 * Action Add New
 *
 * Proses action ketika klik add new
 */
function actionAddNew()
{
	var hash_menu = extractHash("menu");
	var hash_form_input = extractHash("form-input");
	var hash_list_shortcuts = extractHash("list-shortcuts");
	var menu = hash_menu.replace("#", "");
	showInputData(hash_menu, hash_form_input, hash_list_shortcuts, menu);
}

/**
 * Action Main Menu
 *
 * Proses action ketika klik main menu (on top)
 *
 * @param	menu	Menu yang anda klik
 */
function actionMainMenu(menu)
{
	/*************************************************
		BEGIN :: For Action Menu when Clicked
	*************************************************/
	// Initialize variable
	var tagLiOnAllMenu = $(menu).parent().parent().children('li');
	var tagLiOnThisMenu = $(menu).parent();
	var typeMenu = $(menu).attr('type-menu');

	$('#myModal').modal('show'); // process loading
	
	// Inactive & active menu
	tagLiOnAllMenu.removeClass('active');
	tagLiOnThisMenu.addClass('active');
		
	setTimeout(function(){
		$('#myModal').modal('hide'); // loading finish
		
		// Hide all panel
		$('.content-page').hide();
		$('.content-page.' + typeMenu).show(); // except this panel
		$('.content-page.' + typeMenu).children('.content-in-panel').slideDown(); // and then slide down
	}, 500);
	/*************************************************
		END :: For Action Menu when Clicked
	*************************************************/
}

/**
 * Action Toggle Shortcut
 *
 * Proses action ketika klik toggle shortcut
 */
function actionToggleShortcut()
{
	var hash_menu = extractHash("menu");
	var hash_form_input = extractHash("form-input");
	var hash_list_shortcuts = extractHash("list-shortcuts");
	var menu = hash_menu.replace("#", "");
	showListShortcuts(hash_menu, hash_form_input, hash_list_shortcuts, menu);
}

/**
 * in array
 *
 * Mencari suatu nilai dalam sebuah array di javascript
 *
 * @used in		views/roster/xrosterdayview
 * @param		all type variable		@neddle			Bisa berisi semua tipe variable apapun karena ini tergantung content array yang ingin dicari
 * @param		array					@haystack
 * @result		boolean					true / false	True = variable tersebut (needle) ada di dalam array (haystack);  False = Kebalikannnya;
 */
function inArray(needle, haystack)
{
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

/**
 * Show Input Data
 *
 * Menampilkan form input data
 *
 * @param	menu	Letak menu dimana anda berada
 */
function showInputData(hash_menu, hash_form_input, hash_list_shortcuts, menu)
{
	
	// console.log("hash_menu : " + hash_menu);
	// console.log("hash_form_input : " + hash_form_input);
	// console.log("hash_list_shortcuts : " + hash_list_shortcuts);
	// console.log("menu show input : " + menu);
	
	// Cek hash list shortcuts
	if(typeof hash_list_shortcuts === 'undefined') {
		hash_list_shortcuts = "";
	} else {
		hash_list_shortcuts = "/show-list-shortcuts";
	}
	
	// Show / hide input data
	var status = $('.'+ menu +'#input-data').attr('status');
	// console.log("status : " + status);
	if(status == "hidden") {
		// show
		$('.'+ menu +'#input-data').attr('status', "show");
		$('.'+ menu +'#input-data').slideDown();
		
		if(typeof hash_form_input === 'undefined' || hash_form_input == "none"){
			// Update URL Browser
			// Add text for SHOW add new
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "page 2", hash_menu + "/show-form-input" + hash_list_shortcuts);
		}
	} else {
		// hide
		$('.'+ menu +'#input-data').attr('status', "hidden");
		$('.'+ menu +'#input-data').slideUp();
		
		if(typeof hash_form_input != 'undefined'){
			// Update URL Browser
			// Add text for HIDE add new
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "page 2", hash_menu + "/none" + hash_list_shortcuts);
		}
	}
}

/**
 * Show List Shortcuts
 *
 * Menampilkan daftar-daftar tombol untuk shortcuts di aplikasi ini
 *
 * @param	menu	Letak menu dimana anda berada
 */
function showListShortcuts(hash_menu, hash_form_input, hash_list_shortcuts, menu)
{

	// console.log(hash_menu);
	// console.log(hash_form_input);
	// console.log(hash_list_shortcuts);
	// console.log(menu);
	
	// Show / hide list shortcuts
	var status = $('.'+ menu +'#info-shortcuts').attr('status');
	// console.log("status : " + status);
	if(status == "hidden") {
		// show
		$('.'+ menu +'#info-shortcuts').attr('status', "show");
		$('.'+ menu +'#info-shortcuts').slideDown();
		
		if(typeof hash_list_shortcuts === 'undefined'){
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "page 2", hash_menu + '/' + hash_form_input + "/show-list-shortcuts");
		}
	} else {
		// hide
		$('.'+ menu +'#info-shortcuts').attr('status', "hidden");
		$('.'+ menu +'#info-shortcuts').slideUp();
		
		if(typeof hash_list_shortcuts != 'undefined'){
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "page 2", hash_menu + '/' + hash_form_input);
		}
	}
}


