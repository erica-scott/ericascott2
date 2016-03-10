<html>
	<head>
		<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
			$(document).ready(function() {
				$('#return').click(function() {
					window.location.replace('grades.php');
				});

				$('#dialog-add').dialog({
          autoOpen: false,
          buttons: {
            Add: function() {
              var class_name = $('#class_name').val();
              var year = $('#year').val();
              var elective_type = $('#elective_type').val();
              if (elective_type == 'none') {
              	elective_type = NULL;
              }
              $.ajax({
                url: '../ajax/add_required_class.php',
                method: 'post',
                data: {class_name, year},
                success: function(data) {
                  if (data == true) {
                    window.location.reload();
                  } else {
                    $('#dialog-add').html('Error: ' + data);
                  }
                }
              });
            },
            Cancel: function() {
              window.location.reload();
            }
          }
        });
          
        $('#add').click(function() {
          $.ajax({
            url: '../ajax/grades_required_form.php',
            success: function(data) {
                $('#dialog-add').html(data);
                $('#dialog-add').dialog("open");
            }
          });
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
			<input type="button" id="return" name="return" value="Return"><br><br>

			<?php
			$con = mysql_connect('localhost', 'escott', 'Silas2727_') or die('Could not connect: ' . mysql_error());
			mysql_select_db('manage_life');
			
			$username = $_COOKIE['username'];
			$query = sprintf("SELECT * FROM admin WHERE username = '%s'", $username);
			$res = mysql_query($query);
			$user = mysql_fetch_assoc($res);
			$user_id = $user['id'];

			$query = sprintf("SELECT * FROM required_courses WHERE user_id = '%s'", $user_id);
			$res = mysql_query($query);
			$data = array();
			while ($row = mysql_fetch_assoc($res)) {
				$data[$row['year']][] = $row;
			}

			$query = "SELECT * FROM elective_types";
			$res = mysql_query($query);
			while ($row = mysql_fetch_assoc($res)) {
				$elective_types[$row['id']] = $row['name'];
			}
			?>
			<table style="width: 100%; border-collapse:collapse;" border=1>
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="10%">
				<tr>
					<td>First Year:</td>
					<td>Second Year:</td>
					<td>Third Year:</td>
					<td>Fourth Year:</td>
					<td>Electives:</td>
					<td>Type:</td>
				</tr>
				<?php 
				$size = 0;
				foreach ($data as $year => $classes) {
					if (count($classes) > $size) {
						$size = count($classes);
					}
				}
				?>
				<?php for($i = 0; $i < $size; $i++) : ?>
					<tr>
						<td><?php if(isset($data[1][$i])) { print $data[1][$i]['class_name']; } ?></td>
						<td><?php if(isset($data[2][$i])) { print $data[2][$i]['class_name']; } ?></td>
						<td><?php if(isset($data[3][$i])) { print $data[3][$i]['class_name']; } ?></td>
						<td><?php if(isset($data[4][$i])) { print $data[4][$i]['class_name']; } ?></td>
						<td><?php if(isset($data[5][$i])) { print $data[5][$i]['class_name']; } ?></td>
						<td><?php if(isset($data[5][$i])) { print $elective_types[$data[5][$i]['elective_type']]; } ?></td>
					</tr>
				<?php endfor; ?>
			</table>
			<br><br><br>
			<b>These are the elective rules that need to be followed for completion of degree:</b><br>
			- 3 Credits Impact of Technology on Society<br>
			- 6 Credits Humanities or Social Sciences Elective<br>
			- 4 Credits Breadth Electives<br>
			- 11 Credits Advanced Electives<br>
			- 3 Credits Science Electives<br>
			- 6 Credits Technical Electives<br>
			- 6 Credits Free Electives<br>
			<a href="https://www.ece.ubc.ca/sites/default/files/CPEN%20-%20FEB%202016.docx">Find all of the information on these here.</a>
		<?php else : ?>
			<?php 
			include('../library/actions.php'); 
			setMessage('You do not have access to that page. Please login to continue.', 1);
			echo '<script>redirectToLogin();</script>';
			?>
		<?php endif; ?>
		<div id="dialog-add" style="display: none;"></div>
	</body>
</html>