<?php
include('../library/actions.php');

$row = readMessage();

if ($row['read_flag'] == 0) {
	$query = "UPDATE message SET read_flag = '1'";
	$update = mysql_query($query);
	print $row['message'] . '_' . $row['error'];
} else {
	print -1;
}