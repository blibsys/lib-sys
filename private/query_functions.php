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
?>

