<?php

    //find all records
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


    //find single record 
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
	
	function find_user_by_id($id) {
	//show single user record via 'view' link (adds course name)
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

	function find_course_by_id($id) {
	//show single course record via 'view' link 
	global $db;
	
	$sql = "SELECT * FROM courses ";
	$sql .= "WHERE course_id='" . $id . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $course = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $course; // returns an assoc. array
	}
	
	function find_creator_by_id($id) {
		//show single creator record via 'view' link 
	global $db;
	
	$sql = "SELECT * FROM creators ";
	$sql .= "WHERE creator_id='" . $id . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $creator = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $creator; // returns an assoc. array
	}
	
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

	function find_circ_by_id($id) {
		//show single circulation record via 'view' link  (consider adding user name and title)
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
	
	function find_icreator_by_id($id) {
	//show single itemcreator record via 'view' link (add item title and creator name) need to change this so we see all item creators in one view
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
	

	//INSERT
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
	
	function insert_course($course){
		global $db;
		
	 	$errors = validate_course($course);
	 	if(!empty($errors)) {
	 	   return $errors;
	    }
			
		$sql = "INSERT INTO courses ";
		$sql .= "(course_id, course_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . $course['course_id'] . "',";
		$sql .= "'" . $course['course_name'] . "'";
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
	
		
	//UPDATE	
	function update_item($item) {
		global $db;
		
		$sql = "UPDATE items SET ";
		$sql .= "title='" . $item['title'] . "', ";
		$sql .= "item_edition='" . $item['item_edition'] . "', ";
		$sql .= "isbn='" . $item['isbn'] . "', ";
		$sql .= "item_type='" . $item['item_type'] . "', ";
		$sql .= "publication_year='" . $item['publication_year'] . "', ";
		$sql .= "item_copy='" . $item['item_copy'] . "', ";
		$sql .= "publisher_id='" . $item['publisher_id'] . "', ";
		$sql .= "category='" . $item['category'] . "', ";
		$sql .= "item_status='" . $item['item_status'] . "' ";	
		$sql .= "WHERE item_id='" . $item['id'] . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  echo $sql;
		  exit;
		}
	}
	
	function update_user($user) {
    	global $db;
    	
    	$sql = "UPDATE users SET ";
		$sql .= "first_name='" . $user['first_name'] . "', ";
		$sql .= "last_name='" . $user['last_name'] . "', ";
		$sql .= "user_start_date='" . $user['user_start_date'] . "', ";
		$sql .= "user_end_date='" . $user['user_end_date'] . "', ";
		$sql .= "user_type='" . $user['user_type'] . "', ";
		$sql .= "email='" . $user['email'] . "' ";
		$sql .= "WHERE user_id='" . $user['id'] . "'";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
	
	function update_course($course) {
	 	global $db;
	 	
	 	$errors = validate_course($course);
	 	if(!empty($errors)) {
	 	   return $errors;
	    }
	 	
	 	$sql = "UPDATE courses SET ";
		$sql .= "course_name='" . $course['course_name'] . "' ";
		$sql .= "WHERE course_id='" . $course['course_id'] . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
			
	function update_creator($creator) {
		global $db;
		
		$sql = "UPDATE creators SET ";
		$sql .= "creator_name='" . $creator['creator_name'] . "' ";
		$sql .= "WHERE creator_id='" . $creator['id'] . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
	
	function update_publisher($pub) {
		global $db;
		
		$sql = "UPDATE publishers SET ";
		$sql .= "publisher_name='" . $pub['publisher_name'] . "' ";
		$sql .= "WHERE publisher_id='" . $pub['id'] . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
	
	
	//DELETE
	function delete_item($id) {
		global $db;
	
	$sql = "DELETE FROM items ";
	$sql .= "WHERE item_id='" . $id . "' ";
	$sql .= "LIMIT 1";
	
	$result = mysqli_query($db, $sql);
	
	if ($result) {
	   return true;
	 } else {
	 // DELETE failed
	 echo mysql_error($db);
	 db_disconnect($db);
	 exit;
	 }
  }
  
  	function delete_user($id) {
  		global $db;
	
		$sql = "DELETE FROM users ";
		$sql .= "WHERE user_id='" . $id . "' ";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		
		if ($result) {
		   return true;
		 } else {
		 // DELETE failed
		 echo mysql_error($db);
		 db_disconnect($db);
		 exit;
		 }
	  }
	
	function delete_course($id){
		global $db;
	
	$sql = "DELETE FROM courses ";
	$sql .= "WHERE course_id='" . $id . "' ";
	$sql .= "LIMIT 1";
	
	$result = mysqli_query($db, $sql);
	
	//for DELETE statements, $result is true/false
	if($result) {
	  return true;
	} else {
	//delete failed
	  echo mysqli_error($db);
	  db_disconnect($db);
	  exit;
   }
}

    function delete_creator($id){
     	global $db;
	
		$sql = "DELETE FROM creators ";
		$sql .= "WHERE creator_id='" . $id . "' ";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		
		//for DELETE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		//delete failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
	   }
	}
	
	function delete_publisher($id) {
		global $db;
		
		$sql = "DELETE FROM publishers ";
		$sql .= "WHERE publisher_id='" . $id . "' ";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		
		//for DELETE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		//delete failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
	   }
	}
	
	
	//validation
	
	//function validate_item
	
	//function validate_user
	
	function validate_course($course) {
	  $errors = [];

    // course_id
    if(is_blank($course['course_id'])) {
      $errors[] = "id cannot be blank.";
    } elseif(!has_length($course['course_id'], ['min' => 8, 'max' => 20])) {
      $errors[] = "id must be between 8 and 20 characters.";
    }
    
    // course_name
    if(is_blank($course['course_name'])) {
      $errors[] = "Course name cannot be blank.";
    } elseif(!has_length($course['course_name'], ['min' => 3, 'max' => 80])) {
      $errors[] = "Course name must be between 3 and 80 characters.";
    }
    
    return $errors; 
    }
	
	//function validate_creator
	
	//function validate_publisher
	
	/* 
	   // position
    // Make sure we are working with an integer
    $postion_int = (int) $subject['position'];
    if($postion_int <= 0) {
      $errors[] = "Position must be greater than zero.";
    }
    if($postion_int > 999) {
      $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $subject['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Visible must be true or false.";
    }

    return $errors;
  }
	*/
		
	
?>	