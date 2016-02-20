<?php
if (isset($_POST['id'])) {
	$id = $_POST['id'];
} else {
	$id = null;
}
$amount = $_POST['amount'];
$description = $_POST['description'];
$flag = $_POST['flag'];
$month = $_POST['month'];
$day = $_POST['day'];
if ($month < 10) {
	$month = '0' . $month;
}
if ($day < 10) {
	$day = '0' . $day;
}
$date = $_POST['year'].'-'.$month.'-'.$day;

$temp = str_replace('$', '', $amount);
if ($temp < 0) {
	$pos_neg = 0;
} else {
	$pos_neg = 1;
}

include('../library/actions.php');

$res = updateInsert($flag, $amount, $description, $date, $pos_neg, $id, 'money');

if ($res == true) {
	print TRUE;
} else {
	print FALSE;
}
?>