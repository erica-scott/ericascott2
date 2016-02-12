<?php
$id = $_POST['id'];

$con = mysql_connect('localhost', 'root') or die('Could not connect: ' . mysql_error());

mysql_select_db('money');

$query = sprintf("DELETE FROM money where id = '%s'", $id);
$res = mysql_query($query, $con);
print $res;
?>