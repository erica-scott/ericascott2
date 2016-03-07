<?php include('../library/actions.php'); ?>
<label>Class Name</label><br><input type="text" id="class_name" name="class_name"><br>
<label>Percentage</label><br><input type="text" id="percentage" name="percentage"><br>
<label>Credits</label><br>
<select id="credits" name="credits">
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
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
</select>