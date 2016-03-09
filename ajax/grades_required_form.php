<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
  $(document).ready(function() {
    $('#year').change(function() {
      var value = $(this).val();
      if (value == 5) {
        $('#elective').show();
      } else {
        $('#elective').hide();
      }
    });
  });
</script>
<?php include('../library/actions.php'); ?>
<label>Class Name</label><br><input type="text" id="class_name" name="class_name"><br>
<label>Year</label><br>
<select id="year" name="year">
  <option value="none">Year</option>
  <option value="1">First Year</option>
  <option value="2">Second Year</option>
  <option value="3">Third Year</option>
  <option value="4">Fourth Year</option>
  <option value="5">Electives</option>
</select>
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