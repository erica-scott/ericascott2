<script>
$(document).ready(function() {
	$('#day').change(function() {
		if ($(this).val() != 'none') {
			$('#submit_add').show();
		} else {
			 $('#submit_add').hide();
		}
	});
});
</script>
<?php
$month = intval($_POST['month']);
$year = intval($_POST['year']);
$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>
<select id="day" name="day">
	<option value="none">Day</option>
	<?php for($i = 1; $i <= $days; $i++) { ?>
		<option value="<?php print $i; ?>"><?php print $i; ?> </option>
	<?php } ?>
</select>