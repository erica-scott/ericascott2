<?php
$username = $_POST['username'];
$password = $_POST['password'];
$full_name = $_POST['full_name'];

include('../library/actions.php');

$res = createNewUser($username, $password, $full_name);
print $res;
?>