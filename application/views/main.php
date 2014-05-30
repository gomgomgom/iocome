<!DOCTYPE html>
<html lang="en">
	
	<div id="start-page" class="script-process-loading" style="background-color:#535362; position:absolute; z-index:9999; height:100%; width:100%;">
		<style>
			.loading-box{
				height: 30px;
				width: 250px;
				background-color: #fff;
				border: 1px solid #00f;
				margin-left: 10px;
			}
		</style>
		
		<!-- For create loading in order to indicate to the user that the process is running -->
		<!-- Start loading at 5% completed -->
		<!-- if loading complete this div will be remove -->
		<div style="color:#fff; left:50%; text-align:center; top:30%;">
			<br/><br/>
			<h1>IOcome</h1>
			
			<center>
				<div class="loading-box"></div>
				<div class="loading-box" id="progress-bar" style="background-color:#00f; margin-top:-30px; margin-left:-200px; opacity:0.5; width:10px;"></div>
			</center>
			
		</div>
	</div>
	
	<head>
		<title>Income Outcome App</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		
		
		
		<!------------------------------------------------------------------->
		<!----------------  BEGIN :: Declare / Call Plugins  ---------------->
		<!------------------------------------------------------------------->
		
		<!-- Load Plugins :: No More Tables - http://elvery.net/demo/responsive-tables/ -->
		<!--<link rel="stylesheet" href="<?php echo plugins_url();?>/no-more-tables.css" />-->
		
		<!-- Load Plugins :: jQuery - jquery.com -->
		<!----><script type="text/javascript" src="<?php echo plugins_url();?>/jquery/jquery-1.10.2.min.js"></script><!---->
		
		
		
		<div class="script-process-loading">
			<!-- if loading complete this div will be remove -->
			<script type="text/javascript">
				// Set progress bar start page to 30%
				jQuery('#start-page').find('#progress-bar').css('width', '80px');
				jQuery('#start-page').find('#progress-bar').css('margin-left', '-170px');
			</script>
		</div>
	
	
		
		<!-- Load Plugins :: jQuery UI - jqueryui.com -->
		<script type="text/javascript" src="<?php echo plugins_url();?>/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
		<link rel="stylesheet" href="<?php echo plugins_url();?>/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.7.2.custom.css" />
	
		<!-- Load Plugins :: jQuery Numeric - http://www.texotela.co.uk/code/jquery/numeric/ -->
		<script type="text/javascript" src="<?php echo plugins_url();?>/jquery.numeric/jquery.numeric.js"></script>
		
		<!-- Diagram & Chart by Google - https://developers.google.com/chart/‎ -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		
		
		
		
		<div class="script-process-loading">
			<!-- if loading complete this div will be remove -->
			<script type="text/javascript">
				// Set progress bar start page to 50%
				jQuery('#start-page').find('#progress-bar').css('width', '120px');
				jQuery('#start-page').find('#progress-bar').css('margin-left', '-130px');
			</script>
		</div>
		
		
		
		
		<!-- Load Plugins :: Bootstrap 3.1.1 - getbootstrap.com -->
		<link rel="stylesheet" href="<?php echo plugins_url();?>/bootstrap-3.1.1-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo plugins_url();?>/bootstrap-3.1.1-dist/css/bootstrap-theme.min.css" />
		<script type="text/javascript" src="<?php echo plugins_url();?>/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
		
		<!-- Jquery Shortcuts by Stepan Reznikov - www.stepanreznikov.com -->
		<!--<script src="<?php echo plugins_url();?>/jquery-shortcuts/jquery.shortcuts.js"></script>-->
		
		
		<!------------------------------------------------------------------->
		<!----------------  END :: Declare / Call Plugins  ---------------->
		<!------------------------------------------------------------------->
		
		
		
		
		<div class="script-process-loading">
			<!-- if loading complete this div will be remove -->
			<script type="text/javascript">
				// Set progress bar start page to 70%
				jQuery('#start-page').find('#progress-bar').css('width', '170px');
				jQuery('#start-page').find('#progress-bar').css('margin-left', '-80px');
			</script>
		</div>
		
		
		
		
		<!------------------------------------------------------------------->
		<!---------------  BEGIN :: Declare / Call MY MODULE  --------------->
		<!------------------------------------------------------------------->
		<script language="javascript" type="text/javascript" src="<?php echo js_url();?>/Loading/MY_loading.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo js_url();?>/URL/MY_url.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo js_url();?>/Data/MY_data.js"></script>
		<!------------------------------------------------------------------->
		<!----------------  END :: Declare / Call MY MODULE  ---------------->
		<!------------------------------------------------------------------->
		
		

		
		
		
		<script type="text/javascript">
			// Declare GLOBAL variable
			var BASE_URL = "<?php echo base_url();?>";
			var SITE_URL = "<?php echo site_url();?>";
			var IMAGES_URL = "<?php echo images_url();?>";
			var JS_URL = "<?php echo js_url();?>";
			var PLUGINS_URL = "<?php echo plugins_url();?>";
			
			var MAIN_MENU = new Array("dashboard", "category", "transaction", "report");
			var USER_MENU = new Array("notification", "profile", "sign out");
			
			jQuery(document).ready(function(){
				
				// Call class
				var url = new MY_url();
				var data = new MY_data();
				
				
				
				// ---  Begin :: URL Processing  ---
				var urlHeader = url.getURLHeader();
				url.setURLString(urlHeader);
				var urlController = url.getURLController(url);
				// ---  End :: URL Processing  ---
				
				
				
				
				// ---  Begin :: Data Processing  ---
				var classController = url.getClassController();
				console.log(classController);
				// Check whether urlController is there on menu ?
				// Note :: This is ONLY for request page with AJAX not from typing on url
				if(jQuery.inArray(classController, MAIN_MENU) == -1){
					alert("Content page for "+ classController +" cannot found");
					
					// Post to controller to save as Log of Audit Trail
					// -- code --
					
					return false; // stop processing
				}
				
				// Put content
				data.getContentByURL(classController, ".content-page");
				
				// set menu which we selected to be active and switch other menu to be non-active
				setMenuActiveAndNonactive(classController);
				
				// ---  End :: Data Processing  ---
				
				
				// Show tooltip for replace title at tag HTML
				jQuery(".tooltip-info").tooltip();
			});
			
			
			// Class for main function on View
			var Main = {
				
				// Sub class
				buttonTrigger: {
				
					/*
					 * Action Toggle Shortcut
					 *
					 * To show or hide info shortcuts
					 */
					actionToggleShortcut: function()
					{
						// Check visibility
						if(jQuery('.section-info-shortcuts').is(":hidden")) {
							jQuery('.section-info-shortcuts').slideDown("fast"); // show
						} else {
							jQuery('.section-info-shortcuts').slideUp("fast"); // hide
						}
					},
				
					/*
					 * Action Display Form Add
					 *
					 * To show or hide form add
					 */
					actionDisplayFormAdd: function()
					{
						// Check visibility
						if(jQuery('.section-form-add').is(":hidden")) {
							jQuery('.section-form-add').slideDown("fast"); // show
						} else {
							jQuery('.section-form-add').slideUp("fast"); // hide
						}
					}
					
				},
				
				// Sub class
				content: {
				
					/*
					 * Get Content
					 *
					 * Show content at view page (content section)
					 * 
					 * @param			classController		string			url web service to get view content with these data
					 * @param			elementHTML			objectHTML		Location of tag html (div, table, dll) for input data
					 * @call function	
					 */
					getContent: function(classController, elementHTML)
					{
						// get content
						var data = new MY_data();
						data.getContentByURL(classController, ".content-page");
						
						// update url header
						var url = new MY_url();
						url.setURLString(SITE_URL +"/"+ classController);
						url.updateURLHeader();
						
						// set menu which we selected to be active and switch other menu to be non-active
						setMenuActiveAndNonactive(classController);
						
						// Show tooltip for replace title at tag HTML
						jQuery(".tooltip-info").tooltip();
					}
				},
				
				/*
				 * Sign Out
				 *
				 * Remove session & cache for security reason & user privacy
				 */
				signOut: function()
				{
					alert("You have sign out");
					
					// remove session
					
					// remove cache
				}
			}
			
			
			// Set menu which we selected to be active and switch other menu to be non-active
			function setMenuActiveAndNonactive(classController)
			{
				// header menu
				$(".main-menu").removeClass("active"); // set other menu to be non-active
				$(".main-menu."+classController).addClass("active"); // set menu to be active
			}
			
			function showLoadingAtContentPage(elementHTML)
			{
				// Show process loading
				jQuery(elementHTML).html('<center><img style="text-align:center; top:0;" src="'+ IMAGES_URL +'/loading-text.gif" /></center>');
			}
		</script>
		
		
		
		<style>
			.iocome-page.content-page, footer, .iocome-menu {
				margin-left:auto;
				margin-right:auto;
				max-width: 1000px;
			}
			
			.iocome-page.content-page, footer {
				padding-left: 15px;
				padding-right: 15px;
			}
			
			
			
			
			/* Begin Style :: Menu */
			.iocome-menu.user-menu {
				color: #fff;
				float: right;
				margin-top: auto;
				margin-bottom: auto;
				position: relative;
			}
			/* End Style :: Menu */
			
			
			
			
			/* Begin Style :: Quote */
			.iocome-blockquote {
				background-color: #f4f8fa;
				border-left-color: #5bc0de;
			}
			/* End Style :: Quote */
			
			
			
			
			/* Begin Style :: Content Page */
			.subtitle-page {
				font-size: 35px;
			}
			
			.toggle-info-shortcuts:hover {
				color: #83b5d7;
				cursor: pointer;
			}
			.btn-edit:hover, .btn-edit.active {
				color: #FFA600;
				cursor: pointer;
			}
			.btn-remove:hover {
				color: #c52b00;
				cursor: pointer;
			}
			/* End Style :: Content Page */
			
			
			
			
			
			
		</style>
		

    </script>
	</head>
	
	
	
	<div class="script-process-loading">
		<!-- if loading complete this div will be remove -->
		<script type="text/javascript">
			// Set progress bar start page to 90%
			jQuery('#start-page').find('#progress-bar').css('width', '210px');
			jQuery('#start-page').find('#progress-bar').css('margin-left', '-40px');
		</script>
	</div>
	
	
	
	<body>
	
		<!-- Section :: Header -->
		<div>
			<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
				<div class="container iocome-menu">
					<div class="navbar-header">
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#main" id="menu-main" onClick="actionMainMenu(this);" type-menu="main">IOcome</a>
					</div>
					
					<!-- Menu -->
					<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
					
						<!-- Main Menu -->
						<ul class="nav navbar-nav">
							<li class="active main-menu dashboard" onClick="Main.content.getContent('dashboard', this);">
								<a href="#" onClick="return false;">
									<span class="glyphicon glyphicon-dashboard"></span> &nbsp; Dashboard
								</a>
							</li>
							<li class="main-menu category" onClick="Main.content.getContent('category', this);">
								<a href="#" onClick="return false;">
									<span class="glyphicon glyphicon-folder-open"></span> &nbsp; Category
								</a>
							</li>
							<li class="main-menu transaction" onClick="Main.content.getContent('transaction', this);">
								<a href="#" onClick="return false;">
									<span class="glyphicon glyphicon-transfer"></span> &nbsp; Transaction
								</a>
							</li>
							<li class="main-menu report" onClick="Main.content.getContent('report', this);">
								<a href="#" onClick="return false;">
									<span class="glyphicon glyphicon-stats"></span> &nbsp; Report
								</a>
							</li>
						</ul>
						
						<!-- User Menu -->
						<span class="iocome-menu user-menu">
							<ul class="nav navbar-nav">
								<li class="tooltip-info" data-placement="bottom" title="Notification">
									<a href="#" onClick="return false;"><span class="glyphicon glyphicon-bell"></span></a>
								</li>
								<li class="tooltip-info" data-placement="bottom" title="Profile" onClick="Main.content.getContent('profile');">
									<a href="#" onClick="return false;"><span class="glyphicon glyphicon-user"></span></a>
								</li>
								<li class="tooltip-info" data-placement="bottom" title="Sign Out" onClick="Main.signOut();">
									<a href="#" onClick="return false;"><span class="glyphicon glyphicon-off"></span></a>
								</li>
							</ul>
						</span>
						
						
					</nav>
					
				</div>
			</header>
			
			<br/><br/><br/>
		</div>

		<br/>

		<!-- Section :: Content - Dynamic -->
		<div class="iocome-page content-page">
			This is part of content
		</div>
	
	
		<!-- Section :: Footer -->
		<footer class="body-center">
			<br/><hr/><br/>
			<p class="pull-right"><a href="#">Back to top</a></p>
			<p>&copy; 2013 Company, Inc.</p>
		</footer>
		
		
	</body>
	
	
	<div class="script-process-loading">
		<script type="text/javascript">
			setTimeout(function(){
				// Set progress bar start page to 100%
				jQuery('#start-page').find('#progress-bar').css('width', '260px');
				jQuery('#start-page').find('#progress-bar').css('margin-left', '10px');
			}, 100);
			
			setTimeout(function(){
				
				jQuery('#start-page').hide();
				
				// Remove all script for create a loading progress page
				jQuery('.script-process-loading').remove();
			}, 800);
		</script>
	</div>
	
</html>