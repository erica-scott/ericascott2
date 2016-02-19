<?php
$id = $_POST['id'];

include('../library/actions.php');

$res = delete($id, 'money');
print $res;
?>