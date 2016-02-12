<?php
$id = $_POST['id'];
$amount = $_POST['amount'];
$description = $_POST['description'];
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

$con = mysql_connect('localhost', 'root') or die('Could not connect: ' . mysql_error());

mysql_select_db('money');

$query = sprintf("UPDATE money SET amount = '%s', description = '%s', date = '%s', pos_neg = '%s' WHERE id = '%s'", $amount, $description, $date, $pos_neg, $id);
$res = mysql_query($query, $con);
if ($res == true) {
	print TRUE;
} else {
	print FALSE;
}
?>