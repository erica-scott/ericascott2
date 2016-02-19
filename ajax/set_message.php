<?php
$message = $_POST['message'];
$error = $_POST['error'];

include('../library/actions.php');

$res = setMessage($message, $error);
print $res;
?>