<?php
include('../library/actions.php');
$class_name = $_POST['class_name'];
$percentage = $_POST['percentage']; 
$credits = $_POST['credits'];
$year = $_POST['year'];
$semester = $_POST['semester'];
$elective_type = $_POST['elective_type'];
$id = null;
$flag = 0;

$res = updateInsertGrades($flag, $class_name, $percentage, $credits, $year, $semester, $elective_type, $id, 'grades');
if ($res == true) {
	print TRUE;
} else {
	//print mysql_error();
	print $res;
}
?>