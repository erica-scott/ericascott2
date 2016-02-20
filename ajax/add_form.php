<label>Amount: </label><input type="text" id="amount" name="amount" placeholder="$0.00" required><br><br>
<label>Description: </label><input type="text" id="description" name="description" required><br><br>
<?php
$current_year = date('Y');
$last_year = $current_year + 5;
?>
<label>Date: </label><br>
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
<span id="day_dropdown">Test</span>