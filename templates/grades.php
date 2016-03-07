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
				
				$('#input_school_started').click(function() {
				    var year = $('#year_started').val();
				    $.ajax({
				      url: '../ajax/add_grade_year.php',
				      method: 'post',
				      data: {year: year},
				      success: function() {
				        window.location.reload();
				      }
				    });
				});
				
				$('#dialog-add').dialog({
          autoOpen: false,
          buttons: {
            Add: function() {
              var class_name = $('#class_name').val();
              var percentage = $('#percentage').val();
              var credits = $('#credits').val();
              var year = $('#year').val();
              var semester = $('#semester').val();
              $.ajax({
                url: '../ajax/add_grade.php',
                method: 'post',
                data: {class_name, percentage, credits, year, semester},
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
              $(this).dialog("close");
            }
          }
        });
          
        $('#add').click(function() {
          $.ajax({
            url: '../ajax/grades_add_form.php',
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
  	<?php include('header.php'); ?>
		<br>
		<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != 'false') : ?>
		  <input type="button" id="add" value="Add">
			<input type="button" id="return" name="return" value="Return"><br><br>
			<?php
			$con = mysql_connect('localhost', 'root') or die('Could not connect: ' . mysql_error());
			mysql_select_db('manage_life');
			
			$username = $_COOKIE['username'];
			$query = sprintf("SELECT * FROM admin WHERE username = '%s'", $username);
			$res = mysql_query($query);
			$inputted = mysql_fetch_assoc($res);
			if ($inputted['year_started_school'] != NULL) {
        $query = sprintf("SELECT * FROM grades WHERE user_id = '%s' ORDER BY year, semester", $inputted['id']);
        $res = mysql_query($query);
        $grades = array();
        while ($row = mysql_fetch_assoc($res)) {
          $grades[] = $row;
        }
        $data = array();
        foreach ($grades as $grade) {
          $grade['calculated'] = $grade['percentage'] * $grade['credits']/100;
          $data[$grade['year']][$grade['semester']][] = $grade;
        }
        $semester_arr = array(1=>'September-December', 'January-April', 'May-August');
        foreach ($data as $year => $semesters) { ?>
          <h1><?php echo $year; ?></h1>
          <table width=30%>
            <?php foreach ($semesters as $semester => $classes) { ?>
              <tr><td><?php print $semester_arr[$semester]; ?></td></tr>
              <tr><td>
              <table border=1 style="border-collapse:collapse;" width=100%>
                <?php 
                $total_calculated = 0; 
                $total_credits = 0;
                ?>
                <?php foreach ($classes as $class) { 
                  $total_calculated += $class['calculated'];
                  $total_credits += $class['credits'];
                  ?>
                  <tr>
                    <td><?php print $class['class_name']; ?></td>
                    <td><?php print $class['percentage']; ?></td>
                    <td><?php print $class['calculated']; ?></td>
                    <td><?php print $class['credits']; ?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td>Total:</td>
                  <td><?php print ($total_calculated/$total_credits)*100; ?></td>
                  <td><?php print $total_calculated; ?></td>
                  <td><?php print $total_credits; ?></td>
                </tr>
                </table>
              </td></tr>
            <?php } ?>
          </table>
        <?php }
			} else { ?>
			  <label>Enter the year you started school to get started: </label>
			  <input type="text" id="year_started" name="year_started" size=4>
			  <input type="button" id="input_school_started" value="Submit">
			<?php } ?>
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