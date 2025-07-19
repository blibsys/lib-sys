<?php

	function find_all_items() {
	global $db;
	
//set function to call reusable query. Space at end of first line prior to concatenation v important
	
	$sql = "SELECT * FROM items ";
	$sql .= "ORDER BY item_id ASC";
	//echo $sql;
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_users() {
	global $db;
	
	$sql = "SELECT * FROM users ";
	$sql .= "ORDER BY user_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_courses() {
	global $db;
	
	$sql = "SELECT * FROM courses ";
	$sql .= "ORDER BY course_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_creators() {
	global $db;
	
	$sql = "SELECT * FROM creators ";
	$sql .= "ORDER BY creator_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_pubs() {
	global $db;
	
	$sql = "SELECT * FROM publishers ";
	$sql .= "ORDER BY publisher_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_circ() {
	global $db;
	
	$sql = "SELECT * FROM circulation ";
	$sql .= "ORDER BY circulation_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_itemcreators() {
	global $db;
	
	$sql = "SELECT * FROM item_creators ";
	$sql .= "ORDER BY item_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	//show single item record via 'view' link (adds creators)
	function find_item_by_id($id) {
    global $db;
	$sql  = "SELECT i.item_id, i.title, i.item_status, i.item_edition, i.isbn, i.item_type, ";
	$sql .= "i.publication_year, i.item_copy, i.publisher_id, i.category, ";
	$sql .= "GROUP_CONCAT(c.creator_name ORDER BY c.creator_name SEPARATOR ', ') AS creators ";
	$sql .= "FROM items i ";
	$sql .= "LEFT JOIN item_creators ic ON ic.item_id = i.item_id ";
	$sql .= "LEFT JOIN creators c ON c.creator_id = ic.creator_id ";
	$sql .= "WHERE i.item_id='" . $id . "' ";
	$sql .= "GROUP BY i.item_id, i.title, i.item_edition, i.isbn, i.item_type, i.publication_year, i.item_copy";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $item = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $item;
	}
	
	//show single user record via 'view' link (adds course name)
	function find_user_by_id($id) {
	global $db;
 	$sql = "SELECT * FROM users u ";
    $sql .= "JOIN courses c ON c.course_id = u.course_id ";
    $sql .= "WHERE u.user_id='" . $id . "' ";
    //$sql .= "GROUP BY u.user_id"; 
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user;
	}
	
	//show single circulation record via 'view' link  (consider adding user name and title)
	function find_loan_by_id($id) {
	global $db;
	$sql = "SELECT * FROM circulation c ";
	$sql .="JOIN users u ON u.user_id = c.user_id ";
	$sql .="JOIN items i ON i.item_id = c.item_id ";
	$sql .= "WHERE circulation_id='" . $id . "' ";
	// .= "GROUP BY c.user_id";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $circ = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $circ; // returns an assoc. array
	}

	//show single course record via 'view' link 
	function find_course_by_id($id) {
	global $db;
	
	$sql = "SELECT * FROM courses ";
	$sql .= "WHERE course_id='" . $id . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $course = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $course; // returns an assoc. array
	}
	
	//show single creator record via 'view' link 
	function find_creator_by_id($id) {
	global $db;
	
	$sql = "SELECT * FROM creators ";
	$sql .= "WHERE creator_id='" . $id . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $creator = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $creator; // returns an assoc. array
	}
	
	//show single itemcreator record via 'view' link (add item title and creator name) need to change this so we see all item creators in one view
	function find_icreator_by_id($id) {
	global $db;
	
	$sql = "SELECT * FROM item_creators ic ";
	$sql .= "LEFT JOIN items i on i.item_id = ic.item_id ";
	$sql .= "LEFT JOIN creators c on c.creator_id = ic.creator_id ";
	$sql .= "WHERE ic.item_id='" . $id . "' ";
	//$sql .= "GROUP BY ic.item_id";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    
    $icreator = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $icreator; // returns an assoc. array
	} 
	
	
	//show single publisher record via 'view' link 
	function find_pub_by_id($id) {
	global $db;
	
	$sql = "SELECT * FROM publishers ";
	$sql .= "WHERE publisher_id='" . $id . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $pub = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $pub; // returns an assoc. array
	}

	function insert_item($title, $item_edition, $isbn, $item_type, $publication_year, $item_copy, $publisher_id, $category, $item_status)
	 { global $db;
	  
	  	$sql = "INSERT INTO items ";
		$sql .= "(title, item_edition, isbn, item_type, publication_year, item_copy, publisher_id, category, item_status) ";
		$sql .= "VALUES (";
		$sql .= "'" . $title . "',";
		$sql .= "'" . $item_edition . "',";
		$sql .= "'" . $isbn . "',";
		$sql .= "'" . $item_type . "',";
		$sql .= "'" . $publication_year . "',";
		$sql .= "'" . $item_copy . "',";
		$sql .= "'" . $publisher_id . "',";
		$sql .= "'" . $category . "',";
		$sql .= "'" . $item_status . "'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		//echo $sql . "<br>";
		//echo mysqli_error($db);
		if($result) {
			return true;
		} else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}	  
	
	function insert_course($course_id, $course_name){
		global $db;
		
		$sql = "INSERT INTO courses ";
		$sql .= "(course_id, course_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . $course_id . "',";
		$sql .= "'" . $course_name . "'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	
	function insert_creator($creator_id, $creator_name){
		global $db;
		
		$sql = "INSERT INTO creators ";
		$sql .= "(creator_id, creator_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . $creator_id . "',";
		$sql .= "'" . $creator_name . "'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	
	function insert_publisher($publisher_id, $publisher_name){
		global$db;
		
		$sql = "INSERT INTO publishers ";
		$sql .= "(publisher_id, publisher_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . $publisher_id . "',";
		$sql .= "'" . $publisher_name . "'";
		$sql .= ")";
			$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
		
	function insert_user($user_id, $first_name, $last_name, $user_start_date, $user_end_date, $user_type, $email, $course_id)
   	{	global $db;
		
		$sql = "INSERT INTO users ";
		$sql .= "(user_id, first_name, last_name, user_start_date, user_end_date, user_type, email, course_id) ";
		$sql .= "VALUES (";
		$sql .= "'" . $user_id . "',";
		$sql .= "'" . $first_name . "',";
		$sql .= "'" . $last_name . "',";
		$sql .= "'" . $user_start_date . "',";
		$sql .= "'" . $user_end_date . "',";
		$sql .= "'" . $user_type . "',";
		$sql .= "'" . $email . "',";
		$sql .= "'" . $course_id . "'";
		$sql .= ")";
			$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}		
	}
		
		
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>	