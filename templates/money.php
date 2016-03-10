<html>
	<head>
		<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<style>
			.edit:hover {
				cursor:pointer;
			}
			.delete:hover {
				cursor:pointer;
			}
		</style>
		<script>
			$(document).ready(function() {
				$('.current').keyup(function() {
					var total = 0;
					var value;
					$('.current').each(function() {
						value = document.getElementById(this.id).value;
						var temp = value.replace('$', '');
						temp = parseFloat(temp);
						if (temp < 0) {
							document.getElementById(this.id).style.color = "red";
						} else {
							document.getElementById(this.id).style.color = "black";
						}
						total += temp;
					});
					$('.current_total').html('$' + total);
					if (total < 0) {
						$('.current_total').css('color', 'red');
					} else {
						$('.current_total').css('color', 'black');
					}
				});

				$('.edit').click(function() {
					var id = this.id.split('_')[1];
					$.ajax({
						url: '../ajax/edit_form.php',
						method: 'post',
						data: {id: id},
						success: function(data) {
							document.getElementById("dialog-edit").innerHTML = data;
							$('#edit_id').val(id);
							$('#dialog-edit').dialog("open");
						}
					});
				});

				$('.delete').click(function() {
					var id = this.id.split('_')[1];
					document.getElementById("dialog-delete").innerHTML = "Are you sure you want to delete this?";
					$('#delete_id').val(id);
					$('#dialog-delete').dialog("open");
				});

				$('.add').click(function() {
					var id = this.id.split('_')[1];
					$.ajax({
						url: '../ajax/add_copy.php',
						method: 'post',
						data: {id: id},
						success: function(data) {
							document.getElementById("dialog-add").innerHTML = data;
							$('#add_id').val(id);
							$('#dialog-add').dialog("open");
						}
					});
				});

				$('#add').click(function() {
					$.ajax({
						url: '../ajax/add_form.php',
						method: 'post',
						success: function(data) {
							document.getElementById("dialog-new").innerHTML = data;
							$('#dialog-new').dialog("open");

							$('#month').hide();
							$('#day_dropdown').hide();

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
									var days = new Date(year, month, 0).getDate();
									var data = '<select id="day" name="day"><option value="none">Day</option>';
									for (var i = 1; i <= days; i++) {
										data = data + '<option value="' + i + '">' + i + '</option>';
									}
									data = data + '</select>';
									$('#day_dropdown').html(data);
									$('#day_dropdown').show();
								} else {
									$('#day_dropdown').hide();
								}
							});
						}
					});
				});

				$('#dialog-edit').dialog({
					autoOpen: false,
					buttons: {
						'Edit': function() {
							var id = $('#edit_id').val();
							var amount = $('#amount').val();
							var description = $('#description').val();
							var year = $('#year').val();
							var month = $('#month').val();
							var day = $('#day').val();
							$.ajax({
								url: '../ajax/add.php',
								method: 'post',
								data: {id: id, amount: amount, description: description, year: year, month: month, day: day, flag: 1},
								success: function(data) {
									if (data == true) {
										$('#dialog-edit').dialog("close");
										window.location.reload();
									} else {
										document.getElementById("dialog-edit").innerHTML = "There was an error editing this. Please try again.";
									}
								}
							});
						},
						'Cancel': function() {
							$(this).dialog("close");
						}
					}
				});

				$('#dialog-new').dialog({
					autoOpen: false,
					buttons: {
						'Add': function() {
							var amount = $('#amount').val();
							var description = $('#description').val();
							var year = $('#year').val();
							var month = $('#month').val();
							var day = $('#day').val();
							$.ajax({
								url: '../ajax/add.php',
								method: 'post',
								data: {amount: amount, description: description, year: year, month: month, day: day, flag: 0},
								success: function(data) {
									if (data == true) {
										$('#dialog-new').dialog("close");
										window.location.reload();
									} else {
										document.getElementById("dialog-new").innerHTML = "There was an error editing this. Please try again." . data;
									}
								}
							});
						},
						'Cancel': function() {
							$(this).dialog("close");
						}
					}
				});

				$('#dialog-delete').dialog({
					autoOpen: false,
					buttons: {
						'Delete': function() {
							var id = $('#delete_id').val();
							$.ajax({
								url: '../ajax/delete.php',
								method: 'post',
								data: {id: id},
								success: function(data) {
									if (data == true) {
										$('#dialog-delete').dialog("close");
										window.location.reload();
									} else {
										document.getElementById("dialog-delete").innerHTML = "There was an error deleting this. Please try again.";
									}
								}
							});
						},
						'Cancel': function() {
							$(this).dialog("close");
						}
					}
				});

				$('#dialog-add').dialog({
					autoOpen: false,
					buttons: {
						'Add Copy': function() {
							var id = $('#edit_id').val();
							var amount = $('#amount').val();
							var description = $('#description').val();
							var year = $('#year').val();
							var month = $('#month').val();
							var day = $('#day').val();
							$.ajax({
								url: '../ajax/add.php',
								method: 'post',
								data: {id: id, amount: amount, description: description, year: year, month: month, day: day, flag: 0},
								success: function(data) {
									if (data == true) {
										$('#dialog-add').dialog("close");
										window.location.reload();
									} else {
										document.getElementById("dialog-add").innerHTML = "There was an error adding this copy. Please try again.";
									}
								}
							});
						},
						'Cancel': function() {
							$(this).dialog("close");
						}
					}
				});

				$('#return').click(function() {
					window.location.replace('../index.php');
				});

				$('#scroll_to_current').click(function() {
					var id = 'current_total';
					$('html,body').animate({
		        scrollTop: $("#"+id).offset().top},
		        'slow');
					});
			});
			function redirectToLogin() {
				window.location.replace('../index.php');
			}
		</script>
	</head>
	<body>
		<?php include_once("analyticstracking.php") ?>
		<?php include('header.php'); ?>
		<br>
		<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != 'false') : ?>
			<input type="button" id="add" value="Add">
			<input type="button" id ="scroll_to_current" value="Go To Current Total">
			<input type="button" id="return" name="return" value="Return">
			<?php
			$con = mysql_connect('localhost', 'escott', 'Silas2727_') or die('Could not connect: ' . mysql_error());

			mysql_select_db('manage_life');

			$username = $_COOKIE['username'];
			$query = sprintf("SELECT id FROM admin WHERE username = '%s'", $username);
			$res = mysql_query($query);
			$row = mysql_fetch_assoc($res);
			$user_id = $row['id'];

			$query = sprintf("SELECT * FROM money WHERE user_id = '%s' order by date", $user_id);
			$res = mysql_query($query, $con);
			if ($res != false) {
				$data = array();
				while ($row = mysql_fetch_assoc($res)) {
					$date = $row['date'];
					$date = explode('-', $date);
					$data[$date[0]][$date[1]][$date[2]][] = $row;
				}
			}

			$months_arr = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
				'07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');

			$count = 0;
			foreach ($data as $year => $months) {
				foreach ($months as $month => $days) {
					foreach ($days as $day => $rows) {
						foreach ($rows as $row) {
							$temp = str_replace('$', '', $row['amount']);
							if (isset($data[$year][$month]['total'])) {
								$data[$year][$month]['total'] += $temp;
							} else {
								$data[$year][$month]['total'] = $temp;
							}
						}
					}
					$lst_mth = intval($month) - 1;
					if ($lst_mth < 10 && $lst_mth > 0) {
						$lst_mth = '0' . $lst_mth;
						$lst_yr = $year;
					} else if ($lst_mth < 1) {
						$lst_mth = 12;
						$lst_yr = $year-1;
					}
					if (isset($data[$lst_yr][$lst_mth]['total'])) {
						$data[$year][$month]['total'] += $data[$lst_yr][$lst_mth]['total'];
					}
				}
			}

			$current_date = date('Y-m-d');
			$current_date = explode('-', $current_date);
			$current_total = 0;
			foreach ($data as $year => $months) {
				if ($year <= $current_date[0]) {
					foreach ($months as $month => $days) {
						if ($month <= $current_date[1] || $year != $current_date[0]) {
							foreach ($days as $day => $rows) {
								if ($day <= $current_date[2] || $month != $current_date[1]) {
								  if (is_array($rows)) {
                    foreach ($rows as $row) {
                      $temp = str_replace('$', '', $row['amount']);
                      $current_total += floatval($temp);
                    }
									}
								}
							}
						}
					}
				}
			}

			if (empty($data)) {
				print "You have not added any entires yet. Click the add button above to start.";
			}

				foreach ($data as $year => $months) { ?>
					<h1><?php print $year; ?></h1>
					<?php foreach ($months as $month => $days) { ?>
						<table border=1 style="border-collapse:collapse; width:30%;">
							<col width="30%">
							<col width="30%">
							<col width="30%">
							<col witdh="10%">
							<tr>
								<td><b><?php echo $months_arr[$month]; ?></b></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<?php foreach ($days as $day => $rows) {
								if (is_array($rows)) {
									foreach ($rows as $row) { ?>
										<tr>
											<td <?php if($row['pos_neg'] == 0) { ?> style="color:red;" <?php } ?> ><?php echo $row['amount']; ?></td>
											<td><?php echo $row['description']; ?></td>
											<td><?php echo $row['date']; ?></td>
											<td>
												<img class="edit" id="edit_<?php echo $row['id']; ?>" width="20px" height="20px" src="../images/edit.png"><img class="delete" id="delete_<?php echo $row['id']; ?>" width="20px" height="20px" src="../images/delete.png"><img class="add" id="add_<?php echo $row['id']; ?>" width="20px" height="20px" src="../images/add.png">
											</td>
										</tr>
									<?php }
								}
							} ?>
							<tr>
								<td><?php echo '$'.$data[$year][$month]['total']; ?>
								<td>Total</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
						<br>
						<?php if ($year == $current_date[0] && $month == $current_date[1]) {
							print '<div id="current_total"><b>Current Total:</b> ' . $current_total . "</div><br/>";
						} ?>
					<?php 
						$count++;
					} ?>
					<hr>
				<?php } ?>

			<div style="display:none;" id="dialog-edit" title="Edit"></div>
			<input type="hidden" id="edit_id">
			<div style="display:none;" id="dialog-delete" title="Delete"></div>
			<input type="hidden" id="delete_id">
			<div style="display:none;" id="dialog-add" title="Add Copy"></div>
			<input type="hidden" id="add_id">
			<div style="display:none;" id="dialog-new" title="Add"></div>
			<input type="hidden" id="new_id">
		<?php else : ?>
			<?php 
			include('../library/actions.php'); 
			setMessage('You do not have access to that page. Please login to continue.', 1);
			echo '<script>redirectToLogin();</script>';
			?>
		<?php endif; ?>
	</body>
</html>
