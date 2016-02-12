<?php
if (isset($_POST['submit_add'])) {
	$con = mysql_connect('localhost', 'root') or die('Could not connect: ' . mysql_error());

	mysql_select_db('money');

	$amount = $_POST['amount'];
	$description = $_POST['description'];
	$pos_neg = $_POST['pos_neg'];

	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	if ($year == 'none' || $month == 'none' || $day == 'none') {
		print 'You have not chosen an acceptable date. Please try again.';
	} else {
		if ($month < 10) {
			$month = '0' . $month;
		}
		if ($day < 10) {
			$day = '0' . $day;
		}
		$date = $year . '-' . $month . '-' . $day;

		$query = sprintf("INSERT INTO money (amount, description, pos_neg, date) VALUES ('%s', '%s', '%s', '%s')", 
			$amount, $description, $pos_neg, $date);

		print $query;

		$res = mysql_query($query, $con) or die(mysql_error());
		if (mysql_affected_rows() == 1) {
			header("Location: http://ericas-macbook-air.local/money/index.php");
			die();
		}
	}
}
?>
<html>
	<head>
		<style>
			.container {
        width: 300px;
        clear: both;
	    }
	    .container input {
	      width: 100%;
	      clear: both;
	    }
		</style>
		<script src="js/jquery-2.2.0.js"></script>
		<script>
			$(document).ready(function() {

				$('#month').hide();
				$('#day_dropdown').hide();
				$('#submit_add').hide();

				$('#amount').keyup(function() {
					var amount = $('#amount').val();
					$.ajax({
						url: 'ajax/check_pos_neg.php',
						method: 'post',
						data: {amount: amount},
						success: function(data) {
							if (data == 1) {
								$('#amount').css("color","red");
								$('#pos_neg').val(0);
							} else {
								$('#amount').css("color","black");
								$('#pos_neg').val(1);
							}
						}
					});
				});

				$('#year').change(function() {
					if ($(this).val() != 'none') {
						$('#month').show();
					} else {
						$('#month').hide();
						$('#day_dropdown').hide();
					}
				});

				$('#month').change(function() {
					var month = $('#month').val();
					var year = $('#year').val();
					if (month != 'none') {
						$.ajax({
							url: 'ajax/get_num_days.php',
							method: 'post',
							data: {month: month, year: year},
							success: function(data) {
								$('#day_dropdown').html(data);
								$('#day_dropdown').show();
							}
						});
					} else {
						$('#day_dropdown').hide();
					}
				});

				$('#cancel').click(function() {
					window.location.replace('index.php');
				});
			});
			function validate() {
				alert('Stop!');
				return false;
			}
		</script>
	</head>
	<body>
		<div class="container">
			<form method="post" action="">
				<label>Amount: </label><input type="text" id="amount" name="amount" placeholder="$0.00" required><br><br>
				<label>Description: </label><input type="text" id="description" name="description" required><br><br>
				<?php
				$current_year = date('Y');
				$last_year = $current_year + 5;
				?>
				<label>Date: </label>
				<select id="year" name="year" required>
					<option value="none">Year</option>
					<?php for($i = $current_year; $i < $last_year; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
				}
				</select>
				<?php
				$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 
					7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
				?>
				<select id="month" name="month" required>
					<option value="none">Month</option>
					<?php foreach ($months as $key => $val) { ?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
				</select>
				<span id="day_dropdown"></span>
				<br><br>
				<input type="hidden" name="pos_neg" id="pos_neg">
				<input type="button" id="cancel" name="cancel" value="Cancel">
				<input type="submit" name="submit_add" id="submit_add" value="Add">
			</form>
		</div>
	</body>
</html>