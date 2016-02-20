<html>
	<head>
		<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
			$(document).ready(function() {
				$('#return').click(function() {
					window.location.replace('../index.php');
				});
			});
			function redirectToLogin() {
				window.location.replace('../index.php');
			}
		</script>
  </head>
  <body>
  	<?php include('header.php'); ?>
		<br>
		<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != 'false') : ?>
			<input type="button" id="return" name="return" value="Return">
			Hello!
		<?php else : ?>
			<?php 
			include('../library/actions.php'); 
			setMessage('You do not have access to that page. Please login to continue.', 1);
			echo '<script>redirectToLogin();</script>';
			?>
		<?php endif; ?>
  </body>
</html>