<?php
$con = mysql_connect('localhost', 'escott', 'Silas2727_') or die('Could not connect: ' . mysql_error());
mysql_select_db('manage_life');

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
	print mysql_error();
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

function getUserFromUsername($username) {
  global $con;
  $query = "SELECT * FROM admin WHERE username = '$username'";
  $res = mysql_query($query);
  $row = mysql_fetch_assoc($res);
  return $row;
}

function updateInsertMoney($flag, $amount, $description, $date, $pos_neg, $id, $table_name) {
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

function updateInsertGrades($flag, $class_name, $percentage, $credits, $year, $semester, $elective_type, $id, $table_name) {
	global $con;
	$username = $_COOKIE['username'];
	$query = sprintf("SELECT id FROM admin WHERE username = '%s'", $username);
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	$user_id = $row['id'];

	if ($elective_type != NULL || $elective_type == 0) {
		$query = sprintf("SELECT id FROM elective_types WHERE name = '%s'", $elective_type);
		$res = mysql_query($query);
		$row = mysql_fetch_assoc($res);
		$elective_id = $row['id'];
	}

	if ($flag == 1) {
		$query = sprintf("UPDATE %s SET class_name = '%s', percentage = '%s', credits = '%s', year = '%s', semester = '%s', elective_type = '%s' WHERE id = '%s'", $table_name, $class_name, $percentage, $credits, $year, $semester, $elective_id, $id);
	} else {
		$query = sprintf("INSERT INTO %s (class_name, percentage, credits, year, semester, elective_type, user_id) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $table_name, $class_name, $percentage, $credits, $year, $semester, $elective_id, $user_id);
	}
	$res = mysql_query($query, $con);
	return $res;
}

function updateInsertRequiredClasses($flag, $class_name, $year, $id, $table_name) {
	global $con;
	$username = $_COOKIE['username'];
	$query = sprintf("SELECT id FROM admin WHERE username = '%s'", $username);
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	$user_id = $row['id'];

	if ($flag == 1) {
		$query = sprintf("UPDATE %s SET class_name = '%s', year = '%s' WHERE id = '%s'", $table_name, $class_name, $year, $id);
	} else {
		$query = sprintf("INSERT INTO %s (class_name, year, user_id) VALUES ('%s', '%s', '%s')", $table_name, $class_name, $year, $user_id);
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

function addGradeYear($year) {
  global $con;
  $username = $_COOKIE['username'];
  
  $query = "UPDATE admin SET year_started_school = '$year' WHERE username = '$username'";
  $res = mysql_query($query);
  return $res;
}

function updateElectives() {
	global $con;
	$username = $_COOKIE['username'];
	$query = sprintf("SELECT id FROM admin WHERE username = '%s'", $username);
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	$user_id = $row['id'];

	$query = sprintf("SELECT * FROM grades WHERE user_id = '%s' AND elective_type is not NULL", $user_id);
	$res = 	mysql_query($query);
	while($row = mysql_fetch_assoc($res)) {
		$query = sprintf("SELECT * FROM required_courses WHERE class_name = '%s'", $row['class_name']);
		$check = mysql_query($query);
		if (mysql_num_rows($check) < 1) {
			$query = sprintf("INSERT INTO required_courses (class_name, year, elective_type, user_id) VALUES ('%s', '%s', '%s', '%s')", $row['class_name'], 5, $row['elective_type'], $user_id);
			$insert = mysql_query($query);
		}
	}
}
?>