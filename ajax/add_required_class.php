<?php
include('../library/actions.php');
$class_name = $_POST['class_name'];
$year = $_POST['year'];
$elective_type = $_POST['elective_type'];
$id = null;
$flag = 0;

$res = updateInsertRequiredClasses($flag, $class_name, $year, $elective_type, $id, 'required_courses');
if ($res == true) {
	print TRUE;
} else {
	print mysql_error();
}
?>