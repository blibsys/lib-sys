<?php

	function find_all_items() {
	global $db;
	
//set function to call reusable query. Space at end of first line prior to concatenation v important
	
	$sql = "SELECT * FROM items ";
	$sql .= "ORDER BY item_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

	function find_all_users() {
	global $db;
	
	$sql = "SELECT * FROM users ";
	$sql .= "ORDER BY user_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

	function find_all_courses() {
	global $db;
	
	$sql = "SELECT * FROM courses ";
	$sql .= "ORDER BY course_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

	function find_all_creators() {
	global $db;
	
	$sql = "SELECT * FROM creators ";
	$sql .= "ORDER BY creator_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

	function find_all_pubs() {
	global $db;
	
	$sql = "SELECT * FROM publishers ";
	$sql .= "ORDER BY publisher_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

	function find_all_circ() {
	global $db;
	
	$sql = "SELECT * FROM circulation ";
	$sql .= "ORDER BY circulation_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

	function find_all_itemcreators() {
	global $db;
	
	$sql = "SELECT * FROM item_creators ";
	$sql .= "ORDER BY item_id ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}
?>

