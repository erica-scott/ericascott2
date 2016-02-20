<?php
$con = mysql_connect('localhost', 'root') or die('Could not connect: ' . mysql_error());
mysql_select_db('money');

function setMessage($message, $error) {
	global $con;
	$query = sprintf("UPDATE message SET message = '%s', read_flag = '0', error = '%s'", $message, $error);
	$res = mysql_query($query, $con);
	return $res;
}

function readMessage() {
	global $con;
	$query = "SELECT * FROM message";
	$res = mysql_query($query, $con);
	$row = mysql_fetch_assoc($res);
	return $row;
}

function createNewUser($username, $password, $full_name) {
	global $con;
	$query = sprintf("INSERT INTO admin (username, password, full_name) VALUES ('%s', '%s', '%s')", $username, $password, $full_name);
	$res = mysql_query($query);
	return $res;
}

function login($username) {
	global $con;
	$query = sprintf("SELECT * FROM admin WHERE username = '%s'", $username);
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	return $row;
}

function get($id, $table_name) {
	global $con;
	$query = sprintf("SELECT * FROM %s WHERE id = '%s'", $table_name, $id);
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	return $row;
}

function updateInsert($flag, $amount, $description, $date, $pos_neg, $id, $table_name) {
	global $con;
	$username = $_COOKIE['username'];
	$query = sprintf("SELECT id FROM admin WHERE username = '%s'", $username);
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	$user_id = $row['id'];

	if ($flag == 1) {
		$query = sprintf("UPDATE %s SET amount = '%s', description = '%s', date = '%s', pos_neg = '%s' WHERE id = '%s'", $table_name, $amount, $description, $date, $pos_neg, $id);
	} else {
		$query = sprintf("INSERT INTO %s (amount, description, date, pos_neg, user_id) VALUES ('%s', '%s', '%s', '%s', '%s')", $table_name, $amount, $description, $date, $pos_neg, $user_id);
	}
	$res = mysql_query($query, $con);
	return $res;
}

function delete($id, $table_name) {
	global $con;
	$query = sprintf("DELETE FROM %s where id = '%s'", $table_name, $id);
	$res = mysql_query($query, $con);
	return $res;
}
?>