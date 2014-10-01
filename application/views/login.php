<!-- This form copy from http://www.dzyngiri.com/flat-ui-login-form-with-horizontal-scroll/ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Login</title>
		<meta name="description" content="Beautiful flat UI login form with horizontal scroll effect" />
		<meta name="keywords" content="flat, flat ui, flat design, login form, horizontal scroll" />
		<meta name="author" content="Dzyngiri" />
		<link rel="stylesheet" type="text/css" href="<?=plugins_url();?>/login-dzyngiri/style.css" />
		<link rel="stylesheet" type="text/css" href="<?=plugins_url();?>/login-dzyngiri/font/css/fontello.css" />
		<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,700' rel='stylesheet' type='text/css'>-->
		
		<!-- Load Plugins :: jQuery 1.10.2 -->
		<script type="text/javascript" src="<?=plugins_url();?>/jquery/jquery-1.10.2.min.js"></script>
		
		
		<!-- Script for Process Data -->
		<script type="text/javascript">
			$(document).ready(function(){
			
				// Set variable
				Login.btn_submit = $('#btn-submit-login');
				Login.msg = $('#msg-login');
				Login.pass = $('#txt-pass-login');
				Login.user_email = $('#txt-user-login');
				
				// Action event login
				Login.btn_submit.bind('click', function(){
					Login.processLogin();
				});
				
				
				
				// Set variable
				LostPassword.btn_submit = $('#btn-submit-lost-password');
				LostPassword.msg = $('#msg-lost-password');
				LostPassword.user_email = $('#txt-user-lost-password');
				
				// Action event recover
				LostPassword.btn_submit.bind('click', function(){
					LostPassword.processRecover();
				});
				
				
				
				// Set variable
				SignUp.btn_submit = $('#btn-submit-signup');
				SignUp.msg = $('#msg-signup');
				SignUp.name = $('#txt-name-signup');
				SignUp.pass = $('#txt-pass-signup');
				SignUp.confirm_pass = $('#txt-confirm-pass-signup');
				SignUp.user_email = $('#txt-user-signup');
				
				// Action event signup
				SignUp.btn_submit.bind('click', function(){
					SignUp.processSignUp();
				});
				
			});
			
			
			var Login = 
			{
				// Declare variable
				btn_submit: '',
				msg: '',
				pass: '',
				user_email: '',
				
				// Bind again
				// When we enter to a process
				// Trigger on button will be unbind
				// So we can prevent multiple iteration on those process
				// But DONT FORGET, we must bind on button to function again
				bindSubmit: function()
				{
					this.btn_submit.bind('click', function(){
						Login.processLogin();
					});
				},
				
				processLogin: function()
				{
					// Unbind
					// To prevent duplicate request data when user click button too much at a second
					this.btn_submit.unbind('click');
					
					// Validation field is null / not
					if(this.user_email.val() == '' || this.pass.val() == '')
					{
						this.msg.slideUp(400, function(){
							Login.msg.html("Username & password must be filled");
							Login.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Validation email
					// Source :: http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
					var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (! re.test(this.user_email.val()))
					{
						this.msg.slideUp(400, function(){
							Login.msg.html("Please enter a valid email address.");
							Login.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Set data content
					var content = {
						Username: this.user_email.val(),
						Password: this.pass.val()
					};
					
					// Send data to process login
					$.ajax({
						url: '<?=site_url();?>/login/process_login',
						type: 'post',
						dataType: 'json',
						data: JSON.stringify(content),
						beforeSend: function(){
							Login.msg.slideUp(400, function(){
								Login.msg.html('<img src="<?=images_url();?>/loading/ajax-load-4-1.gif" />');
								Login.msg.slideDown();
							});
						},
						success: function(result){
							if(result["Status"] == 200){
								Login.msg.slideUp(400, function(){
									Login.msg.html('<span style="color:#10AF16;">'+ result['Message'] +'</span>');
									Login.msg.slideDown();
								});
								window.location = '<?=site_url();?>/dashboard';
							}
							else if(result["Status"] == 500){
								Login.msg.slideUp(400, function(){
									Login.msg.html(result['Message']);
									Login.msg.slideDown();
								});
								
								Login.bindSubmit();
							}
							else {
								Login.msg.slideUp(400, function(){
									Login.msg.html(result['Message']);
									Login.msg.slideDown();
								});
								
								Login.bindSubmit();
							}
						},
						error: function(e){
							alert("Login failed. There is an error when login");
							console.log(e);
						}
					});
					
				}
				
			}
			
			var LostPassword =
			{
				// Declare variable
				btn_submit: '',
				msg: '',
				user_email: '',
				
				// Bind again
				// When we enter to a process
				// Trigger on button will be unbind
				// So we can prevent multiple iteration on those process
				// But DONT FORGET, we must bind on button to function again
				bindSubmit: function()
				{
					this.btn_submit.bind('click', function(){
						LostPassword.processRecover();
					});
				},
				
				processRecover: function()
				{
					// Unbind
					// To prevent duplicate request data when user click button too much at a second
					this.btn_submit.unbind('click');
					
					// Validation field is null / not
					if(this.user_email.val() == '')
					{
						this.msg.slideUp(400, function(){
							LostPassword.msg.html("Email must be filled");
							LostPassword.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Validation email
					// Source :: http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
					var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (! re.test(this.user_email.val()))
					{
						this.msg.slideUp(400, function(){
							LostPassword.msg.html("Please enter a valid email address.");
							LostPassword.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Set data content
					var content = {
						Email: this.user_email.val()
					};
					
					// Send data to process recover password
					$.ajax({
						url: '<?=site_url();?>/login/process_lost_password',
						type: 'post',
						dataType: 'json',
						data: JSON.stringify(content),
						beforeSend: function(){
							LostPassword.msg.slideUp(400, function(){
								LostPassword.msg.html('<img src="<?=images_url();?>/loading/ajax-load-4-1.gif" />');
								LostPassword.msg.slideDown();
							});
						},
						success: function(result){
							if(result["Status"] == 200){
								LostPassword.msg.slideUp(400, function(){
									LostPassword.msg.html('<span style="color:#10AF16;">'+ result['Message'] +'</span>');
									LostPassword.msg.slideDown();
								});
							}
							else if(result["Status"] == 500){
								LostPassword.msg.slideUp(400, function(){
									LostPassword.msg.html(result['Message']);
									LostPassword.msg.slideDown();
								});
								
								LostPassword.bindSubmit();
							}
							else {
								LostPassword.msg.slideUp(400, function(){
									LostPassword.msg.html(result['Message']);
									LostPassword.msg.slideDown();
								});
								
								LostPassword.bindSubmit();
							}
						},
						error: function(e){
							alert("Send password failed. There is an error when send password to your email");
							console.log(e);
						}
					});
				}
				
			}
			
			var SignUp = 
			{
				// Declare variable
				btn_submit: '',
				confirm_pass: '',
				msg: '',
				name: '',
				pass: '',
				user_email: '',
				
				// Bind again
				// When we enter to a process
				// Trigger on button will be unbind
				// So we can prevent multiple iteration on those process
				// But DONT FORGET, we must bind on button to function again
				bindSubmit: function()
				{
					this.btn_submit.bind('click', function(){
						SignUp.processSignUp();
					});
				},
				
				processSignUp: function()
				{
					// Unbind
					// To prevent duplicate request data when user click button too much at a second
					this.btn_submit.unbind('click');
					
					// Validation field is null / not
					if(this.name.val() == '' || this.user_email.val() == '' || this.pass.val() == '')
					{
						this.msg.slideUp(400, function(){
							SignUp.msg.html("All field must be filled");
							SignUp.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Validation email
					// Source :: http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
					var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (! re.test(this.user_email.val()))
					{
						this.msg.slideUp(400, function(){
							SignUp.msg.html("Please enter a valid email address.");
							SignUp.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Validation confirm password
					// field Password and Confirm password must have same value
					if(this.pass.val() != this.confirm_pass.val())
					{
						this.msg.slideUp(400, function(){
							SignUp.msg.html("Your confirmation password not same with password.");
							SignUp.msg.slideDown();
						});
						
						this.bindSubmit();
						return false;
					}
					
					// Set data content
					var content = {
						Name: this.name.val(),
						Username: this.user_email.val(),
						Password: this.pass.val()
					};
					
					// Send data to process SignUp
					$.ajax({
						url: '<?=site_url();?>/login/process_signup',
						type: 'post',
						dataType: 'json',
						data: JSON.stringify(content),
						beforeSend: function(){
							SignUp.msg.slideUp(400, function(){
								SignUp.msg.html('<img src="<?=images_url();?>/loading/ajax-load-4-1.gif" />');
								SignUp.msg.slideDown();
							});
						},
						success: function(result){
							if(result["Status"] == 200){
								SignUp.msg.slideUp(400, function(){
									SignUp.msg.html('<span style="color:#10AF16;">'+ result['Message'] +'</span>');
									SignUp.msg.slideDown();
								});
							}
							else if(result["Status"] == 500){
								SignUp.msg.slideUp(400, function(){
									SignUp.msg.html(result['Message']);
									SignUp.msg.slideDown();
								});
								
								SignUp.bindSubmit();
							}
							else {
								SignUp.msg.slideUp(400, function(){
									SignUp.msg.html(result['Message']);
									SignUp.msg.slideDown();
								});
								
								SignUp.bindSubmit();
							}
						},
						error: function(e){
							alert("Sign Up failed. There is an error when sign up");
							console.log(e);
						}
					});
					
				}
				
			}
			
		</script>
	</head>
	
	<body>
		<!-- BEGIN: Login Section -->
		<div class="section" id="section1">
			<div class="login-form">
				<h1>Login</h1>
				<p>You already have an account? Great! Login here.</p>
				<div>
					<form action="<?=site_url();?>/login/process_login" class="form-wrapper-01" method="post">
						<input type="text" id="txt-user-login" class="inputbox email" placeholder="Email" />
						<input type="password" id="txt-pass-login" class="inputbox password" placeholder="Password" />
						<div id="msg-login" style="color:#E00909; display:none;"></div>
						<p><a href="#" class="button" id="btn-submit-login">Login <i class="icon-paper-plane"></i></a></p>
					</form>
					<p>Forget password? It's ok. <a class="scroll" href="#section3">Recover here &raquo;</a></p>
				</div>
				<hr />
				<p>Or you can Login with one of the following</p>
				<div class="social">
					<a href="#" class="facebook"><i class="icon-facebook"></i></a>
					<a href="#" class="twitter"><i class="icon-twitter"></i></a>
					<a href="#" class="google"><i class="icon-gplus"></i></a>
				</div>
				<p>Don't have an account? <a class="scroll" href="#section2">Register Now &raquo;</a></p>
			</div>
		</div>
		<!-- END: Login Section -->
		
		<!-- BEGIN: Signup Section -->
		<div class="section" id="section2">
			<div class="signup-form">
				<h1>Sign Up in Seconds!</h1>
				<p>Signup using your Email address</p>
				<div>
					<form class="form-wrapper-01">
						<input id="txt-name-signup" class="inputbox name" type="text" placeholder="Your Name" />
						<input id="txt-user-signup" class="inputbox email" type="text" placeholder="Email" />
						<input id="txt-pass-signup" class="inputbox password" type="password" placeholder="Password" />
						<input id="txt-confirm-pass-signup" class="inputbox password" type="password" placeholder="Confirm Password" />
						<div id="msg-signup" style="color:#E00909; display:none;"></div>
						<p><a href="#" class="button" id="btn-submit-signup">Create my Account <i class="icon-paper-plane"></i></a></p>
						<!--<input id="" type="button" class="button" value="Sign up" />-->
					</form>
				</div>
				<hr />
				<p>Or you can Signup with one of the following</p>
				<div class="social">
					<a href="#" class="facebook"><i class="icon-facebook"></i><span>Facebook</span></a>
					<a href="#" class="twitter"><i class="icon-twitter"></i><span>Twitter</span></a>
					<a href="#" class="google"><i class="icon-gplus"></i><span>Google</span></a>
				</div>
				<p><a class="scroll" href="#section1">&laquo; Login here</a></p>
			</div>
		</div>
		<!-- END: Signup Section -->
	
		<!-- BEGIN: Forget Password Section -->
		<div class="section" id="section3">
			<div class="login-form">
				<h1>Lost password?</h1>
				<p>Ohk, don't panic. You can recover it here.</p>
				<div>
					<form class="form-wrapper-01">
						<input type="text" id="txt-user-lost-password" class="inputbox email" placeholder="Email" />
						<div id="msg-lost-password" style="color:#E00909; display:none;"></div>
						<p><a href="#" class="button" id="btn-submit-lost-password">Send me <i class="icon-paper-plane"></i></a></p>
					</form>
				</div>
				<hr />
				<p>You remember your Password? Brilliant!</p>
				<p><a class="scroll" href="#section1">&laquo; Login here</a></p>
			</div>
		</div>
		<!-- END: Forget Password Section -->
		
		
		<!--Script for Horizontal Scrolling-->
		<script type="text/javascript" src="<?=plugins_url();?>/login-dzyngiri/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript">
			$(function() {
				$('a.scroll').bind('click',function(event){
					var $anchor = $(this);
					$('html, body').stop().animate({
						scrollLeft: $($anchor.attr('href')).offset().left
					}, 500,'easeInOutExpo');
					 /* Uncomment this for another scrolling effect */
					 /*
					$('html, body').stop().animate({
						scrollLeft: $($anchor.attr('href')).offset().left
					}, 1000);*/
					event.preventDefault();
				});
			});
		</script>
		

		<!--Google analytics-->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-55180685-1', 'auto');
			ga('send', 'pageview');
		</script>
		
	</body>
</html>