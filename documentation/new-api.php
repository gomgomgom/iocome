<?php
// Read file JSON
$toc = json_decode(file_get_contents("toc.json")); // Table of contents

$content_category = json_decode(file_get_contents("content-category.json")); // Content of Category API
$content_transaction = json_decode(file_get_contents("content-transaction.json")); // Content of Transaction API

// print_r($content_category);
// print_r($content_category[0]->ContentFull->Parameter);
// exit;
?>

<html>
	<head>
		<script type="text/javascript" src="../plugins/jquery/jquery-1.10.2.min.js"></script>
		<!--<link href='http://fonts.googleapis.com/css?family=Oxygen:300' rel='stylesheet' type='text/css'>-->
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('.toc-toggle').click(function(){
					if($(this).parent().next('.toc-content').is(':visible')){
						$(this).text('[ + ]');
						$(this).parent().next('.toc-content').slideUp();
					} else {
						$(this).text('[ - ]');
						$(this).parent().next('.toc-content').slideDown()
					}
				});
			});
			
			function toogleNote(elementHTML)
			{
				if($('#box-note').is(':visible')){
					$('#box-note').slideUp();
					$(elementHTML).text('v');
				} else {
					$('#box-note').slideDown();
					$(elementHTML).text('^');
				}
			}
		</script>
		
		<style>
			body {
				background-color: #f8f8f8;
				font-family: 'Oxygen', sans-serif;
			}
			
			
			
			/** LAYOUT **/
			#header {
			}
			#main-column {
				min-width: 400px;
			}
			#left-column {
				height: 70%;
				overflow-y: scroll;
				padding-left: 20px;
				width: 250px;
			}
			#left-column ul{
				margin-left: -30px;
			}
			#right-column {
				height: 70%;
				overflow: auto;
			}
			#footer {
				padding: 15px 0px;
				text-align: center;
				width: 100%;
			}
			
			
		
		
			label {
				font-style: italic;
				font-size: 14px;
				padding-right: 20px;
			}
			
			table {
				border: 1px solid #DFDFD0;
				box-shadow: 1px 1px 5px #A8A8B7;
				padding: 10px;
			}
			
			li > h2 {
				border-bottom:3px solid #313030;
				padding-bottom: 10px;
			}
			
			li > h3 {
				display: list-item;
				list-style-type: square;
			}
			
			li {
				list-style-type: none;
			}
			
			hr {
				border: 3px solid black;
			}
			
			a {
				text-decoration: none; !important
			}
			a:hover {
				text-decoration: underline; !important
			}
			
			
			
			
			
			li.box-api-function {
				padding-bottom: 50px;
			}
			
			.back-to-top {
				line-height: 50px;
				padding-bottom: 50px;
				text-align: right;
				width: 100%;
			}
			
			.url, .parameter, .return {
				width: 600px;
			}
			
			.parameter, .return {
				border: 1px solid #CECEBF;
				font-size: 14px;
				padding: 15px;
				/*padding: 5px;
				padding-top: 15px;*/
			}
			
			.url {
				border: 1px solid #CECEBF;
				font-family: arial;
				font-size: 13px;
				padding: 5px;
			}
			
			
			
			
			/** STYLESHEET TOC **/
			.toc {
				font-size: 15px;
				line-height: 25px;
			}
			.toc .head-section {
				list-style-type: none;
			}
			.toc li {
				list-style-type: circle;
			}
			.toc-toggle {
				color: #999;
				cursor: pointer;
			}
			.toc-toggle:hover {
				color: #B3002D;
			}
			.toc-content {
				color: #000;
				font-size: 13px;
			}
			.toc-content a {
				color: #000;
			}
			
		</style>
		
	</head>
	
	<body>
		<div id="header">
			<h1>IOcome Documentation - API <button onClick="toogleNote(this);">^</button></h1>
			<div id="box-note">
				NOTE ::<br/>
				For Get List .....  There are parameter start, limit, order by, order sort
				<br/>
			</div>
		</div>
		<hr/>
		
		<div id="main-column"><!-- Box All Content -->
		
			<div id="left-column" style="float:left;">
			
			<h3 style="text-align:center;">Table of Contents</h3>
			<ul class="toc">
				<?php
				for($indexTOC_Head=0; $indexTOC_Head<count($toc); $indexTOC_Head++){
					$headTitle = $toc[$indexTOC_Head]->HeadTitle;
				?>
				<li class="head-section"><br/><b><?=$headTitle;?></b> &nbsp; <span class="toc-toggle">[ - ]</span></li>
				<div class="toc-content">
					<ul>
					<?php
					$tocCategory = $toc[$indexTOC_Head]->ListAPI;
					for($indexTOC_API=0; $indexTOC_API<count($tocCategory); $indexTOC_API++){
						$title = $tocCategory[$indexTOC_API]->Title;
						$link = $tocCategory[$indexTOC_API]->Link;
						$attributeId = $tocCategory[$indexTOC_API]->AttributeID;
						$attributeClass = $tocCategory[$indexTOC_API]->AttributeClass;
						$attributeOther = $tocCategory[$indexTOC_API]->AttributeOther;
					?>
						<li><a class="<?=$attributeClass;?>" id="<?=$attributeId;?>" href="<?=$link;?>"><?=$title;?></a></li>
					<?php
					}
					?>
					</ul>
				</div>
				<?php
				}
				?>
			</ul>
			
			</div>
			<div id="right-column">
			
			<ul>
				<li id="category">
					<h2>Category</h2>
					<ul>
						<?php
						for($i=0; $i<count($content_category); $i++){
						?>
						<li class="box-api-function" id="<?=$content_category[$i]->ElementID;?>">
							<h3><?=$content_category[$i]->TitleAPI;?></h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url"><?=$content_category[$i]->URLFull;?></td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">
										<pre><?=file_get_contents("parameter_and_return_full/category/".$content_category[$i]->TitleAPI." - Parameter.txt");?></pre>
									</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre><?=file_get_contents("parameter_and_return_full/category/".$content_category[$i]->TitleAPI." - Return.txt");?></pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				
				<li id="transaction">
					<h2>Transaction</h2>
					<ul>
						<?php
						for($i=0; $i<count($content_transaction); $i++){
						?>
						<li class="box-api-function" id="<?=$content_transaction[$i]->ElementID;?>">
							<h3><?=$content_transaction[$i]->TitleAPI;?></h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url"><?=$content_transaction[$i]->URLFull;?></td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">
										<pre><?=file_get_contents("parameter_and_return_full/transaction/".$content_transaction[$i]->TitleAPI." - Parameter.txt");?></pre>
									</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre><?=file_get_contents("parameter_and_return_full/transaction/".$content_transaction[$i]->TitleAPI." - Return.txt");?></pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				
				<li id="user">
					<h2>User</h2>
					<ul>
						<li class="box-api-function" id="add-user">
							<h3>Add User</h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url">http://localhost/iocome/index.php/API/User/AddUser</td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">
										<pre>
	{
		"Username": "[ string ]",
		"Password": "[ string ]",
		"Name": "[ string ]",
		"Email": "[ string ]"
	}
										</pre>
									</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre>
	{
		"Status": "[ boolean ]",
		"Message": "[ string ]"
	}
										</pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
						<li class="box-api-function" id="edit-user">
							<h3>Edit User</h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url">http://localhost/iocome/index.php/API/User/EditUser</td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">
										<pre>
	{
		"ID": "[ int ]",
		"Password": "[ string ]",
		"Name": "[ string ]",
		"Email": "[ string ]"
	}
										</pre>
									</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre>
	{
		"Status": "[ boolean ]",
		"Message": "[ string ]"
	}
										</pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
						<li class="box-api-function" id="remove-user">
							<h3>Remove User</h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url">http://localhost/iocome/index.php/API/Transaction/RemoveUser?id=[ int ]</td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">on URL (GET method)</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre>
	{
		"Status": "[ boolean ]",
		"Message": "[ string ]"
	}
										</pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
						<li class="box-api-function" id="login">
							<h3>Login</h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url">http://localhost/iocome/index.php/API/User/Login</td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">
										<pre>
	{
		"Username": "[ string ]",
		"Password": "[ string ]"
	}
										</pre>
									</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre>
	{
		"Status": "[ boolean ]",
		"Message": "[ string ]"
	}
										</pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
						<li class="box-api-function" id="logout">
							<h3>Logout</h3>
							<table>
								<tr>
									<td><label>URL</label></td>
									<td class="url">http://localhost/iocome/index.php/API/User/Logout</td>
								</tr>
								<tr>
									<td><label>Parameter</label></td>
									<td class="parameter">NULL
									</td>
								</tr>
								<tr>
									<td><label>Return</label></td>
									<td class="return">
										<pre>
	{
		"Status": "[ boolean ]",
		"Message": "[ string ]"
	}
										</pre>
									</td>
								</tr>
							</table>
							<a class="back-to-top" href="http://localhost/dev/iocome/documentation/api.html">Back to top &#10548;</a>
						</li>
					</ul>
				</li>
				
			</ul>
			
			</div>
		</div>
		
		<hr/>
		<div id="footer">Footer</div>
	</body>
	
</html>