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
						url: 'ajax/edit_form.php',
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
								url: 'ajax/add.php',
								method: 'post',
								data: {id: id, amount: amount, description: description, year: year, month: month, day: day},
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

				$('#dialog-delete').dialog({
					autoOpen: false,
					buttons: {
						'Delete': function() {
							var id = $('#delete_id').val();
							$.ajax({
								url: 'ajax/delete.php',
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
			});
		</script>
	</head>
	<body>
		<form method="post" action="add.php">
			<input type="submit" id="add" value="Add">
		</form>
		<?php
		$con = mysql_connect('localhost', 'root') or die('Could not connect: ' . mysql_error());

		mysql_select_db('money');

		$query = "SELECT * FROM money order by date";
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
				} else if ($lst_mth < 1) {
					$lst_mth = 12;
				}
				if (isset($data[$year][$lst_mth]['total'])) {
					$data[$year][$month]['total'] += $data[$year][$lst_mth]['total'];
				}
			}
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
										<img class="edit" id="edit_<?php echo $row['id']; ?>" width="20px" height="20px" src="images/edit.png"><img class="delete" id="delete_<?php echo $row['id']; ?>" width="20px" height="20px" src="images/delete.png">
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
			<?php 
				$count++;
			} ?>
			<hr>
		<?php } ?>

		<div style="display:none;" id="dialog-edit" title="Edit"></div>
		<input type="hidden" id="edit_id">
		<div style="display:none;" id="dialog-delete" title="Delete"></div>
		<input type="hidden" id="delete_id">
	</body>
</html>
