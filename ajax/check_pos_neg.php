<?php
$amount = $_POST['amount'];
$amount = str_replace('$', '', $amount);
$amount = intval($amount);
if ($amount < 0) {
	print 1;
} else {
	print 0;
}
?>