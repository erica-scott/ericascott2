<?php
$username = $_POST['username'];
$password = $_POST['password'];

include('../library/actions.php');

$row = login($username);

if ($row['password'] == $password) {
	print $row['full_name'];
} else {
	print false;
}
?>