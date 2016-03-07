<?php
include('../library/actions.php');
$year = $_POST['year'];
$res = addGradeYear($year);
print $res;
?>