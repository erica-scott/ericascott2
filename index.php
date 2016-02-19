
<html>
	<head>
		<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
			$(document).ready(function() {
				readNextMessage();

				$('#money').click(function() {
					window.location.replace('money.php');
				});
				$('#login').click(function() {
					var username = $('#username').val();
					var password = $('#password').val();
					login(username, password);
				});

				$('#logout').click(function() {
					setNextMessage("You have been succesfully logged out.");
					createCookie('username', 'false', 1);
					window.location.reload();
				});

				$('#create_redirect').click(function() {
					$('#login_form').hide();
					$('#new_user_form').show();
				});

				$('#create').click(function() {
					var username = $('#new_username').val();
					var password = $('#new_password').val();
					var full_name = $('#full_name').val();
					$.ajax({
						url: 'ajax/create_new_user.php',
						method: 'post',
						data: {username: username, password: password, full_name: full_name},
						success: function(data) {
							if (data == true) {
								login(username, password);
							}
						}
					});
				});

				$('#cancel').click(function() {
					$('#new_user_form').hide();
					$('#login_form').show();
				});
			});
			function login(username, password) {
				$.ajax({
					url: 'ajax/login.php',
					method: 'post',
					data: {username: username, password: password},
					success: function(data) {
						if (data != false) {
							setNextMessage('Welcome ' + data + '!', 0);
							createCookie('username', username, 60);
						} else {
							setNextMessage("That username/password combination was incorrect. Please try again.", 1);
						}
						window.location.reload();
					}
				});
			}
			function createCookie(name, value, minutes) {
				if (minutes) {
					var date = new Date();
					date.setTime(date.getTime()+(minutes*60*1000));
					var expires = "; expires=" + date.toGMTString();
				} else {
					var expires = "";
				}
				document.cookie = name + "=" + value + expires + "; path=/";
			}
			function setNextMessage(message, error) {
				$.ajax({
					url: 'ajax/set_message.php',
					method: 'post',
					data: {message: message, error: error}
				});
			}
			function readNextMessage() {
				$.ajax({
					url: 'ajax/read_message.php',
					method: 'post',
					success: function(data) {
						if (data != -1) {
							var message = data.split('_')[0];
							var error = data.split('_')[1];
							var color;
							if (error == 1) {
								color = '#ff9999';
							} else {
								color = '#ccffcc';
							}
							var width = message.length;
							$('#message').width(width);
							$('#message').css({
								'border-width' : '5px',
								'border-style' : 'solid',
								'border-color' : color
							});
							$('#message').html(message);
						}
					}
				});
			}
		</script>
		<style>
			.form { padding:20px; }
			.form .field { padding: 4px; margin 1px; }
			.form .field label { display: inline-block; width: 120px; margin-left: 5px; }
			.form .field input { display: inline-block; }
			.form .button { padding: 4px; margin 1px; }
			.form .button input { width: 260px; }
		</style>
	</head>
	<body>
		<?php include('header.php'); ?>
		<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != 'false') : ?>
			<h1>Please choose a function below:</h1><br>
			<input type="button" name="money" id="money" value ="Manage Money">
			<input type="button" name="logout" id="logout" value ="Logout">
		<?php else : ?>
			<div id="login_form">
				<h1>Please login to access functions:</h1><br>
				<div class="form">
					<div class="field">
						<label>Username:</label>
						<input type="text" id="username" name="username">
					</div>
					<div class="field">
						<label>Password:</label>
						<input type="password" id="password" name="password">
					</div>
					<div class="button">
						<input type="button" id="login" name="login" value="Login">
					</div>
					<div class="button">
						<input type="button" id="create_redirect" name="create_redirect" value="Create New User">
					</div>
				</div>
			</div>
			<div style="display:none;" id="new_user_form">
				<h1>Please fill out the following details to create a new account:</h1><br>
				<div class="form">
					<div class="field">
						<label>Username:</label>
						<input type="text" id="new_username" name="new_username">
					</div>
					<div class="field">
						<label>Password:</label>
						<input type="password" id="new_password" name="new_password">
					</div>
					<div class="field">
						<label>Full Name:</label>
						<input type="text" id="full_name" name="full_name">
					</div>
					<div class="button">
						<input type="button" id="create" name="create" value="Create New User">
					</div>
					<div class="button">
						<input type="button" id="cancel" name="cancel" value="Cancel">
					</div>
				</div>
			</div>
		<?php endif; ?>
	</body>
</html>