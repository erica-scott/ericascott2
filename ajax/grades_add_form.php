<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
  $(document).ready(function() {
    $('input:radio[name="elective_check"]').change(function() {
      var value = $(this).val();
      if (value == 'yes') {
        $('#elective').show();
      } else {
        $('#elective').hide();
      }
    });
  });
</script>
<?php include('../library/actions.php'); ?>
<label>Class Name</label><br><input type="text" id="class_name" name="class_name"><br>
<label>Percentage</label><br><input type="text" id="percentage" name="percentage"><br>
<label>Credits</label><br>
<select id="credits" name="credits">
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="10">10</option>
</select><br>
<?php
$username = $_COOKIE['username'];
$data = getUserFromUsername($username);
$year_started = $data['year_started_school'];
?>
<label>Year/Semester</label><br>
<select id="year" name="year">
  <option value="none">Year</option>
  <?php for ($i = $year_started; $i < $year_started+10; $i++) { ?>
    <option value="<?php echo $i . '/' . ($i+1); ?>"><?php echo $i . '/' . ($i+1); ?></option>
  <?php } ?>
</select>
<select id="semester" name="semester">
  <option value="none">Semester</option>
  <option value="1">Sept-Dec</option>
  <option value="2">Jan-Apr</option>
  <option value="3">May-Aug</option>
</select><br>
<label>Is this an elective?</label>
<input type="radio" name="elective_check" value="yes">Yes
<input type="radio" name="elective_check" value="no">No
<div id="elective" style="display:none;" >
<label>Elective Type</label>
  <select id="elective_type" name="elective_type">
    <option value="humanities">Humanities/Social Sciences</option>
    <option value="impact_tech">Impact of Technology on Society</option>
    <option value="breadth">Breadth</option>
    <option value="technical">Technical</option>
    <option value="advanced">Advanced</option>
    <option value="science">Science</option>
    <option value="free">Free</option>
  </select>
</div>